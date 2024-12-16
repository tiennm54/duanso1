<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use App\Models\PaymentLog;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Log;
use DB;
use Carbon\Carbon;

class PaymentLogController extends Controller {

    public function __construct() {
        $this->middleware("editor");
    }
    
    public function indexStripe($code){
        $model_payment_type = PaymentType::where("code","VISA_STRIPE")->first();
        if($model_payment_type){
            return redirect()->route('admin.paymentLog.index', ['id' => $model_payment_type->id]);
        }
    }

    public function index(Request $request, $id) {
        $model_payment_type = PaymentType::find($id);
        if ($model_payment_type != null) {
            
            $model = PaymentLog::where("payments_type_id", "=", $id);

            if (isset($request->start_date) && $request->start_date != "" && isset($request->end_date) && $request->end_date != "") {
                $start_date = $request->start_date;
                $end_date = $request->end_date;
                if($end_date < $start_date){
                    $request->session()->flash('alert-warning', 'Waring: Ngày kết thúc nhỏ hơn ngày bắt đầu!');
                }else{
                    $model = $model->where("created_at", ">=", $start_date)->where("created_at", "<=", $end_date);
                }
            }
            
            $count_total_money = $model->sum('money_received');
            
            $model = $model->orderBy('id', 'desc')->paginate(NUMBER_PAGE);
            
            $date_now = Carbon::now();
            $date_start = Carbon::now()->subDays(30);
            $visitors = PaymentLog::select(
                            "id" ,
                            DB::raw("(sum(money_received)) as total_click"),
                            DB::raw("(count(money_received)) as count_order"),
                            DB::raw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as my_date")
                            )
                            ->where("created_at", ">" , $date_start)->where("created_at", "<=", $date_now)
                            ->orderBy('created_at')
                            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"))
                            ->get();
            
            Log::info($visitors);
            
            return view('admin::paymentLog.index', compact('model', 'model_payment_type', 'count_total_money'));
        }
    }

    public function postCreate(Request $request, $id) {
        if (isset($request)) {
            $model_payment_type = PaymentType::find($id);
            if ($model_payment_type) {

                $money_current_new = $model_payment_type->money_current - $request->money_received;
                if ($money_current_new >= 0) {
                    $model_payment_type->money_current = $money_current_new;
                    $model_payment_type->save();
                    $model = new PaymentLog();
                    $model->money_received = $request->money_received;
                    $model->payments_type_id = $id;
                    $model->status = 1;
                    $model->save();
                    $request->session()->flash('alert-success', 'Success: Create Completed!');
                    return back();
                } else {
                    $request->session()->flash('alert-warning', 'Waring: Số tiền nhận về lớn hơn số tiền hiện có!');
                    return back();
                }
            }
        }
        return view('errors.503');
    }

    public function postEdit(Request $request) {
        if (isset($request)) {
            $model = PaymentLog::find($request->payment_log_id);
            if ($model != null) {

                $money_received_old = $request->money_received_old;
                $model_payment_type = PaymentType::find($model->payments_type_id);
                if ($model_payment_type) {

                    $money_new = $model_payment_type->money_current + $money_received_old - $request->money_received;

                    if ($money_new >= 0) {
                        $model_payment_type->money_current = $money_new;
                        $model_payment_type->save();

                        $model->money_received = $request->money_received;
                        $model->status = $request->status;
                        $model->save();
                        $request->session()->flash('alert-success', 'Success: Edit Completed!');
                        return back();
                    } else {
                        $request->session()->flash('alert-warning', 'Waring: Số tiền Edit không chính xác!');
                        return back();
                    }
                }
            }
        }
    }

}
