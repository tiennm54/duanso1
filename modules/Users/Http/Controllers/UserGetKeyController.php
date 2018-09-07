<?php
namespace Modules\Users\Http\Controllers;
use App\Helpers\SeoPage;
use App\Models\ArticlesTypeKey;
use App\Models\UserOrders;
use App\Models\UserOrdersDetail;
use Modules\Users\Http\Requests\GetKeyRequest;
use Pingpong\Modules\Routing\Controller;

class UserGetKeyController extends Controller {

    public function guestGetKey() {
        SeoPage::seoPage($this);
        $attributes = [
            'data-theme' => 'light',
            'data-type' => 'image',
        ];
        return view("users::getKey.get-key", compact('attributes'));
    }

    public function postGuestGetKey(GetKeyRequest $request) {
        if (isset($request)) {
            $data = $request->all();
            $model = UserOrders::where("email", "=", trim($data["email"]))->where("order_no", "=", trim($data["order_no"]))->first();
            if ($model != null) {
                $model_order = UserOrdersDetail::where("user_orders_id", "=", $model->id)->get();
                $model_key = ArticlesTypeKey::where("user_orders_id", "=", $model->id)->get();
                return view('users::order-history.order-history-view', compact('model', 'model_order', 'model_key'));
            }
        }

        $request->session()->flash('alert-warning', ' Warning: Wrong Email Address or Invoice. Please try again.');
        return back();
    }

}
