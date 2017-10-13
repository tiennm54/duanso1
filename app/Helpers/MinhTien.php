<?php

namespace App\Helpers;

class MinhTien {

    public static function validateEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //echo("$email is a valid email address");
            return 1;
        } else {
            //echo("$email is not a valid email address");
            return 0;
        }
    }

}
