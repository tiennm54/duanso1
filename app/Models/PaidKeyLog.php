<?php

namespace App\Models;

use App\Models\ArticlesType;
use App\Models\Articles;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PaidKeyLog extends Model {

    protected $table = 'paid_key_log';
    public $timestamps = true;

    public function savePaidKeyLog($articles_id, $model_product, $unit_sold, $unit_refund) {// model cua tung san pham nho
        $this->articles_id = $articles_id;
        $this->articles_type_id = $model_product->id;
        $this->unit_price = $model_product->price_reseller;
        $this->unit_sold = $unit_sold; // so luong ban ra
        $this->unit_refund = $unit_refund; // so luong refund
        $this->total_paid = ($unit_sold - $unit_refund) * $model_product->price_reseller;
        $this->product_name = $model_product->title;
        $this->save();
    }

}
