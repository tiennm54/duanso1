<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\UserRef;
use Crisu83\ShortId\ShortId;

class MinhTien {

    public static function createPassword() {
        $obj_key = ShortId::create(array("length" => 7));
        $password = $obj_key->generate();
        return $password;
    }

    public static function saveSponser($model_user, $sponser_email) {
        $model_sponser = User::where("email", "=", $sponser_email)->first();
        if ($model_sponser) {
            $model_ref = UserRef::where("user_id", "=", $model_user->id)->first();
            if ($model_ref == null) {
                $model_ref = new UserRef();
                $model_ref->user_id = $model_user->id;
                $model_ref->user_sponser_id = $model_sponser->id;
                $model_ref->save();
                return $model_ref;
            }
        } else {
            return null;
        }
    }

}
