<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Global
|--------------------------------------------------------------------------
*/

$config['site_admin'] = "AME Fitness Equipment Administrator Area";
$config['site_admin_name'] = "AME Fitness Equipment";

$config['category.best.image.view'] = "( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 280X219)";

$config['product.best.image.view'] = "( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 600X600 )";

$config['brand.best.image.view'] = "( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 199X96 )";

$config['total_product_images'] = "4";
$config['pagesize'] = "20";

$config['adminPageOpt'] = array(
	$config['pagesize'],
	2*$config['pagesize'],
	3*$config['pagesize'],
	4*$config['pagesize'],
	5*$config['pagesize'],
	6*$config['pagesize'],
	7*$config['pagesize'],
	8*$config['pagesize'],
	9*$config['pagesize'],
	10*$config['pagesize'],
	20*$config['pagesize']
);

$config['bannersz'] =  array(
'Top'=>"980x173",
'Bottom'=>"909x169"
);

$config['bannersections'] = array(
'category'=>"Category",
'subcategory'=>"Subcategory",
'product'=>"Product",
'login'=>"Login",
'register'=>"Registration",
'myaccount'=>"My Account",
'search'=>'Search',
'cart'=>"Cart",
'checkout'=>"Checkout",
'static'=>'Static Pages',
'testimonials'=>'Testimonials',
'faq'=>'FAQ',
'sitemap'=>'Sitemap',
'video'=>'Video',
'wholesale inquiry'=>'Wholesale Inquiry'
);

$config['admin_groups'] =  array(
'2'=>"Half Admin Rights",
'3'=>"Low Admin Rights",
);



/* End of file account.php */
/* Location: ./application/modules/sitepanel/config/sitepanel.php */