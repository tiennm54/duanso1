<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class UserWishList extends Model
{
    protected $table = 'user_wish_list';
    public $timestamps = true;

    public function getArticlesType()
    {
        return $this->hasOne('App\Models\ArticlesType', 'id', 'articles_type_id');
    }
}