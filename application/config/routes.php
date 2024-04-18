<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller'] = 'AdminController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ======== Admin ========= //
$route['paymentresponse/(:num)'] = 'AdminController/paymentresponse/$1';
$route['paymentresponsepolicy/(:num)/(:any)/(:num)'] = 'AdminController/paymentresponsepolicy/$1/$2/$3';
$route['details'] = 'DashboardController/admindetails';
$route['dashboard'] = 'DashboardController';
$route['update_company'] = 'DashboardController/update_company';
$route['logout'] = 'LoginController/logout';
$route['users/filter/(:any)'] = 'UsersController/index/$1';

$route['users/create'] = 'UsersController/createuser';
$route['users/add'] = 'UsersController/add';
$route['users/import'] = 'UsersController/import';
$route['users/update'] = 'UsersController/update';
// $route['user/profile'] = 'UsersController/profile';
// $route['user/adminprofile/(:num)'] = 'UsersController/adminprofile/$1';
$route['user/profile/(:num)/(:any)'] = 'UsersController/profile/$1/$2';
$route['user/disable/(:num)/(:any)/(:num)'] = 'UsersController/disable/$1/$2/$3';
$route['user/enable/(:num)/(:any)/(:num)'] = 'UsersController/enable/$1/$2/$3';
$route['users/resetpass/(:any)/(:any)'] = 'UsersController/resetpass/$1/$2';
$route['users/getprovince'] = 'UsersController/getprovince';
$route['users/getdistrict'] = 'UsersController/getdistrict';

$route['policies'] = 'FuneralController';
$route['policies/create'] = 'FuneralController/createpolicy';
$route['policies/add'] = 'FuneralController/add';
$route['policies/update'] = 'FuneralController/update';
$route['policies/details/(:num)'] = 'FuneralController/details/$1';
$route['policies/disable/(:num)'] = 'FuneralController/disable/$1';
$route['policies/enable/(:num)'] = 'FuneralController/enable/$1';
$route['policies/filedelete/(:num)/(:num)'] = 'FuneralController/filedelete/$1/$2';

$route['region'] = 'RegionController';
$route['region/geo_restrict/(:num)'] = 'RegionController/geo_restrict/$1';
$route['region/cities'] = 'RegionController/cities';
$route['region/add'] = 'RegionController/addregion';
$route['region/update'] = 'RegionController/updateregion';
$route['region/addcity'] = 'RegionController/addcity';
$route['region/getregiondetails'] = 'RegionController/getregiondetails';
$route['region/getcitydetails'] = 'RegionController/getcitydetails';
$route['region/updatecity'] = 'RegionController/updatecity';
$route['region/disableprovince/(:num)'] = 'RegionController/disableprovince/$1';
$route['region/enableprovince/(:num)'] = 'RegionController/enableprovince/$1';
$route['region/disablecity/(:num)'] = 'RegionController/disablecity/$1';
$route['region/enablecity/(:num)'] = 'RegionController/enablecity/$1';
$route['region/restrict_region'] = 'RegionController/restrict_region';

$route['categories'] = 'CategoryController';
$route['categories/add'] = 'CategoryController/add';
$route['categories/edit/(:num)'] = 'CategoryController/edit/$1';
$route['subcategories'] = 'CategoryController/subcategories';
$route['subcategories/add'] = 'CategoryController/addsubcategories';
$route['categories/update'] = 'CategoryController/update';
$route['subcategories/update'] = 'CategoryController/updatesubcategories';
$route['categories/getcategorydetails'] = 'CategoryController/getcategorydetails';
$route['categories/getsubcategorydetails'] = 'CategoryController/getsubcategorydetails';
$route['categories/disablecat/(:num)'] = 'CategoryController/disablecat/$1';
$route['categories/enablecat/(:num)'] = 'CategoryController/enablecat/$1';
$route['categories/deletecat/(:num)'] = 'CategoryController/deletecat/$1';
$route['subcategories/disablesubcat/(:num)'] = 'CategoryController/disablesubcat/$1';
$route['subcategories/enablesubcat/(:num)'] = 'CategoryController/enablesubcat/$1';

$route['donations'] = 'DonationController';
$route['donations/add'] = 'DonationController/add';
$route['donations/register'] = 'DonationController/register';
$route['donations/save'] = 'DonationController/save';

$route['transactions'] = 'TransactionController';
$route['transaction/add'] = 'TransactionController/add';
$route['transaction/register'] = 'TransactionController/register';
$route['transaction/save'] = 'TransactionController/save';

$route['noticecategories'] = 'NoticeController';
$route['noticecategories/add'] = 'NoticeController/add';
$route['noticecategories/edit/(:num)'] = 'NoticeController/edit/$1';
$route['noticecategories/update'] = 'NoticeController/update';
$route['noticecategories/getcategorydetails'] = 'NoticeController/getcategorydetails';
$route['noticecategories/disablecat/(:num)'] = 'NoticeController/disablecat/$1';
$route['noticecategories/deletecat/(:num)'] = 'NoticeController/deletecat/$1';
$route['noticecategories/enablecat/(:num)'] = 'NoticeController/enablecat/$1';

$route['branches'] = 'CategoryController/branchlist';
$route['branches/add'] = 'CategoryController/branchadd';
$route['branches/edit/(:num)'] = 'CategoryController/branchedit/$1';
$route['branches/update'] = 'CategoryController/branchupdate';
$route['branches/getbranchdetails'] = 'CategoryController/getbranchdetails';
$route['branches/disablebranch/(:num)'] = 'CategoryController/disablebranch/$1';
$route['branches/enablebranch/(:num)'] = 'CategoryController/enablebranch/$1';
$route['branches/deletebranch/(:num)'] = 'CategoryController/deletebranch/$1';

$route['cells'] = 'CategoryController/celllist';
$route['cells/add'] = 'CategoryController/celladd';
$route['cells/edit/(:num)'] = 'CategoryController/celledit/$1';
$route['cells/update'] = 'CategoryController/cellupdate';
$route['cells/getcelldetails'] = 'CategoryController/getcelldetails';
$route['cells/disablecell/(:num)'] = 'CategoryController/disablecell/$1';
$route['cells/enablecell/(:num)'] = 'CategoryController/enablecell/$1';
$route['cells/deletecell/(:num)'] = 'CategoryController/deletecell/$1';

$route['events'] = 'TopicController';
$route['events/add'] = 'TopicController/addtopic';
$route['events/edit/(:num)'] = 'TopicController/edit/$1';
$route['events/update'] = 'TopicController/update';
$route['events/getsubcat'] = 'TopicController/getsubcat';
$route['events/getsubcat2'] = 'TopicController/getsubcat2';
$route['events/save'] = 'TopicController/savetopic';
$route['events/getarticle'] = 'TopicController/getarticle';
$route['events/disable/(:num)'] = 'TopicController/disable/$1';
$route['events/enable/(:num)'] = 'TopicController/enable/$1';
$route['events/delete/(:num)'] = 'TopicController/delete/$1';

$route['notices'] = 'NoticeController/noticelist';
$route['notices/add'] = 'NoticeController/addnotice';
$route['notices/edit/(:num)'] = 'NoticeController/editnotice/$1';
$route['notices/update'] = 'NoticeController/updatenotice';
$route['notices/save'] = 'NoticeController/savenotice';
$route['notices/getarticle'] = 'NoticeController/getnotice';
$route['notices/disable/(:num)'] = 'NoticeController/disablenotice/$1';
$route['notices/enable/(:num)'] = 'NoticeController/enablenotice/$1';
$route['notices/delete/(:num)'] = 'NoticeController/deletenotice/$1';


$route['notifications'] = 'NotificationController';
$route['notifications/add'] = 'NotificationController/addnotice';
$route['notifications/disable/(:num)'] = 'NotificationController/disable/$1';
$route['notifications/enable/(:num)'] = 'NotificationController/enable/$1';

$route['announcements'] = 'NotificationController/announcementlist';
$route['addannouncement'] = 'NotificationController/addannouncement';
$route['announcements/disable/(:num)'] = 'NotificationController/announcementdisable/$1';
$route['announcements/enable/(:num)'] = 'NotificationController/announcementenable/$1';
$route['announcements/delete/(:num)'] = 'NotificationController/announcementdelete/$1';

// $route['centres'] = 'CentreController';
// $route['centres/import'] = 'CentreController/import';
// $route['centres/importFile'] = 'CentreController/importFile';
// $route['centres/getcity'] = 'CentreController/getcity';
// $route['centres/getcity2'] = 'CentreController/getcity2';
// $route['centres/getcityname'] = 'CentreController/getcityname';
// $route['centres/showtiming'] = 'CentreController/showtiming';
// $route['centres/savecentre'] = 'CentreController/savecentre';
// $route['centres/add'] = 'CentreController/addcentre';
// $route['centres/details'] = 'CentreController/details';
// $route['centres/getprovincename'] = 'CentreController/getprovincename';
// $route['centres/edit/(:num)'] = 'CentreController/editcentre/$1';
// $route['centres/update'] = 'CentreController/updatecentre';
// $route['centres/disable/(:num)'] = 'CentreController/disable/$1';
// $route['centres/enable/(:num)'] = 'CentreController/enable/$1';
// $route['centre/restrict_columna'] = 'CentreController/restrict_columna';
// $route['centre/restrict_columnb'] = 'CentreController/restrict_columnb';

// $route['booking/(:any)'] = 'BookingController/index/$1';
// $route['reviews'] = 'ReviewController';
// $route['reviews/approve/(:num)'] = 'ReviewController/appropve/$1';
// $route['reviews/disapprove/(:num)'] = 'ReviewController/disappropve/$1';

// $route['languageswitcher/switchlang/(:any)'] = 'languageswitcher/switchlang/$1';

$route['verifyuser/(:any)/(:any)/(:any)'] = 'VerifyController/index/$1/$2/$3';
$route['resetuser/(:any)/(:any)'] = 'ResetController/index/$1/$2';

$route['testmail'] = 'MailTestController';

$route['periodcalendar'] = 'CalendarController';
$route['periodcalendar/details/(:num)'] = 'CalendarController/calendargenerate/$1';

// ======== APIs ========= //
$route['apilists'] = 'DashboardController/displayapis';
$route['apilistsnew'] = 'DashboardController/displayapisnew';
$route['apicalllogs'] = 'DashboardController/api_call_logs';
$route['dashboard/getapidata'] = 'DashboardController/getapidata';
$route['calendar'] = 'DashboardController/calendar';
$route['updatecalendarimage'] = 'DashboardController/updatecalendarimage';

// $route['api/v1/general/homepage/(:any)'] = 'admin/api/v1/General/homepage/(:any)';
// $route['api/v1/categories/(:any)'] = 'admin/api/v1/categories/(:any)';