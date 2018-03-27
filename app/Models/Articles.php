<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Log;

class Articles extends Model {

    protected $table = 'articles';
    public $timestamps = true;

    public function getCategory() {
        return $this->hasOne('App\Models\Category', 'id', 'category_id')->select("id", "name");
    }

    public function saveViewCount() {
        $this->view_count = $this->view_count + 1;
        $this->save();
    }
    
    public function saveOrderCount($count) {
        $this->order_count = $this->order_count + $count;
        $this->save();
    }

}
