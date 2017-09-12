/*
SQLyog Community v12.09 (64 bit)
MySQL - 10.1.16-MariaDB : Database - buypmwmk_premiumkey
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`buypmwmk_premiumkey` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `buypmwmk_premiumkey`;

/*Table structure for table `articles_type_des` */

DROP TABLE IF EXISTS `articles_type_des`;

CREATE TABLE `articles_type_des` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artilces_type_id` int(11) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `articles_type_des` */

insert  into `articles_type_des`(`id`,`artilces_type_id`,`description`) values (4,12,'No waiting'),(5,12,'Maximum download speed'),(6,12,'Resume support');

/*Table structure for table `news` */

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) DEFAULT NULL,
  `url_title` varchar(500) DEFAULT NULL,
  `description` text,
  `product_id` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `seo_title` varchar(500) DEFAULT NULL,
  `seo_description` varchar(500) DEFAULT NULL,
  `seo_keyword` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `news` */

insert  into `news`(`id`,`title`,`url_title`,`description`,`product_id`,`created_at`,`updated_at`,`created_by`,`updated_by`,`seo_title`,`seo_description`,`seo_keyword`) values (1,'Test 2',NULL,'<p>Test 2</p>\r\n',1,'2017-07-20 17:01:04','2017-07-21 09:39:23',NULL,2,'Test 12','Test 2','Test 2');

/*Table structure for table `seo` */

DROP TABLE IF EXISTS `seo`;

CREATE TABLE `seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('index','checkout') DEFAULT NULL,
  `seo_title` varchar(200) DEFAULT NULL,
  `seo_description` varchar(500) DEFAULT NULL,
  `seo_keyword` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `seo` */

insert  into `seo`(`id`,`type`,`seo_title`,`seo_description`,`seo_keyword`,`created_at`,`updated_at`) values (1,'index','Authorized Reseller - Premium Key/voucher via Paypal, Secure & Instant Delivery','We are Official Reseller File Hosting - You can buy premium key, voucher,  プレミアムキー  via Paypal, Visa/Master Card, Webmoney, Bitcoin, Okpay, ','Depfile premium paypal, depfile paypal, depfile reseller paypal, Keep2share reseller paypal, Fileboom reseller paypal, rapidgator reseller paypal, Alfafile reseller paypal, datafile reseller paypal, filesmonster reseller paypal','2017-07-05 22:23:30','2017-07-05 22:23:37'),(2,'checkout','Checkout','We are Official Reseller File Hosting - You can buy premium key, voucher,  プレミアムキー  via Paypal, Visa/Master Card, Webmoney, Bitcoin, Okpay, ','Depfile premium paypal, depfile paypal, depfile reseller paypal, Keep2share reseller paypal, Fileboom reseller paypal, rapidgator reseller paypal, Alfafile reseller paypal, datafile reseller paypal, filesmonster reseller paypal','2017-07-05 22:23:34','2017-07-05 22:23:41');

/*Table structure for table `terms_conditions` */

DROP TABLE IF EXISTS `terms_conditions`;

CREATE TABLE `terms_conditions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `terms_conditions` */

insert  into `terms_conditions`(`id`,`description`) values (1,'<p>YOUR AGREEMENT TO THESE TERMS AND CONDITIONS OF SERVICE Welcome to our website. If you continue to browse or purchasing and use this website you are agreeing to comply with and be bound by the following terms and conditions of use, which together with our privacy policy govern PremiumInstant.Com relationship with you in relation to this website. ABOUT PremiumInstant.Com PremiumInstant.Com is a reseller of Premium access to file-sharing services. We don&rsquo;t sell content (files), but only sell services - Premium accounts for high speed access or other such premium benefits. It is strictly forbidden to download or upload any copyrighted content (movie , software, music , picture, ...) without prior approval of the copyright content owner. It&#39;s illegal to download or upload child pornography. It is strictly forbidden to download or upload any pornographic, erotic content on any storage solution that we represent. &#39;You&#39; agree that you will not misuse any of the file hosting / cloud storage / storage solutions that we resell via premium vouchers, keys, login id &amp; password&#39;s or direct upgrade in downloading, uploading or storing any type of copyrighted or porn content, if found you are sole responsible for the legal and financial consequences arising from it. SERVICE AVAILABILITY PremiumInstant.Com strives to provide 24/7 service, it may however happen that due to break in connections or service maintenance, service to certain File-hosting are temporarily unavailable. USE OF SERVICE Subject to these conditions, you may use the Service to purchase a product ( Premium key / Premium account / Voucher / Code ) as follows: (i) Use and follow the step-by-step transaction process to initiate a product. (ii) After you confirm the order by making the payment and the transaction is successfully processed, the Recipient will be informed that transaction is successfully. (iii) You will receive product via email. DELIVERY Activation / Premium key sent via your email. The processing lead-time of your order depends on the means of payment you have chosen. Usually it does not exceed 30 minutes for on-line payments during opening time, maximum 12 hours ( * Note: Our working time: 8h00 - 23h00 GMT+7 ) Delivery of our services will be confirmed on your mail ID as specified during registration. For any issues in utilizing our services you may contact our helpdeskIts the customers responsibility to provide a valid and correct email ID as the product will be delivered to it. The customer needs to confirm that our emails do not end up in JUNK folder of your email. A copy of the product will be stored in your account with PremiumInstant.Com just login into your account to view it. If you do not receive any product details from us with in 48 hrs then please contact us Paypal Payment Method: If any disputes has been opened in Paypal will cause only a permanently ban for the user and, of course, shut down of all the keys and the products that are purchased from PremiumInstant.Com. The ban is permanently which prevents the user from buying any products in the future. We will contact Admin of Filehost to disable your account ! Manually Payment Methods: User have to fulfill the &ldquo;Order Notes&rdquo; field with the chosen Payment method information. Example: Payza Email, Webmoney purse number, Moneybookers Email, Vodafone number etc&hellip; CREDIT CARD SECURITY We do not keep records of credit card details credit cards are processed by a third party secured payment gateway. Your Credit card details will be handled securely to ensure confidentiality and that 128 bit SSL encryption is employed to ensure sensitive data is protected during transmission over the internet We can ask identity proof to verify the rightful owner of the credit card like Scanned copy (or photograph by a digital camera) of Driving License, Identification card, Last hardcopy of credit card statement, Passport etc. If asked for kindly provide one of the above as it is for the security of the card holder. (This is only one time process, the customer will not require to go through the identification process for the next transfers) CONNECTION SECURITY YOUR CONNECTION TO THIS SITE IS ENCRYPTED AND SECURED BY 256BIT SSL FROM GEOTRUST REFUND &amp; CANCELLATION POLICY We offer 100% guarantee. However, our products are subject to Terms and Conditions and we will offer a refund only if the service did not work. Our overall objective is safety and execution of obligations to clients. On the other hand we try to protect ourselves from casual the incidents connected with a piracy and swindle concerning the software. As we sell non-tangible irrevocable goods we do not issue refunds once the order is accomplished and the product is delivered. As a customer you are responsible for understanding this upon purchasing any item at our site. If the error occur we will try our best to solve the problem in 72 hours after this time if the problem can&#39;t be solved we will make the refund but the money will be deducted the payment fee It is dependent on the payment gateway fee, usually it is range from 1% to 3% product value. We do not take responsibility and no warranty if your account is banned, blocked because of broken the rules of File-hosting company. When refunding is possible: - The duplicated orders. If system on what or, to the reasons has sold to you two identical premium keys instead of two different. - If sold system of the premium key has appeared not efficient. - Received a wrong voucher code, e.g. a wrong retention or wrong service. Of course we can give you another premium key code also - After you successfully complete payment, on any to the reasons could not give out or send you on indicating you an e-mail premium a premium key in a current of 7 days. When refunding is not possible: - Ordered premium keys or accounts but do not need it anymore - Simultaneous purchase of several different premium keys. The scenario at which the user gets some keys, applies them, what most approaches its needs chooses, and, then tries to receive the refund for all other goods which do not approach it, is regarded as dishonest. The given actions harm to our business so we not begin to return the paid money or to resolve pretentious payments - We can not offer a refund if after the purchase, the user feels that the download is slow, the link is dead, or do not get the desired files to download ... - A refund will not be accepted if the company File-hosting is no longer active due to some technical issues, or closed according to law or other issues, or you cannot access the website. REFUND REQUESTS should be submitted to PremiumInstant.Com by email at support@premiuminstant.com CHARGES PremiumInstant.Com does not charge any fees ( Except Paypal payment method ) for sending product (Premium key / Premium account / Voucher / Code) and all prices listed are final and include all taxes. EXPIRATION DATE OF PREMIUM KEY / PREMIUM ACCOUNT Premium key / Premium account will generally have an expiration date, which is established by the File-hosting&#39;s administrator. Please consult with the File-hosting&#39;s administrator for additional details. LIMITATION OF LIABILITY We are not liable for acts or omissions of another service provider, for information provided through your email address, equipment failure or modification, or causes beyond our reasonable control. We are not liable for any accidents or incidents, which result from the use of Service by you or any other person. Our liability and the liability of any underlying carrier for any failure or mistake shall in no event exceed our charges during the affected period. We and any underlying carrier are not liable for any incidental, punitive or consequential damages such as lost profits. We and any underlying carrier are not liable for economic loss or injury to persons or property arising from the use of service. Additionally, in no event will the Company, Company Affiliates, Content Providers and their respective shareholders be liable for any direct, indirect, special, punitive, incidental, exemplary or consequential damages of any kind (including, but not limited to, economic loss, loss of information or data, interruption, delay or loss of access to or use of the Internet, and the like), arising in any way or any manner from errors or omissions in the content or defects in the services provided by PremiumInstant.Com hereunder or your access to and use of the Service. THE LIMITATIONS CONTAINED IN THE SITE SHALL APPLY REGARDLESS OF THE FORM OF ACTION, WHETHER IN CONTRACT, TORT OR STRICT LIABILITY, AND REGARDLESS OF THE NATURE OR NUMBER OF CLAIMS OR ACTIONS. This paragraph shall survive termination of this Agreement. INDEMNIFICATION You agree to defend, indemnify, and hold us, our affiliates and representatives and any other service provider, harmless from claims or damages relating to this Agreement or your premises or statements made in it and use the Service. This paragraph shall survive termination of this Agreement. NO WARRANTIES WE DO NOT MAKE ANY EXPRESS OR IMPLIED WARRANTIES, REPRESENTATIONS OR ENDORSEMENTS WHATSOEVER (INCLUDING WITHOUT LIMITATION WARRANTIES OF TITLE OR NON-INFRINGEMENT, OR THE IMPLIED WARRANTIES OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE) WITH REGARD TO THE SITE, ANY MERCHANDISE, INFORMATION OR SERVICE PROVIDED THROUGH THE SITE OR ON THE INTERNET GENERALLY, AND WE SHALL NOT BE LIABLE FOR ANY COST OR DAMAGE ARISING EITHER DIRECTLY OR INDIRECTLY FROM ANY SUCH TRANSACTION. IT IS YOUR RESPONSIBILITY TO EVALUATE THE ACCURACY, COMPLETENESS AND USEFULNESS OF ALL OPINIONS, ADVICE, SERVICES, MERCHANDISE AND OTHER INFORMATION PROVIDED THROUGH THE SITE OR ON THE INTERNET GENERALLY. WE DO NOT WARRANT THAT THE SERVICE WILL BE UNINTERRUPTED OR ERROR-FREE OR THAT DEFECTS IN THE SITE WILL BE CORRECTED. THE SITE AND ANY INFORMATION MADE AVAILABLE ON THE SITE ARE PROVIDED ON AN &ldquo;AS IS, AS AVAILABLE&rdquo; BASIS. IN NO EVENT WILL PremiumInstant.Com BE LIABLE FOR (1) ANY INCIDENTAL, CONSEQUENTIAL, OR INDIRECT DAMAGES (INCLUDING, BUT NOT LIMITED TO, DAMAGES FOR LOSS OF PROFITS, BUSINESS INTERRUPTION, LOSS OF PROGRAMS OR INFORMATION, AND THE LIKE) ARISING OUT OF THE USE OF OR INABILITY TO USE THE SITE. WE DO NOT AUTHORIZE ANYONE TO MAKE ANY WARRANTY ON OUR BEHALF AND YOU SHOULD NOT RELY ON ANY SUCH STATEMENT. THIS PARAGRAPH SHALL SURVIVE TERMINATION OF THIS AGREEMENT. DISTRIBUTION OF INFORMATION We may share information with governmental agencies or other companies assisting us in fraud prevention or investigation. We may do so when: (1) permitted or required by law; or, (2) trying to protect against or prevent actual or potential fraud or unauthorized transactions; or, (3) investigating fraud which has already taken place. The information is not provided to these companies for marketing purposes. CUSTOMER SERVICE All complaints or remarks on errors on our part should be reported by using the email address provided during registration. As per File-hosting companies policy we are appoint only to resell premium accounts, any technical issue or any other issue related with the product has to be addressed by File-hosting companies customer care, we can only extend help in payment related issues which a customer makes to us. Do not hesitate to contact us for any questions. Thank you &amp; Best regards, Service clients BuyPremiumKey.Com. $$$$</p>\r\n');

/*Table structure for table `user_orders` */

DROP TABLE IF EXISTS `user_orders`;

CREATE TABLE `user_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(100) DEFAULT NULL,
  `users_id` int(11) NOT NULL DEFAULT '0',
  `users_roles_id` int(11) NOT NULL DEFAULT '0',
  `first_name` varchar(150) DEFAULT NULL,
  `last_name` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL,
  `payments_type_id` int(11) NOT NULL,
  `payment_charges` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `quantity_product` int(11) DEFAULT '0',
  `comment` varchar(500) DEFAULT NULL COMMENT 'comment của người dùng khi comfirm order',
  `payment_date` datetime DEFAULT NULL COMMENT 'ngày thanh toán',
  `payment_status` enum('pending','paid') DEFAULT 'pending' COMMENT '0: Chưa thanh toán\n 1: Đã thanh toán',
  `mail_status` int(11) DEFAULT '0' COMMENT '0: Chưa gửi request yêu cầu thanh toán cho hóa đơn\n1: Đã gửi',
  `created_at` datetime DEFAULT NULL COMMENT 'ngày tạo',
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`users_id`,`users_roles_id`,`payments_type_id`),
  KEY `fk_user_orders_users1_idx` (`users_id`,`users_roles_id`),
  KEY `fk_user_orders_payments_type1_idx` (`payments_type_id`),
  CONSTRAINT `fk_user_orders_payments_type1` FOREIGN KEY (`payments_type_id`) REFERENCES `payments_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_orders_users1` FOREIGN KEY (`users_id`, `users_roles_id`) REFERENCES `users` (`id`, `roles_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Data for the table `user_orders` */

insert  into `user_orders`(`id`,`order_no`,`users_id`,`users_roles_id`,`first_name`,`last_name`,`email`,`sub_total`,`payments_type_id`,`payment_charges`,`total_price`,`quantity_product`,`comment`,`payment_date`,`payment_status`,`mail_status`,`created_at`,`updated_at`) values (4,NULL,1,2,'Kenshin','Tien Minh','test@gmail.com','25.75',3,'1.05','26.80',1,NULL,NULL,'paid',0,'2017-04-30 10:16:46','2017-06-03 12:29:07'),(5,NULL,1,2,'Kenshin','Tien Minh','test@gmail.com','25.75',3,'1.05','26.80',1,NULL,NULL,'pending',0,'2017-04-30 10:16:46','2017-04-30 10:16:46'),(6,NULL,1,2,'Kenshin','Tien Minh','rapelover@gmail.com','13.00',3,'0.68','13.68',1,NULL,NULL,'paid',0,'2017-05-16 16:24:40','2017-06-03 09:30:02'),(7,NULL,1,2,'Kenshin','Tien Minh','minhtienuet@gmail.com','25.75',3,'1.05','26.80',2,NULL,NULL,'pending',0,'2017-05-22 04:46:31','2017-05-22 04:46:31'),(8,NULL,1,2,'Kenshin','Tien Minh','minhtienuet@gmail.com','20.34',4,'0.89','21.23',1,NULL,NULL,'paid',0,'2017-05-22 08:28:55','2017-06-03 09:17:43'),(9,NULL,4,2,'Minh','Tuan','minhtuan.humg@gmail.com','20.34',3,'0.89','21.23',1,NULL,NULL,'pending',0,'2017-06-02 13:13:08','2017-06-02 13:13:08'),(10,NULL,5,2,'RRR','RRR','rapelover.com@gmail.com','29.50',3,'1.16','30.66',1,NULL,NULL,'pending',0,'2017-06-02 13:24:09','2017-06-02 13:24:09'),(11,NULL,1,2,'Kenshin','Tien Minh','test@gmail.com','52.95',4,'1.84','54.79',2,NULL,NULL,'paid',0,'2017-06-02 13:37:15','2017-06-03 09:35:11'),(17,NULL,1,2,'Tien','Minh','minhtienuet@gmail.com','72.00',4,'2.39','74.39',2,NULL,NULL,'paid',0,'2017-06-02 17:31:54','2017-06-03 09:00:02'),(18,NULL,6,2,'Tien','Tong','rapeloving.com@gmail.com','29.50',3,'1.16','30.66',1,NULL,NULL,'paid',0,'2017-06-02 17:38:47','2017-06-04 13:17:38'),(19,'BPK-2017091',2,1,'Kenshin','Tien','kingkenshin69@gmail.com','591.65',3,'17.46','609.11',5,NULL,NULL,'pending',0,'2017-07-04 15:17:54','2017-07-04 15:17:54'),(22,'BPK-20170722',2,1,'Kenshin','Tien','kingkenshin69@gmail.com','201.20',3,'6.13','207.33',3,NULL,NULL,'pending',0,'2017-07-09 04:06:50','2017-07-09 04:06:50');

/*Table structure for table `user_orders_detail` */

DROP TABLE IF EXISTS `user_orders_detail`;

CREATE TABLE `user_orders_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_orders_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `users_roles_id` int(11) NOT NULL,
  `articles_type_id` int(11) NOT NULL,
  `title` varchar(300) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price_order` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`,`articles_type_id`,`user_orders_id`,`users_id`,`users_roles_id`),
  KEY `fk_user_orders_detail_user_orders1_idx` (`user_orders_id`,`users_id`,`users_roles_id`),
  KEY `fk_user_orders_articles_type1_idx` (`articles_type_id`),
  CONSTRAINT `fk_user_orders_articles_type1` FOREIGN KEY (`articles_type_id`) REFERENCES `articles_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_orders_detail_user_orders1` FOREIGN KEY (`user_orders_id`, `users_id`, `users_roles_id`) REFERENCES `user_orders` (`id`, `users_id`, `users_roles_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Data for the table `user_orders_detail` */

insert  into `user_orders_detail`(`id`,`user_orders_id`,`users_id`,`users_roles_id`,`articles_type_id`,`title`,`image`,`quantity`,`price_order`,`total_price`) values (1,4,1,2,2,'DepFile Premium 30 Days','http://localhost:8087/images/1479011160.png',1,'12.75','12.75'),(2,4,1,2,12,'BigFile Premium 30 Days','http://localhost:8087/images/1479054175.png',1,'13.00','13.00'),(3,6,1,2,12,'BigFile Premium 30 Days','http://localhost:8087/images/1479054175.png',1,'13.00','13.00'),(4,7,1,2,2,'DepFile Premium 30 Days','http://localhost:8087/images/1479011160.png',1,'12.75','12.75'),(5,7,1,2,12,'BigFile Premium 30 Days','http://localhost:8087/images/1479054175.png',1,'13.00','13.00'),(6,8,1,2,3,'DepFile Premium 60 Days','http://localhost:8087/images/1479011160.png',2,'20.34','40.68'),(7,9,4,2,3,'DepFile Premium 60 Days','http://localhost:8087/images/1479011160.png',1,'20.34','20.34'),(8,10,5,2,13,'BigFile Premium 90 Days','http://localhost:8087/images/1479054175.png',1,'29.50','29.50'),(9,11,1,2,12,'BigFile Premium 30 Days','http://localhost:8087/images/1479054175.png',1,'13.00','13.00'),(10,11,1,2,18,'Fileboom Premium 90 Days','http://localhost:8087/images/1480247179.png',1,'39.95','39.95'),(12,17,1,2,12,'BigFile Premium 30 Days','http://localhost:8087/images/1479054175.png',1,'13.00','13.00'),(13,17,1,2,13,'BigFile Premium 90 Days','http://localhost:8087/images/1479054175.png',2,'29.50','59.00'),(14,18,6,2,13,'BigFile Premium 90 Days','http://localhost:8087/images/1479054175.png',1,'29.50','29.50'),(15,19,2,1,13,'BigFile Premium 90 Days','http://localhost:8087/images/1497536645.png',4,'29.50','118.00'),(16,19,2,1,1,'DepFile Premium 90 Days','http://localhost:8087/images/1497539265.png',5,'38.90','194.50'),(17,19,2,1,3,'DepFile Premium 60 Days','http://localhost:8087/images/1497539265.png',4,'28.90','115.60'),(18,19,2,1,5,'Keep2share Premium 90 Days','http://localhost:8087/images/1497696369.png',3,'38.25','114.75'),(19,19,2,1,14,'BigFile Premium 180 Days','http://localhost:8087/images/1497536645.png',1,'48.80','48.80'),(20,22,2,1,1,'DepFile Premium 90 Days','http://localhost:8087/images/1497539265.png',2,'38.90','77.80'),(21,22,2,1,12,'BigFile Premium 30 Days','http://localhost:8087/images/1497536645.png',2,'12.90','25.80'),(22,22,2,1,14,'BigFile Premium 180 Days','http://localhost:8087/images/1497536645.png',2,'48.80','97.60');

/*Table structure for table `user_profiles` */

DROP TABLE IF EXISTS `user_profiles`;

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `users_roles_id` int(11) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `company` varchar(150) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `street_address_01` varchar(300) DEFAULT NULL,
  `street_address_02` varchar(300) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `zip_code` varchar(45) DEFAULT NULL,
  `state_province` varchar(100) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`users_id`,`users_roles_id`),
  KEY `fk_user_profiles_users1_idx` (`users_id`,`users_roles_id`),
  CONSTRAINT `fk_user_profiles_users1` FOREIGN KEY (`users_id`, `users_roles_id`) REFERENCES `users` (`id`, `roles_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `user_profiles` */

insert  into `user_profiles`(`id`,`users_id`,`users_roles_id`,`image`,`company`,`telephone`,`fax`,`street_address_01`,`street_address_02`,`city`,`zip_code`,`state_province`,`country`,`created_at`,`updated_at`) values (17,2,1,NULL,'GLUCK','01689935018','1689935018','Ha Noi Viet Nam','Ha Noi Viet Nam','Ha Noi','100000','15','VN','2017-04-13 17:17:18','2017-04-13 17:17:18'),(18,1,2,NULL,'GLUCK','01689935018','1689935018','Ha Noi Viet Nam','Ha Noi Viet Nam','Ha Noi','100000','63','VN','2017-04-30 03:30:57','2017-04-30 03:30:57'),(19,4,2,NULL,'','21243243','','Hà Nội','Hà Nội','Hà Noi','100000','13','VN','2017-05-07 03:22:11','2017-05-07 03:22:11'),(20,5,2,NULL,NULL,NULL,NULL,'Ha Noi Viet Nam, Ha Noi Viet Nam','Ha Noi Viet Nam, Ha Noi Viet Nam','Ha Noi','100000','13','VN','2017-06-02 13:24:09','2017-06-02 13:24:09'),(21,6,2,NULL,NULL,'13453251',NULL,'Ha Noi Viet Nam, Ha Noi Viet Nam','Ha Noi Viet Nam, Ha Noi Viet Nam','Ha Noi','100000','13','VN','2017-06-02 17:38:47','2017-06-02 17:38:47');

/*Table structure for table `user_review` */

DROP TABLE IF EXISTS `user_review`;

CREATE TABLE `user_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `articles_type_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `full_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('not-approval','approved') COLLATE utf8_unicode_ci DEFAULT 'not-approval',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_review` */

insert  into `user_review`(`id`,`articles_type_id`,`user_id`,`full_name`,`email`,`description`,`rate`,`created_at`,`updated_at`,`status`) values (1,3,1,'Kenshin Tien Minh','test@gmail.com','Tôi rất thích sản phẩm của bạn',2,'2017-05-18 11:12:39','2017-05-18 11:12:39','not-approval'),(2,3,1,'Tong Tien','minhtienuet@gmail.com','Tôi đã thanh toán nhưng chưa nhận được  key',5,'2017-05-18 11:17:07','2017-05-18 11:17:07','not-approval'),(3,67,0,'Tien Minh','minhtienuet@gmail.com','aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',5,'2017-06-21 14:42:33','2017-06-21 14:42:33','not-approval');

/*Table structure for table `user_shipping_address` */

DROP TABLE IF EXISTS `user_shipping_address`;

CREATE TABLE `user_shipping_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('default','add-new') COLLATE utf8_unicode_ci DEFAULT 'add-new',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_shipping_address` */

insert  into `user_shipping_address`(`id`,`user_id`,`email`,`status`,`created_at`,`updated_at`) values (1,4,'minhtuan.humg@gmail.com','default','2017-05-07 02:54:04','2017-05-07 02:54:04'),(2,4,'tongcongtien90@gmail.com','add-new','2017-05-16 22:50:08','2017-05-17 22:50:14'),(8,1,'minhtienuet@gmail.com','add-new','2017-05-21 17:38:21','2017-05-21 17:58:07'),(9,1,'tongcongtien@gmal.com','default','2017-05-21 17:53:13','2017-05-21 17:58:07'),(11,1,'test@gmail.com','add-new','2017-06-01 15:02:19','2017-06-01 15:02:19'),(12,5,'rapelover.com@gmail.com','default','2017-06-02 13:24:09','2017-06-02 13:24:09'),(13,6,'rapeloving.com@gmail.com','default','2017-06-02 17:38:47','2017-06-02 17:38:47');

/*Table structure for table `user_shopping_cart` */

DROP TABLE IF EXISTS `user_shopping_cart`;

CREATE TABLE `user_shopping_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `articles_type_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status_payment` enum('Checkout','NotCheckout') DEFAULT 'NotCheckout',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

/*Data for the table `user_shopping_cart` */

insert  into `user_shopping_cart`(`id`,`user_id`,`articles_type_id`,`quantity`,`created_at`,`updated_at`,`status_payment`) values (20,2,13,4,'2017-04-09 04:02:49','2017-07-09 04:06:51','Checkout'),(22,2,1,5,'2017-04-19 15:58:05','2017-07-09 04:06:51','Checkout'),(23,2,3,4,'2017-04-19 17:11:36','2017-07-09 04:06:51','Checkout'),(33,1,2,3,'2017-04-23 11:25:01','2017-06-02 17:31:55','Checkout'),(34,1,12,2,'2017-04-30 03:25:18','2017-06-02 17:31:55','Checkout'),(36,1,12,1,'2017-05-03 10:38:29','2017-06-02 17:31:55','Checkout'),(37,1,2,1,'2017-05-18 11:18:30','2017-06-02 17:31:55','Checkout'),(38,1,12,1,'2017-05-22 02:46:25','2017-06-02 17:31:55','Checkout'),(39,1,3,1,'2017-05-22 07:49:11','2017-06-02 17:31:55','Checkout'),(44,1,3,3,'2017-05-22 09:36:26','2017-06-02 17:31:55','Checkout'),(45,1,2,1,'2017-05-22 09:45:47','2017-06-02 17:31:55','Checkout'),(46,1,12,1,'2017-05-22 09:47:05','2017-06-02 17:31:55','Checkout'),(47,5,12,1,'2017-06-02 13:27:05','2017-06-02 13:27:05','NotCheckout'),(48,1,12,1,'2017-06-02 14:05:52','2017-06-02 17:31:55','Checkout'),(49,1,13,1,'2017-06-02 16:15:52','2017-06-02 17:31:55','Checkout'),(50,1,13,1,'2017-06-10 17:35:35','2017-06-10 17:35:35','NotCheckout'),(51,2,5,3,'2017-06-20 15:46:40','2017-07-09 04:06:51','Checkout'),(52,2,14,1,'2017-07-04 15:17:18','2017-07-09 04:06:51','Checkout'),(53,2,1,2,'2017-07-04 15:24:09','2017-07-09 04:06:51','Checkout'),(54,2,12,2,'2017-07-08 03:52:22','2017-07-09 04:06:51','Checkout'),(55,2,14,2,'2017-07-08 17:43:49','2017-07-09 04:06:51','Checkout');

/*Table structure for table `user_wish_list` */

DROP TABLE IF EXISTS `user_wish_list`;

CREATE TABLE `user_wish_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `articles_type_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `user_wish_list` */

insert  into `user_wish_list`(`id`,`user_id`,`articles_type_id`,`created_at`,`updated_at`) values (4,1,12,'2017-04-20 07:45:59','2017-04-20 07:45:59'),(5,1,13,'2017-04-20 07:55:18','2017-04-20 07:55:18'),(6,1,14,'2017-04-20 07:55:21','2017-04-20 07:55:21'),(7,1,5,'2017-06-10 17:28:34','2017-06-10 17:28:34'),(16,2,27,'2017-07-08 04:07:12','2017-07-08 04:07:12'),(17,2,28,'2017-07-08 04:07:16','2017-07-08 04:07:16');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `key_forgotten` varchar(100) DEFAULT NULL COMMENT 'mã được sinh ra khi người dùng yêu cầu lấy lại mật khẩu',
  `roles_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`roles_id`),
  KEY `fk_users_roles_idx` (`roles_id`),
  CONSTRAINT `fk_users_roles` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`first_name`,`last_name`,`email`,`password`,`key_forgotten`,`roles_id`,`created_at`,`updated_at`) values (1,'Kenshin','Tien Minh','test@gmail.com','$2y$10$m3biEd/T.sIIlRfn7pS34eQtKum8.7iyAXVmpl97qaslngwxhmiLu',NULL,2,'2017-03-11 18:25:51','2017-05-04 17:02:46'),(2,'Kenshin','Tien','kingkenshin69@gmail.com','$2y$10$VpQBUaetSsUgAYGsQXPbdO4HloPCjZN8MGBgg48vPtGQiRmdp/OHC','',1,'2017-03-11 18:27:59','2017-06-13 17:05:56'),(3,'Guest','Guest','guest@buykeypremium.com',NULL,NULL,2,'2017-04-23 19:00:34','2017-04-23 19:00:38'),(4,'Minh','Tuan','minhtuan.humg@gmail.com','$2y$10$4WBp4xlZlGXQSD7osBEQVuxlXO4F/y1/Luye3yDTPobIbE4H46E7q',NULL,2,'2017-05-07 02:54:04','2017-05-07 02:54:04'),(5,'RRR','RRR','rapelover.com@gmail.com','$2y$10$jyLPA//P/fzWx5JjN.VlIODAWJrTifuIdVdOuz9WGw2wm.VykxEPu',NULL,2,'2017-06-02 13:24:09','2017-06-02 13:24:09'),(6,'Tien','Tong','rapeloving.com@gmail.com','$2y$10$FYCdrGDfwZa86HhmQ8fGX./RskwaHKam1bqxluty3uYH8a7Ii54Uu',NULL,2,'2017-06-02 17:38:47','2017-06-02 17:38:47');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
