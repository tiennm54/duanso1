<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use App\Models\VisaPaymentLog;
use Illuminate\Http\Request;
use Log;

class VisaLogManagementController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function index(Request $request) {
        if (isset($request)) {
            $data = $request->all();
            Log::info($data);
            $model = new VisaPaymentLog();
            if(isset($data["buyer"]) && $data["buyer"] != "") {
                $model = $model->where("buyer","LIKE", "%" . $data["buyer"] . "%");
            }
            
            if(isset($data["orderId"]) && $data["orderId"]){
                $model = $model->where("orderid","=",$data["orderId"]);
            }

            $model = $model->orderBy("id", "DESC")->paginate(NUMBER_PAGE);
            
            $total_price = VisaPaymentLog::where("status","=","Transaction Success")->sum('total');
            $total_price = number_format($total_price,2);
            return view('admin::visaLog.index', compact('model','total_price'));
        }
    }

}
