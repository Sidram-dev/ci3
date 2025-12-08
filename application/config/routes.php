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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['login'] = 'login';
$route['register'] = 'register';
$route['dashboard'] = 'dashboard';
$route['forgetpassward'] = 'forgetpassward';
$route['header'] = 'header';
$route['footer'] = 'footer';
$route['tabels'] = 'tabels/index';
$route['new_admin'] = 'new_admin';
$route['profile'] = 'profile';
$route['email_form'] = 'Email';
$route['reset_passward'] = 'reset_passward';
$route['dashboard_v1'] = 'dashboard_v1';
$route['api_user'] = 'Apiusers/index';
$route['api_user/(:num)'] = 'Apiusers/index/$1';
$route['add_products'] = 'ProductController/add_product';

$route['manage_product'] = 'ProductController/manage_product';
$route['edit_product/(:num)'] = 'ProductController/edit_product/$1';
$route['add_category'] = 'CategoryController/add_category';
$route['stores'] = 'CategoryController/stores';
$route['sub_categories'] = 'CategoryController/sub_categories';







