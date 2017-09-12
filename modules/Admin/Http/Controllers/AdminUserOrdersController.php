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

    public function __construct(){
        $this->middleware("role");
    }

    public function listOrders(Request $request)
    {
        $data = $request->all();
        $model = UserOrders::orderBy("id","DESC");

        if (isset($data["order_id"]) && $data["order_id"] != ""){
            $model = $model->where("id","=",$data["order_id"]);
        }

        if (isset($data["email"]) && $data["email"] != ""){
            $model = $model->where("email","LIKE", "%". $data["email"]."%");
        }

        if (isset($data["payment_status"]) && $data["payment_status"] != ""){
            $model = $model->where("payment_status","=", $data["payment_status"] );
        }

        if (isset($data["start_created_at"]) && $data["start_created_at"] != "" && isset($data["end_created_at"]) && $data["end_created_at"] != ""){
            $model = $model->where("created_at",">", $data["start_created_at"])->where("created_at","<", $data["end_created_at"]);
        }


        $model = $model->paginate(20);
        return view('admin::userOrders.listOrders', compact('model'));
    }


    public function viewOrders($id){
        $model = UserOrders::find($id);
        if ($model){
            $countryState = new CountryState();
            $countries = $countryState->getCountries();

            $countryState = new CountryState();
            $states = $countryState->getStates($model->country);

            $model["country_name"] = $countryState->findCountry($model->country, $countries);
            $model["state_name"] = $countryState->findState($model->state_province, $states);
            return view('admin::userOrders.view', compact('model'));
        }
    }

    //Lấy key trên hệ thống và gửi đi cho khách hàng
    public function getKeySend($model_orders, $model_order_detail){
        //Danh sách sản phẩm
        $list_product = array();

        foreach ($model_order_detail as $item){
            $product_id = $item->articles_type_id;
            $product_quantity = $item->quantity;
            for ($i = 0; $i < $product_quantity; $i++){
                $model_key = ArticlesTypeKey::where("articles_type_id","=",$product_id)->where("status","=","active")->first();
                if ($model_key){
                    $model_key->user_orders_detail_id = $product_id;
                    $model_key->user_id = $item->users_id;
                    $model_key->status = "sent";
                    $model_key->save();

                    $tmp_content = array(
                        "title" => $item->title,
                        "price_order" => $item->price_order,
                        "key" => $model_key->key
                    );

                    array_push($list_product, $tmp_content);

                }
            }
        }

        $model_orders->payment_status = "paid";
        $model_orders->save();

        return $list_product;

    }

    //Gửi mail sản phẩm tới khách hàng
    public function sendProductEmail($model_orders, $list_product){
        Mail::send('admin::userOrders.email-sent-product', ['model_orders' => $model_orders,'list_product' => $list_product], function ($m) use ($model_orders) {
            $m->from("buypremiumkey@gmail.com", "Buy Premium Key");
            $m->to($model_orders->email, $model_orders->first_name." ".$model_orders->last_name)->subject('Send product for orders #'. $model_orders->id);
        });

        if (count(Mail::failures()) > 0) {
            return 0;
        }else{
            return 1;
        }
    }


    //Func chính thực hiện chức năng gửi sản phẩm tới khách hàng qua email
    public function sendKey($id, $email, Request $request){
        if (isset($request)){
            DB::beginTransaction();
            $model_orders = UserOrders::find($id);
            if ($model_orders){
                if ($model_orders->email == $email && $model_orders->payment_status == "pending"){
                    //GET LIST KEY SẼ SENT
                    $model_order_detail = UserOrdersDetail::where("user_orders_id","=",$model_orders->id)->get();
                    if (count($model_order_detail) != 0) {
                        $flag = true;
                        $string_product_error = "| ";
                        foreach ($model_order_detail as $item) {

                            $product_id = $item->articles_type_id;
                            $product_quantity = $item->quantity;

                            $check = ArticlesTypeKey::where("articles_type_id","=",$product_id)->where("status","=","active")->count();
                            if ($check < $product_quantity){
                                $flag = false;
                                $string_product_error = $string_product_error . $item->articles_type->title . ' |';
                            }
                        }
                        if ($flag == true){
                            //Send email + cap nhat trang thai orders
                            $list_product = $this->getKeySend($model_orders, $model_order_detail);
                            $check_email = $this->sendProductEmail($model_orders, $list_product);

                            if ($check_email == 1){
                                DB::commit();
                                $request->session()->flash('alert-success', 'Success: Đã gửi key thành công tới khách hàng!');
                                return back();
                            }else{
                                $request->session()->flash('alert-warning', 'Warning: Không thể gửi sản phẩm tới địa chỉ email này!');
                                return back();
                            }



                        }else{

                            $request->session()->flash('alert-warning', 'Warning: Thiếu key cho sản phẩm: '.$string_product_error);
                            return back();
                        }
                    }
                }
            }
        }
        $request->session()->flash('alert-warning', 'Waring: Không đủ key hoặc đã xảy ra lỗi!');
        return back();
    }

    public function autoCompleteEmail(Request $request){
        if (isset($request)) {
            $data = UserOrders::select(
                "id",
                "email as name"
            )->where("email", "LIKE", "%{$request->input('query')}%")->get();
            return response()->json($data);
        }
    }


    public function saveStatusPayment($id, Request $request){
        if (isset($request)){
            $data = $request->all();
            if (isset($data["payment_status"])){
                $model = UserOrders::find($id);
                if ($model){

                    if ($data["payment_status"] == "paid") {
                        $model->payment_status = $data["payment_status"];
                        $model->save();
                        $request->session()->flash('alert-success', 'Success: Cập nhật trạng thái đã thanh toán thành công');
                        return back();
                    }else{
                        $model_detail = UserOrdersDetail::where("user_orders_id","=",$id)->get();
                        $list_orders_id = array();
                        foreach ($model_detail as $item){
                            array_push($list_orders_id, $item->id);
                        }

                        $check_key = ArticlesTypeKey::whereIn("user_orders_detail_id", $list_orders_id)->count();
                        if ($check_key == 0){
                            $model->payment_status = $data["payment_status"];
                            $model->save();
                            $request->session()->flash('alert-success', 'Success: Cập nhật trạng thái đã thanh toán thành công');
                            return back();
                        }else{
                            $request->session()->flash('alert-warning', 'Warning: Không thể cập nhật trạng thái, Orders đã được xử lý');
                            return back();
                        }
                    }

                }
            }
        }
        $request->session()->flash('alert-warning', 'Warning: Đã xảy ra lỗi khi cập nhật trạng thái');
        return back();

    }



}