<?php

namespace Modules\Users\Http\Controllers;
use Pingpong\Modules\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckMemberController extends Controller {
    public function checkMember(){
        if (Auth::check()) {
            $user = Auth::user();
            if ($user) {
                $user_id = $user->id;
                $model = User::find($user_id);
                if ($model) {
                    return $model;
                }
            }
        }
        return null;
    }
}