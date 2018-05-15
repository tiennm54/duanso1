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
}
