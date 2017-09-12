<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserProfiles extends Model{
    protected $table = 'user_profiles';
    public $timestamps = true;
}