<?php

namespace Modules\Config\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use App\Models\BonusConfig;
use Illuminate\Http\Request;

class BonusConfigController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function getCreate() {
        $model = BonusConfig::first();
        return view('config::bonusConfig.create', compact('model'));
    }

    public function postCreate(Request $request) {
        if(isset($request)){
            $model = BonusConfig::first();
            if($model == null){
                $model = new BonusConfig();
            }
            $model->bonus_reg = $request->bonus_reg;
            $model->bonus_sponsor = $request->bonus_sponsor;
            $model->bonus_basic = $request->bonus_basic;
            $model->save();
            $request->session()->flash('alert-success', 'Success: Update bonus config success!');
            return back();
        }
    }

}
