<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Global
|--------------------------------------------------------------------------
*/

$lang['activate']             = "Record has been activated successfully.";
$lang['deactivate']           = "Record has been de-activated successfully.";
$lang['deleted']              = "Record has been deleted successfully.";
$lang['successupdate']        = "Record has been updated successfully.";
$lang['order_updated']        = "The Selected Record(s) has been re-ordered.";
$lang['password_incorrect']   = "The Old Password is incorrect";
$lang['recordexits']          = "Record address already exists.";
$lang['success']              = "Record added successfully.";
$lang['paysuccess']           = "Payment added successfully.";
$lang['admin_logout_msg']     = "Logout successfully ..";
$lang['admin_mail_msg']       = "Mail sent Successfully...";
$lang['forgot_msg']           = "Email Id does not exist in database";
$lang['admin_reply_msg']      = "Enquiry reply sent Successfully...";
$lang['pic_uploaded']         = 'Photos has been uploaded successfully.';
$lang['pic_uploaded_err']	  = 'Please upload at least one photo.';
$lang['pic_delete']			  = 'Photo has been deleted successfully.';

$lang['child_to_deactivate']     =  "The selected record(s) has some sub-category/product.Please de-activate them first";
$lang['child_to_activate']       =  "The selected record(s) has some sub-category/product.Please activate them first";
$lang['child_to_delete']         =  "The selected record(s) has some sub-category/product.Please delete them first";

$lang['marked_paid']        = "The selected record(s) has been marked as Paid";
$lang['marked_unpaid']        = "The selected record(s) has been marked as unpaid and the stock has been reversed successfully.";
$lang['payment_succeeded']  = "The payment has been made successfully.";
$lang['payment_failed']     = "The payment has been canceled.";
$lang['email_sent']	     = "The Email has been sent successfully to the selected Users/Members.";

$lang['top_menu_list'][1] = array( "Dashboard"=>"sitepanel/dashbord/",
"Product Management"=>    array( "Manage Categories"=>"sitepanel/category/",
"Manage Products"=>"sitepanel/products/",
"Manage Bulk Upload"=>"sitepanel/products/bulk_uploading"
),

"Members Management"=>         array(
"Manage Buyer Members"=>"sitepanel/members",
"Manage Wholesaler Members"=>"sitepanel/members/index/1"
),

"Menu Management"     =>array(
"Manage About Us"		=>"sitepanel/about/",
"Manage Gym Packages"	=>"sitepanel/gym_packages/"
),

"Manage Orders"     =>array(
"Manage Buyer Orders"			=>"sitepanel/orders/",
"Manage Wholesaler Orders"		=>"sitepanel/orders/index/1"
),

"FAQs Management"     =>array(
							"Manage FAQ Category"=>"sitepanel/faq_category/",
							"Manage FAQs"=>"sitepanel/faq/",
							),

"Newsletter" =>array(
"Manage Newsletter"			=>"sitepanel/newsletter/",
"Bulk Upload Newsletter"	=>"sitepanel/newsletter/import_newsletter"
),
				                              

"Manage Entities" =>array( 
"Manage Warranty"=>"sitepanel/warranty",
"Manage Packing"=>"sitepanel/package",
"Manage Brand"=>"sitepanel/brand",

/*"Manage Materials"=>"sitepanel/material",
"Manage Colors"=>"sitepanel/color",
"Manage Sizes"=>"sitepanel/size",
"Manage Google Ads"=>"sitepanel/googleads"*/
),

//"News" =>array( "Manage News & Events"   =>"sitepanel/news/"),

 /*"Blogs Management"   =>array(
                       "Manage Blogs Category"     =>"sitepanel/blogs/category",
					   "Manage Blogs"			   =>"sitepanel/blogs/topics" ,
					   "Blogs Comments"	           =>"sitepanel/blogs/comments" ,  	                 
                      ),*/
                      
"Shipping"     =>array(
"Shipping Calendar"			=>"sitepanel/calendar/"
),								  
								  
"Other Management"  =>array(
"Manage Static Pages"=>"sitepanel/staticpages/",
"Manage Mail Contents"=>"sitepanel/mailcontents/",
"Manage Contact Inquiries"=>"sitepanel/enquiry/" ,
"Manage Feedback"=>"sitepanel/enquiry/feedback" ,
//"Manage Manage Shipping"=>"sitepanel/shipping/" ,
"Manage Country/State/cities"=>"sitepanel/country/" ,
//"Manage Product Enquiries"=>"sitepanel/product_enquiries/" ,
//"Manage Service Enquiries"=>"sitepanel/service_enquiries/" ,
//"Manage Banners"=>"sitepanel/banners/",
"Manage Header Images"=>"sitepanel/header_images/",
"Manage Testimonial"		    =>"sitepanel/testimonial/" ,
//"Manage Currency"=>"sitepanel/currency/",
//"Manage Discount Coupon"=>"sitepanel/coupons/",
"Manage  Meta Tags"=>"sitepanel/meta/"   ,
// "Manage Subadmins"=>"sitepanel/subadmin/" ,
"Manage Admin Settings"=>"sitepanel/setting/" ,
"Change Password"=>"sitepanel/setting/change" ,
/*"Manage Zip Location"			=>	"sitepanel/zip_location",
"Manage Bulk Upload Location"	=>	"sitepanel/zip_location/uploads_location",
"View Low Stock Products"=>"sitepanel/products/low_stock_products",*/
"Logout"=>"sitepanel/logout"
),);


$lang['top_menu_list'][2] = array( "Dashboard"=>"sitepanel/dashbord/",
/*
"Product Management"=>    array( "Manage Categories"=>"sitepanel/category/",
"Manage Products"=>"sitepanel/products/",
"Manage Bulk Upload"=>"sitepanel/products/bulk_uploading"
),

"Members Management"=>         array(
"Manage Buyer Members"=>"sitepanel/members",
"Manage Wholesaler Members"=>"sitepanel/members/index/1"
),

"Manage Orders"     =>array(
"Manage Buyer Orders"			=>"sitepanel/orders/",
"Manage Wholesaler Orders"			=>"sitepanel/orders/index/1"
),
*/
"Newsletter" =>array(
"Manage Newsletter"			=>"sitepanel/newsletter/",
"Bulk Upload Newsletter"	=>"sitepanel/newsletter/import_newsletter"
),
				                              
/*
"Manage Entities" =>array( 
"Manage Warranty"=>"sitepanel/warranty",
"Manage Packing"=>"sitepanel/package",
"Manage Brand"=>"sitepanel/brand",

"Manage Materials"=>"sitepanel/material",
"Manage Colors"=>"sitepanel/color",
"Manage Sizes"=>"sitepanel/size",
"Manage Google Ads"=>"sitepanel/googleads"
),*/

//"News" =>array( "Manage News & Events"   =>"sitepanel/news/"),

 /*"Blogs Management"   =>array(
                       "Manage Blogs Category"     =>"sitepanel/blogs/category",
					   "Manage Blogs"			   =>"sitepanel/blogs/topics" ,
					   "Blogs Comments"	           =>"sitepanel/blogs/comments" ,  	                 
                      ),*/
								  
"Shipping"     =>array(
"Shipping Calendar"			=>"sitepanel/calendar/"
),
                      
"Other Management"  =>array(
//"Manage Static Pages"=>"sitepanel/staticpages/",
//"Manage Mail Contents"=>"sitepanel/mailcontents/",
//"Manage Contact Inquiries"=>"sitepanel/enquiry/" ,
//"Manage Feedback"=>"sitepanel/enquiry/feedback" ,
//"Manage Manage Shipping"=>"sitepanel/shipping/" ,
//"Manage Country/State/cities"=>"sitepanel/country/" ,
//"Manage Product Enquiries"=>"sitepanel/product_enquiries/" ,
//"Manage Service Enquiries"=>"sitepanel/service_enquiries/" ,
//"Manage Banners"=>"sitepanel/banners/",
//"Manage Header Images"=>"sitepanel/header_images/",
//"Manage Testimonial"		    =>"sitepanel/testimonial/" ,
//"Manage FAQs"=>"sitepanel/faq/" ,
//"Manage Currency"=>"sitepanel/currency/",
//"Manage Discount Coupon"=>"sitepanel/coupons/",
//"Manage  Meta Tags"=>"sitepanel/meta/"   ,
// "Manage Subadmins"=>"sitepanel/subadmin/" ,
"Manage Admin Settings"=>"sitepanel/setting/" ,
"Change Password"=>"sitepanel/setting/change" ,
/*"Manage Zip Location"			=>	"sitepanel/zip_location",
"Manage Bulk Upload Location"	=>	"sitepanel/zip_location/uploads_location",
"View Low Stock Products"=>"sitepanel/products/low_stock_products",*/
"Logout"=>"sitepanel/logout"
),);


$lang['top_menu_list'][3] = array( "Dashboard"=>"sitepanel/dashbord/",
"Product Management"=>    array( 
//"Manage Categories"=>"sitepanel/category/",
"Manage Products"=>"sitepanel/products/",
"Manage Bulk Upload"=>"sitepanel/products/bulk_uploading"
),
/*
"Members Management"=>         array(
"Manage Buyer Members"=>"sitepanel/members",
"Manage Wholesaler Members"=>"sitepanel/members/index/1"
),

"Manage Orders"     =>array(
"Manage Buyer Orders"			=>"sitepanel/orders/",
"Manage Wholesaler Orders"			=>"sitepanel/orders/index/1"
),

"Newsletter" =>array(
"Manage Newsletter"			=>"sitepanel/newsletter/",
"Bulk Upload Newsletter"	=>"sitepanel/newsletter/import_newsletter"
),
				                              

"Manage Entities" =>array( 
"Manage Warranty"=>"sitepanel/warranty",
"Manage Packing"=>"sitepanel/package",
"Manage Brand"=>"sitepanel/brand",

/*"Manage Materials"=>"sitepanel/material",
"Manage Colors"=>"sitepanel/color",
"Manage Sizes"=>"sitepanel/size",
"Manage Google Ads"=>"sitepanel/googleads"*
),
*/
//"News" =>array( "Manage News & Events"   =>"sitepanel/news/"),

 /*"Blogs Management"   =>array(
                       "Manage Blogs Category"     =>"sitepanel/blogs/category",
					   "Manage Blogs"			   =>"sitepanel/blogs/topics" ,
					   "Blogs Comments"	           =>"sitepanel/blogs/comments" ,  	                 
                      ),*/
                      
"Other Management"  =>array(
//"Manage Static Pages"=>"sitepanel/staticpages/",
//"Manage Mail Contents"=>"sitepanel/mailcontents/",
//"Manage Contact Inquiries"=>"sitepanel/enquiry/" ,
//"Manage Feedback"=>"sitepanel/enquiry/feedback" ,
//"Manage Manage Shipping"=>"sitepanel/shipping/" ,
//"Manage Country/State/cities"=>"sitepanel/country/" ,
//"Manage Product Enquiries"=>"sitepanel/product_enquiries/" ,
//"Manage Service Enquiries"=>"sitepanel/service_enquiries/" ,
//"Manage Banners"=>"sitepanel/banners/",
//"Manage Header Images"=>"sitepanel/header_images/",
//"Manage Testimonial"		    =>"sitepanel/testimonial/" ,
//"Manage FAQs"=>"sitepanel/faq/" ,
//"Manage Currency"=>"sitepanel/currency/",
//"Manage Discount Coupon"=>"sitepanel/coupons/",
//"Manage  Meta Tags"=>"sitepanel/meta/"   ,
// "Manage Subadmins"=>"sitepanel/subadmin/" ,
"Manage Admin Settings"=>"sitepanel/setting/" ,
"Change Password"=>"sitepanel/setting/change" ,
/*"Manage Zip Location"			=>	"sitepanel/zip_location",
"Manage Bulk Upload Location"	=>	"sitepanel/zip_location/uploads_location",
"View Low Stock Products"=>"sitepanel/products/low_stock_products",*/
"Logout"=>"sitepanel/logout"
),);

$lang['top_menu_icon'] = array(
"Product Management"=>"maintenance.png",
"Members Management"=>"manage-sec.png",
"Orders Management"=>"order2.png",
"Newsletter"=>"news-lt-.png",
"News"=>"news-lt-.png",
"Other Management"=>"management.png",
);

/* Location: ./application/modules/sitepanel/language/admin_lang.php */