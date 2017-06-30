<?php
class Sitepanel extends Public_Controller {
   
	public function __construct()
	{
		parent::__construct();  
		
		$this->load->model(array('sitepanel/sitepanel_model'));
		
	}
	
	public  function index()
	{
		
		if($this->session->userdata('admin_logged_in'))
		{
		  redirect('sitepanel/dashbord/', 'refresh');
		}
		else
		{
			
		  $data['title'] =  $this->config->item("site_name");
		  $this->load->view('dashboard/admin_login',$data);
		  
		}		
		
	}	
	
	public function logout()
	{
		$sess_arr = array(
				           'admin_user' =>0,
				           'adm_key' =>0,
				           'admin_type' =>0,
				           'admin_id' =>0,
						   'is_admin_switch'=>0,
				           'admin_logged_in' => FALSE
				           );				
	    $this->session->unset_userdata($sess_arr);	
		
		$this->session->set_flashdata('error', lang('admin_logout_msg'));
		$this->session->sess_destroy();
		redirect('sitepanel', 'refresh');
	}
	
	public function auth()
	{	
	  
		if ( $this->input->post('action') != "")
		{	
			$postdata = array(
											  'admin_username' => $this->input->post('username'),
												'admin_password' => $this->input->post('password'),
												'status'=>'1'
												);
			$this->form_validation->set_rules('username','Username','trim|required|xss_clean');
			$this->form_validation->set_rules('password','Password','trim|required|xss_clean');
			
			if ($this->form_validation->run() == TRUE)
			{				
				$this->sitepanel_model->check_admin_login( $postdata );
				if ( $this->session->userdata('adm_key')!="" )
				{
					redirect('sitepanel/dashbord', 'refresh');
				}			 
			}else
			{ 
				$this->index();
			}
		}else{
			
			redirect('sitepanel');
		}
	}
	
	public function forgotten_password()
	{	
		
		if ( $this->input->post('forgotme')!="")
		{
			$this->form_validation->set_rules('email', ' Email ID', 'required|valid_email');
			$this->form_validation->set_rules('verification_code','Verification code','trim|required|valid_captcha_code');	
			
			if ($this->form_validation->run() == TRUE)
			{
				$this->forgot_password_mail($this->input->post('email'));
			}			 
		}
		
		$data['heading_title'] = "Forgot Password";			
		$this->load->view('dashboard/view_forgot_password',$data);		
	}
	
	
	private function forgot_password_mail($email)
	{
		$this->load->library('email');
		$res_data =  $this->db->get_where('tbl_admin', array('admin_email' =>$email ))->row();
		
		if( is_object( $res_data ) )
		{ 
			/* Forgot  mail to user */			
			
			$mail_to      = $res_data->admin_email;
			$mail_subject = $this->config->item('site_name')." Forgot Password"; 
			$from_email   = $mail_to;
			$from_name    =  $this->config->item('site_name');
			$verify_url= "<a href=".base_url()."sitepanel/>Click here </a>";
			
			$body = " Dear Admin,<br />
			Your login details are as follows:<br />
			User name :  {username}<br />        
			Password:  {password}<br /> 
			Click here to login {link}<br />  <br />						   
			Thanks and Regards,<br />						   
			{site_name} Team  ";
			
			$body			=	str_replace('{username}',$res_data->admin_username,$body);
			$body			=	str_replace('{password}',$res_data->admin_password,$body);
			$body			=	str_replace('{site_name}',$this->config->item('site_name'),$body);
			$body			=	str_replace('{url}',base_url(),$body);
			$body           =	str_replace('{link}',$verify_url,$body);
					
			$this->email->from($from_email, $from_name);
			$this->email->to($mail_to);			
			$this->email->subject($mail_subject);				
			$this->email->message($body);
			$this->email->set_mailtype('html');
			$this->email->send();
			
			/* End Forgot mail to user */
			
			$this->session->set_flashdata('message',  lang('admin_mail_msg'));			
			redirect('sitepanel/forgotten_password', '');
			
			
		}else
		{
			$this->session->set_flashdata('message', lang('forgot_msg') );
			redirect('sitepanel/forgotten_password', '');
		}
	}
}
/* End of file sitepanel.php */