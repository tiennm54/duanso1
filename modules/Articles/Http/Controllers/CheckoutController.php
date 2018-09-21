<?php

namespace Modules\Articles\Http\Controllers;

use App\Models\ArticlesType;
use App\Models\Information;
use App\Models\PaymentType;
use App\Models\UserOrders;
use App\Models\UserOrdersHistory;
use App\Models\UserShippingAddress;
use App\Models\BonusPaymentHistory;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Modules\Articles\Http\Requests\CheckoutRequest;
use App\Models\UserShoppingCart;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Log;
use DB;
use URL;
use App\Models\Seo;
use App\Helpers\SeoPage;

class CheckoutController extends ShoppingCartController {

    //[Paypal payment]Gửi mail có khách orders 
    public function sendMailPaypal($model_orders, $model_user, $password) {
        Mail::send('articles::checkout.email-checkout', ['model_orders' => $model_orders, 'model_user' => $model_user, 'password' => $password], function ($m) use ($model_orders) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject(SUBJECT_PAYPAL_PAYMENT . $model_orders->order_no);
        });
    }

    public function sendMailVisa($model_orders, $model_user, $password) {
        Mail::send('articles::checkout.visa-email-checkout', ['model_orders' => $model_orders, 'model_user' => $model_user, 'password' => $password], function ($m) use ($model_orders) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject(SUBJECT_VISA_PAYMENT . $model_orders->order_no);
        });
    }

    //[Amazon payment] Gửi mail cho khách hàng sử dụng phương thức amazon
    public function sendMailAmazon($model_orders, $model_user, $password) {
        Mail::send('articles::checkout.amazon-email-checkout', ['model_orders' => $model_orders, 'model_user' => $model_user, 'password' => $password], function ($m) use ($model_orders) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject(SUBJECT_AMAZON_PAYMENT . $model_orders->order_no);
        });
    }

    //[WMZ payment] Gửi mail cho khách hàng sử dụng phương thức WEBMONEY
    public function sendMailWebMoney($model_orders, $model_user, $password) {
        Mail::send('articles::checkout.wmz-email-checkout', ['model_orders' => $model_orders, 'model_user' => $model_user, 'password' => $password], function ($m) use ($model_orders) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject(SUBJECT_WMZ_PAYMENT . $model_orders->order_no);
        });
    }

    //[PERFECT MONEY payment] Gửi mail cho khách hàng sử dụng phương thức PERFECT MONEY
    public function sendMailPerfectMoney($model_orders, $model_user, $password) {
        Mail::send('articles::checkout.perfect-email-checkout', ['model_orders' => $model_orders, 'model_user' => $model_user, 'password' => $password], function ($m) use ($model_orders) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject(SUBJECT_PERFECT_PAYMENT . $model_orders->order_no);
        });
    }

    //[My money payment] Gửi mail cho khách hàng sử dụng phương thức my money
    public function sendMailChooseBonus($model_orders, $model_user, $password) {
        Mail::send('articles::checkout.bonus-email-checkout', ['model_orders' => $model_orders, 'model_user' => $model_user, 'password' => $password], function ($m) use ($model_orders) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject(SUBJECT_BONUS_PAYMENT . $model_orders->order_no);
        });
    }

    public function sendMailUsedBonus($model_orders) {
        Mail::send('articles::checkout.email-used-bonus', ['model_orders' => $model_orders], function ($m) use ($model_orders) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to(EMAIL_RECEIVE_ORDER, "Minh Tiến")->subject(SUBJECT_USED_BONUS . $model_orders->order_no);
        });
    }

    public function sendMailLockAccount($model_orders) {
        Mail::send('articles::checkout.email-lock-account', ['model_orders' => $model_orders], function ($m) use ($model_orders) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject(SUBJECT_LOCK_ACCOUNT);
        });
    }

    function getLocationInfoByIp() {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = @$_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if ($ip_data && $ip_data->geoplugin_countryName != null) {
            return $ip_data->geoplugin_countryCode;
        }
        return "";
    }

    ///MUA SẢN PHẨM
    public function index(Request $request) {
        SeoPage::seoPage($this);
        $money_user = 0;
        $model_terms = Information::find(5);
        $model_payment_type = PaymentType::orderBy("position", "ASC")->get();

        $data = Session::get('array_orders', []);
        $obj_shopping_cart = new UserShoppingCart();
        $subTotal = $obj_shopping_cart->getSubTotal($data);
        Session::set('sub_total', $subTotal);

        $model_payment_selected = PaymentType::where("status_selected", "=", 1)->first();
        $totalOrder = $this->getTotalOrder($data, $model_payment_selected->id, $money_user);
        $model_user = $this->checkMember();
        if ($model_user != null) {
            $money_user = $model_user->getMoneyForUser();
            $model_user->updateSessionMoney($money_user);
        }

        if (count($data) != 0) {

            $user_country = $this->getLocationInfoByIp();

            return view('articles::checkout.checkout', compact(
                            "data", "model_payment_type", "model_terms", "model_user", 'totalOrder', 'money_user', 'user_country'
            ));
        } else {
            return view('articles::checkout.checkout-none');
        }
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

    /*
     * $data_product: mảng sản phẩm cần mua
     * $payment_id: id loại tiền thanh toán
     * $charges_bonus: Số tiền sẽ sửa dụng trong tài khoản sản có.
     * * */

    function getTotalOrder($data_product, $payment_id, $charges_bonus) {
        $sub_total = 0;
        $payment_charges = 0;
        $total = 0;
        $payment_name = "";
        $payment_code = "";

        foreach ($data_product as $item) {
            $sub_total = $sub_total + ($item["quantity"] * $item["price_order"]);
        }

        if ($sub_total != 0) {
            // Default 20%
            $payment_charges = round(($sub_total * 20) / 100, 2);
            $model = PaymentType::find($payment_id);
            if ($model != null) {
                $payment_charges = $this->getPaymentCharges($sub_total, $model);
                $payment_name = $model->title;
                $payment_code = $model->code;
                if ($model->code == "BONUS") {
                    $charges_bonus = 0;
                }
            }
            $total = $sub_total + $payment_charges - $charges_bonus;
            if ($total < 0) {
                $total = 0;
                $charges_bonus = $sub_total + $payment_charges;
            }
        }

        $return_data = array(
            "sub_total" => $sub_total,
            "charges" => $payment_charges,
            "payment_name" => $payment_name,
            "payment_code" => $payment_code,
            "used_bonus" => $charges_bonus,
            "total" => round($total,2)
        );
        return $return_data;
    }

    //Thay đổi loại hình thanh toán
    public function selectTypePayment(Request $request) {
        $data = $request->all();
        if (isset($data["payment_id"])) {
            $payment_id = $data["payment_id"];
            $money_user = 0;
            if ($data["check_bonus"] == "true") {
                $model_user = $this->checkMember();
                if ($model_user) {
                    $money_user = $model_user->getMoneyForUser();
                }
            }
            $data_product = Session::get('array_orders', []);
            $totalOrder = $this->getTotalOrder($data_product, $payment_id, $money_user);
            return $totalOrder;
        }
    }

    //Lựa chọn sử dụng tiền bonus trong tài khoản
    public function chooseBonusMoney(Request $request) {
        $data = $request->all();
        $payment_id = $data["payment_id"];
        $check_bonus = $data["check_bonus"];
        $money_user = 0;
        if ($check_bonus == "true") {
            $model_user = $this->checkMember();
            if ($model_user) {
                $money_user = $model_user->getMoneyForUser();
            }
        }
        $data_product = Session::get('array_orders', []);
        $totalOrder = $this->getTotalOrder($data_product, $payment_id, $money_user);
        return $totalOrder;
    }

    //Thay đổi số lượng sản phẩm khi checkout
    public function changeQuantity(Request $request) {
        if (isset($request)) {
            $data = $request->all();
            //Log::info($data);
            if (isset($data["id"]) && isset($data["number"])) {
                $id = $data["id"];
                $number = $data["number"];
                $model_articles_type = ArticlesType::find($id);
                if ($model_articles_type) {
                    $model_user = $this->checkMember();
                    $money_user = 0;
                    if ($model_user) {
                        $array_orders = $this->changeNumberProductOrderForMember($model_user, $model_articles_type, $number);
                        if ($data["check_bonus"] == "true") {
                            $money_user = $model_user->getMoneyForUser();
                        }
                    } else {
                        $array_orders = $this->changeNumberProductOrderForGuest($model_articles_type, $number);
                    }
                    $obj_shopping_cart = new UserShoppingCart();
                    $data_product = $array_orders;
                    $obj_shopping_cart->setSession($data_product);
                    $totalOrder = $this->getTotalOrder($data_product, $data["payment_type"], $money_user);
                    return $totalOrder;
                }
            }
        }
        return redirect()->route('frontend.articles.index');
    }

    //Thay đổi trạng thái shopping cart của khách hàng
    //Xóa session shopping cart
    public function changeStatusAfterCheckout($model_user) {
        UserShoppingCart::where("user_id", "=", $model_user->id)->update(['status_payment' => 'Checkout']);
        $obj = new UserShoppingCart();
        $obj->emptySession();
    }

    public function findUserForCheckout($email) {
        $model_user = User::where("email", "=", $email)->first();
        if ($model_user == null) {// Không có mail trong bảng User
            $check_user_shipping = UserShippingAddress::where("email", "=", $email)->first();
            if ($check_user_shipping) {// Tìm thấy email trong bảng shipping address
                $model_user = User::find($check_user_shipping->user_id);
            }
        }
        return $model_user;
    }

    public function getConfirmOrder(Request $request) {
        $request->session()->flash('alert-warning', 'Warning: Server error. Please come back later!');
        return redirect()->route('frontend.checkout.index');
    }

    public function checkEmailPaypal($email) {
        if (strpos(strtolower($email), 'paypal') !== false) {
            return true;
        } else {
            return false;
        }
    }

    public function confirmOrder(CheckoutRequest $request) {
        if (isset($request)) {
            DB::beginTransaction();
            $data = $request->all();
            $array_orders = Session::get('array_orders', []);
            $password = "";
            $used_bonus = 0;
            $check_created_user = false;
            if (isset($data["payments_type_id"])) {
                $model_payment_type = PaymentType::find($data["payments_type_id"]);
                if ($model_payment_type != null) {

                    //Check email paypal kiem tra site
                    if ($model_payment_type->code == "PAYPAL") {
                        $check_paypal = $this->checkEmailPaypal($data['email']);
                        if ($check_paypal == true) {
                            $request->session()->flash('alert-warning', 'Warning: PayPal payment method is being maintained. Please select another payment method!');
                            return back();
                        }
                    }

                    if (count($array_orders) > 0) {
                        $model_user = $this->checkMember();
                        if ($model_user == null) {
                            //Tìm user qua email
                            $model_user = $this->findUserForCheckout($data['email']);
                        }
                        if ($model_user == null) {
                            $obj_user = new User();
                            $result = $obj_user->createUser($data);
                            if ($result) {
                                $user_id = $result["user_id"];
                                $password = $result["password"];
                                $model_user = User::find($user_id);
                                //BẢO MẬT NÊN KHÔNG ĐƯỢC DI CHUYỂN KHỎI IF NÀY
                                //Chỉ user new mới được login, bởi cần tính bảo mật trong trường hợp người dùng điền bừa email
                                Auth::loginUsingId($model_user->id);
                                Session::set('user_email_login', $model_user->email);
                                $data["shipping_address"] = $model_user->email;
                                $check_created_user = true;
                            } else {
                                $request->session()->flash('alert-warning', 'Warning: Server error. Please come back later!');
                                return back();
                            }
                        }

                        if ($model_user != null) {//TÌM THẤY NGƯỜI DÙNG TỒN TẠI TRÊN HỆ THỐNG
                            if ($model_user->status_delete == 1) {
                                $request->session()->flash('alert-warning', 'Warning: Your account has been locked!');
                                return back();
                            }

                            $money_user = $model_user->getMoneyForUser();
                            if (isset($data["use_my_bonus"]) && $model_payment_type->code != "BONUS") {
                                $used_bonus = $money_user;
                            }
                            if ($model_payment_type->code == "BONUS") {
                                $checkMoney = $this->checkUsePaymentBonus($data, $array_orders, $model_user);
                                if ($checkMoney == false) {//KIỂM TRA NGƯỜI DÙNG CÓ ĐỦ TIỀN BONUS THỰC HIỆN THANH TOÁN HAY KHÔNG
                                    $request->session()->flash('alert-warning', 'Warning: You do not have enough money in your account. Please come back later!');
                                    return back();
                                }
                            }

                            //CREATE ORDER
                            $totalOrder = $this->getTotalOrder($array_orders, $data["payments_type_id"], $used_bonus);
                            $obj_model_orders = new UserOrders();
                            $model_orders = $obj_model_orders->createOrder($model_user, $money_user, $data, $array_orders, $totalOrder);
                            if ($model_orders) {
                                //SAVE LỊCH SỬ CHI TIÊU CỦA KHÁCH HÀNG - SPENDING
                                $obj_bonus_history = new BonusPaymentHistory();
                                if ($model_payment_type->code == "BONUS") {
                                    $model_bonus_history = $obj_bonus_history->saveHistorySpending($model_orders, $model_user, "BONUS");
                                } else if ($used_bonus != 0) {
                                    $model_bonus_history = $obj_bonus_history->saveHistorySpending($model_orders, $model_user, "NA");
                                }
                                //SAVE LỊCH SỬ TRẠNG THÁI CỦA ORDER
                                $model_history = new UserOrdersHistory();
                                $model_history->saveHistoryOrder($model_orders);
                                $this->changeStatusAfterCheckout($model_user);

                                switch ($model_orders->payment_type->code) {
                                    case "PAYPAL":
                                        $this->sendMailPaypal($model_orders, $model_user, $password);
                                        break;
                                    case "AMAZON":
                                        $this->sendMailAmazon($model_orders, $model_user, $password);
                                        break;
                                    case "BONUS":
                                        $this->sendMailChooseBonus($model_orders, $model_user, $password);
                                        break;
                                    case "WEBMONEY":
                                        $this->sendMailWebMoney($model_orders, $model_user, $password);
                                        break;
                                    case "PERFECT_MO":
                                        $this->sendMailPerfectMoney($model_orders, $model_user, $password);
                                        break;
                                }

                                if ($model_orders->total_price == 0 || $model_orders->payment_type->code == "BONUS") {
                                    $this->sendMailUsedBonus($model_orders);
                                }

                                DB::commit();
                                return redirect()->route('frontend.invoice.view', ['id' => $model_orders->id, 'email' => $model_orders->email]);
                                //return redirect()->route('frontend.checkout.success', ['email' => $model_user->email, "password" => $password]);
                            } else {
                                $request->session()->flash('alert-warning', 'Warning: Your account has been lock! Please use another email to purchase your product.');
                            }
                        } else {
                            $request->session()->flash('alert-warning', 'Warning: Can not create new user!');
                        }
                    } else {
                        $request->session()->flash('alert-warning', 'Warning: Your shopping cart is empty!');
                    }
                } else {
                    $request->session()->flash('alert-warning', 'Warning: This payment method does not exist!');
                }
            } else {
                $request->session()->flash('alert-warning', 'Warning: Please select a payment method!');
            }
        } else {
            $request->session()->flash('alert-warning', 'Warning: Server error. Please come back later!');
        }
        return back();
    }

    //Kiểm tra số tiền trong tài khoản của khách hàng có đủ điều khiện thực hiện phương thức thanh toán BONUS không?
    public function checkUsePaymentBonus($data, $array_orders, $model_user) {
        $totalOrder = $this->getTotalOrder($array_orders, $data["payments_type_id"], 0);
        $total_price = $totalOrder["total"];
        $total_money = $model_user->getMoneyForUser();
        if ($total_money >= $total_price) {
            return true;
        } else {
            return false;
        }
    }

    public function checkoutSuccess($email = "", $password = "") {
        SeoPage::seoPage($this);
        return view('articles::checkout.checkout-success', compact('email', 'password'));
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
                $money_user = 0;
                if ($model_user) {
                    $array_orders = $this->deleteSessionOrderForMember($model_user, $model_articles_type);
                    if ($data["check_bonus"] == "true") {
                        $money_user = $model_user->getMoneyForUser();
                    }
                } else {
                    $array_orders = $this->deleteSessionOrderForGuest($model_articles_type);
                }
                $obj_shopping_cart = new UserShoppingCart();
                $data_product = $array_orders;
                $obj_shopping_cart->setSession($data_product);
                $totalOrder = $this->getTotalOrder($data_product, $data["payment_type"], $money_user);
                $subTotal = $totalOrder["sub_total"];
                $payment_charges = $totalOrder["charges"];
                $total = $totalOrder["total"];
                return view('articles::append.listProductCheckout', compact('data_product', 'subTotal', 'payment_charges', 'total'));
            }
        }
        return response()->json("Delete error !!!", 404);
    }

    public function createOrderVisa(Request $request) {
        DB::beginTransaction();
        $data = $request->all();

        Log::info("VISA CHECKOUT");
        Log::info($data);

        $array_orders = Session::get('array_orders', []);
        $used_bonus = 0;
        $password = "";
        $model_payment = PaymentType::where("code", "VISA")->first();
        if ($model_payment) {
            if (count($array_orders) > 0) {
                $data["payments_type_id"] = $model_payment->id;
                $model_user = $this->checkMember();
                //Tìm user qua email
                if ($model_user == null) {
                    $model_user = $this->findUserForCheckout($data['email']);
                }
                //Tạo user nếu chưa tồn tại
                if ($model_user == null) {
                    $obj_user = new User();
                    $result = $obj_user->createUser($data);
                    if ($result) {
                        $user_id = $result["user_id"];
                        $password = $result["password"];
                        $model_user = User::find($user_id);
                        Auth::loginUsingId($model_user->id);
                        Session::set('user_email_login', $model_user->email);
                    }
                }
                if ($model_user) {
                    $money_user = $model_user->getMoneyForUser();
                    if (isset($data["use_my_bonus"]) && $data["use_my_bonus"] == 1) {
                        $used_bonus = $money_user;
                    }
                    $totalOrder = $this->getTotalOrder($array_orders, $model_payment->id, $used_bonus);
                    //Tạo order
                    $obj_model_orders = new UserOrders();
                    $model_orders = $obj_model_orders->createOrder($model_user, $money_user, $data, $array_orders, $totalOrder);
                    if ($model_orders && $totalOrder["total"] >= VISA_PAYMENT_MIN) {
                        //SAVE LỊCH SỬ CHI TIÊU CỦA KHÁCH HÀNG - SPENDING
                        $obj_bonus_history = new BonusPaymentHistory();
                        if ($used_bonus > 0) {
                            $obj_bonus_history->saveHistorySpending($model_orders, $model_user, "NA");
                        }
                        //SAVE LỊCH SỬ TRẠNG THÁI CỦA ORDER
                        $model_history = new UserOrdersHistory();
                        $model_history->saveHistoryOrder($model_orders);
                        $this->changeStatusAfterCheckout($model_user);
                        $this->sendMailVisa($model_orders, $model_user, $password);
                        //SEND MAIL
                        $visa = array(
                            "status" => 1,
                            "total_price" => $totalOrder["total"],
                            "order_id" => $model_orders->id,
                            "order_no" => $model_orders->order_no,
                        );
                        DB::commit();
                        return $visa;
                    }
                }
            }
        }
        $visa = array(
            "status" => 0,
        );
        return $visa;
    }

}
