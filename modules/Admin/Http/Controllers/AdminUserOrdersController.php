<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\ArticlesType;
use App\Models\ArticlesTypeKey;
use App\Models\UserOrders;
use App\Models\UserOrdersDetail;
use App\Models\UserOrdersHistory;
use App\Models\BonusPaymentHistory;
use App\Models\UserRef;
use App\Models\User;
use App\Models\BonusConfig;
use App\Models\BonusHistory;
use App\Models\PaymentType;
use Carbon\Carbon;
use DougSisk\CountryState\CountryState;
use Illuminate\Http\Request;
use Pingpong\Modules\Routing\Controller;
use DB;
use Illuminate\Support\Facades\Mail;
use Log;

class AdminUserOrdersController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function listOrders(Request $request) {
        $data = $request->all();
        $model = UserOrders::orderBy("id", "DESC");
        if (isset($data["order_id"]) && $data["order_id"] != "") {
            $model = $model->where("order_no", "=", $data["order_id"])->orWhere("id", "=", $data["order_id"]);
        }
        if (isset($data["email"]) && $data["email"] != "") {
            $model = $model->where("email", "LIKE", "%" . $data["email"] . "%");
        }
        if (isset($data["payment_status"]) && $data["payment_status"] != "") {
            $model = $model->where("payment_status", "=", $data["payment_status"]);
        }
        if(isset($data['used_bonus']) && $data['used_bonus'] != ""){
            $model = $model->where('used_bonus', ">" , 0);
        }
        
        if(isset($data['payment_type']) && $data['payment_type'] != ""){
            $model = $model->where('payments_type_id','=', $data['payment_type']);
        }
        
        $model = $model->paginate(NUMBER_PAGE);
        $model_payment_type = PaymentType::orderBy('id','asc')->get();
        return view('admin::userOrders.listOrders', compact('model','model_payment_type'));
    }

    //Xem thông tin chi tiết order
    public function viewOrders($id, Request $request) {
        $model = UserOrders::find($id);
        if ($model) {
            foreach ($model->orders_detail as &$item) {
                $count_key = ArticlesTypeKey::where("articles_type_id", "=", $item->articles_type_id)
                        ->where("user_orders_detail_id", "=", $item->id)
                        ->where("user_orders_id", "=", $model->id)
                        ->whereNotNull("key")->where("key", "!=", "")
                        ->count();
                $item["count_key"] = $count_key;
            }
            $model_key = ArticlesTypeKey::where("user_orders_id", "=", $model->id)->get();
            $countryState = new CountryState();
            $countries = $countryState->getCountries();
            $countryState = new CountryState();
            $states = $countryState->getStates($model->country);
            $model["country_name"] = $countryState->findCountry($model->country, $countries);
            $model["state_name"] = $countryState->findState($model->state_province, $states);

            $check_send_key = $this->checkKeyEnough($model);
            $model["check_send_key"] = $check_send_key;
            $model_history = UserOrdersHistory::where("user_orders_id", "=", $model->id)->get();
            return view('admin::userOrders.view', compact('model', 'model_key', 'model_history'));
        }
        $request->session()->flash('alert-warning', 'Warning: Đã xảy ra lỗi !!!');
        return back();
    }

    /////////////////////HOÀN THIỆN ĐƠN HÀNG ĐỒNG THỜI BONUS TIỀN CHO NGƯỜI DÙNG////////////////////////
    public function sendKey($id, Request $request) {
        DB::beginTransaction();
        $model_orders = UserOrders::find($id);
        if ($model_orders) {
            $model_key = $this->getPremiumKeySend($model_orders);
            if ($model_key) {
                //Trường hợp gửi lại key cho khách hàng và khách hàng không thể nhận thêm bonus
                if ($model_orders->payment_status == "completed") {
                    $this->sendProductEmail($model_orders, $model_key);
                    $request->session()->flash('alert-success', 'Success: Đã gửi premium key thành công tới khách hàng!');
                    return back();
                }

                //BONUS: LUÔN LUÔN BONUS CHO KHÁCH
                $check_bonus = 0;
                $model_user = User::find($model_orders->users_id);
                if ($model_user) {
                    $model_user_ref = UserRef::where("user_id", "=", $model_user->id)->first();
                    $model_money = BonusConfig::orderBy("id", "DESC")->first();
                    if ($model_user_ref) {
                        if ($model_user_ref->user_sponser_id) {
                            if ($model_money) {
                                $model_sponsor = User::find($model_user_ref->user_sponser_id);
                                if ($model_sponsor) {
                                    $check_bonus = $this->bonusMoney($model_orders, $model_user, $model_sponsor, $model_money);
                                    if ($check_bonus == 1) {// lock user
                                        DB::rollBack();
                                        $model_user->saveLockStatus();
                                        $request->session()->flash('alert-warning', 'Warning: Hãy kiểm tra lại tài khoản của BUYER!');
                                    }

                                    if ($check_bonus == 2) {// lock sponsor
                                        DB::rollBack();
                                        $model_sponsor->saveLockStatus();
                                        $request->session()->flash('alert-warning', 'Warning: Hãy kiểm tra lại tài khoản của SPONSOR!');
                                    }
                                }
                            }
                        }
                    } else {//Làm thêm chức năng bonus cho khách hàng thường
                        //Log::info("Nguoi dung khong co sponsor");
                        $check_bonus_basic = $this->bonusBasic($model_orders, $model_user, $model_money);
                        if ($check_bonus_basic == 1) {// lock user
                            //Log::info("Nguoi dung bị khoa tai khoan");
                            DB::rollBack();
                            $model_user->saveLockStatus();
                            $request->session()->flash('alert-warning', 'Warning: Hãy kiểm tra lại tài khoản của BUYER!');
                        }
                    }
                }


                //Nếu người dùng, dùng phương thức thanh toán thông thường thì hệ thống vẫn gửi key cho khách
                if ($check_bonus == 0 || ($model_orders->payment_type->code != "BONUS" && $model_orders->used_bonus == 0)) {

                    $this->sendProductEmail($model_orders, $model_key);
                    foreach ($model_key as $item) {
                        $item->status = "sent";
                        $item->date_sent = Carbon::now();
                        $item->user_id = $model_orders->users_id;
                        $item->user_email = $model_orders->email;
                        $item->save();
                    }

                    $model_orders->payment_status = "completed";
                    $model_orders->payment_date = Carbon::now();
                    $model_orders->save();

                    $model_orders_history = new UserOrdersHistory();
                    $model_orders_history->saveHistoryOrder($model_orders);

                    DB::commit();
                    $request->session()->flash('alert-success', 'Success: Đã gửi premium key thành công tới khách hàng!');
                }
                return back();
            }
        }
        $request->session()->flash('alert-warning', 'Warning: Đã xảy ra lỗi !!!');
        return back();
    }

    public function bonusMoney($model_orders, $model_user, $model_sponsor, $model_money) {

        if ($model_orders->payment_status == "paid") {
            $money_sponsor = ($model_money->bonus_sponsor * $model_orders->sub_total) / 100;
            $money_user = ($model_money->bonus_reg * $model_orders->sub_total) / 100;

            //Bonus for user
            if ($money_user > 0) {
                $money_user_current = $model_user->getMoneyForUser();
                $money_user_check = $model_user->getMoneyAccountCurrent();
                if ($money_user_current == $money_user_check && $model_user->status_lock == 0) {
                    $obj_bonus_his = new BonusHistory();
                    $obj_bonus_his->saveBonusHistory($model_orders, $model_user->id, $model_sponsor->id, $money_user, "Buyer", $model_money->bonus_reg);
                    $total_money_user = $model_user->getMoneyForUser();
                    //Log::info("Updated: " . $total_money_user);
                    $model_user->updateMoneyForUser($total_money_user);
                    $this->sendMailBonus($model_orders, $model_user, $money_user);
                } else {
                    return 1;
                }
            }

            //Bonus for sponsor
            if ($money_sponsor > 0) {
                $money_sponsor_current = $model_sponsor->getMoneyForUser();
                $money_sponsor_check = $model_sponsor->getMoneyAccountCurrent();
                if ($money_sponsor_current == $money_sponsor_check && $model_sponsor->status_lock == 0) {
                    $obj_bonus_his = new BonusHistory();
                    $obj_bonus_his->saveBonusHistory($model_orders, $model_user->id, $model_sponsor->id, $money_sponsor, "Sponser", $model_money->bonus_sponsor);
                    $total_money_sponsor = $model_sponsor->getMoneyForUser();
                    $model_sponsor->updateMoneyForUser($total_money_sponsor);
                    $this->sendMailBonus($model_orders, $model_sponsor, $money_sponsor);
                } else {
                    return 2;
                }
            }
        }
        return 0;
    }

    //Bonus cho người dùng không có sponsor
    public function bonusBasic($model_orders, $model_user, $model_money) {
        if($model_money) {
            if ($model_orders->payment_status == "paid") {
                $money_basic = ($model_money->bonus_basic * $model_orders->sub_total) / 100;
                if ($money_basic > 0) {
                    $money_user_current = $model_user->getMoneyForUser();
                    $money_user_check = $model_user->getMoneyAccountCurrent();
                    if ($money_user_current == $money_user_check && $model_user->status_lock == 0) {
                        $obj_bonus_his = new BonusHistory();
                        $obj_bonus_his->saveBonusHistory($model_orders, $model_user->id, 0, $money_basic, "Buyer", $model_money->bonus_basic);
                        $total_money_user = $model_user->getMoneyForUser();
                        //Log::info("Updated: " . $total_money_user);
                        $model_user->updateMoneyForUser($total_money_user);
                        $this->sendMailBonus($model_orders, $model_user, $money_basic);
                    } else {
                        return 1;
                    }
                }
            }
        }
        return 0;
    }

    public function autoCompleteEmail(Request $request) {
        if (isset($request)) {
            $data = UserOrders::select(
                            "id", "email as name"
                    )->where("email", "LIKE", "%{$request->input('query')}%")->get();
            return response()->json($data);
        }
    }

    //THAY ĐỔI TRANG THÁI ORDER
    public function saveStatusPayment($id, Request $request) {
        if (isset($request)) {
            $data = $request->all();
            if (isset($data["payment_status"])) {
                $model = UserOrders::find($id);
                if ($model) {
                    $model_user = User::find($model->users_id);
                    $tmp_status = $model->payment_status;
                    $payment_status = $data["payment_status"];
                    switch ($payment_status) {
                        case 'paid' :
                            //Kiểm tra và xác nhận trừ tiền trong tài khoản
                            $checkPaid = $this->paymentByBonus($model, $model_user);
                            if ($checkPaid) {
                                $this->saveOrderCountForProduct($model);
                                $this->sendMailPaid($model);
                            } else {
                                $request->session()->flash('alert-warning', 'Warning: Vui lòng kiểm tra giao dịch của tài khoản này!');
                                return back();
                            }
                            break;

                        case 'completed' :
                            if ($tmp_status == 'paid') {
                                $checkUpdateCompleted = $this->checkKeyEnough($model);
                                if ($checkUpdateCompleted == 0) {
                                    $request->session()->flash('alert-warning', 'Warning: Chưa cung cấp premium key cho người dùng');
                                    return back();
                                } else {
                                    $request->session()->flash('alert-warning', 'Warning: OKIE...Hãy send key để hoàn thành đơn hàng');
                                    return back();
                                }
                            } else {
                                $request->session()->flash('alert-warning', 'Warning: Đơn hàng này chưa hoàn tất thanh toán!');
                                return back();
                            }
                            break;

                        case 'refund' :
                            if ($tmp_status == 'paid') {
                                $check_refund = $model->cancelRefundOrder("refund", $model_user);
                                if ($check_refund) {
                                    $this->sendMailRefund($model);
                                } else {
                                    $request->session()->flash('alert-warning', 'Warning: Lỗi Refund Order!');
                                    return back();
                                }
                            } else {
                                $request->session()->flash('alert-warning', 'Warning: Đơn hàng này chưa hoàn tất thanh toán!');
                                return back();
                            }
                            break;

                        case 'cancel' :
                            if ($tmp_status == "pending") {
                                $check_cancel = $model->cancelRefundOrder("cancel", $model_user);
                                if ($check_cancel) {
                                    $this->sendMailCancel($model);
                                } else {
                                    $request->session()->flash('alert-warning', 'Warning: Lỗi hủy Order!');
                                    return back();
                                }
                            } else {
                                $request->session()->flash('alert-warning', 'Warning: Không thể hủy đơn hàng này do đơn hàng không ở trạng thái pending!');
                                return back();
                            }
                            break;
                    }

                    $model->payment_status = $data["payment_status"];
                    $model->save();
                    $model_orders_history = new UserOrdersHistory();
                    $model_orders_history->saveHistoryOrder($model);

                    $request->session()->flash('alert-success', 'Success: Cập nhật trạng thái thành công');
                    return back();
                }
            }
        }
        $request->session()->flash('alert-warning', 'Warning: Đã xảy ra lỗi khi cập nhật trạng thái');
        return back();
    }

    //ADD KEY CHO ORDER
    public function getAddPremiumKey($product_id, $order_detail_id) {

        $model_product = ArticlesType::find($product_id);
        $model_order_detail = UserOrdersDetail::find($order_detail_id);

        if ($model_product && $model_order_detail) {
            $model = $model_order_detail->user_orders;
            if ($model_order_detail->articles_type_id == $product_id && $model) {

                $model_key = ArticlesTypeKey::where("articles_type_id", "=", $model_product->id)
                        ->where("user_orders_detail_id", "=", $model_order_detail->id)
                        ->get();

                return view('admin::userOrders.addPremiumKey', compact('model_product', 'model_order_detail', 'model_key', 'model'));
            }
        }

        return view('errors.503');
    }

    public function postAddPremiumKey($product_id, $order_detail_id, Request $request) {
        $data = $request->all();
        $model_product = ArticlesType::find($product_id);
        $model_order_detail = UserOrdersDetail::find($order_detail_id);
        if ($model_product && $model_order_detail && isset($data["premium_key"])) {
            $model = $model_order_detail->user_orders;
            if ($model_order_detail->articles_type_id == $product_id && $model) {
                $model_check = ArticlesTypeKey::where("key", "=", trim($data["premium_key"]))->first();
                if ($model_check == null) {
                    $count_key = ArticlesTypeKey::where("articles_type_id", "=", $model_product->id)
                            ->where("user_orders_detail_id", "=", $model_order_detail->id)
                            ->count();
                    if ($count_key < $model_order_detail->quantity) {
                        $model_key = new ArticlesTypeKey();
                        $model_key->articles_type_id = $model_product->id;
                        $model_key->articles_type_title = $model_product->title;
                        $model_key->articles_type_price = $model_product->price_order;
                        $model_key->user_orders_detail_id = $model_order_detail->id;
                        $model_key->user_orders_id = $model->id;
                        $model_key->key = $data["premium_key"];
                        $model_key->status = "active";
                        $model_key->save();

                        $request->session()->flash('alert-success', 'Success: Add premium key for ' . $model_product->title . ' success!');
                        return back();
                    } else {
                        $request->session()->flash('alert-warning', 'Warning: Không thể add thêm vì đã vượt quá số lượng cho phép !');
                        return back();
                    }
                } else {
                    $request->session()->flash('alert-warning', 'Warning: Đã tồn tại premium key này !');
                    return back();
                }
            }
        }
        return view('errors.503');
    }

    public function deletePremiumKey($id, Request $request) {
        $model = ArticlesTypeKey::find($id);
        if ($model) {
            if ($model->status == "active") {
                $model->delete();
                $request->session()->flash('alert-success', 'Success: Xóa Premium Key thành công !!! ');
                return back();
            }
        }
        $request->session()->flash('alert-warning', 'Warning: Bạn không thể xóa Premium Key này !!! ');
        return back();
    }

    //Lấy premium gửi cho khách
    public function getPremiumKeySend($model_order) {
        if ($model_order) {
            $check = $this->checkKeyEnough($model_order);
            if ($check == 1) {//Nếu số key đã đủ để send cho khách
                $model_key = ArticlesTypeKey::where("user_orders_id", "=", $model_order->id)->get();
                return $model_key;
            }
        }
        return null;
    }

    //Kiểm tra số lượng key đã đủ để có thể gửi cho khách
    public function checkKeyEnough($model_order) {
        if ($model_order) {
            $count_quantity = UserOrdersDetail::where("user_orders_id", "=", $model_order->id)->sum("quantity");
            $count_key = ArticlesTypeKey::where("user_orders_id", "=", $model_order->id)
                    ->whereNotNull("key")->where("key", "!=", "")
                    ->count();

            if ($count_quantity == $count_key) {
                return 1;
            }
        }
        return 0;
    }

    public function savePremiumKey(Request $request) {
        $data = $request->all();
        if (isset($data["id"]) && isset($data["key"]) && $data["key"] != "") {
            $id = $data["id"];
            $key = $data["key"];
            $model = ArticlesTypeKey::find($id);
            if ($model) {
                $model->key = $key;
                $model->status = "active";
                $model->save();

                $model_order = UserOrders::find($model->user_orders_id);
                $check = $this->checkKeyEnough($model_order);
                if ($check == 1) {
                    return 1; // Đủ key để gửi cho khách
                }
                return 2; // Không đủ key
            }
        }
        return 0; // Lỗi
    }

    //SAVE COMMENT HISTORY
    public function saveHistory($id, Request $request) {
        $data = $request->all();
        $model_history = UserOrdersHistory::find($id);
        if ($model_history) {
            if (isset($data["history_comment"])) {
                $model_history->comment = $data["history_comment"];
                $model_history->save();
                $request->session()->flash('alert-success', 'Success: Update history thành công !!! ');
                return back();
            }
        }
        $request->session()->flash('alert-warning', 'Warning: Update history thất bại !!! ');
        return back();
    }

    //XÁC NHẬN THANH TOÁN CHO NGƯỜI DÙNG TRONG TRƯỜNG HỢP NGƯỜI DÙNG DÙNG PHƯƠNG THỨC THANH TOÁN BẰNG TIỀN BONUS
    public function paymentByBonus($model_order, $model_user) {
        if ($model_user) {
            if ($model_order->payment_type->code == "BONUS" || $model_order->used_bonus > 0) {
                $count_order = BonusPaymentHistory::where("user_orders_id", "=", $model_order->id)->count();
                if ($count_order > 0) {
                    BonusPaymentHistory::where("user_orders_id", "=", $model_order->id)->update(["status" => "completed"]);
                    return true;
                }
            }
            //Nếu dùng tiền trong tài khoản thì vẫn gửi mail thông báo
            return true;
        }
        return false;
    }

    //Gửi mail sản phẩm tới khách hàng
    public function sendProductEmail($model_orders, $model_key) {
        $subject_email = SUBJECT_SEND_PRODUCT . $model_orders->order_no;
        if ($model_orders->payment_status == "completed") {
            $subject_email = SUBJECT_RESEND_PRODUCT . $model_orders->order_no;
        }
        Mail::send('admin::userOrders.email-sent-product', ['model_orders' => $model_orders, 'model_key' => $model_key], function ($m) use ($model_orders, $subject_email) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject($subject_email);
        });
    }

    public function sendMailPaid($model_orders) {
        $subject_email = SUBJECT_CUSTOMER_PAID . $model_orders->order_no;
        Mail::send('admin::userOrders.email-send-paid', ['model_orders' => $model_orders], function ($m) use ($model_orders, $subject_email) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject($subject_email);
        });
    }

    public function sendMailRefund($model_orders) {
        $subject_email = SUBJECT_REFUND . $model_orders->order_no;
        Mail::send('admin::userOrders.email-send-refund', ['model_orders' => $model_orders], function ($m) use ($model_orders, $subject_email) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject($subject_email);
        });
    }

    public function sendMailCancel($model_orders) {
        $subject_email = SUBJECT_CANCEL . $model_orders->order_no;
        Mail::send('admin::userOrders.email-send-cancel', ['model_orders' => $model_orders], function ($m) use ($model_orders, $subject_email) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject($subject_email);
        });
    }
    
    public function sendMailBonus($model_orders, $model_user, $money){
        $subject_email = SUBJECT_EMAIL_BONUS . $model_orders->order_no;
        Mail::send('admin::userOrders.email-send-bonus', ['model_orders' => $model_orders, 'model_user' => $model_user, 'money' => $money], function ($m) use ($model_user, $subject_email) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to($model_user->email, $model_user->first_name . " " . $model_user->last_name)->subject($subject_email);
        });
    }

    public function saveOrderCountForProduct($model_order) {
        if ($model_order->payment_status != "paid") {
            $model_detail = UserOrdersDetail::where("user_orders_id", $model_order->id)->get();
            foreach ($model_detail as $detail) {
                $model_product_type = ArticlesType::find($detail->articles_type_id);
                if ($model_product_type) {
                    $model_product = $model_product_type->getArticles;
                    if ($model_product) {
                        $model_product->saveOrderCount($detail->quantity);
                    }
                }
            }
        }
    }

}
