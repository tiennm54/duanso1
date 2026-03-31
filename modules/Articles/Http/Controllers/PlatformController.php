<?php

namespace Modules\Articles\Http\Controllers;

use App\Models\ArticlesType;
use App\Models\StripeAccount;
use App\Models\Information;
use App\Models\PaymentType;
use App\Models\PaypalAccount;
use App\Models\UserOrders;
use App\Models\UserOrdersHistory;
use App\Models\UserShippingAddress;
use App\Models\BonusPaymentHistory;
use App\Models\KeyStock;
use App\Models\BlackListIP;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Modules\Articles\Http\Requests\CheckoutRequest;
use App\Models\UserShoppingCart;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserOrdersDetail;
use Log;
use DB;
use URL;

class PlatformController extends CheckoutController {

    public function __construct() {
        $this->middleware("banListIP");
    }

    public function platformCreateOrder(Request $request) {
        DB::beginTransaction();
        $data = $request->all();
        $paymentType_code = $data["payment_type_code"];
        $array_orders = Session::get('array_orders', []);
        $used_bonus = 0;

        $model_payment = PaymentType::where("code", $paymentType_code)->first(); // lấy được payment type từ client về
        if ($model_payment) {
            if (count($array_orders) > 0) {
                $data["payments_type_id"] = $model_payment->id;
                $model_user = $this->findUserForOrder($data);
                if ($model_user) {
                    $money_user = $model_user->getMoneyForUser();
                    if (isset($data["use_my_bonus"]) && $data["use_my_bonus"] == 1) {
                        $used_bonus = $money_user;
                    }
                    $totalOrder = $this->getTotalOrder($array_orders, $model_payment->id, $used_bonus);
                    //Check số tiền thanh toán vượt quá hạn mức cho phép
                    $checkMaxOrder = $this->checkMaxOrder($request, $totalOrder, $model_payment);
                    $checkTimePay = $this->checkTimePay($request);

                    if ($checkMaxOrder == 1 && $checkTimePay == 1) {// Hạn mức thanh toán không bị vượt quá mức cho phép
                        //Tạo order
                        $obj_model_orders = new UserOrders();
                        $model_orders = $obj_model_orders->createOrder($model_user, $money_user, $data, $array_orders, $totalOrder);
                        if ($model_orders) {

                            //SAVE LỊCH SỬ CHI TIÊU CỦA KHÁCH HÀNG - SPENDING
                            $obj_bonus_history = new BonusPaymentHistory();
                            if ($used_bonus > 0) {
                                $obj_bonus_history->saveHistorySpending($model_orders, $model_user, "NA");
                            }
                            //Tao PARAMS de gui len PLATFORM xu ly
                            $platformParams = $this->getPlatformParams($model_orders, $model_payment);

                            // POST thong tin len PLATFORM va nhan reponse tra ve 
                            $response = $this->platformPost($platformParams);
                            //Log::info("RESPONSE TRA VE TU PLATFORM");
                            //Log::info($response);

                            $response["url_invoice"] = $this->getURLInvoice($model_orders); // Add link view invoice cua khach hang de huong dan khach hang check email thuc hien thanh toan

                            $status = (isset($response["status"])) ? $response["status"] : "";
                            $message = (isset($response["message"])) ? $response["message"] : "";
                            $payment_type = (isset($response["payment_type"])) ? $response["payment_type"] : "";
                            $payment_url = (isset($response["payment_url"])) ? $response["payment_url"] : "";
                            $error = (isset($response["error"])) ? $response["error"] : 0;

                            if ($status == "success") {
                                //Thiếu đoạn gửi email invoice tới khách hàng
                                if ($payment_type == 'invoice' || $payment_type == 'none') { // PAYMENT TYPE LÀ INVOICE
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
                            return $response;
                        }
                    }
                } else {
                    Log::info("PLATFORM CREATE ORDER: model_user == null");
                }
            } else {
                Log::info("PLATFORM CREATE ORDER: count array_orders == 0");
            }
        } else {
            Log::info("PLATFORM CREATE ORDER: KHONG TIM THAY model_payment");
        }

        $dataResponse = array(
            "status" => "error",
            "message" => "The payment method you selected cannot process payment for your order."
        );
        return $dataResponse;
    }

    public function platformCallback(Request $request) {
        //Log::info("START CALLBACK PLATFORM!!!");
        if (isset($request)) {
            DB::beginTransaction();
            $data = $request->all();
            Log::info($data);

            $order_id = (isset($data["data"]["request_id"])) ? $data["data"]["request_id"] : 0;
            $amount = (isset($data["data"]["amount"])) ? $data["data"]["amount"] : 0;
            $email = (isset($data["data"]["email"])) ? $data["data"]["email"] : 0;

            $signature = (isset($data["signature"])) ? $data["signature"] : "";
            $code = (isset($data["code"])) ? $data["code"] : 0; // Code = 2 nghia là success
            $email_blocked = (isset($data["email_blocked"])) ? $data["email_blocked"] : ""; // Code = 2 nghia là success
            $transaction_id = (isset($data["transaction_id"])) ? $data["transaction_id"] : "";

            $checkSingature = $this->generateSignature($data["data"]);
            if ($checkSingature == $signature) {
                $keyStock = new KeyStock();
                $model = UserOrders::find($order_id);
                if ($model && $model->id == $order_id) {

                    Log::info("MODEL ID #" . $model->id);

                    if ($model->payment_status == "completed") {
                        echo "done";
                        Log::info("DONE COMPLETED ORDER: #" . $order_id);
                        exit;
                    }
                    if ($code == 2) {// thanh toan thành công
                        if ($model->total_price == $amount) {

                            //KIỂM TRA SẢN PHẨM CÓ DÙNG API LINK KHÔNG??????
                            //NẾU DÙNG THÌ TẠO KEY THÔNG QUA API VÀ SAVE VÀO DB
                            $keyStock->checkLinkApiProduct($model);

                            //Send key toi khach hang
                            $model_key = $keyStock->sendAndChangeStatusKey($model);
                            if ($model_key != null) {
                                $keyStock->sendProductEmail($model, $model_key);
                            } else {
                                $keyStock->sendMailPaid($model);
                                $keyStock->sendEmailOutOfStock($model);
                            }
                            
                            Log::info("DONE ORDER: #" . $order_id);
                            echo "done";
                        } else {// PLATFORM tra ve Order ID sai
                            //$keyStock->sendMailPaid($model);
                            $model->payment_status = "echeck";
                            $model->save();
                            Log::info("ECHECK VOI CODE = 2 ORDER: #" . $order_id);
                        }
                        
                    } else if ($code == 1 || $email_blocked != "") { // echeck
                        if ($model->total_price == $amount) {
                            $keyStock->sendMailPaid($model);
                            $model->payment_status = "echeck";
                            $model->save();
                        }
                        Log::info("ECHECK VOI CODE = 1 ORDER: #" . $order_id);
                        echo "done";
                    }
                    DB::commit();
                    exit;
                    //return redirect()->route('frontend.invoice.view', ['id' => $model->id, 'email' => $model->email]);
                } else {
                    Log::info("platformCallback(): Khong tim thay model order theo ID !!!");
                    $model = UserOrders::where("email", "=", $email)->orderBy("id", "DESC")->first();
                    if ($model) {
                        if ($model->payment_status == "pending") {
                            if ($model->total_price == $amount) {
                                $keyStock->sendMailPaid($model);
                                $model->payment_status = "echeck";
                                $model->save();
                            }
                            DB::commit();
                            echo "done";
                            Log::info("TIM THEO EMAIL => ECHECK ORDER: #" . $model->id);
                            exit;
                        }
                    } else {
                        //send email thông báo cần kiểm tra bằng tay
                        $keyStock->sendEmailCheckOrder($email, $transaction_id);
                        echo "done";
                        Log::info("Da gui email kiem tra khach hang nay: " . $email);
                        exit;
                    }
                }
            } else {
                Log::info("platformCallback(): checkSingature khong dung !!!");
            }
        }
        Log::info("CALLBACK PLATFORM ERORR!!!");
        return redirect()->route('frontend.checkoutVisa.failure');
    }

    public function getNotifyPaymentError() {
        return view('articles::platform.error-notify');
    }

    public function getURLInvoice($model_orders) {
        $url_invoice = URL::route('frontend.invoice.view', ['id' => $model_orders->id, 'email' => $model_orders->email]);
        return $url_invoice;
    }

    public function getURLNotifyCallback() {
        $url_notify = URL::route('frontend.platform.platformCallback');
        return $url_notify;
    }

    public function findUserForOrder($data) {
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
                Session::set('user_password_login', $password);
            }
        }
        return $model_user;
    }

    public function checkTimePay(Request $request) {
        $model_pending = $this->checkOrderViaIP();
        if ($model_pending != null) {
            $request->session()->flash('alert-warning', 'Warning: Your order #' . $model_pending->id . ' has not been processed successfully, please wait 1 hour before you create a new order. We apologize for this inconvenience.');
            return 0;
        } else {
            return 1;
        }
    }

    public function checkMaxOrder(Request $request, $totalOrder, $model_payment) {
        if ($model_payment->max_payment > 0 && $totalOrder["total"] > $model_payment->max_payment) {
            $request->session()->flash('alert-warning', 'Warning: The total value of your order is too large. ( Total <= ' . $model_payment->max_payment . ' ).'
                    . ' Please choose another payment method.'
                    . ' I apologize for this inconvenience.'
                    . ' Thank you so much!');
            return 0;
        } else {
            return 1;
        }
    }

    public function generateSignature($params) {
        ksort($params);
        $secretKey = PLATFORM_PRIVATE_KEY;
        $signature = hash_hmac("sha256", base64_encode(json_encode($params)), $secretKey);
        return $signature;
    }

    public function curlPlatformPost($params, $merchant_id, $signature, $gateway_url) {
        $headers = [
            "Authorization: client_id=$merchant_id&signature=$signature",
            "Content-Type: application/json"
        ];

        $curl = curl_init($gateway_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));

        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, true);
        return $result;
    }

    //Lay list code cac san pham ma khach hang mua sam
    public function getCodeProduct($model) {
        $listProduct = "";
        $model_product = UserOrdersDetail::where("user_orders_id", "=", $model->id)->get();
        foreach ($model_product as $item) {
            $listProduct = $listProduct . trim($item->title) . ",";
        }
        return trim($listProduct, ",");
    }

    //Lay cac thong tin cua param de gui len platform xu ly
    public function getPlatformParams($model, $model_payment) {
        $country_code = "N/A";
        $country_name = "N/A";
        $ips = "N/A";

        if ($model->user_info) {
            $user_info = explode("|", $model->user_info);
            if (isset($user_info[0]) && isset($user_info[1]) && isset($user_info[2])) {
                $country_code = trim($user_info[0]);
                $country_name = trim($user_info[1]);
                $ips = trim($user_info[2]);
            }
        }

        $customer_name = $model->first_name . " " . $model->last_name;
        $params = [
            "request_id" => (string) $model->id,
            "amount" => (string) $model->total_price,
            "email" => trim($model->email),
            //"description" => $this->getCodeProduct($model),
            "items" => $this->getCodeProduct($model), // danh sách product gửi lên
            "first_name" => trim($customer_name),
            "cancel_url" => "NA",
            "return_url" => $this->getURLInvoice($model),
            "notify_url" => $this->getURLNotifyCallback(),
            "ip" => $model->user_ip,
            "method" => $model_payment->code,
            "country_code" => $country_code,
            "country_name" => $country_name,
            "ips" => $ips
        ];
        //Log::info("POST PARAM: ");
        //Log::info($params);

        return $params;
    }

    public function platformPost($params) {
        $platform_sigature = $this->generateSignature($params);
        $response = $this->curlPlatformPost($params, PLATFORM_PUBLIC_KEY, $platform_sigature, PLATFORM_URL_POST);
        //Log::info("POST PARAM LEN PLATFORM VA NHAN VE KET QUA: ");
        //Log::info($response);
        return $response;
    }

    //END PLATFORM
    //Lấy danh sách sản phẩm cho platform
    public function getListProductCode() {
        $model = ArticlesType::orderBy('title', 'ASC')->get();
        $data = [];
        foreach ($model as $items) {
            if ($items->getArticles->status_stock == 1) {
                $array_item = [
                    "product_id" => $items->id,
                    "product_code" => $items->title
                ];
                array_push($data, $array_item);
            }
        }
        echo json_encode($data);
    }

    //Nhận response từ Platform để cập nhật status acc Limited
    public function platformUpdateAccLimited(Request $request) {
        //Log::info("START CALLBACK UPDATE ACC LIMITED !!!");
        if (isset($request)) {
            DB::beginTransaction();
            $data = $request->all();
            //Log::info($data);

            $email = (isset($data["data"]["email"])) ? $data["data"]["email"] : "";
            $status = (isset($data["data"]["status"])) ? $data["data"]["status"] : "";
            $signature = (isset($data["signature"])) ? $data["signature"] : "";

            $param = [
                "data" => [
                    "email" => $email,
                    "status" => $status
                ]
            ];
            $checkSingature = $this->generateSignature($param['data']);
            Log::info($checkSingature);
            if ($checkSingature == $signature) {

                Log::info("Check signature acc limited ok!!!");

                $model = PaypalAccount::where("email", "=", trim($email))->first();
                if ($model) {
                    if ($status == "Limited Step") {
                        $model->status = "UnLimit";
                        $model->save();
                    } else if ($status == "Limited 180d") {
                        $model->status = "Limit";
                        $model->save();
                    }
                    DB::commit();
                    Log::info("save acc limited ok: " . $email . " Status: " . $status);
                }
            }
        }
    }

    public function testGetKey($id) {
        $model_order = UserOrders::find($id);
        if ($model_order) {
            $model_stock = new KeyStock();
            $model_stock->checkLinkApiProduct($model_order);
        }
    }

}
