<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Subadmin_hooks {

	private $ci;
	public $trackAdmin;	
	
	public function __construct() 
	{
		$this->ci =& get_instance();
	}
	
	//--------------------------------------------------------------------
	
	
	/**
	  check privilege to login user
	 */
	public function check_privileges() 
	{
		if (!class_exists('CI_Session'))
		{
			$this->ci->load->library('session');
		}

		/* Works only if admin login && working environment is sitepanel */
		//$path_admin = FCPATH.'modules/'.$module.'/

		if(( $this->ci->session->userdata('admin_user')!='' ) && in_array('sitepanel',$this->ci->uri->segments))
		{
		  @$userType = $this->ci->admin_log_data['admin_type'];

		  $controller = $this->ci->router->fetch_class();
		  $method = $this->ci->router->fetch_method();

		  $prvg = TRUE;

		  switch($controller)
		  {
			  case 'members':
				if($userType==3)
				{
				  $prvg = FALSE;
				}
			  break;
			  case 'subadmin':
				if($userType!=1)
				{
				  $prvg = FALSE;
				}
			  break;
			  case 'orders':
				switch($method)
				{
					case 'make_paid':
					  if(!$this->ci->orderstatusPrvg)
					  {
						$prvg = FALSE;
					  }	
					break;
				}
			  break;
			  default:
				  switch($method)
				  {
					  case 'edit':
						if(!$this->ci->editPrvg)
						{
						  $prvg = FALSE;
						}	
					  break;
					  case 'delete':
						if(!$this->ci->deletePrvg)
						{
						  $prvg = FALSE;
						}	
					  break;
					  
				  }
			  break;

		  }

		  if($prvg)
		  {
			  /* Check for common activities */

			  if($this->ci->input->post('Delete')!='')
			  {
				  if(!$this->ci->deletePrvg)
				  {
					$prvg = FALSE;
				  }
			  }
			  elseif($this->ci->input->post('status_action')=='Activate')
			  {
				  if(!$this->ci->activatePrvg)
				  {
					$prvg = FALSE;
				  }
			  }
			  elseif($this->ci->input->post('status_action')=='Deactivate')
			  {
				  if(!$this->ci->deactivatePrvg)
				  {
					$prvg = FALSE;
				  }
			  }
			  elseif($this->ci->input->post('update_order')!='')
			  {
				  if(!$this->ci->orderPrvg)
				  {
					$prvg = FALSE;
				  }
			  }
		  }

		  if(!$prvg)
		  {
			$this->ci->session->set_userdata(array('msg_type'=>'error'));
			$this->ci->session->set_flashdata('error',"You do not have access to the page requested. Please contact super administrator");
			 $red_path = 'sitepanel/dashbord';//$this->ci->session->userdata('previous_page');
			 redirect($red_path, '');
		  }
	   }
	}
}

// End Subadmin_hooks class