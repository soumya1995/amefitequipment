<?php
$route['pages/refer_to_friends/(:num)']       = 'pages/refer_to_friends/$1';
$route['pages/newsletter_log/(:any)']               = 'pages/newsletter_log/$1';
$route['pages/unsubscribe/(:any)']                     = 'pages/unsubscribe/$1';
$route['pages/(newsletter|newsletter_ajx)']               = 'pages/$1';
$route['pages/thanks']                     = 'pages/thanks';
$route['pages/(:any)']                        = 'pages/index/$1';
$route['pages/contactus']                     = 'pages/contactus/$1';

$route['pages/join_newsletter']               = 'pages/join_newsletter/$1';
$route['sitemap']                       = 'pages/sitemap/$1';
$route['pages/faq']                           = 'pages/faq/$1';
$route['pages/refer_to_friends']              = 'pages/refer_to_friends';
$route['pages/track_order']					  = 'pages/track_order';
$route['(contactus)']         		  = 'pages/contactus/$1';
$route['(sitemap)']         		  = 'pages/sitemap/$1';
$route['(aboutus)']         		  = 'pages/index/$1';
$route['(trade_services)']         		  = 'pages/index/$1';
$route['(return_refund)']         		  = 'pages/index/$1';
$route['(advertise_with_us)']         		  = 'pages/index/$1';
$route['(return_refund)']         		  = 'pages/terms-conditions/$1';
$route['(terms-conditions)']         		  = 'pages/index/$1';
$route['(privacy-policy)'] = 'pages/index/$1';
$route['(shipping_policy)']='pages/index/$1';
$route['(payment_options)']='pages/index/$1';
$route['(buyers_guide)']='pages/index/$1';