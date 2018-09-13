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

/**
 * Description of InvoiceController
 *
 * @author minht
 */
class InvoiceController extends Controller {
    
    public function view($id, $email){
        SeoPage::seoPage($this);
        $model = UserOrders::find($id);
        if($model != null){
            if(trim($model->email) == trim($email)){
                $model_order = UserOrdersDetail::where("user_orders_id", "=", $model->id)->get();
                return view('articles::invoice.view', compact('model','model_order'));
            }
        }
    }
    
}
