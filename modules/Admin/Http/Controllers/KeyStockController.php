<?php

namespace Modules\Admin\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use App\Models\KeyStock;
use App\Models\ArticlesType;
use App\Models\PaidKeyLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Log;
use DB;

/**
 * Description of KeyStockController
 *
 * @author minht
 */
class KeyStockController extends Controller {

    public function __construct() {
        $this->middleware("editor");
    }

    public function getCreate(Request $request, $id) {

        $model_product = ArticlesType::find($id);
        if ($model_product != null) {
            $model = new KeyStock();
            $model = $model->where("articles_type_id", "=", $id);
            if (isset($request->searchKey) && $request->searchKey != "") {
                $model = $model->where("premium_key", "LIKE", "%" . $request->searchKey . "%");
            }
            if (isset($request->searchStatus) && $request->searchStatus != "") {
                $model = $model->where("status", "=", $request->searchStatus);
            }
            if (isset($request->searchInvoice) && $request->searchInvoice != "") {
                $model = $model->where("invoice", "LIKE", "%" . $request->searchInvoice . "%");
            }
            if (isset($request->searchUser) && $request->searchUser != "") {
                $model = $model->where("user_activated_email", "LIKE", "%" . $request->searchUser . "%");
            }

            $count_unpaid = KeyStock::where("articles_type_id", "=", $id)->where("status_paid", "!=", 1)->count();

            $count_unpaid_refund = KeyStock::where("articles_type_id", "=", $id)
                            ->where("status_paid", "!=", 1)
                            ->where("status", "=", "Refund")->count();

            $model = $model->orderBy('status', 'asc')->orderBy('id', 'desc')->paginate(NUMBER_PAGE);

            return view('admin::keyStock.create', compact('model', 'model_product', 'count_unpaid', 'count_unpaid_refund'));
        }
    }

    public function postCreate(Request $request, $id) {
        if (isset($request)) {
            $model_product = ArticlesType::find($id);
            if ($model_product != null) {
                DB::beginTransaction();
                $model = new KeyStock();
                $model->articles_type_id = $id;
                $model->articles_type_title = $model_product->title;
                $model->premium_key = $request->premiumKey;
                $model->status_paid = 0;
                $model->status = "Pending";
                $model->created_at = Carbon::now();
                $model->updated_at = Carbon::now();
                $model->save();
                DB::commit();
                $request->session()->flash('alert-success', 'Success: Add Key: ' . $model->premium_key);
                return back();
            }
        }
        DB::rollback();
        return view('errors.503');
    }

    public function saveOneUnPaid($model_product) {
        $model_key = KeyStock::where("articles_type_id", "=", $model_product->id)->where("status_paid", "!=", 1)->where("status", "!=", "Pending")->get();
        $count_key_refund = KeyStock::where("articles_type_id", "=", $model_product->id)->where("status_paid", "!=", 1)->where("status", "=", "Refund")->count();
        $count_key_paid = 0;
        if ($model_key != null) {
            foreach ($model_key as $item) {
                $item->status_paid = 1;
                $item->save();
                $count_key_paid++;
            }
        }

        //Lưu log paid
        if ($count_key_paid != 0 || $count_key_refund != 0) {
            $model_paid_log = new PaidKeyLog();
            $model_paid_log->savePaidKeyLog($model_product->getArticles->id, $model_product, $count_key_paid, $count_key_refund);
            return 'Success: Đã paid: ' . $count_key_paid . ' key | Refund: ' . $count_key_refund . ' key.';
        }
        return "";
    }

    public function saveUnPaid(Request $request, $id) {
        if (isset($request)) {
            $model_product = ArticlesType::find($id);
            if ($model_product != null) {

                DB::beginTransaction();

                $check = $this->saveOneUnPaid($model_product);
                if ($check != "") {
                    $request->session()->flash('alert-success', $check);
                } else {
                    $request->session()->flash('alert-warning', 'Warning: Không có premium key nào cần thanh toán!');
                }

                DB::commit();
                return back();
            } else {
                $request->session()->flash('alert-warning', 'Warning: Tất cả các key đã được thanh toán!');
                return back();
            }
        }
    }

    public function saveAllUnPaid(Request $request, $id) {
        DB::beginTransaction();
        $model_list_product = ArticlesType::where("articles_id", "=", $id)->get();
        if ($model_list_product) {
            foreach ($model_list_product as $model_product) {
                $this->saveOneUnPaid($model_product);
            }
        }
        DB::commit();
        return redirect()->route('admin.paidFilehost.index', ["id" => $id]);
        return back();
    }

    public function delete($id, Request $request) {
        $model = KeyStock::find($id);
        if ($model != null) {
            $key = $model->premium_key;
            $model->delete();
            $request->session()->flash('alert-success', 'Success: Xóa key: ' . $key);
            return back();
        } else {
            return view('errors.503');
        }
    }

    public function saveStatusKey($id, Request $request) {
        if (isset($request)) {
            DB::beginTransaction();
            $model = KeyStock::find($id);
            if ($model != null) {
                $model->status = $request->statusKey;
                $model->status_paid = $request->statusPaid;
                $model->save();
                DB::commit();
                $request->session()->flash('alert-success', 'Success: Update status key: ' . $model->premium_key . ' là: ' . $model->status);
                return back();
            }
        }
    }

}
