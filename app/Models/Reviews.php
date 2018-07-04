<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model {

    protected $table = 'reviews';
    public $timestamps = true;

    public function getReviews($review_url) {
        $model = $this->where("review_url", "=", $review_url)->orderBy("id", "DESC")->paginate(10);
        return $model;
    }

    public function countReviews($review_url) {
        $count = $this->where("review_url", "=", $review_url)->count();
        $sum = 0;
        if ($count > 0) {
            $sum = (int) $this->where("review_url", "=", $review_url)->sum('review_rate') / $count;
        }
        $data = array(
            "count" => $count,
            "sum" => $sum
        );

        return $data;
    }

}
