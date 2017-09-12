<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model{
    protected $table = 'articles';
    public $timestamps = true;

    public function getCategory(){
        return $this->hasOne('App\Models\Category', 'id' ,'category_id')->select("id","name");
    }
}