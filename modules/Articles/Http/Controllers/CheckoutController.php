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

    //Xóa sản phẩm tại giao diện checkout
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

    public function createOrder($model_user, $data, $array_orders) {
        $model_user_orders = new UserOrders();
        $model_user_orders->users_id = $model_user->id;
        $model_user_orders->users_roles_id = $model_user->roles_id;
        $model_user_orders->first_name = $model_user->first_name;
        $model_user_orders->last_name = $model_user->last_name;
        if(isset($data["shipping_address"])){
            $model_user_orders->email = $data["shipping_address"];
        }else{
            $model_user_orders->email = $model_user->email;
        }

        $model_user_orders->payments_type_id = $data["payments_type_id"];
        $model_user_orders->sub_total = $data["sub_total"];
        $model_user_orders->payment_charges = $data["payment_charges"];
        $model_user_orders->total_price = $data["total_price"];
        $model_user_orders->quantity_product = count($array_orders);
        $model_user_orders->save();
        $model_user_orders->order_no = $this->getNameOrderNo($model_user_orders);
        $model_user_orders->save();

        $model_user_orders->order_no = $this->getNameOrderNo($model_user_orders->id);
        $model_user_orders->save();

        //Save Order Detail
        foreach ($array_orders as $item) {
            $model_user_orders_detail = new UserOrdersDetail();
            $model_user_orders_detail->user_orders_id = $model_user_orders->id;
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
        return $model_user_orders;
    }

    //Thay đổi trạng thái shopping cart của khách hàng
    //Xóa session shopping cart
    public function changeStatusAfterCheckout($model_user) {
        UserShoppingCart::where("user_id", "=", $model_user->id)->update(['status_payment' => 'Checkout']);
        $obj = new UserShoppingCart();
        $obj->emptySession();
    }

    public function getConfirmOrder(Request $request){
        $request->session()->flash('alert-warning', 'Warning: Server error. Please come back later!');
        return redirect()->route('frontend.checkout.index');
    }

    public function confirmOrder(Request $request) {
        if (isset($request)) {
            DB::beginTransaction();
            $data = $request->all();
            $array_orders = Session::get('array_orders', []);
            if (count($array_orders) > 0) {

                $model_user = $this->checkMember();
                if($model_user == null){
                    $model_user = User::where("email", "=", $data["email"])->first();
                    if ($model_user == null) {// Không có mail trong bảng User
                        $check_user_shipping = UserShippingAddress::where("email", "=", $data["email"])->first();
                        if ($check_user_shipping) {// Tìm thấy email trong bảng shipping address
                            $model_user = User::find($check_user_shipping->user_id);
                        }
                    }
                }

                $password = "";
                if ($model_user == null) {
                    $obj_user = new User();
                    $result = $obj_user->createUser($data);
                    $user_id = $result["user_id"];
                    $password = $result["password"];
                    $model_user = User::find($user_id);
                    //Chỉ user new mới được login, bởi cần tính bảo mật trong trường hợp người dùng điền bừa email
                    Auth::loginUsingId($model_user->id);
                    Session::set('user_email_login', $model_user->email);
                    $data["shipping_address"] = $model_user->email;
                }
                $model_orders = $this->createOrder($model_user, $data, $array_orders);
                DB::commit();
                if ($model_orders) {
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
