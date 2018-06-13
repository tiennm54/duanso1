<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of VisaPaymentLog
 *
 * @author minht
 */
class VisaPaymentLog extends Model {

    //put your code here
    protected $table = 'visa_payment_log';
    public $timestamps = true;

    public function saveLog($data) {
        
        $action = (isset($data["action"])) ? $data["action"] : "";
        $buyer = (isset($data["buyer"])) ? $data["buyer"] : "";
        $comment = (isset($data["comment"])) ? $data["comment"] : "";
        $orderid = (isset($data["orderid"])) ? $data["orderid"] : 0;
        $pid = (isset($data["pid"])) ? $data["pid"] : "";
        $pname = (isset($data["pname"])) ? $data["pname"] : "";
        $quantity = (isset($data["quantity"])) ? $data["quantity"] : 0;
        $status = (isset($data["status"])) ? $data["status"] : "";
        $total = (isset($data["total"])) ? $data["total"] : 0;
        $signature = (isset($data["signature"])) ? $data["signature"] : "";

        $this->action = $action;
        $this->buyer = $buyer;
        $this->comment = $comment;
        $this->orderid = $orderid;
        $this->pid = $pid;
        $this->pname = $pname;
        $this->quantity = $quantity;
        $this->status = $status;
        $this->total = $total;
        $this->signature = $signature;
        $this->save();
    }

}
