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
use Carbon\Carbon;
use DougSisk\CountryState\CountryState;
use Illuminate\Http\Request;
use Pingpong\Modules\Routing\Controller;
use DB;
use Input;
use Excel;
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
            $model = $model->where("id", "=", $data["order_id"]);
        }
        if (isset($data["email"]) && $data["email"] != "") {
            $model = $model->where("email", "LIKE", "%" . $data["email"] . "%");
        }
        if (isset($data["payment_status"]) && $data["payment_status"] != "") {
            $model = $model->where("payment_status", "=", $data["payment_status"]);
        }
        if (isset($data["start_created_at"]) && $data["start_created_at"] != "" && isset($data["end_created_at"]) && $data["end_created_at"] != "") {
            $model = $model->where("created_at", ">", $data["start_created_at"])->where("created_at", "<", $data["end_created_at"]);
        }
        $model = $model->paginate(20);
        return view('admin::userOrders.listOrders', compact('model'));
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

                foreach ($model_key as $item) {
                    $item->status = "sent";
                    $item->date_sent = Carbon::now();
                    $item->user_id = $model_orders->users_id;
                    $item->user_email = $model_orders->email;
                    $item->save();
                }

                $this->sendProductEmail($model_orders, $model_key);
                
                $model_orders->payment_status = "completed";
                $model_orders->payment_date = Carbon::now();
                $model_orders->save();
                
                $this->saveHistoryOrder($model_orders);
                $this->bonusMoney($model_orders);

                DB::commit();

                $request->session()->flash('alert-success', 'Success: Đã gửi premium key thành công tới khách hàng!');
                return back();
            }
        }
        $request->session()->flash('alert-warning', 'Warning: Đã xảy ra lỗi !!!');
        return back();
    }

    //Bonus cho sponser và người mua
    public function bonusMoney($model_orders) {
        $model_bonus_his = BonusHistory::where("user_order_id", "=", $model_orders->id)->first();
        if ($model_bonus_his == null) {
            $model_bonus_config = BonusConfig::orderBy("id", "DESC")->first();
            if ($model_bonus_config && $model_bonus_config->bonus_sponsor > 0) {
                $model_user_sponser = $this->bonusSponser($model_orders, $model_bonus_config);
                //Nếu người mua có sponsor
                if ($model_user_sponser) {
                    $this->updateMoneyForUser($model_user_sponser);
                    $model_user = $this->bonusUser($model_orders, $model_bonus_config, $model_user_sponser);
                    if ($model_user) {
                        $this->updateMoneyForUser($model_user);
                    }
                }
            }
        }
    }

    //Bonus cho người được ref từ người mua
    public function bonusSponser($model_orders, $model_bonus_config) {
        //Người mua hàng
        $user_id = $model_orders->users_id;
        $model_user_ref = UserRef::where("user_id", "=", $user_id)->first();
        if ($model_user_ref) {
            if ($model_user_ref->user_sponser_id) {
                $user_sponser_id = $model_user_ref->user_sponser_id;
                $model_user_sponser = User::find($user_sponser_id);
                if ($model_user_sponser) {
                    $bonus_sponser = ($model_bonus_config->bonus_sponsor * $model_orders->sub_total) / 100;
                    if ($bonus_sponser > 0) {
                        $this->saveBonusHistory($model_orders, $user_id, $user_sponser_id, $bonus_sponser, "Sponser", $model_bonus_config->bonus_sponsor);
                        return $model_user_sponser;
                    }
                }
            }
        }
        return null;
    }

    //Bonus cho người mua
    public function bonusUser($model_orders, $model_bonus_config, $model_user_sponser) {
        $user_id = $model_orders->users_id;
        $model_user = User::find($user_id);
        if ($model_user) {
            $bonus_user = ($model_bonus_config->bonus_reg * $model_orders->sub_total) / 100;
            if ($bonus_user > 0) {
                $this->saveBonusHistory($model_orders, $user_id, $model_user_sponser->id, $bonus_user, "Buyer", $model_bonus_config->bonus_reg);
                return $model_user;
            }
        }
        return null;
    }

    //Lưu lịch sử bonus cho người dùng
    public function saveBonusHistory($model_orders, $user_buy_id, $user_sponser_id, $bonus_money, $bonus_type, $bonus_percent) {
        $model = new BonusHistory();
        $model->user_buy_id = $user_buy_id;
        $model->user_sponser_id = $user_sponser_id;
        $model->user_order_id = $model_orders->id;
        $model->bonus = $bonus_money;
        $model->bonus_type = $bonus_type;
        $model->bonus_percent = $bonus_percent;
        $model->save();
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
        if (count(Mail::failures()) > 0) { // gửi lỗi
            return 0;
        } else {
            return 1;
        }
    }

    public function autoCompleteEmail(Request $request) {
        if (isset($request)) {
            $data = UserOrders::select(
                            "id", "email as name"
                    )->where("email", "LIKE", "%{$request->input('query')}%")->get();
            return response()->json($data);
        }
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

    public function saveHistoryOrder($model_order) {
        $model_check = UserOrdersHistory::where("user_orders_id", "=", $model_order->id)->where("history_name", "=", "completed")->first();
        if ($model_check == null) {
            $model_history = new UserOrdersHistory();
            $model_history->user_orders_id = $model_order->id;
            $model_history->history_name = $model_order->payment_status;
            $model_history->save();
        }
    }

    //Thay đổi trạng thái order
    public function saveStatusPayment($id, Request $request) {
        if (isset($request)) {
            $data = $request->all();
            if (isset($data["payment_status"])) {
                $model = UserOrders::find($id);
                if ($model) {
                    $tmp_status = $model->payment_status;
                    if ($data["payment_status"] == 'refund' || $data["payment_status"] == 'completed') {
                        if ($tmp_status != 'paid') {
                            $request->session()->flash('alert-warning', 'Warning: Đơn hàng này chưa được thanh toán hoặc có trạng thái không thay đổi');
                            return back();
                        } else {
                            if ($data["payment_status"] == 'completed') {
                                $checkUpdateCompleted = $this->checkKeyEnough($model);
                                if ($checkUpdateCompleted == 0) {
                                    $request->session()->flash('alert-warning', 'Warning: Chưa cung cấp premium key cho người dùng');
                                    return back();
                                }
                            }
                        }
                    }

                    if ($data["payment_status"] == 'cancel' && $tmp_status != "pending") {
                        $request->session()->flash('alert-warning', 'Warning: Không thể hủy đơn hàng này!');
                        return back();
                    }

                    if ($data["payment_status"] == 'paid') {
                        //Xác nhận thanh toán
                        $checkPaid = false;
                        if ($model->payment_type->code == "BONUS") {
                            $checkPaid = $this->paymentByBonus($model);
                            if ($checkPaid) {
                                $this->sendMailPaid($model);
                            } else {
                                $request->session()->flash('alert-warning', 'Warning: Vui lòng kiểm tra giao dịch của tài khoản này!');
                                return back();
                            }
                        } else {
                            $this->sendMailPaid($model);
                        }
                    }
                    if ($data["payment_status"] == 'refund') {
                        //Tra lai tien cho nguoi dung
                        if ($model->payment_type->code == "BONUS") {
                            $this->refundByBonus($model);
                        }
                        $this->sendMailRefund($model);
                    }
                    if ($data["payment_status"] == 'cancel') {
                        $model_user = User::find($model->users_id);
                        if ($model_user) {
                            $this->updateMoneyForUser($model_user);
                        }
                        $this->sendMailCancel($model);
                    }

                    $model->payment_status = $data["payment_status"];
                    $model->save();

                    $this->saveHistoryOrder($model);

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

    //Update lại tiên trong tài khoản cho người dùng, việc này xảy ra khi bonus cho người dùng
    public function updateMoneyForUser($model_user) {
        $total_money = $model_user->getMoneyForUser();
        $model_user->user_money = $total_money;
        $model_user->save();
    }

    //XÁC NHẬN THANH TOÁN CHO NGƯỜI DÙNG TRONG TRƯỜNG HỢP NGƯỜI DÙNG DÙNG PHƯƠNG THỨC THANH TOÁN BẰNG TIỀN BONUS
    public function paymentByBonus($model_order) {
        $model_user = User::find($model_order->users_id);
        if ($model_user) {
            //Lấy tiền trước khi thanh toán
            $total_money = $model_user->getMoneyForUser();
            //Tien thanh toans
            $total_payment = $model_order->total_price;

            if ($total_money == $model_user->user_money + $total_payment) {
                //Ghi log
                $model_bonus_history = new BonusPaymentHistory();
                $model_bonus_history->user_orders_id = $model_order->id;
                $model_bonus_history->user_id = $model_user->id;
                $model_bonus_history->total_payment = $total_payment;
                $model_bonus_history->total_before = $total_money;
                $model_bonus_history->total_after = $total_money - $total_payment;
                $model_bonus_history->status = "completed";
                $model_bonus_history->save();
                //Update lại tiền vào tài khoản người dùng
                $this->updateMoneyForUser($model_user);
                return true;
            }
        }
        return false;
    }

    public function refundByBonus($model_order) {
        $model_user = User::find($model_order->users_id);
        BonusPaymentHistory::where("user_orders_id", "=", $model_order->id)->update(["status" => "refund"]);
        if ($model_user) {
            $this->updateMoneyForUser($model_user);
        }
    }

}
