<?php
class Users extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('date','language','string','cookie','file'));
		$this->load->model(array('users/users_model','pages/pages_model','warranty/warranty_model'));
		$this->load->library(array('safe_encrypt','securimage_library','Auth','Dmailer','cart'));
		$this->form_validation->set_error_delimiters("<div class='red'>","</div>");

		$rf_session = $this->session->userdata('ref');
		if( $rf_session=='' && $this->input->get('ref')!="")
		{
			$this->session->set_userdata( array('ref'=>$this->input->get('ref') ) );
		}

	}

	public function index()
	{
		if ( $this->auth->is_user_logged_in() )
		{
			redirect($this->auth->logged_member_type(), '');
		}
		$data['heading_title'] = "Login";
		$data['unq_section'] = "Login";
		$this->load->view('users_login',$data);
	}

	public function forgotten_password()
	{
		if ( $this->input->post('forgotme')!="")
		{
			$email = $this->input->post('email',TRUE);
			$this->form_validation->set_rules('email', ' Email ID', 'required|valid_email');
			$this->form_validation->set_rules('verification_code','Verification code','trim|required|valid_captcha_code');
			
			if ($this->form_validation->run() == TRUE)
			{
				$condtion = array('field'=>"user_name,password,first_name,last_name",'condition'=>"user_name ='$email' AND status ='1' ");
				$res = $this->users_model->find('wl_customers',$condtion);
				if( is_array($res) && !empty($res))
				{
					$first_name  = $res['first_name'];
					$last_name   = $res['last_name'];
					$username    = $res['user_name'];
					$password    = $res['password'];
					$password = $this->safe_encrypt->decode($password);
					/* Send  mail to user */

					$content    =  get_content('wl_auto_respond_mails','2');
					$subject    =  $content->email_subject;
					$body       =  $content->email_content;

					$verify_url = "<a href=".base_url()."users/login>Click here </a>";

					$name = ucwords($first_name)." ".ucwords($last_name);

					$body			=	str_replace('{mem_name}',$name,$body);
					$body			=	str_replace('{username}',$username,$body);
					$body			=	str_replace('{password}',$password,$body);
					$body			=	str_replace('{admin_email}',$this->admin_info->admin_email,$body);
					$body			=	str_replace('{site_name}',$this->config->item('site_name'),$body);
					$body			=	str_replace('{url}',base_url(),$body);
					$body			=	str_replace('{link}',$verify_url,$body);

					$mail_conf =  array(
					'subject'=>$subject,
					'to_email'=>$username,
					'from_email'=>$this->admin_info->admin_email,
					'from_name'=> $this->config->item('site_name'),
					'body_part'=>$body
					);

					$this->dmailer->mail_notify($mail_conf);
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success',$this->config->item('forgot_password_success'));
					redirect('users/forgotten_password', '');

				}else
				{
					$this->session->set_userdata(array('msg_type'=>'error'));
					$this->session->set_flashdata('error',$this->config->item('email_not_exist'));
					redirect('users/forgotten_password', '');
				}
			}

		}
			
		$data['heading_title'] = "Forgot Password";
		$this->load->view('users_forgot_password',$data);
	}
	
	public function login()
	{
		if( $this->auth->is_user_logged_in() )
		{
			redirect(base_url()."members/myaccount");
		}
		
		if ( $this->input->post('action') )
		{
			$this->form_validation->set_rules('user_name', 'Email ID','required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required|');
			
			if ($this->form_validation->run() == TRUE)
			{
				$username  =  $this->input->post('user_name');
				$password  =  $this->input->post('password');
				$rember    =  ($this->input->post('remember')!="") ? TRUE : FALSE;
				
				if($this->input->post('remember')=="Y"){
					set_cookie('userName',$this->input->post('user_name'), time()+60*60*24*30 );
					set_cookie('pwd',$this->input->post('password'), time()+60*60*24*30 );
				}else{
					delete_cookie('userName');
					delete_cookie('pwd');
				}
				
				$this->auth->verify_user($username,$password,'',$customer_type);
				if( $this->auth->is_user_logged_in() )
				{					
					$ref = $this->session->userdata('ref');
					$this->session->unset_userdata(array('ref'=>0));
					if( $ref !="")
					{
						redirect($ref,'');
					}else{
						redirect('members/myaccount','');
					}
					
				}else{
					$this->session->set_userdata(array('msg_type'=>'error'));
					$this->session->set_flashdata('error',$this->config->item('login_failed'));
					redirect('users/login/', '');
				}
			}
		}
		$friendly_url = 'member_benefits';
		$condition       = array('friendly_url'=>$friendly_url,'status'=>'1');
		$content         =  $this->pages_model->get_cms_page( $condition );
		$data['content']=$content;
		
		$data['heading_title'] = "Login";
		$this->load->view('login',$data);
	}
	
		
	public function guest_login()
	{
		if( $this->auth->is_user_logged_in() )
		{
			redirect('cart/checkout','');
		}
		
		if ( $this->input->post('action') )
		{
			$this->form_validation->set_rules('user_name', 'Email ID','required|valid_email');
			$this->form_validation->set_rules('user_login', 'User Login', 'required|');
			if($this->input->post('user_login')=="member"){
				$this->form_validation->set_rules('password', 'Password', 'required|');
			}
			
			if ($this->form_validation->run() == TRUE)
			{
				$username  =  $this->input->post('user_name');

				
				if($this->input->post('user_login')=="guest"){					
					$status='3';
					$user=$this->users_model->create_guest_user();					
					$password=$user[2];							
					$this->session->set_userdata("guest",$user[0]);				
					redirect('cart/checkout','');
				}else{					
					$password=$this->input->post('password');	
					$status='1';
					$this->auth->verify_user($username,$password,$status);
				}
										
				$rember    =  ($this->input->post('remember')!="") ? TRUE : FALSE;
				
				if($this->input->post('remember')=="Y"){
					set_cookie('userName',$this->input->post('user_name'), time()+60*60*24*30 );
					set_cookie('pwd',$password, time()+60*60*24*30 );
				}else{
					delete_cookie('userName');
					delete_cookie('pwd');
				}
							
				if( $this->auth->is_user_logged_in() )
				{
					$ref = $this->session->userdata('ref');
					$this->session->unset_userdata(array('ref'=>0));
					if( $ref !="")
					{
						redirect($ref,'');
					}else{
						redirect('cart/checkout','');
					}
				}else{
					$this->session->set_userdata(array('msg_type'=>'error'));
					$this->session->set_flashdata('error',$this->config->item('login_failed'));
					redirect('users/guest_login', '');
				}
			}
		}
			$data['heading_title'] = "Login";
			$this->load->view('guest_login',$data);
	}
	
	public function logout()
	{
		$data2 = array(
		'shipping_id' =>0,
		'coupon_id'=>0,
		'discount_amount'=>0
		);
		$this->session->unset_userdata($data2);
		$this->session->unset_userdata(array("ref"=>'0'));
		$this->cart->destroy();
		$this->auth->logout();
		//$this->session->set_userdata(array('msg_type'=>'success'));
		//$this->session->set_flashdata('success',$this->config->item('member_logout'));
		redirect('users/login', '');
	}

	public function thanks()
	{
		$data['heading_title'] = "Thanks";
		$this->load->view('register_thanks',$data);
	}

	public function register()
	{
		if (!$this->auth->is_user_logged_in() )
		{ 			
			$this->form_validation->set_rules('customer_type', 'Register As','trim|required');		
			$this->form_validation->set_rules('user_name', 'Email ID','trim|required|valid_email|max_length[80]|callback_email_check');			
			$this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[20]|valid_password');
			$this->form_validation->set_rules('confirm_password', 'Confirm password', 'required|max_length[20]|matches[password]');
			//$this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[10]|xss_clean');
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha|max_length[32]|xss_clean');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|alpha|max_length[32]|xss_clean');
			$this->form_validation->set_rules('mobile_number', 'Mobile No.', 'trim|required|min_length[9]|max_length[32]|xss_clean');
			$this->form_validation->set_rules('phone_number', 'Phone', 'trim|max_length[32]|xss_clean');
			//$this->form_validation->set_rules('gender', 'Gender','trim|max_length[10]|xss_clean');
			/*$this->form_validation->set_rules('zipcode', 'Zip Code','trim|max_length[20]|required|numeric|xss_clean');
			$this->form_validation->set_rules('country', 'Country','trim|required|max_length[80]|xss_clean');
			$this->form_validation->set_rules('state', 'State','trim|required|min_length[3]|max_length[50]|xss_clean');
			$this->form_validation->set_rules('city', 'City','trim|required|min_length[3]|max_length[50]|xss_clean');*/
			$this->form_validation->set_rules('subscribe_newsletter', 'Subscribe Newsletter', 'trim|max_length[32]|xss_clean');
			$this->form_validation->set_rules('terms_conditions', 'Terms And conditions', 'trim|required|max_length[32]|xss_clean');

			$this->form_validation->set_rules('verification_code','Verification code','trim|required|valid_captcha_code');
			
			if ($this->form_validation->run() == TRUE)
			{
				$registerId  = $this->users_model->create_user();
				$first_name  = $this->input->post('first_name',TRUE);
				$last_name   = $this->input->post('last_name',TRUE);
				$username    = $this->input->post('user_name',TRUE);
				$password    = $this->input->post('password',TRUE);
				
				if($registerId !='')
				{
					
					$cname = ucwords($first_name.' '.$last_name);
					$this->session->set_userdata(array('cname'=>$cname));
					/* Send  mail to user */
					
					$content    =  get_content('wl_auto_respond_mails','1');
					$subject    =  str_replace('{site_name}',$this->config->item('site_name'),$content->email_subject);
					$body       =  $content->email_content;
					$verify_url = "<a href=".base_url()."users/verify/".$registerId.">Click here </a>";
					
					$name = ucwords($first_name)." ".ucwords($last_name);

					$body			=	str_replace('{mem_name}',$name,$body);
					$body			=	str_replace('{username}',$username,$body);
					$body			=	str_replace('{password}',$password,$body);
					$body			=	str_replace('{admin_email}',$this->admin_info->admin_email,$body);
					$body			=	str_replace('{site_name}',$this->config->item('site_name'),$body);
					$body			=	str_replace('{url}',base_url(),$body);
					$body			=	str_replace('{link}',$verify_url,$body);
					
					$mail_conf =  array(
					'subject'=>$subject,
					'to_email'=>$this->input->post('user_name'),
					'from_email'=>$this->admin_info->admin_email,
					'from_name'=> $this->config->item('site_name'),
					'body_part'=>$body
					);
	/*trace($mail_conf);
	exit;*/
	
					$this->dmailer->mail_notify($mail_conf);
					
					$content    =  get_content('wl_auto_respond_mails','6');			
					$subject    =  str_replace('{site_name}',$this->config->item('site_name'),$content->email_subject);
					$body       =  $content->email_content;
					$verify_url = "<a href=".base_url()."users/>Click here </a>";
					
					$name = ucwords($first_name)." ".ucwords($last_name);

					$body			=	str_replace('{name}',$name,$body);
					$body			=	str_replace('{username}',$username,$body);
					$body			=	str_replace('{password}',$password,$body);
					$body			=	str_replace('{admin_email}',$this->admin_info->admin_email,$body);
					$body			=	str_replace('{site_name}',$this->config->item('site_name'),$body);
					$body			=	str_replace('{url}',base_url(),$body);
											
					$mail_conf =  array(
					'subject'=>$subject,
					'to_email'=>$this->admin_info->admin_email,
					'from_email'=>$this->input->post('user_name'),
					'from_name'=> $this->config->item('site_name'),
					'body_part'=>$body
					);

					$this->dmailer->mail_notify($mail_conf);

					/* End send  mail to user */
									}
					
				$this->auth->verify_user($username,$password);
				$message = $this->config->item('register_thanks_activate');
				$message = str_replace('<site_name>',$this->config->item('site_name'),$message);
				
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',$message);				
					
				/*if( $this->cart->total_items() > 0 ){
					redirect('cart','');
				}else{
					redirect('members/myaccount','');
				}*/
				redirect('users/thanks','');
					
			}
			
			$friendly_url = 'benefits';
			$condition       = array('friendly_url'=>$friendly_url,'status'=>'1');
			$content         =  $this->pages_model->get_cms_page( $condition );
			$data['content']=$content;
			
			$data['heading_title'] = "Register";
			$data['unq_section'] = "Register";
			$this->load->view('register',$data);
				
		}else{
			redirect($this->auth->logged_member_type(), 'refresh');
		}
	}
	
	
	public function email_check()
	{
		$email = $this->input->post('user_name');
		if ($this->users_model->is_email_exits(array('user_name' => $email)))
		{
			$this->form_validation->set_message('email_check', $this->config->item('exists_user_id'));
			return FALSE;
		}else
		{
			return TRUE;
		}
	}

	public function valid_captcha_code($verification_code)
	{
		if ($this->securimage_library->check($verification_code) == true)
		{
			return TRUE;
		}else
		{
			$this->form_validation->set_message('valid_captcha_code', 'The Word verification code you have entered is invalid.');
			return FALSE;
		}
	}

	public function verify()
	{
		$customers_id = $this->users_model->activate_account($this->uri->segment(3) );
		$message = $this->config->item('register_thanks');
		$message = str_replace('<site_name>',$this->config->item('site_name'),$message);
				
		$this->session->set_userdata(array('msg_type'=>'success'));
		$this->session->set_flashdata('success',$message);				
		redirect('users/thanks','');		
	}	
	
}
/* End of file users.php */
/* Location: ./application/modules/users/controller/users.php */