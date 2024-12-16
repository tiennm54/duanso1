<?php
define('HTTP','http://');
define('DOMAIN_SITE','buypremiumkey.com');
define('NAME_COMPANY','BuyPremiumKey Authorized Reseller');
define('EMAIL_BUYPREMIUMKEY','support@buypremiumkey.com');
define('EMAIL_ADMIN_BUYPREMIUMKEY','admin@buypremiumkey.com');
define('EMAIL_RECEIVE_ORDER','driverxheqadni@gmail.com');
define('EMAIL_RECEIVE_AMAZON','driverxheqadni@gmail.com');
define('EMAIL_RECEIVE_VISA','buypremiumkey@gmail.com');

define('SUBJECT_PAYPAL_PAYMENT','[Buypremiumkey.com] Paypal Invoice for Order #');
define('SUBJECT_VISA_PAYMENT','[Visa payment] Visa Invoice for Order #');
define('SUBJECT_AMAZON_PAYMENT','[Amazon payment] Amazon Invoice for Order #');
define('SUBJECT_WMZ_PAYMENT','[Webmoney payment] Webmoney Invoice for Order #');
define('SUBJECT_PERFECT_PAYMENT','[PerfectMoney payment] PerfectMoney Invoice for Order #');
define('SUBJECT_VISASTRIPE_PAYMENT','[VISA payment] VISA Invoice for Order #');
define('SUBJECT_BONUS_PAYMENT','[Your money payment] Invoice for Order #');
define('SUBJECT_LOCK_ACCOUNT','Your account was has been locked');

define('SUBJECT_USED_BONUS','Thông báo người dùng sử dụng tiền bonus cho thanh toán ');
define('SUBJECT_SEND_PRODUCT','[BuyPremiumKey.Com] Your premium key/account. Order #');
define('SUBJECT_RESEND_PRODUCT','[BuyPremiumKey.Com] Your premium key/account. Order #');
define('SUBJECT_CUSTOMER_PAID','[BuyPremiumKey.Com] You have successfully paid for your Order #');
define('SUBJECT_REFUND','[BuyPremiumKey.Com] Refunded Orders #');
define('SUBJECT_CANCEL','[BuyPremiumKey.Com] Canceled Orders #');
define('SUBJECT_CONTACT','[BuyPremiumKey.Com] Contact by customer');
define('SUBJECT_FORGOT','[BuyPremiumKey.Com] Forgot password');
define('SUBJECT_REPLY_COMMENT','[BuyPremiumKey.Com] Your comment has been replied');

define('SUBJECT_EMAIL_BONUS','[BuyPremiumKey.Com] You received a bonus from order #');

define('NUMBER_PAGE',20);
define('RATE_PAYPAL',4.42);


define('VISA_ERROR_PRICE',"We only accept payment with TOTAL PRICE >= $2. Or there was an error processing the payment. Please try again!");
define('VISA_ERROR_CHECKOUT',"There was an error processing the payment. Please try again.");
define('VISA_PAYMENT_MIN',2);

define('VISA_CODE',"we2ue7ku3ge1pru5ro5pu6mi4pra7pri1chu4cle8pho7go0no9stu6pe6cli0ti");

define('VISA_PRIVATE_KEY', "17f4a3-d9f8e6-d2a662-3e4209-8d8e1b");
define('VISA_SELLER_ID',"buypremiumkey.com");
define('VISA_POST',"https://ipremium.io/receiverpost.php");

define('VISA_STRIPE_SITE','https://hugeamazing.com');


define('NOTI_WORKING', "We are working in business time! Place your order now, or contact us if you have a problem.");
define('NOTI_OUT_WORKING', "Your keys/vouchers/account will be delivery within 1-8 hours. If you do not receive premium in maximum 8 hours => Please contact us first, do not open the disputed. We will deliver to you as soon as possible. Thanks you!");
define('NOTI_NOTE_VISA', "You are our loyal customer so you can pay through VISA/MASTER CARD payment gateway. Please note: The content of the payment for this order in your bank will be different from the description of the product you will purchase so please do not open a dispute. If you would like a refund, please contact us via the customer support email: support@buypremiumkey.com. Thank you for using our service!");

define('PRIVATE_PAYPAL_KEY', "AAABBBCCC");
define('MAX_PAYMENT', 500);
define('PAYPAL_PRIVATE_KEY', "17f4a3-d9f8e6-d2a662-3e4209-8d8e1b");

define('LICENSE_IP', 'Vzx2w0qmXvMvAuR');
define('FIELDS_IP', 66846719);


/*
|--------------------------------------------------------------------------
| Platform: He thong quan ly ngoai site ban hang
|--------------------------------------------------------------------------
| Duoi day la tat ca cac config lien quan toi Platform phat trien ngay 14/11/2024
|
*/

define('PLATFORM_PUBLIC_KEY', "bf239cf4-cf02-454b-82b2-4a185931b947");
define('PLATFORM_PRIVATE_KEY', "t0yu1ISpnXg4qz5JrF78pnqYR1mdwwW2SzPwBTJp");
define('PLATFORM_URL_POST', "https://buypremiumkey.co/api/v1/order");


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
