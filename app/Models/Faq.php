<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model{
    protected $table = 'faq';
    public $timestamps = true;

    public function getCategoryFaq(){
        return $this->hasOne('App\Models\CategoryFaq', 'id' ,'category_faq_id')->select('id','title');
    }
}