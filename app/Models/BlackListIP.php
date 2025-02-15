<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Log;

class BlackListIP extends Model {

    protected $table = 'blacklist_ip';
    public $timestamps = false;

    public function getUserIpAddr() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    
    public function getInfoIP($ip) {
        $url = 'https://pro.ip-api.com/php/' . $ip . '?key=' . LICENSE_IP . '&fields=' . FIELDS_IP;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = unserialize($result);
        //Log::info($result);
        return $result;
    }

    public function getShortIP($ip) {
        $explode = explode(".", $ip);
        $count_ex = count($explode);
        $short_ip = "";
        for ($i = 0; $i < $count_ex - 1; $i++) {
            $short_ip = $short_ip . $explode[$i] . ".";
        }
        return $short_ip;
    }

    public function addBlackListIP($ip) {
        $short_ip = $this->getShortIP($ip);
        $model = BlackListIP::where("short_ip", "=", $short_ip)->first();
        if ($model == null && $short_ip != IP_PLATFORM) {
            $this->user_ip = $ip;
            $this->short_ip = $short_ip;
            $this->save();
            return true;
        }
        return false;
    }
    
    public function addBlackListIPCurrent(){
        $ip = $this->getUserIpAddr();
        $this->addBlackListIP($ip);
    }

    public function checkIPBan() {
        $ip = $this->getUserIpAddr();
        $short_ip = $this->getShortIP($ip);
        if ($short_ip != "") {
            $model = BlackListIP::where("short_ip", "=", $short_ip)->first();
            if ($model) {
                return true; // tim thay ip bi ban
            } else {
                $infoIP = $this->getInfoIP($ip);
                if ($infoIP['status'] == 'success') {
                    $check_isp = strpos(strtolower($infoIP['isp']), 'paypal');
                    if ($check_isp !== false){
                        $this->addBlackListIP($ip);
                    }
                }
                return false; // khong tim thay
            }
        }
        return false; // khong tim thay
    }
}
