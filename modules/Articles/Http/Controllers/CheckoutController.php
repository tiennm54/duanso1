<?php

namespace Modules\Articles\Http\Controllers;

use App\Http\Controllers\SendEmailController;
use App\Models\Articles;
use App\Models\ArticlesType;
use App\Models\Information;
use App\Models\PaymentType;
use App\Models\TermsConditions;
use App\Models\UserOrders;
use App\Models\UserOrdersDetail;
use App\Models\UserShippingAddress;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Articles\Http\Requests\CreateRequest;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use DougSisk\CountryState\CountryState;
use Response;
use App\Models\UserShoppingCart;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Log;
use DB;
use SEOMeta;
use OpenGraph;
use Twitter;
use URL;
use App\Models\Seo;
use App\Helpers\SeoPage;

class CheckoutController extends ShoppingCartController {

    //Gửi mail có khách orders
    public function sendMail($model_orders, $password) {
        Mail::send('articles::checkout.email-checkout', ['model_orders' => $model_orders, 'password' => $password], function ($m) use ($model_orders) {
            $m->from("buypremiumkey@gmail.com", "BuyPremiumKey Authorized Reseller");
            $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject('[Paypal payment] Paypal Invoice for Order #' . $model_orders->order_no);
        });
    }

    public function sendMailToMe($model_orders) {
        Mail::send('articles::checkout.email-checkout-me', ['model_orders' => $model_orders], function ($m) use ($model_orders) {
            $m->from("buypremiumkey@gmail.com", "BuyPremiumKey Authorized Reseller");
            $m->to("minhtienuet@gmail.com", "Minh Tiến")->subject('[Payment Request] Order Customer: #' . $model_orders->order_no);
        });
    }

    public function getNameOrderNo($order_id) {
        $time = strtotime(Carbon::now());
        $month = date("m", $time);
        $year = date("Y", $time);
        $order_no = "BPK-" . $year . $month . $order_id;
        return $order_no;
    }

    public function getPaymentCharges($subTotal, $model_payment) {
        $payment_charges = 0;
        if ($subTotal != 0) {
            if ($model_payment != null) {
                $fees = $model_payment->fees;
                $plus = $model_payment->plus;
                $payment_charges = round(($subTotal * $fees) / 100, 2) + $plus;
            }
        }
        return $payment_charges;
    }

    public function seoIndexCheckOut($model_seo){
        $url_page = URL::route('frontend.checkout.index');
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }

    ///MUA SẢN PHẨM
    public function index(Request $request) {
        $model_seo = Seo::where("type", "=", "checkout")->first();
        if ($model_seo) {
            $this->seoIndexCheckOut($model_seo);
        }

        $model_terms = Information::find(5);

        $model_payment_type = PaymentType::orderBy("position", "ASC")->get();

        $data = Session::get('array_orders', []);
        $obj_shopping_cart = new UserShoppingCart();
        $subTotal = $obj_shopping_cart->getSubTotal($data);
        Session::set('sub_total', $subTotal);

        $model_payment_selected = PaymentType::where("status_selected", "=", 1)->first();
        $payment_charges = $this->getPaymentCharges($subTotal, $model_payment_selected);
        $total = $subTotal + $payment_charges;
        $model_user = $this->checkMember();
        $model_shipping_address = null;

        if (count($data) != 0) {
            return view('articles::checkout.checkout', compact(
                            "data", "model_payment_type", "model_terms", "model_payment_selected", "model_user", "subTotal", "payment_charges", "total"
            ));
        } else {
            return view('articles::checkout.checkout-none');
        }
    }

    //Thay đổi loại hình thanh toán
    public function selectTypePayment(Request $request) {
        $data = $request->all();
        if (isset($data["payment_id"])) {
            $payment_id = $data["payment_id"];

            $data_product = Session::get('array_orders', []);
            $obj_shopping_cart = new UserShoppingCart();
            $subTotal = $obj_shopping_cart->getSubTotal($data_product);

            $model = PaymentType::find($payment_id);

            if ($model != null) {

                $payment_charges = $this->getPaymentCharges($subTotal, $model);
                $total = $subTotal + $payment_charges;

                $data_return = array(
                    "payment_charges" => $payment_charges,
                    "payment_name" => $model->title,
                    "total" => $total
                );

                return $data_return;
            }
        }
    }

    //Thay đổi số lượng sản phẩm khi checkout
    public function changeQuantity(Request $request) {
        if (isset($request)) {
            $data = $request->all();

            if (isset($data["id"]) && isset($data["number"])) {
                $id = $data["id"];
                $number = $data["number"];

                $model_articles_type = ArticlesType::find($id);
                if ($model_articles_type) {

                    $model_user = $this->checkMember();

                    if ($model_user) {
                        $array_orders = $this->changeNumberProductOrderForMember($model_user, $model_articles_type, $number);
                    } else {
                        $array_orders = $this->changeNumberProductOrderForGuest($model_articles_type, $number);
                    }

                    $obj_shopping_cart = new UserShoppingCart();
                    $data_product = $array_orders;
                    $obj_shopping_cart->setSession($data_product);
                    $subTotal = Session::get('sub_total');

                    $payment_charges = 0;
                    if (isset($data["payment_type"])) {
                        $payment_id = $data["payment_type"];
                        $model = PaymentType::find($payment_id);

                        if ($model != null) {
                            $payment_charges = $this->getPaymentCharges($subTotal, $model);
                            $total = $subTotal + $payment_charges;
                        } else {
                            $total = $subTotal;
                        }
                    } else {
                        $total = $subTotal;
                    }

                    return view('articles::append.listProductCheckout', compact('data_product', 'subTotal', 'payment_charges', 'total'));
                }
            }
        }

        return redirect()->route('frontend.articles.index');
    }

    //Xóa sản phẩm khi checkout
    public function deleteProductCheckout(Request $request) {
        if (isset($request)) {
            $data = $request->all();

            $id = $data["id"];
            $model_articles_type = ArticlesType::find($id);
            if ($model_articles_type) {
                //Nếu là member
                $model_user = $this->checkMember();
                if ($model_user) {
                    $array_orders = $this->deleteSessionOrderForMember($model_user, $model_articles_type);
                } else {
                    $array_orders = $this->deleteSessionOrderForGuest($model_articles_type);
                }

                $obj_shopping_cart = new UserShoppingCart();
                $data_product = $array_orders;
                $obj_shopping_cart->setSession($data_product);
                $subTotal = Session::get('sub_total');

                $payment_charges = 0;
                if (isset($data["payment_type"])) {
                    $payment_id = $data["payment_type"];
                    $model = PaymentType::find($payment_id);
                    if ($model != null) {
                        $payment_charges = $this->getPaymentCharges($subTotal, $model);
                        $total = $subTotal + $payment_charges;
                    } else {
                        $total = $subTotal;
                    }
                } else {
                    $total = $subTotal;
                }

                return view('articles::append.listProductCheckout', compact('data_product', 'subTotal', 'payment_charges', 'total'));
            }
        }

        return response()->json("Delete error !!!", 404);
    }

    public function confirmOrderForMember($model_user, $data, $array_orders, $flag_user) {

        //Đối với người dùng đăng nhập
        $model_user_orders = new UserOrders();
        $model_user_orders->users_id = $model_user->id;
        $model_user_orders->users_roles_id = $model_user->roles_id;
        $model_user_orders->first_name = $model_user->first_name;
        $model_user_orders->last_name = $model_user->last_name;
        $model_user_orders->email = $data["shipping_address"];
        $model_user_orders->payments_type_id = $data["payments_type_id"];
        $model_user_orders->sub_total = $data["sub_total"];
        $model_user_orders->payment_charges = $data["payment_charges"];
        $model_user_orders->total_price = $data["total_price"];
        $model_user_orders->quantity_product = count($array_orders);
        $model_user_orders->save();
        $model_user_orders->order_no = $this->getNameOrderNo($model_user_orders);
        $model_user_orders->save();

        return $model_user_orders->id;
    }

    public function confirmOrderForGuest($model_user, $data, $array_orders) {
        unset($data["_token"]);
        unset($data["check_term"]);
        $data["users_id"] = $model_user->id;
        $data["users_roles_id"] = $model_user->roles_id;
        $data["quantity_product"] = count($array_orders);
        $data["created_at"] = Carbon::now();
        $data["updated_at"] = Carbon::now();
        $id = UserOrders::insertGetId($data);
        return $id;
    }

    public function saveUserOrdersDetail($user_order_id, $model_user, $array_orders) {

        foreach ($array_orders as $item) {
            $model_user_orders_detail = new UserOrdersDetail();
            $model_user_orders_detail->user_orders_id = $user_order_id;
            $model_user_orders_detail->users_id = $model_user->id;
            $model_user_orders_detail->users_roles_id = $model_user->roles_id;
            $model_user_orders_detail->articles_type_id = $item["id"];
            $model_user_orders_detail->title = $item["title"];
            $model_user_orders_detail->image = $item["image"];
            $model_user_orders_detail->quantity = $item["quantity"];
            $model_user_orders_detail->price_order = $item["price_order"];
            $model_user_orders_detail->total_price = $item["total"];
            $model_user_orders_detail->save();
        }
    }

    //Thay đổi trạng thái shopping cart của khách hàng
    //Xóa session shopping cart
    public function changeStatusAfterCheckout($model_user) {
        UserShoppingCart::where("user_id", "=", $model_user->id)->update(['status_payment' => 'Checkout']);
        $obj = new UserShoppingCart();
        $obj->emptySession();
    }

    public function confirmOrder(Request $request) {
        if (isset($request)) {
            DB::beginTransaction();
            $data = $request->all();
            $array_orders = Session::get('array_orders', []);
            if (count($array_orders) > 0) {

                $model_user = $this->checkMember();
                $flag_user = 0; // Đánh dấu người dùng vãng lai, chưa từng có trong hệ thống
                if ($model_user) {
                    $flag_user = 1; // Đã đăng nhập
                } else {
                    //Đối với người dùng vãng lai có 2 TH
                    //TH1: Dùng email đã có trên hệ thống
                    //TH2: Chưa có email nào trên hệ thống => Cần tự tạo tài khoản để người dùng có thể đăng nhập lần sau.
                    $model_user = User::where("email", "=", $data["email"])->first();
                    if ($model_user == null) {
                        $check_user_shipping = UserShippingAddress::where("email", "=", $data["email"])->first();
                        if ($check_user_shipping) {
                            $model_user = User::find($check_user_shipping->user_id);
                            if ($model_user) {
                                $flag_user = 3; // Có email là tài khoản shipping trên hệ thống
                            }
                        }
                    } else {
                        $flag_user = 2; // Có email là tài khoản đã đăng kí
                    }
                }

                $password = "";
                if ($flag_user == 0) {
                    //Tạo mới user
                    $obj_user = new User();
                    $result = $obj_user->createUser($data);
                    $user_id = $result["user_id"];
                    $password = $result["password"];
                    $model_user = User::find($user_id);
                    Auth::loginUsingId($model_user->id);
                }
                //0 và 1 được login luôn vào hệ thống
                if ($flag_user == 0 || $flag_user == 1) {
                    $user_order_id = $this->confirmOrderForMember($model_user, $data, $array_orders, $flag_user);
                } else {
                    $user_order_id = $this->confirmOrderForGuest($model_user, $data, $array_orders);
                }

                $this->saveUserOrdersDetail($user_order_id, $model_user, $array_orders);
                DB::commit();
                $model_orders = UserOrders::find($user_order_id);
                if ($model_orders) {
                    $model_orders->order_no = $this->getNameOrderNo($user_order_id);
                    $model_orders->save();

                    $this->changeStatusAfterCheckout($model_user);
                    $this->sendMail($model_orders, $password);
                    $this->sendMailToMe($model_orders);
                    return redirect()->route('frontend.checkout.success', ['email' => $model_user->email, "password" => $password]);
                }
            } else {
                $request->session()->flash('alert-warning', 'Warning: Your shopping cart is empty!');
            }
        }

        $request->session()->flash('alert-warning', 'Warning: Server error. Please come back later!');
        return redirect()->route('frontend.checkout.index');
    }

    public function checkoutSuccess($email = "", $password = "") {
        return view('articles::checkout.checkout-success', compact('email', 'password'));
    }

}
