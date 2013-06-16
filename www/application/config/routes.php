<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "main";
/*
$route['idea/(:num)']        = "idea/index/$1";
$route['ideas/(.+)$']        = "main/index/$1";
$route['judge/(:num)']       = "judge/item/$1";
$route['judges/(.+)$']       = "judge/items/$1";
$route['judges$']            = "judge/index";
$route['partner/(:num)']       = "partner/item/$1";
$route['partners/(.+)$']       = "partner/items/$1";
$route['partners$']            = "partner/index";
$route['video/(:num)']         = "video/item/$1";
$route['videos/(.+)$']         = "video/items/$1";
$route['videos$']              = "video/index";
*/

$route['about'] = "pages/about";
$route['campaign'] = "pages/campaign";
$route['lookbook'] = "pages/lookbook";
$route['news'] = "pages/news";
$route['private-order'] = "pages/private_order";
$route['contacts'] = "pages/contacts";
$route['collections/(.+)$'] = "products/collections/$1";
$route['collections$'] = "products/collections";
$route['products/(.+)$'] = "products/index/$1";
$route['products$'] = "products/index";
$route['categories/(.+)$'] = "products/categories/$1";
$route['categories$'] = "products/categories";

$route['admin/products/add'] = "admin/addProduct";
$route['admin/products/edit/(.+)$'] = "admin/addProduct/$1";
$route['admin/categories/add'] = "admin/addCategory";
$route['admin/categories/edit/(.+)$'] = "admin/addCategory/$1";
$route['admin/details/add'] = "admin/addDetail";
$route['admin/details/edit/(.+)$'] = "admin/addDetail/$1";

//about
//compaign
//lookbook
//news
//private_order
//contacts


$route['^(en|ru|ua)/idea/(:num)$'] = "idea/index/$2";
$route['^(en|ru|ua)/ideas/(.+)$']  = "main/index/$2";
$route['^(en|ru|ua)/judge/(:num)'] = "judge/item/$2";
$route['^(en|ru|ua)/judges/(.+)$'] = "judge/items/$2";
$route['^(en|ru|ua)/judges$']      = "judge/index";
$route['^(en|ru|ua)/partner/(:num)'] = "partner/item/$2";
$route['^(en|ru|ua)/partners/(.+)$'] = "partner/items/$2";
$route['^(en|ru|ua)/partners$']      = "partner/index";
$route['^(en|ru|ua)/video/(:num)'] = "video/item/$2";
$route['^(en|ru|ua)/videos/(.+)$'] = "video/items/$2";
$route['^(en|ru|ua)/videos$']      = "video/index";
$route['^(en|ru|ua)/(.+)$']        = "$2";
$route['^(en|ru|ua)$'] = $route['default_controller'];

$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */