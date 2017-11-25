<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\UserRef;
use Crisu83\ShortId\ShortId;


class MinhTien {
    public static function createPassword(){
        $obj_key = ShortId::create(array("length" => 7));
        $password = $obj_key->generate();
        return $password;
    }

    public static function createIdShare() {
        while (true){
            $obj_key = ShortId::create(array("length" => 15));
            $key = $obj_key->generate();
            $check = User::where("id_share","=",trim($key))->first();
            if(count($check) == 0){
                return $key;
            }
        }
        return null;
    }
    
    public static function getSponsor($id_share){
        $model = User::where("id_share","=", trim($id_share))->first();
        return $model;
    }
    
    public static function saveSponsor($id_share, $model_user){
        $model_sponsor = MinhTien::getSponsor($id_share);
        if($model_sponsor){
            $model_ref = new UserRef();
            $model_ref->user_id = $model_user->id;
            $model_ref->user_parent_id = $model_sponsor->id;
            $model_ref->save();
        }
    }
}
