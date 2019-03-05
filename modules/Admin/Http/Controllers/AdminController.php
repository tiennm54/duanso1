<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\ArticlesType;
use App\Models\UserOrders;
use App\Models\User;
use App\Models\Articles;
use App\Models\FeedBack;
use App\Models\PaymentType;
use App\Models\NewsComment;
use App\Models\Reviews;
use Pingpong\Modules\Routing\Controller;
use Session;

class AdminController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function index() {
        $obj_order = new UserOrders();
        $obj_user = new User();
        $model_order_pending = $obj_order->getOrderPending();
        $model_order_paid = $obj_order->getOrderPaid();
        $model_order_completed = $obj_order->getOrderCompletedDay();
        $data_money = $obj_order->getTotalOrderMoney();
        $count_user = $obj_user->countTotalUser();
        $model_user_lock = $obj_user->getModelUserLock();
        $this->statisticSession();
        
        return view('admin::index', compact(
                'model_order_pending', 
                'model_order_paid',
                'model_order_completed',
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

    /**
     * Thống kê
     * Số đơn hàng thanh toán bằng tiền bonus chưa được xử lý
     * Số đơn hàng thanh toán bằng phương thức bonus chưa được xử lý (key)
     * Số đơn hàng đang pending
     * Số đơn hàng đã thanh toán nhưng chưa nhận key
     * Số đơn hàng phải hoàn trả
     * Số người bị lock tài khoản
     * Số sản phẩm không có trong kho
     * Số lượng feedback chưa giải quyết
     * * */
    public function statisticSession() {
        $obj_user = new User();
        $count_used_bonus_pending = UserOrders::where("used_bonus", ">", 0)->where("payment_status", "=", "pending")->count();
        $count_bonus_payment = UserOrders::join('payments_type', 'user_orders.payments_type_id', '=', 'payments_type.id')
                        ->select('user_orders.payment_status', 'payments_type.code')
                        ->where('payments_type.code', "=", "BONUS")
                        ->where('user_orders.payment_status', "=", "pending")->count();
        $count_order_pending = UserOrders::where("payment_status", "=", "pending")->count();
        $count_order_paid = UserOrders::where("payment_status", "=", "paid")->count();
        $count_order_refund = UserOrders::where("payment_status", "=", "refund")->count();
        $count_order_completed = UserOrders::where("payment_status", "=", "completed")->count();
        $count_order_cancel = UserOrders::where("payment_status", "=", "cancel")->count();
        
        $count_user_lock = $obj_user->getModelUserLock()->count();
        $count_product_no_stock = Articles::where("status_stock", "=", 0)->orWhere("status_disable", "=", 1)->count();
        $count_feedback = FeedBack::where("status_fix", "=", "NO")->count();
        $count_comment = NewsComment::where("parent_id",0)->where("status_admin_reply",0)->count();
        $count_reviews = Reviews::whereDay('created_at', '=', date('d'))->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->count();
        
        $model_payment = PaymentType::where("code","=","BONUS")->first();
        if($model_payment != null){
            $payment_bonus_id = $model_payment->id;
        }else{
            $payment_bonus_id = "";
        }
        $data = array(
            "count_used_bonus_pending" => $count_used_bonus_pending,
            "count_bonus_payment" => $count_bonus_payment,
            "count_order_pending" => $count_order_pending,
            "count_order_paid" => $count_order_paid,
            "count_order_refund" => $count_order_refund,
            "count_order_completed" => $count_order_completed,
            "count_order_cancel" => $count_order_cancel,
            "count_user_lock" => $count_user_lock,
            "count_product_no_stock" => $count_product_no_stock,
            "count_feedback" => $count_feedback,
            "count_reviews" => $count_reviews,
            "count_comment" => $count_comment,
            "count_noti" => ($count_reviews + $count_feedback),
            "payment_bonus_id" => $payment_bonus_id
        );

        Session::set('statisticCount', $data);
    }

}
