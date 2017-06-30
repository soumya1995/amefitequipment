<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/


$hook['post_controller'][] = array(
								'class'		=> 'App_hooks',
								'function'	=> 'prep_redirect',
								'filename'	=> 'App_hooks.php',
								'filepath'	=> 'hooks',
								'params'	=> ''
							);
							

// Maintenance Mode
$hook['post_controller_constructor'][] = array(
								'class'		=> 'App_hooks',
								'function'	=> 'check_site_status',
								'filename'	=> 'App_hooks.php',
								'filepath'	=> 'hooks',
								'params'	=> ''
							);

// Subadmin Access
$hook['post_controller_constructor'][] = array(
								'class'		=> 'Subadmin_hooks',
								'function'	=> 'check_privileges',
								'filename'	=> 'Subadmin_hooks.php',
								'filepath'	=> 'hooks',
								'params'	=> ''
							);
							
							

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */