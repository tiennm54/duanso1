<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\UserOrders;

class UserManagementController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function index(Request $request) {
        if (isset($request)) {
            $data = $request->all();
            $model = User::where("roles_id", "=", 2);
            if (isset($data["filter_name"])) {
                $model = $model->where("full_name", "LIKE", "%" . $data["filter_name"] . "%");
            }
            if (isset($data["filter_email"])) {
                $model = $model->where("email", "LIKE", "%" . $data["filter_email"] . "%");
            }
            if (isset($data["filter_status"]) && $data["filter_status"] != "") {
                $model = $model->where("status_lock", $data["filter_status"]);
            }
            $model = $model->orderBy("status_lock", "DESC")->orderBy("id", "DESC")->paginate(NUMBER_PAGE);
            return view('admin::userManagement.index', compact('model'));
        }
        return back();
    }

    public function view($id) {
        $model = User::find($id);
        if ($model) {
            $model_role = Role::get();
            $model_bonus = $model->getModelBonus();
            $model_spending = $model->getModelSpending();
            return view('admin::userManagement.view', compact('model_bonus', 'model_spending', 'model', 'model_role'));
        }
        return back();
    }

    public function updateMoney($id, Request $request) {
        $model = User::find($id);
        if ($model) {
            $bonus_money = $model->getMoneyForUser();
            $model->updateMoneyForUser($bonus_money);
            $model->saveUnLock();
            $request->session()->flash('alert-success', 'Success: Update money thành công!');
        } else {
            $request->session()->flash('alert-warning', 'Warning: Update money lỗi!');
        }
        return back();
    }

    public function changeRole($id, Request $request) {

        $model = User::find($id);
        if ($model) {
            $model_order = UserOrders::where("users_id", $model->id)->first();
            if ($model_order == null) {
                $model->roles_id = $request->role_id;
                $model->save();
                $request->session()->flash('alert-success', 'Success: Cập nhật role thành công!');
                return back();
            } else {
                $request->session()->flash('alert-warning', 'Warning: Không thể phân quyền cho user này!');
                return back();
            }
        } else {
            $request->session()->flash('alert-warning', 'Warning: Cập nhật role thất bại!');
            return back();
        }
        return back();
    }

}

?>