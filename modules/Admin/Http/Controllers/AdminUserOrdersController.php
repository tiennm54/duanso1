<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\ArticlesType;
use App\Models\ArticlesTypeKey;
use App\Models\UserOrders;
use App\Models\UserOrdersDetail;
use Carbon\Carbon;
use DougSisk\CountryState\CountryState;
use Illuminate\Http\Request;
use Pingpong\Modules\Routing\Controller;
use DB;
use Input;
use Excel;
use Illuminate\Support\Facades\Mail;

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
    public function viewOrders($id) {
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



            return view('admin::userOrders.view', compact('model', 'model_key'));
        }
    }

    public function sendKey($id, Request $request) {
        $model_orders = UserOrders::find($id);
        if ($model_orders) {
            $model_key = $this->getPremiumKeySend($model_orders);
            if ($model_key) {
                $check_send = $this->sendProductEmail($model_orders, $model_key);
                if ($check_send) {
                    $model_orders->payment_status = "completed";
                    $model_orders->payment_date = Carbon::now();
                    $model_orders->save();

                    foreach ($model_key as $item) {
                        $item->status = "sent";
                        $item->date_sent = Carbon::now();
                        $item->user_id = $model_orders->users_id;
                        $item->user_email = $model_orders->email;
                        $item->save();
                    }

                    $request->session()->flash('alert-success', 'Success: Đã gửi premium key thành công tới khách hàng!');
                    return back();
                }
            }
        }
        $request->session()->flash('alert-warning', 'Warning: Đã xảy ra lỗi !!!');
        return back();
    }

    //Gửi mail sản phẩm tới khách hàng
    public function sendProductEmail($model_orders, $model_key) {
       
        $subject_email = '[BuyPremiumKey.Com] Send product(s) for orders #' . $model_orders->order_no;
        if($model_orders->payment_status == "completed"){
            $subject_email = '[BuyPremiumKey.Com] Resend product(s) for orders #' . $model_orders->order_no;
        }
        
        Mail::send('admin::userOrders.email-sent-product', ['model_orders' => $model_orders, 'model_key' => $model_key], function ($m) use ($model_orders, $subject_email) {
            $m->from("buypremiumkey@gmail.com", "BuyPremiumKey Authorized Reseller");
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
    
    
    public function sendMailPaid($model_orders){
        $subject_email = '[BuyPremiumKey.Com] Orders #'.$model_orders->order_no.' Information';
        Mail::send('admin::userOrders.email-send-paid', ['model_orders' => $model_orders], function ($m) use ($model_orders, $subject_email) {
            $m->from("buypremiumkey@gmail.com", "BuyPremiumKey Authorized Reseller");
            $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject($subject_email);
        });
    }

        //Thay đổi trạng thái order
    public function saveStatusPayment($id, Request $request) {
        if (isset($request)) {
            $data = $request->all();
            if (isset($data["payment_status"])) {
                $model = UserOrders::find($id);
                if ($model) {
                    $model->payment_status = $data["payment_status"];
                    $model->save();
                    
                    if($data["payment_status"] == 'paid'){
                        $this->sendMailPaid($model);
                    }
                    
                    $request->session()->flash('alert-success', 'Success: Cập nhật trạng thái đã thanh toán thành công');
                    return back();
                }
            }
        }
        $request->session()->flash('alert-warning', 'Warning: Đã xảy ra lỗi khi cập nhật trạng thái');
        return back();
    }

    //ADD KEY
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
                    return 1;
                }
                return 2;
            }
        }
        return 0;
    }

}
