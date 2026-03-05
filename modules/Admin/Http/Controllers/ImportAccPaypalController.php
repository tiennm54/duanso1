<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\PaypalAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Pingpong\Modules\Routing\Controller;
use DB;
use Log;
use Input;
use Excel;

class ImportAccPaypalController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function getImportAccPaypal() {
        return view('admin::import.import-acc-paypal');
    }

    public function postImportAccPaypal(Request $request) {

        $arr_prefix = array("Maintenance & Support Package", 
            "App Design",
            "Website Optimization Services", 
            "Web Design", 
            "Cosy Teddy MacBook Case",
            "Dog Walking Bag Bundle",
            "Mexico Hawaiian Shirts",
            "Beach Summer Shirts",
            "Hawaiian Shirts",
            "Dog Unisex T Shirt",
            "Unisex T Shirt",
            "Apple Watch Case",
            "Bluetooth Speaker",
            "SSD hard drive",
            "Wireless headphones",
            "Gaming keyboard",
            "Gaming mouse",
            "Smart watch",
            "Computer screen",
            "Gadget Galaxy",
            "NYC Snapback Hat",
            "Black and white snapback hat");
        
        if (isset($request)) {
            
            
            
            $data = $request->all();
            $max_amount = $data["max_amount"];
            $seller_name = $data["seller_name"];

            if (Input::hasFile('import_file_acc')) {
                $path = Input::file('import_file_acc')->getRealPath();
                $dataExcel = Excel::load($path, function ($reader) {
                            
                        })->get();

                if (!empty($dataExcel) && $dataExcel->count()) {

                    $error = array();
                    $insert = array();

                    $count = 0;
                    foreach ($dataExcel as $key => $value) {
                        
                        //Log::info($value["email_paypal"]);

                        $check = PaypalAccount::where("email", "=", trim($value["email_paypal"]))->count();

                        if ($check == 0) {
                            
                            $birthday = "";
                            if (strtotime($value["birthday"]) !== false){
                                $birthday = $value["birthday"]->toDateString();
                            }else{
                                $birthday = (string) $value["birthday"];
                            }


                            $description = "<p> " . $value["email_paypal"] . " / " . $value["password_email"] . "</p>" .
                                    "<p>" . $value["full_name"] . "</p>" .
                                    "<p>Birthday: " . $birthday . "</p>" .
                                    "<p>CCCD: " . $value["cccd_and_id"] . "</p>" .
                                    "<p>Phone: " . $value["phone"] . "</p>" .
                                    "<p>Address: " . $value["address"] . "</p>" .
                                    "<p>Link Docs: " . $value["link_docs"] . "</p>" .
                                    "<p>2FA Paypal: " . $value["2fa_paypal"] . "</p>" .
                                    "<p>2FA Email: " . $value["2fa_email"] . "</p>" .
                                    "<p>Email backup: " . $value["email_paypal_backup"] . " / " . $value["password_email_backup"] . "</p>" .
                                    "<p>Recovery email: " . $value["recovery_email"] . "</p>" .
                                    "<p>Note 1: " . $value["note_1"] . "</p>" .
                                    "<p>Note 2: " . $value["note_2"] . "</p>";
                            
                            $randomPrefixKey = array_rand($arr_prefix);
                            $randomPrefixString = $arr_prefix[$randomPrefixKey];


                            $tmp = array(
                                "email" => $value["email_paypal"],
                                "password" => $value["password_paypal"],
                                "full_name" => $value["full_name"],
                                "status_activate" => "No_Activate",
                                "status" => "Work",
                                "phone" => $data["seller_name"] . " " . $value["phone"],
                                "max_money" => $max_amount,
                                "max_receive" => $max_amount,
                                "cmnd" => $value["cccd_and_id"],
                                "money_activate" => 0,
                                "money_hold" => 0,
                                "description" => $description,
                                "prefix" => $randomPrefixString
                            );
                            array_push($insert, $tmp);
                            $count++;
                            
                        } else {

                            $tmp_error = array(
                                "email_paypal" => $value["email_paypal"]
                            );

                            array_push($error, $tmp_error);
                        }
                    }

                    if ($count != 0) {
                        PaypalAccount::insert($insert);
                        $request->session()->flash('alert-success', 'Success: Import thành công: ' . $count . ' account paypal.');
                        return redirect()->route('admin.paypal.index');
                    } else {
                        return $error;
                    }
                }
            }

            $request->session()->flash('alert-warning', 'Warning: Bị lỗi rồi, Minh Tiến hãy cố gắng và vui lòng thực hiện lại!');
            return back();
        }
    }

}
