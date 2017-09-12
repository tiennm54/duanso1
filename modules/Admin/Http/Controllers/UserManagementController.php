<?php
namespace Modules\Admin\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserManagementController extends Controller {

    public function __construct(){
        $this->middleware("role");
    }

    public function index(Request $request){
        if (isset($request)){
            $data = $request->all();
            $model = User::where("roles_id","=",2);
            if (isset($data["filter_name"])){
                $model = $model->where("full_name","LIKE","%".$data["filter_name"]."%");
            }
            if (isset($data["email"])){
                $model = $model->where("email","LIKE","%".$data["filter_email"]."%");
            }

            $model = $model->orderBy("id","DESC")->paginate(20);

            return view('admin::userManagement.index', compact('model'));
        }

    }
}

?>