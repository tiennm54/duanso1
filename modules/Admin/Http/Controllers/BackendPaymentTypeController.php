<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\PaymentType;
use Modules\Admin\Http\Requests\PaymentTypeRequest;
use Pingpong\Modules\Routing\Controller;
use DB;
use Input;

class BackendPaymentTypeController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function index() {
        $model = PaymentType::orderBy('position', 'ASC')->get();
        return view('admin::paymentType.index', compact('model'));
    }

    public function getCreate() {
        return view('admin::paymentType.create');
    }

    public function postCreate(PaymentTypeRequest $request) {
        if (isset($request)) {
            DB::beginTransaction();

            $model = new PaymentType();
            $model->title = $request->txt_title;
            $model->code = $request->txt_code;
            $model->status_disable = $request->int_status_disable;
            $model->status_selected = $request->int_status_selected;
            $model->position = $request->txt_position;
            $model->fees = $request->txt_fees;
            $model->plus = $request->txt_plus;
            if (isset($request->txt_payment_id)) {
                $model->payment_id = $request->txt_payment_id;
            }

            if (isset($request->txt_description)) {
                $model->description = $request->txt_description;
            }

            if ((isset($request->txt_email))) {
                $model->email = $request->txt_email;
            }

            if (isset($request->txt_image)) {
                if ($request->hasFile('txt_image')) {
                    $image = $request->file('txt_image');
                    $input['image_name'] = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/images');
                    $image->move($destinationPath, $input['image_name']);
                    $model->image = $input['image_name'];
                }
            }

            $model->save();
            DB::commit();
            $request->session()->flash('alert-success', 'Success: Tạo phương thức thanh toán thành công !!!');
            return redirect()->route('paymentType.index');
        }
    }

    public function getEdit($id) {

        $model = PaymentType::find($id);
        if ($model) {
            return view('admin::paymentType.edit', compact('model'));
        } else {
            return view('errors.503');
        }
    }

    public function postEdit(PaymentTypeRequest $request, $id) {
        if (isset($request)) {
            DB::beginTransaction();
            $model = PaymentType::find($id);
            if ($model != null) {
                $old_image = $model->image;

                $model->title = $request->txt_title;
                $model->code = $request->txt_code;
                $model->status_disable = $request->int_status_disable;
                $model->status_selected = $request->int_status_selected;
                $model->position = $request->txt_position;
                $model->fees = $request->txt_fees;
                $model->plus = $request->txt_plus;
                $model->disable_vn = $request->disable_vn;
                if (isset($request->txt_payment_id)) {
                    $model->payment_id = $request->txt_payment_id;
                }

                if (isset($request->txt_description)) {
                    $model->description = $request->txt_description;
                }

                if ((isset($request->txt_email))) {
                    $model->email = $request->txt_email;
                }

                if (isset($request->txt_image)) {
                    if ($request->hasFile('txt_image')) {
                        $image = $request->file('txt_image');
                        $input['image_name'] = time() . '.' . $image->getClientOriginalExtension();
                        $destinationPath = public_path('/images');
                        $image->move($destinationPath, $input['image_name']);
                        $model->image = $input['image_name'];

                        if ($old_image && file_exists('images/' . $old_image)) {
                            unlink('images/' . $old_image);
                        }
                    }
                }

                $model->save();
                DB::commit();
                $request->session()->flash('alert-success', 'Success: Cập nhật phương thức thanh toán thành công !!!');
                return back();
            }
        }
        return view('errors.503');
    }

    public function delete($id) {
        $model = PaymentType::find($id);
        if ($model != null) {
            if ($model->image && file_exists('images/' . $model->image)) {
                unlink('images/' . $model->image);
            }

            $model->delete();
            $request->session()->flash('alert-success', 'Success: Xóa phương thức thanh toán thành công !!!');
            return redirect()->route('paymentType.index');
        }
        return view('errors.503');
    }

}
