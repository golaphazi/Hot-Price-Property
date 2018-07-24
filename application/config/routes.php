<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] 	= 'WelcomeHpp';
$route['contact'] 		= 'WelcomeHpp/contactUs';
$route['blog'] 			= 'WelcomeHpp/property_news';
$route['faq'] 			= 'WelcomeHpp/faqPage';
$route['terms'] 		= 'WelcomeHpp/termsPage';
$route['service'] 		= 'WelcomeHpp/servicePage';
$route['help'] 			= 'WelcomeHpp/helpPage';
$route['advertise'] 	= 'WelcomeHpp/advertise';
$route['opt-out'] 		= 'WelcomeHpp/opt_out';
$route['sitemap'] 		= 'WelcomeHpp/sitemap';
$route['careers'] 		= 'WelcomeHpp/careers';
$route['about-us'] 		= 'WelcomeHpp/about_us';
$route['find-agent'] 	= 'WelcomeHpp/find_agentPage';


$route['buy'] 		= 'propertyController/PropertyControl/searchProperty/buy';
$route['rent'] 		= 'propertyController/PropertyControl/searchProperty/rent';
$route['auction']       = 'propertyController/PropertyControl/searchProperty/auction';
$route['hot_price']     = 'propertyController/PropertyControl/searchProperty/hot_price';
$route['sell'] 		= 'propertyController/PropertyControl/sell_property';
$route['post_rent'] 	= 'propertyController/PropertyControl/rent_property';
$route['preview']       = 'propertyController/PropertyControl/property_details';

$route['property-news'] = 'WelcomeHpp/property_news';
$route['news_preview']  = 'WelcomeHpp/property_news_details';

$route['login']             = 'loginController/LoginControll';
$route['forgot-password']   = 'loginController/LoginControll/forgot_password';
$route['logout'] 	= 'loginController/LoginControll/logoutIndex';
$route['logout-admin'] 	= 'loginController/LoginControll/adminIndex';

$route['dashboard']     = 'profileController/user/ProfileControll/dashboard';
$route['profile']       = 'profileController/user/ProfileControll/profileIndex';
$route['add_user']      = 'profileController/user/ProfileControll/addSubUser';

$route['manage-property'] 	= 'profileController/user/ProfileControll/manageProperty';
$route['payment-auction'] 	= 'profileController/user/AuctionPaymentControll/paymentIndex';
$route['payment-now'] 		= 'profileController/user/AuctionPaymentControll/paymentNowIndex';
$route['massage-board'] 	= 'profileController/user/ProfileControll/massage_board';
$route['email-inbox'] 		= 'profileController/user/ProfileControll/email_inbox';
$route['bidding-summery'] 	= 'profileController/user/ProfileControll/bidding_summery';
$route['offer-summery'] 	= 'profileController/user/ProfileControll/offer_summery';

/*--- Start reports url --*/
//For Buyer..
$route['purchase-report']           = 'reportController/user/ReportControll/purchaseReport';
$route['rent-property-list']        = 'reportController/user/ReportControll/rent_property_list';
$route['failed-auction-property-list']  = 'reportController/user/ReportControll/failed_auction_list';

$route['ledger-report']             = 'reportController/user/ReportControll/ledgerReport';

//For Seller..
$route['sold-out-property-list']    = 'reportController/user/ReportControll/sold_out_property_list';
$route['list-of-property']          = 'reportController/user/ReportControll/list_of_property';
$route['ongoing-property-list']     = 'reportController/user/ReportControll/ongoing_property_list';
$route['reject-property-list']      = 'reportController/user/ReportControll/reject_property_list';
$route['date-over-property-list']   = 'reportController/user/ReportControll/date_over_property_list';
/*-- End reports url --*/

$route['agent']             = 'profileController/user/AgentControll/agentIndex';


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
