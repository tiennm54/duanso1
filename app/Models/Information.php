<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use URL;

class Information extends Model{
    protected $table = 'information';
    public $timestamps = false;
    
    public function getUrl(){
        return URL::route('frontend.information.view',['id'=>$this->id,'url'=>$this->url_title.'.html']);
    }
}