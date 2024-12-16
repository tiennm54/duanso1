<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\PaidKeyLog;
use App\Models\Articles;
use Log;
use DB;
use Carbon\Carbon;

class PaidKeyLogController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function index(Request $request, $id) {

        $model = Articles::find($id);
        if ($model) {

            $start_date = Carbon::now()->subDays(1);
            $end_date = Carbon::now();


            //Log::info($start_date);
            //Log::info($end_date);

            if (isset($request)) {
                if (isset($request->start_date) && $request->start_date != "" && isset($request->end_date) && $request->end_date != "") {
                    $start_date = $request->start_date;
                    $end_date = $request->end_date;

                    if ($end_date < $start_date) {
                        $request->session()->flash('alert-warning', 'Waring: Ngày kết thúc nhỏ hơn ngày bắt đầu!');
                        return back();
                    }
                }
            }


            $model_report = PaidKeyLog::select(
                            "*", DB::raw("(sum(unit_sold)) as total_sold"), DB::raw("(sum(unit_refund)) as total_refund"), DB::raw("(sum(total_paid)) as total_all_paid")
                    )
                    ->where("articles_id", "=", $model->id)
                    ->where("created_at", ">", $start_date)->where("created_at", "<=", $end_date)
                    ->orderBy('unit_price', "ASC")
                    ->groupBy('articles_type_id')
                    ->get();



            return view('admin::paidKeyLog.index', compact('model_report','model'));
        }
    }

}
