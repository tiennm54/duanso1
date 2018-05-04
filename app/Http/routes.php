<?php
define('HTTP','http://');
define('DOMAIN_SITE','buypremiumkey.com');
define('NAME_COMPANY','BuyPremiumKey Authorized Reseller');
define('EMAIL_BUYPREMIUMKEY','buypremiumkey@gmail.com');
define('EMAIL_RECEIVE_ORDER','driverxheqadni@gmail.com');
define('EMAIL_RECEIVE_AMAZON','driverxheqadni@gmail.com');

define('SUBJECT_PAYPAL_PAYMENT','[Paypal payment] Paypal Invoice for Order #');
define('SUBJECT_AMAZON_PAYMENT','[Amazon payment] Amazon Invoice for Order #');
define('SUBJECT_WMZ_PAYMENT','[Webmoney payment] Webmoney Invoice for Order #');
define('SUBJECT_PERFECT_PAYMENT','[Webmoney payment] PerfectMoney Invoice for Order #');
define('SUBJECT_BONUS_PAYMENT','[Your money payment] Invoice for Order #');
define('SUBJECT_LOCK_ACCOUNT','Your account was has been locked');

define('SUBJECT_USED_BONUS','Thông báo người dùng sử dụng tiền bonus cho thanh toán ');
define('SUBJECT_SEND_PRODUCT','[BuyPremiumKey.Com] Send product(s) for orders #');
define('SUBJECT_RESEND_PRODUCT','[BuyPremiumKey.Com] Resend product(s) for orders #');
define('SUBJECT_CUSTOMER_PAID','[BuyPremiumKey.Com] We received your payment for the order #');
define('SUBJECT_REFUND','[BuyPremiumKey.Com] Refunded Orders #');
define('SUBJECT_CANCEL','[BuyPremiumKey.Com] Canceled Orders #');
define('SUBJECT_CONTACT','[BuyPremiumKey.Com] Contact by customer');
define('SUBJECT_FORGOT','[BuyPremiumKey.Com] Forgot password');

define('SUBJECT_EMAIL_BONUS','[BuyPremiumKey.Com] You received a bonus from order #');

define('NUMBER_PAGE',20);



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'email'], function()
{
    Route::get('view-email',['as'=>'email.viewEmail','uses'=>'SendEmailController@viewEmail']);
    Route::get('send-email',['as'=>'email.sendMail','uses'=>'SendEmailController@sendMail']);
});
