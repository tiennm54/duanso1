<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserOrdersHistory extends Model
{
    protected $table = 'user_orders_history';
    public $timestamps = true;
    
        
    public function saveHistoryOrder($model_order){
        $model_check = UserOrdersHistory::where("user_orders_id", "=", $model_order->id)->where("history_name", "=", $model_order->payment_status)->first();
        if ($model_check == null) {
            $this->user_orders_id = $model_order->id;
            $this->history_name = $model_order->payment_status;
            $this->save();
        }
    }
}