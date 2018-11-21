<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Articles\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use App\Models\UserOrders;
use App\Models\UserOrdersDetail;
use App\Helpers\SeoPage;
use Illuminate\Http\Request;
use Log;

/**
 * Description of InvoiceController
 *
 * @author minht
 */
class InvoiceController extends Controller {

    public function view($id, $email) {
        SeoPage::seoPage($this);
        $model = UserOrders::find($id);
        if ($model != null) {
            if (trim($model->email) == trim($email)) {
                $model_order = UserOrdersDetail::where("user_orders_id", "=", $model->id)->get();
                return view('articles::invoice.view', compact('model', 'model_order'));
            }
        }
    }

    public function paypalPay($token) {
        $model = null;
        $decode = base64_decode($token);
        $explode = explode("-", $decode);
        if (count($explode) == 4) {
            if ($explode[0] == PRIVATE_PAYPAL_KEY) {
                $time = $explode[3];
                $now = time();
                $number_date = ($now - $time) / 3600;
                if ($number_date <= 12) {
                    $order_id = $explode[1];
                    $model = UserOrders::find($order_id);
                }
            }
        }
        return view('articles::invoice.paypalPay', compact('model'));
    }

    public function callbackPaypalPay(Request $request) {
        if (isset($request)) {
            $data = $request->all();
            //Log::info($data);
            if($data["payment_status"] == "Completed"){
                $order_reponse = $data["item_name"];
                $explode = explode("-", $order_reponse);
                $order_id = $explode[1];
                Log::info($order_id);
                if($order_id != null && $order_id != ""){
                    $model = UserOrders::find($order_id);
                    if($model){
                        $model->payment_status = "completed";
                        $model->save();
                        return redirect()->route('frontend.invoice.paySuccess');
                    }
                }
            }
        }
    }
    
    public function paySuccess(){
        return view('articles::invoice.paySuccess');
    }

}
