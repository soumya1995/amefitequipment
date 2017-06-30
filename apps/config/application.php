<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['meta_title'] = 'AME Fitness Equipment';
$config['meta_keyword']	= 'AME Fitness Equipment';
$config['meta_description']	= 'AME Fitness Equipment';

$config['bottom.debug'] = 0;
$config['site.status']	= '1';
$config['site_name']	= 'AME Fitness Equipment';

$config['auth.password_min_length']	= '6';
$config['auth.password_force_numbers']	= '1';
$config['auth.password_force_symbols']	= '1';
$config['auth.password_force_mixed_case']	= '0';

$config['allow.imgage.dimension']	= '3072x3072';
$config['allow.file.size']	        = '3072'; //In KB

$config['width_unit']	        = 'Inch.'; 
$config['height_unit']	        = 'Inch.'; 
$config['length_unit']	        = 'Inch.'; 
$config['weight_unit']	        = 'LBS.'; 

$config['allow_discount_option'] = 1;

$config['config.date.time']	= date('Y-m-d H:i:s');
$config['config.date']	    = date('Y-m-d');

$config['analytics_id']	    = '1';

$config['no_record_found'] = "No record(s) Found.";

$config['product_set_as_config'] = array(''=>"Product Set As",
'new_arrival'=>'New Arrival',
'hot_product'=>'Hot Product',
/*'offered_product'=>'Offer Product',*/
'featured_product'=>'Featured Product');

$config['product_unset_as_config']	= array(''=>"Product Unset As",
'new_arrival'=>'New Arrival',
'hot_product'=>'Hot Product',
/*'offered_product'=>'Offer Product',*/
'featured_product'=>'Featured Product');

$config['category_set_as_config'] = array(''=>"Category Set As",
'is_fetaured'=>'Featured',
'is_new'=>'New',
'is_hot'=>'Hot');

$config['category_unset_as_config']	= array(''=>"Category Unset As",
'is_fetaured'=>'Featured',
'is_new'=>'New',
'is_hot'=>'Hot');

$config['user_title'] =  array(""=>"Select","Mr."=>"Mr.","Ms."=>"Ms.","Miss."=>"Miss.","Mrs."=>"Mrs.","Dr"=>"Dr","Shri"=>"Shri","Smt"=>"Smt","Madam"=>"Madam");

$config['user_gender'] =  array("Male"=>"M","Female"=>"F");
$config['seller_type'] =  array("0"=>"Retailer","1"=>"Distributor","2"=>"Factory");

$config['service_type'] =  array("1"=>"Remanufactured","2"=>"Refurbished","3"=>"Cleaned & Serviced","4"=>"As Is");

$config['register_thanks']            = "Thanks for registering with <site_name>. We look forward to serving you. ";

$config['register_thanks_activate']   = "Thanks for registering with <site_name>. Please Check your mail account to activate you account on the <site_name>. ";

$config['enquiry_success']              = "Your enquiry has been submitted successfully. We will revert back to you soon.";
$config['feedback_success']             = "Your Feedback has been submitted successfully. We will revert back to you soon.";
$config['product_enquiry_success']      = "Your product enquiry  has been submitted successfully.We will revert back to you soon.";
$config['product_referred_success']     = "This product has been referred to your friend successfully.";
$config['site_referred_success']        = "Product has been referred to your friend successfully.";
$config['forgot_password_success']      = "Your password has been send to your email address. Please check your email account.";

$config['exists_user_id']              = "Email id  already exists. Please use different email id.";
$config['email_not_exist']             = "Email id does not exist.";

$config['login_failed']             = "Invalid Username/Password";

$config['newsletter_subscribed']           =  "You have been subscribed successfully for our newsletter service.";
$config['newsletter_already_subscribed']   =  "This Email address already exist.";
$config['newsletter_unsubscribed']         =  "You have been unsubscribed from our newsletter service.";
$config['newsletter_not_subscribe']        =  "You are not the subscribe member of our news letter service.";
$config['newsletter_already_unsubscribed']   =  "You have already un-subscribed the newsletter service.";

$config['testimonial_post_success']     = "Thank you for your testimonial to <site_name>. Your message will be posted after review by the <site_name> team.";

$config['advertisement_request']          = "Your advertisement request has been submitted successfully. We will revert back to you soon.";
$config['myaccount_update']               = "Your account information has been updated successfully.";
$config['myaccount_password_changed']     = "Password has been changed successfully.";
$config['myaccount_password_not_match']   = "Old Password does  not match. Please try again.";
$config['member_logout']                  = "Logout successfully.";

$config['wish_list_add']               = "Product has been added to your wishlist successfully.";
$config['wish_list_delete']            = "Product has been deleted from your wishlist.";
$config['wish_list_product_exists']    = "This product already exists in your wishlist.";

$config['cart_add']                  =  "Product has been added to your Shopping Basket.";
$config['cart_quantity_update']      =  "Product quantity has been updated successfully.";
$config['cart_product_exist']        =  "Product is already exist in your cart.";
$config['cart_delete_item']          =  "Product(s) has been deleted successfully.";
$config['cart_empty']                 =  "Basket has been cleared successfully.";
$config['cart_available_quantity']   =  "Maximum available quantity  is <quantity>. You can not add  more then available Quantity.";

$config['shipping_required']         =  "Shipping selection is required.";
$config['payment_success']           =  "Your Order has been placed successfully. A confirmation email and invoice have been sent to your email id";
$config['payment_failed']            =  "Your transaction is canceled.";

$config['arr_rating'] =  array(
'1'=>'1',
'2'=>'2',
'3'=>'3',
'4'=>'4',
'5'=>'5'
);	

$config['bannersz'] =  array(
'Left Panel'=>'286x448',
'Home Page'=>'286x428'
);	

$config['bannersections'] = array(
'common'=>"All Pages"
);
/* KEY PAIR OF SECTION AND POSTION */
$config['banner_section_positions'] = array(
'product'=>array('Left','Bottom')

);

$config['total_product_images'] = "4";
$config['product.best.image.view'] = "( File should be .jpg, .png, .gif format and file size should not be more then 3 MB (3072 KB)) ( Best image size 3984X3984 )";
