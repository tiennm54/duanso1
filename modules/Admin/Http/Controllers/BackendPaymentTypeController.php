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
            $model->status_disable = $request->int_status_disable;
            $model->position = $request->txt_position;
            $model->fees = $request->txt_fees;
            $model->plus = $request->txt_plus;

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
                $model->status_disable = $request->int_status_disable;
                $model->position = $request->txt_position;
                $model->fees = $request->txt_fees;
                $model->plus = $request->txt_plus;

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
            return redirect()->route('paymentType.index');
        }
        return view('errors.503');
    }

}
