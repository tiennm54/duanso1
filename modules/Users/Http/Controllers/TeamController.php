<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRef;

class TeamController extends CheckMemberController {

    public function listTeam(Request $request) {
        $data = $request->all();
        $model_user = $this->checkMember();
        if ($model_user) {
            
            $model = UserRef::join("users","user_ref.user_id","=","users.id")
            ->select(
                "user_ref.*",
                "users.email"
            )
            ->where("user_ref.user_sponser_id","=",$model_user->id);
            
            if(isset($data["searchTeam"]) && $data["searchTeam"] != ""){
                $model = $model->where("users.email","LIKE", "%" . $data["searchTeam"] . "%");
            }
            $model = $model->groupBy("user_ref.user_id")->paginate(NUMBER_PAGE);
            
            $model_sponsor = UserRef::where("user_id", $model_user->id)->first();
            return view('users::team.index', compact('model','model_sponsor'));
        } else {
            return redirect()->route('users.getLogin');
        }
    }

}
