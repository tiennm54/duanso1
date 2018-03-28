<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\ArticlesType;
use App\Models\UserOrders;
use App\Models\User;

use Pingpong\Modules\Routing\Controller;

class AdminController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function index() {
        $obj_order = new UserOrders();
        $obj_user = new User();
        $model_order_pending = $obj_order->getOrderPending();
        $model_order_paid = $obj_order->getOrderPaid();
        $data_money = $obj_order->getTotalOrderMoney();
        $count_user = $obj_user->countTotalUser();
        $model_user_lock = $obj_user->getModelUserLock();
        
        return view('admin::index', compact(
                'model_order_pending',
                'model_order_paid',
                'data_money',
                'count_user',
                'model_user_lock'
                ));
    }

    public function taoTieuChi() {
        $model = ArticlesType::get();
        foreach ($model as $item) {
            $item->url_title = str_slug($item->title, '-') . "-" . 'reseller';
            $item->save();
        }
    }

}
