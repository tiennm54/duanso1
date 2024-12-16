<?php

namespace Modules\Admin\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use App\Models\BlackListIP;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Log;
use DB;

/**
 * Description of KeyStockController
 *
 * @author minht
 */
class BlackListIPController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function index(Request $request) {
        $model = new BlackListIP();
        if (isset($request)) {
            if (isset($request->user_ip) && $request->user_ip != "") {
                $model = $model->where("user_ip", "LIKE", "%" . trim($request->user_ip) . "%");
            }
        }

        $model = $model
                ->orderBy('id', "DESC")
                ->paginate(NUMBER_PAGE);

        return view('admin::blackListIp.index', compact('model'));
    }

    public function delete($id, Request $request) {
        $model = BlackListIP::find($id);
        if ($model != null) {
            $model->delete();
            $request->session()->flash('alert-success', 'Success: Xóa thành công!');
            return back();
        } else {
            $request->session()->flash('alert-warning', 'Warning: Xóa không thành công!');
            return back();
        }
    }

    public function create(Request $request) {
        if (isset($request)) {
            if (isset($request->ip_ban) && $request->ip_ban != "") {
                $model = new BlackListIP();
                $check = $model->addBlackListIP(trim($request->ip_ban));
                if ($check) {
                    $request->session()->flash('alert-success', 'Success: Tạo thành công!');
                }else{
                    $request->session()->flash('alert-warning', 'Warning: IP này đã tồn tại!');
                }
                return back();
            }
        }
        $request->session()->flash('alert-warning', 'Warning: Tạo không thành công!');
        return back();
    }

}
