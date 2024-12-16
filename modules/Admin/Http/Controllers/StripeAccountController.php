<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\StripeAccount;
use App\Models\StripeAccountPO;
use DB;
use Log;

/**
 * Description of PaypalAccountManagerController
 *
 * @author minht
 */
class StripeAccountController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function index() {
        $model = StripeAccount::orderBy("status_activate","DESC")->get();
        
        foreach ($model as $item){
            //Log::info($item->id);
            $total_pay = StripeAccountPO::where("stripe_account_id","=", $item->id)->where("status", "=", 0)->sum('money_po');
            $item->total_pay = $total_pay;
        }
        
        $total_all_pay = StripeAccountPO::where("status", "=", 0)->sum('money_po');
        
        return view('admin::stripe.index', compact('model','total_all_pay'));
    }

    public function saveData($id, Request $request) {
        if (isset($request)) {
            $model = StripeAccount::find($id);
            if ($model) {
                $model->total_hold = $request->total_hold;
                $model->total_money = $request->total_money;
                $model->status_activate = $request->status_activate;
                $model->save();
                $request->session()->flash('alert-success', 'Success: Save Stripe Account Completed!');
                return back();
            }
        }
    }

    public function getCreate() {
        return view('admin::stripe.create');
    }

    public function postCreate(Request $request) {
        if (isset($request)) {
            DB::beginTransaction();
            $model = new StripeAccount();
            $model->url_web = $request->url_web;
            $model->max_money = $request->max_money;
            $model->max_receive = $request->max_receive;
            $model->total_hold = $request->total_hold;
            $model->total_money = $request->total_money;
            $model->status_activate = $request->status_activate;
            $model->description = $request->description;
            $model->save();
            DB::commit();
            $request->session()->flash('alert-success', 'Success: Create Stripe Account Completed!');
            return redirect()->route('admin.stripe.getEdit', ["id" => $model->id]);
        }
    }

    public function getEdit($id) {
        $model = StripeAccount::find($id);
        if ($model) {
            return view('admin::stripe.create', compact('model'));
        }
    }

    public function postEdit($id, Request $request) {
        $model = StripeAccount::find($id);
        if ($model) {
            DB::beginTransaction();
            $model->url_web = $request->url_web;
            $model->max_money = $request->max_money;
            $model->max_receive = $request->max_receive;

            $model->total_hold = $request->total_hold;
            $model->total_money = $request->total_money;

            $model->status_activate = $request->status_activate;
            $model->description = $request->description;
            $model->save();
            DB::commit();
            $request->session()->flash('alert-success', 'Success: Edit Stripe Account Completed!');
            return back();
        }
    }

    public function delete($id, Request $request) {
        $model = StripeAccount::find($id);
        if ($model) {
            $name = $model->url_web;
            $model->delete();
            $request->session()->flash('alert-success', 'Success: Delete Stripe Account: ' . $name . ' Completed!');
            return back();
        }
    }

    public function sellStripe(Request $request) {
        if (isset($request)) {

            $stripe_id = $request->stripe_account_id;
            $money = $request->money;
            $model_stripe = StripeAccount::find($stripe_id);
            if ($model_stripe) {
                $total_money = $model_stripe->total_money;
                if ($total_money >= $money) {
                    $model_stripe->total_money = $total_money - $money;
                    $model_stripe->save();
                    $model = new StripeAccountPO();
                    $model->stripe_account_id = $request->stripe_account_id;
                    $model->stripe_account_url = $request->stripe_account_url;
                    $model->money_po = $request->money;
                    $model->date_pay = $request->date_pay;
                    $model->status = 0;
                    $model->save();
                    $request->session()->flash('alert-success', 'Success: Save Stripe Account: ' . $request->stripe_account_url . ': ' . $money . '$ Completed!');
                    return back();
                } else {
                    $request->session()->flash('alert-warning', 'Warning: Error Pay Stripe Account: ' . $request->stripe_account_url . '!');
                    return back();
                }
            }
        }
    }

    public function indexStripePay(Request $request) {
        $model = new StripeAccountPO();

        if (isset($request)) {
            if (isset($request->stripe_account_url)) {
                $model = $model->where("stripe_account_url", "LIKE", "%" . $request->stripe_account_url . "%");
            }
        }

        $model = $model->orderBy("status", "ASC")->orderBy("id", "DESC")->paginate(NUMBER_PAGE);

        return view('admin::stripe.indexStripePay', compact('model'));
    }

    public function editStripePay(Request $request) {
        
        if (isset($request)) {
            if (isset($request->stripe_pay_id)) {
                $id = $request->stripe_pay_id;
                $model = StripeAccountPO::find($id);
                if ($model) {
                    $stripe_id = $model->stripe_account_id;
                    $model_stripe = StripeAccount::find($stripe_id);
                    if ($model_stripe) {

                        $money_old = $model->money_po;
                        $money_new = $request->money;

                        $model_stripe->total_money = $model_stripe->total_money + $money_old - $money_new;
                        $model_stripe->save();
                        
                        $model->status = $request->status;
                        $model->money_po = $money_new;
                        $model->save();
                        
                        $request->session()->flash('alert-success', 'Success: Save Completed!');
                        return back();
                    }
                }
            }
        }
        
        $request->session()->flash('alert-warning', 'Warning: Error !');
        return back();
    }

}
