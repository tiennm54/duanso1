<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use App\Models\UserOrders;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Log;
use DB;
use Carbon\Carbon;

class ReportController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function index(Request $request) {
        $date_now = Carbon::now();
        $date_start = Carbon::now()->subDays(30);
        $model_type = PaymentType::where("status_disable", "=", 0)->orderBy("position", "ASC")->get();
        
        $start_date = $date_start;
        $end_date = $date_now;

        $payment_code = "PAYPAL";
        $date_select = "Day";
        $groupBy = "%d-%m-%Y";

        if (isset($request)) {
            

            if (isset($request->paymentType) && isset($request->paymentType) != "") {
                $payment_code = $request->paymentType;
            }

            if (isset($request->dateSelect) && isset($request->dateSelect) != "") {
                $date_select = $request->dateSelect;
                if($date_select == "Month"){
                    $start_date = Carbon::now()->subMonth(12);
                    $groupBy = "%m-%Y";
                }
                if($date_select == "Year"){
                    $start_date = Carbon::now()->subYear(1);
                    $groupBy = "%Y";
                }
            }
            
            if (isset($request->start_date) && $request->start_date != "" && isset($request->end_date) && $request->end_date != "") {
                $start_date = $request->start_date;
                $end_date = $request->end_date;
                if ($end_date < $start_date) {
                    $request->session()->flash('alert-warning', 'Waring: Ngày kết thúc nhỏ hơn ngày bắt đầu!');
                    return back();
                }
            }
        }

        $model_type_select = PaymentType::where("code", "=", trim($payment_code))->first();
        
         //$date_now->setTimezone('Asia/Bangkok');
        
        if ($model_type_select) {
            $model = UserOrders::select(
                            "id", DB::raw("(sum(total_price)) as total_price"), 
                    DB::raw("(count(total_price)) as total_count"), 
                    DB::raw("(DATE_FORMAT(payment_date, '".$groupBy."')) as my_date")
                    )
                    ->where("payments_type_id","=",$model_type_select->id)
                    ->where("payment_status","=","completed")
                    ->where("payment_date", ">", $start_date)->where("payment_date", "<=", $end_date)
                    ->orderBy('payment_date', "DESC")
                    ->groupBy('my_date')
                    ->get();
            return view('admin::report.index', compact('model', 'model_type', 'model_type_select','date_now'));
        } else {
            $request->session()->flash('alert-warning', 'Waring: Không chọn được Payment Type!');
            return back();
        }
    }

}
