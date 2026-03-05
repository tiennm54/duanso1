<?php

namespace Modules\Articles\Http\Controllers;

use App\Models\ArticlesType;
use App\Models\ArticlesTypeKey;
use App\Models\PaymentType;
use App\Models\UserOrders;
use App\Models\UserOrdersHistory;
use App\Models\KeyStock;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\UserOrdersDetail;
use Log;
use DB;
use URL;

class FastCheckoutController extends PlatformController {

    public function __construct() {
        $this->middleware("banListIP");
    }

    public function view(Request $request, $payment_name, $product_id, $customer_email = '') {//ID sản phẩm mua, VISA/PAYPAL, EMAIL KHÁCH HÀNG
        DB::beginTransaction();
        $paymentType_code = "PREMIUM_PAYPAL";

        if (isset($payment_name) && isset($product_id) && isset($customer_email)) {

            if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format";
                return null;
            }

            if ($payment_name == "visa") {
                $paymentType_code = "PREMIUM_STRIPE";
            } else {
                $paymentType_code = "PREMIUM_PAYPAL";
            }

            $dataUser = array(
                "first_name" => "Guest",
                "last_name" => "Guest",
                "email" => $customer_email
            );

            $model_user = $this->findUserForOrder($dataUser);
            
            //Log::info("=>>>>>>>>>>>>FCHECKOUT MODEL USER");
            //Log::info($model_user);
            
            $model_product = ArticlesType::find($product_id);
            $model_payment = PaymentType::where("code", $paymentType_code)->first();

            if ($model_user != null && $model_product != null && $model_payment != null) {

                //CHECK IP AND PROXY
                $ip = $this->get_client_ip();
                $infoIP = $this->getInfoIP($ip);

                if (isset($infoIP['status']) && $infoIP['status'] == 'success') {
                    $user_country = $infoIP['countryCode'];
                    $check_isp = strpos(strtolower($infoIP['isp']), 'paypal');
                    $check_proxy = $infoIP['proxy'];
                    $check_hosting = $infoIP['hosting'];
                    if ($check_isp !== false || $check_proxy === true || $check_hosting === true) {
                        $isProxy = "YES";
                        if ($check_isp !== false) {
                            $this->sendEmailWarningPaypal($infoIP);
                            return redirect()->route("frontend.shoppingCart.buyNow", ["id" => $product_id, 'code' => $model_product->code]);
                        }
                    }

                    $check_disable_country = $this->checkDisableForCountry($model_payment, $user_country);

                    if ($check_disable_country == 1 || $check_proxy === true || $check_hosting === true) {
                        $request->session()->flash('alert-warning', 'Please disable VPN/Proxy');
                        return redirect()->route("frontend.shoppingCart.buyNow", ["id" => $product_id, 'code' => $model_product->code]);
                    }
                }//END CHECK PROXY
                //CREATE ORDER
                $obj_model_orders = new UserOrders();
                $model_orders = $obj_model_orders->createFastOrder($model_payment, $model_product, $model_user);

                if ($model_orders) {
                    //Tao PARAMS de gui len PLATFORM xu ly
                    $platformParams = $this->getPlatformParams($model_orders, $model_payment);

                    // POST thong tin len PLATFORM va nhan reponse tra ve 
                    $response = $this->platformPost($platformParams);
                    //Log::info("FCHECKOUT RESPONSE TRA VE TU PLATFORM");
                    //Log::info($response);
                    //$response["url_invoice"] = $this->getURLInvoice($model_orders); // Add link view invoice cua khach hang de huong dan khach hang check email thuc hien thanh toan

                    $status = (isset($response["status"])) ? $response["status"] : "";
                    $message = (isset($response["message"])) ? $response["message"] : "";
                    $payment_type = (isset($response["payment_type"])) ? $response["payment_type"] : "";
                    $payment_url = (isset($response["payment_url"])) ? $response["payment_url"] : "";
                    $error = (isset($response["error"])) ? $response["error"] : 0;

                    $check_payment_type = "URL";

                    if ($status == "success") {
                        //Gửi email invoice tới khách hàng nếu tìm được acc none và acc loại invoice
                        if ($payment_type == 'invoice' || $payment_type == 'none') { // PAYMENT TYPE LÀ INVOICE
                            $check_payment_type = "INVOICE";
                            $password = "";
                            if (Session::has('user_password_login')) {
                                $password = Session::get('user_password_login');
                            }
                            $keyStock = new KeyStock();
                            $keyStock->sendMailPaypalInvoice($model_orders, $model_user, $password, $payment_url);
                        }

                        //SAVE LỊCH SỬ TRẠNG THÁI CỦA ORDER
                        $model_history = new UserOrdersHistory();
                        $model_history->saveHistoryOrder($model_orders);
                        $this->changeStatusAfterCheckout($model_user);
                        DB::commit();
                    } else {
                        if ($error == 1) {//Tat ca cac acc deu pending nen se dong cong thanh toan nay
                            $model_payment->saveStatusDisable(1);
                            $model_orders->saveStatusOrder("cancel");
                            //SEND EMAIL THÔNG BÁO ĐÃ ĐÓNG CỔNG
                            $model_payment->sendEmailClosePaymentGateway();
                            DB::commit();
                        }
                        $request->session()->flash('alert-warning', 'Warning: ' . $message);
                    }
                }

                return view('articles::fastcheckout.view', compact('model_payment', 'model_product', 'model_user', 'model_orders', 'response'));
            }
        }
    }

    public function getProduct($order_id) {//Chuyển khách hàng tới page đợi key và hướng dẫn thanh toán invoice
        //echo "tong cong tien";
        $model = UserOrders::find($order_id);
        if ($model != null) {
            $model_product = UserOrdersDetail::where("user_orders_id", "=", $model->id)->get();
            $model_key = ArticlesTypeKey::where("user_orders_id", "=", $model->id)->get();
            return view('articles::fastcheckout.getProduct', compact('model', 'model_product', 'model_key'));
        }
    }

}
