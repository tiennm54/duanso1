<?php
define('HTTP','http://');
define('DOMAIN_SITE','buypremiumkey.com');
define('NAME_COMPANY','BuyPremiumKey Authorized Reseller');
define('EMAIL_BUYPREMIUMKEY','support@buypremiumkey.com');
define('EMAIL_RECEIVE_ORDER','driverxheqadni@gmail.com');
define('EMAIL_RECEIVE_AMAZON','driverxheqadni@gmail.com');
define('EMAIL_RECEIVE_VISA','driverxheqadni@gmail.com');

define('SUBJECT_PAYPAL_PAYMENT','[Paypal payment] Paypal Invoice for Order #');
define('SUBJECT_VISA_PAYMENT','[Visa payment] Visa Invoice for Order #');
define('SUBJECT_AMAZON_PAYMENT','[Amazon payment] Amazon Invoice for Order #');
define('SUBJECT_WMZ_PAYMENT','[Webmoney payment] Webmoney Invoice for Order #');
define('SUBJECT_PERFECT_PAYMENT','[PerfectMoney payment] PerfectMoney Invoice for Order #');
define('SUBJECT_BONUS_PAYMENT','[Your money payment] Invoice for Order #');
define('SUBJECT_LOCK_ACCOUNT','Your account was has been locked');

define('SUBJECT_USED_BONUS','Thông báo người dùng sử dụng tiền bonus cho thanh toán ');
define('SUBJECT_SEND_PRODUCT','[BuyPremiumKey.Com] Your premium key/account. Order #');
define('SUBJECT_RESEND_PRODUCT','[BuyPremiumKey.Com] Your premium key/account. Order #');
define('SUBJECT_CUSTOMER_PAID','[BuyPremiumKey.Com] We received your payment for the order #');
define('SUBJECT_REFUND','[BuyPremiumKey.Com] Refunded Orders #');
define('SUBJECT_CANCEL','[BuyPremiumKey.Com] Canceled Orders #');
define('SUBJECT_CONTACT','[BuyPremiumKey.Com] Contact by customer');
define('SUBJECT_FORGOT','[BuyPremiumKey.Com] Forgot password');
define('SUBJECT_REPLY_COMMENT','[BuyPremiumKey.Com] Your comment has been replied');

define('SUBJECT_EMAIL_BONUS','[BuyPremiumKey.Com] You received a bonus from order #');

define('NUMBER_PAGE',20);


define('VISA_ERROR_PRICE',"We only accept payment with TOTAL PRICE >= $2. Or there was an error processing the payment. Please try again!");
define('VISA_ERROR_CHECKOUT',"There was an error processing the payment. Please try again.");
define('VISA_PAYMENT_MIN',2);
define('VISA_CODE',"we2ue7ku3ge1pru5ro5pu6mi4pra7pri1chu4cle8pho7go0no9stu6pe6cli0ti");


define('NOTI_WORKING', "We are working in business time! Place your order now, or contact us if you have a problem.");
define('NOTI_OUT_WORKING', "Your keys/vouchers/account will be delivery within 1-6 hours. If you do not receive premium in maximum 8 hours => Please contact us first, do not open the disputed. We will deliver to you as soon as possible. Thanks you!");




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
