<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $table = 'seo';
    public $timestamps = true;
    
    public function getPage() {
        return $this->hasOne('App\Models\SeoCreatePage', 'id', 'page_id')->select("id", "name");
    }

}