<?php
class Pages extends Public_Controller
{

	public function __construct() {

		parent::__construct();
		$this->load->helper(array('file','category/category'));
		$this->load->library(array('Dmailer'));
		$this->load->model(array('pages/pages_model','members/members_model','brand/brand_model'));
		$this->form_validation->set_error_delimiters("<div class='red'>","</div>");

	}

	public function index()
	{
		$friendly_url = @($this->uri->rsegments[3]) ? $this->uri->rsegments[3]: $this->uri->segment(1);
		$condition       = array('friendly_url'=>$friendly_url,'status'=>'1');
		$content         =  $this->pages_model->get_cms_page( $condition );
		$data['content'] = $content;
		$this->load->view('pages/cms_page_view',$data);
	}

	public function contactus()
	{
		$this->form_validation->set_rules('first_name','First Name','trim|alpha|required|max_length[30]');
		$this->form_validation->set_rules('last_name','Last Name','trim|alpha|max_length[30]');
		$this->form_validation->set_rules('phone_number','Phone','trim|max_length[15]');
		$this->form_validation->set_rules('mobile_number','Mobile Number','trim|max_length[15]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[80]');
		$this->form_validation->set_rules('company_name','Company Name','trim');
		//$this->form_validation->set_rules('country','Country','trim');
		$this->form_validation->set_rules('message','Message','trim|required|max_length[8500]');
		$this->form_validation->set_rules('verification_code','Verification code','trim|required|valid_captcha_code');
		$data['page_error'] = "";

		if($this->form_validation->run()==TRUE)
		{

			$posted_data=array(
			'first_name'    => $this->input->post('first_name'),
			'last_name'     => $this->input->post('last_name'),
			'email'         => $this->input->post('email'),
			'phone_number'  => $this->input->post('phone_number'),
			'mobile_number'  => $this->input->post('mobile_number'),
			'company_name'  => '',
			'country'		=> '',
			'message'       => $this->input->post('message'),
			'receive_date'     =>$this->config->item('config.date.time')
			);

			$this->pages_model->safe_insert('wl_enquiry',$posted_data,FALSE);

			/* Send  mail to user */

			$content    =  get_content('wl_auto_respond_mails','5');
			$subject    =  str_replace('{site_name}',$this->config->item('site_name'),$content->email_subject);
			$body       =  $content->email_content;

			$verify_url = "<a href=".base_url().">Click here </a>";

			$name = ucwords($this->input->post('first_name')." ".$this->input->post('last_name'));

			$body			=	str_replace('{mem_name}',$name,$body);
			$body			=	str_replace('{email}',$this->input->post('email'),$body);
			$body			=	str_replace('{phone}',$this->input->post('phone_number'),$body);
			$body			=	str_replace('{mobile}',$this->input->post('mobile_number'),$body);
			$body			=	str_replace('{comments}',$this->input->post('message'),$body);
			$body			=	str_replace('{admin_email}',$this->admin_info->admin_email,$body);
			$body			=	str_replace('{site_name}',$this->config->item('site_name'),$body);
			$body			=	str_replace('{url}',base_url(),$body);
			$body			=	str_replace('{link}',$verify_url,$body);

			$mail_conf =  array(
			'subject'=>$subject,
			'to_email'=>$this->input->post('email'),
			'from_email'=>$this->admin_info->admin_email,
			'from_name'=> $this->config->item('site_name'),
			'body_part'=>$body
			);

			$this->dmailer->mail_notify($mail_conf);

			/* End send  mail to user */

			/* Send  mail to admin */

			$body       =  $content->email_content;

			$verify_url = "<a href=".base_url().">Click here </a>";

			$name = 'Admin';

			$body			=	str_replace('{mem_name}',$name,$body);
			$body			=	str_replace('{email}',$this->input->post('email'),$body);
			$body			=	str_replace('{phone}',$this->input->post('phone_number'),$body);
			$body			=	str_replace('{mobile}',$this->input->post('mobile_number'),$body);
			$body			=	str_replace('{comments}',$this->input->post('message'),$body);
			$body			=	str_replace('{admin_email}',$this->admin_info->admin_email,$body);
			$body			=	str_replace('{site_name}',$this->config->item('site_name'),$body);
			$body			=	str_replace('{url}',base_url(),$body);
			$body			=	str_replace('{link}',$verify_url,$body);

			$mail_conf =  array(
			'subject'=>$subject,
			'to_email'=>$this->admin_info->admin_email,
			'from_email'=>$this->admin_info->admin_email,
			'from_name'=> $this->config->item('site_name'),
			'body_part'=>$body
			);

			$this->dmailer->mail_notify($mail_conf);

			/* End send  mail to admin */

			$data['page_error'] = "";
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_userdata(array('msg_type_convs_request'=>'success_contect'));
			$this->session->set_flashdata('success', 'Your enquiry has been submitted successfully. We will get back to you soon.');
			redirect('pages/thanks', '');

		}else{
			$posted_data_str=$this->input->post('action');
			if(strlen($posted_data_str) && $posted_data_str=="Submit"){
				$data['page_error'] = "validation error";
			}
		}
		$friendly_url = $this->uri->segment(2)==''?$this->uri->segment(1):$this->uri->segment(2);
		$condition       = array('friendly_url'=>$friendly_url,'status'=>'1');
		$content         =  $this->pages_model->get_cms_page( $condition );
		$data['content'] = $content['page_description'];
		$data['title'] = "Contact Us";

		$this->load->view('pages/contactus',$data);

	}

	public function feedback()
	{

		$this->form_validation->set_rules('first_name','Name','trim|alpha|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[80]');
		$this->form_validation->set_rules('message','Message','trim|required|max_length[8500]');
		$this->form_validation->set_rules('verification_code','Verification code','trim|required|valid_captcha_code');

		if($this->form_validation->run()==TRUE)
		{

			$posted_data=array(
			'first_name'    => $this->input->post('first_name'),
			'last_name'     => '',
			'type'     => '2',
			'email'         => $this->input->post('email'),
			'phone_number'  => '',
			'mobile_number'  => '',
			'company_name'  => '',
			'country'		=> '',
			'message'       => $this->input->post('message'),
			'receive_date'     =>$this->config->item('config.date.time')
			);

			$this->pages_model->safe_insert('wl_enquiry',$posted_data,FALSE);

			// Send  mail to user

			$content    =  get_content('wl_auto_respond_mails','4');
			$subject    =  str_replace('{site_name}',$this->config->item('site_name'),$content->email_subject);
			$body       =  $content->email_content;

			$name = ucwords($this->input->post('first_name'));

			$body			=	str_replace('{mem_name}',$name,$body);
			$body			=	str_replace('{email}',$this->input->post('email'),$body);
			$body			=	str_replace('{phone}',$this->input->post('phone_number'),$body);
			$body			=	str_replace('{mobile}',$this->input->post('mobile_number'),$body);
			$body			=	str_replace('{address}',$this->input->post('address'),$body);
			$body			=	str_replace('{comments}',$this->input->post('message'),$body);
			$body			=	str_replace('{admin_email}',$this->admin_info->admin_email,$body);
			$body			=	str_replace('{site_name}',$this->config->item('site_name'),$body);

			$mail_conf =  array(
			'subject'=>$subject,
			'to_email'=>$this->input->post('email'),
			'from_email'=>$this->admin_info->admin_email,
			'from_name'=> $this->config->item('site_name'),
			'body_part'=>$body
			);

			$this->dmailer->mail_notify($mail_conf);

			// End send  mail to user

			// Send  mail to admin

			$body       =  $content->email_content;

			$name = 'Admin';

			$body			=	str_replace('{mem_name}',$name,$body);
			$body			=	str_replace('{email}',$this->input->post('email'),$body);
			$body			=	str_replace('{phone}',$this->input->post('phone_number'),$body);
			$body			=	str_replace('{mobile}',$this->input->post('mobile_number'),$body);
			$body			=	str_replace('{address}',$this->input->post('address'),$body);
			$body			=	str_replace('{comments}',$this->input->post('message'),$body);
			$body			=	str_replace('{admin_email}',$this->admin_info->admin_email,$body);
			$body			=	str_replace('{site_name}',$this->config->item('site_name'),$body);

			$mail_conf =  array(
			'subject'=>$subject,
			'to_email'=>$this->admin_info->admin_email,
			'from_email'=>$this->admin_info->admin_email,
			'from_name'=> $this->config->item('site_name'),
			'body_part'=>$body
			);

			$this->dmailer->mail_notify($mail_conf);

			// End send  mail to admin

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success', 'Your feedback has been submitted successfully.');
			redirect('pages/feedback', '');

		}

		$this->load->view('pages/feedback');

	}

	public function sitemap()
	{
		$data['title'] = "Sitemap";
		$this->load->view('sitemap',$data);
	}
	
	public function video_chat()
	{
		$data['title'] = "Live Video Chat";
		$this->load->view('video_chat',$data);
	}

	public function newsletter()
	{
		$data['default_email_text']= "Email Id";
		$this->form_validation->set_rules('subscriber_name','Name','trim|required|max_length[225]');
		$this->form_validation->set_rules('subscriber_email','Email','trim|required|valid_email|max_length[255]');
		$this->form_validation->set_rules('subscribe_me','Status','trim|required');
		//$this->form_validation->set_rules('verification_code','Verification Code','trim|required|valid_captcha_code');
		if($this->form_validation->run()==TRUE)
		{
			$res = $this->pages_model->add_newsletter_member();
			$this->session->set_userdata('msg_type',$res['error_type']);
			$this->session->set_flashdata($res['error_type'],$res['error_msg']);
			redirect('pages/newsletter', '');
		}
		$this->load->view('view_subscribe_newsletter',$data);
	}
	

	private function subscribe_newsletter($posted_data)
	{
		$query = $this->db->query("SELECT subscriber_email,status FROM  wl_newsletters WHERE subscriber_email='$posted_data[subscriber_email]'");
		$subscribe_me  = $posted_data['subscribe_me'];

		if( $query->num_rows() > 0 )
		{
			$row = $query->row_array();
			if( $row['status']=='0' && ($subscribe_me=='Y') )
			{
				$where = "subscriber_email = '".$row['subscriber_email']."'";
				$this->pages_model->safe_update('wl_newsletters',array('status'=>'1'),$where,FALSE);
				$msg =  $this->config->item('newsletter_subscribed');
				return $msg;
			}else if($row['status']=='0' && ($subscribe_me=='N'))
			{
				$msg =  $this->config->item('newsletter_not_subscribe');
				return $msg;
			}else if($row['status']=='1' && ($subscribe_me=='Y'))
			{
				$msg =  $this->config->item('newsletter_already_subscribed');
				return $msg;
			}else if($row['status']=='1' && ($subscribe_me=='N'))
			{
				$where = "subscriber_email = '".$row['subscriber_email']."'";
				$this->pages_model->safe_update('wl_newsletters',array('status'=>'0'),$where,FALSE);
				$msg =  $this->config->item('newsletter_unsubscribed');
			  return $msg;
		  }
	  }else
	  {
		  if($subscribe_me=='N' )
		  {
			  $msg =  $this->config->item('newsletter_not_subscribe');
			  return $msg;
		  }else
		  {
			  $data =  array('status'=>'1', 'subscriber_name'=>$posted_data['subscriber_name'], 'subscriber_email'=>$posted_data['subscriber_email']);
			  $this->pages_model->safe_insert('wl_newsletters',$data);
				$msg =  $this->config->item('newsletter_subscribed');
				return $msg;
			}
		}
	}

	public function join_newsletter()
	{
		$subscriber_name        = $this->input->post('subscriber_name',TRUE);
		$subscriber_email       = $this->input->post('subscriber_email',TRUE);
		$subscribe_me           = $this->input->post('subscribe_me',TRUE);
		$this->form_validation->set_error_delimiters("<p class='white fs12 b'>","</p>");
		$this->form_validation->set_rules('subscriber_name', 'Name', "trim|required|alpha|max_lenght[32]");
		$this->form_validation->set_rules('subscriber_email', 'Email ID', "trim|required|valid_email|max_lenght[80]");
		$this->form_validation->set_rules('verification_code','Verification code','trim|required|valid_captcha_code');
		if ($this->form_validation->run() == TRUE)
		{
			$posted_data = array( 'subscriber_name'=>$subscriber_name,'subscriber_email'=>$subscriber_email,'subscribe_me'=>$subscribe_me);
			$result      =  $this->subscribe_newsletter($posted_data);
			if( $result )
			{
				echo '<div style="color:#FFF; font-weight:bold;">'.$result.'</div>';
			}
		}else
		{
			header('Content-type: text/json');
			echo json_encode(array('error'=>validation_errors()));
			//echo '<div style="color:#FF0000"><font size="-1">'.validation_errors().'</font></div>';
		}
	}
	
	 public function join_newsletter_footer() {
        $subscriber_name = $this->input->post('subscriber_name', TRUE);
        $subscriber_email = $this->input->post('subscriber_email', TRUE);

        $subscribe_me = $this->input->post('subscribe_me', TRUE);

        $this->form_validation->set_rules('subscriber_name', 'Name', "trim|required|alpha|max_lenght[32]");

        $this->form_validation->set_rules('subscriber_email', 'Email ID', "trim|required|valid_email|max_lenght[80]");
        $this->form_validation->set_rules('verification_code_news', 'Verification code', 'trim|required|valid_captcha_code');

        if ($this->form_validation->run() == TRUE) {
            $posted_data = array('subscriber_name' => $subscriber_name,
                'subscriber_email' => $subscriber_email,
                'subscribe_me' => $subscribe_me
            );
            $result = $this->subscribe_newsletter_footer($posted_data);

            if ($result) {
				list($message, $class) = explode('-',$result);
                echo '<div class="'.$class.'">' . $message . '</div>';
				$this->load->view('pages/view_newsletter_footer');
            }
        } else {
            echo '<script>document.getElementById("verification_code_news").value="";</script>';
			$this->load->view('pages/view_newsletter_footer');
            //echo '<div style="color:#FF0000"><font size="-1">' . validation_errors() . '</font></div>';
        }


        // $this->load->view('newsletter_view');				 
    }
private function subscribe_newsletter_footer($posted_data) {

        $query = $this->db->query("SELECT subscriber_email,status FROM  wl_newsletters WHERE subscriber_email='$posted_data[subscriber_email]'");

        $subscribe_me = $posted_data['subscribe_me'];

        if ($query->num_rows() > 0 and $subscribe_me == 'Y') {
            $row = $query->row_array();

            if ($row['status'] == '0' && ($subscribe_me == 'Y')) {
                $where = "subscriber_email = '" . $row['subscriber_email'] . "'";
                $this->pages_model->safe_update('wl_newsletters', array('status' => '1'), $where, FALSE);
                $msg = $this->config->item('newsletter_subscribed');
                return $msg.'-success';
            } else if ($row['status'] == '0' && ($subscribe_me == 'N')) {
                $msg = $this->config->item('newsletter_not_subscribe');
                return $msg.'-error';
            } else if ($row['status'] == '1' && ($subscribe_me == 'Y')) {

                $msg = $this->config->item('newsletter_already_subscribed');
                return $msg.'-error';
            } else if ($row['status'] == '1' && ($subscribe_me == 'N')) {
                $where = "subscriber_email = '" . $row['subscriber_email'] . "'";
                $this->pages_model->safe_update('wl_newsletters', array('status' => '0'), $where, FALSE);
                echo "<script>$('#person_name').val('');$('#email').val('');$('#verification_code_news').val('')</script>";
                $msg = $this->config->item('newsletter_unsubscribed');
                return $msg.'-success';
            }
        } else {

            if ($subscribe_me == 'Y') {
                $data = array('status' => '1',
                    'subscriber_name' => $posted_data['subscriber_name'],
                    'subscriber_email' => $posted_data['subscriber_email']);
                $this->pages_model->safe_insert('wl_newsletters', $data);

                echo "<script>$('#person_name').val('');$('#email').val('');$('#verification_code_news').val('')</script>";

                $msg = $this->config->item('newsletter_subscribed');
                return $msg.'-success';
            } elseif ($query->num_rows() == 0) {

                $msg = "Record with this email does not exists";
                return $msg.'-error';
            } else {
                $row = $query->row_array();
                $where = "subscriber_email = '" . $row['subscriber_email'] . "'";
                $this->pages_model->safe_update('wl_newsletters', array('status' => '0'), $where, FALSE);
                echo "<script>$('#person_name').val('');$('#email').val('');$('#verification_code_news').val('')</script>";
				$msg = $this->config->item('newsletter_unsubscribed');
                return $msg.'-success';
            }
        }
    }
	public function refer_to_friends()
	{
		$productId        = (int) $this->uri->segment(3);
		$user_id=$this->session->userdata("user_id");
		$mres = $this->members_model->get_member_row( $user_id);
		
		$data['heading_title'] = "Refer to a Friend";
		$this->form_validation->set_rules('your_name','Name','trim|required|alpha|xss_clean|max_length[100]');
		$this->form_validation->set_rules('your_email','Email','trim|required|valid_email|xss_clean|max_length[100]');
		$this->form_validation->set_rules('friend_name','Friend\'s Name','trim|required|alpha|xss_clean|max_length[100]');
		$this->form_validation->set_rules('friend_email','Friend\'s Email','trim|required|valid_email|xss_clean|max_length[100]');

		$this->form_validation->set_rules('verification_code','Verification code','trim|required|valid_captcha_code');

		if($this->form_validation->run()==TRUE)
		{
			
			$your_name     = $this->input->post('your_name',TRUE);
			$your_email    =  $this->input->post('your_email',TRUE);
			$friend_name   = $this->input->post('friend_name',TRUE);
			$friend_email  = $this->input->post('friend_email',TRUE);

			$conditions   = "your_email ='$your_email' AND friend_email ='$friend_email' AND customers_id ='$user_id' ";
			$count_result = $this->pages_model->findCount('wl_invite_friends',$conditions);

			//if( !$count_result )
			//{
					$posted_data =  array(
					'customers_id'=>$user_id,
					'your_name'=>$your_name,
					'your_email'=>$your_email,
					'friend_name'=>$friend_name,
					'friend_email'=>$friend_email,
					'receive_date'=>$this->config->item('config.date.time')
					);
					$this->pages_model->safe_insert('wl_invite_friends',$posted_data);			
	
				$content    =  get_content('wl_auto_respond_mails','3');
				$body       =  $content->email_content;
	
				if($productId > 0 )
				{
					$product_link_url = get_db_field_value('wl_products','friendly_url'," AND products_id='$productId'");
					//$product_link_url =  base_url()."products/detail/$productId";
					$link_url = base_url().$product_link_url;
					$link_url= "<a href=".$link_url.">Click here </a>";
					$text ="Product";
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success',$this->config->item('product_referred_success'));
				}else
				{
					$link_url = base_url();
					$link_url= "<a href=".$link_url.">Click here </a>";
					$text ="Site";
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success',$this->config->item('site_referred_success'));
				}
	
				$body			=	str_replace('{friend_name}',$friend_name,$body);
				$body			=	str_replace('{your_name}',$your_name,$body);
				$body			=	str_replace('{site_name}',$this->config->item('site_name'),$body);
				$body			=	str_replace('{text}',$text,$body);
				$body			=	str_replace('{site_link}',$link_url,$body);
	
				$mail_conf =  array(
				'subject'=>"Invitation from ".$your_name." to see",
				'to_email'=>$friend_email,
				'from_email'=>$your_email,
				'from_name'=>$your_name,
				'body_part'=>$body
				);
				$this->dmailer->mail_notify($mail_conf);
				$data['mres']=$mres;
				
				redirect('pages/refer_to_friends', '');
				$this->load->view('pages/view_refer_to_friend',$data);	
			/*}else{
				
				$this->session->set_userdata('msg_type','error');
				$this->session->set_flashdata('error','Reffered email already exist!');
				redirect('pages/refer_to_friends', '');			
				
			}*/
		}
		$data['mres']=$mres;
		
		$this->load->view('pages/view_refer_to_friend',$data);

	}

	public function unsubscribe(){
		$subscribe_id=$this->uri->segment(3);

		$this->pages_model->safe_update('wl_newsletters',array('status'=>'0'),array("md5(subscriber_id)"=>$subscribe_id),FALSE);

		$msg =  $this->config->item('newsletter_unsubscribed');
		$this->session->set_userdata(array('msg_type'=>'success'));
		$this->session->set_flashdata('success',$msg);
		redirect("pages/thanks");
	}

	public function thanks(){
		$this->load->view('thanks')	;
	}

	public function advanced_search()
	{
		$param= array('status'=>'1');		
		$brand_res              = $this->brand_model->getbrands($param,0,100);		
		$data['total_brand']	= get_found_rows();
		$data['brand_res']       = $brand_res;
		
		$this->load->view('pages/advanced_search_view',$data);
	}

	public function _404(){
		//$this->load->view("404");
		$base_url=base_url();
		redirect($base_url);
	}
	
	public function advertisement()
	{
		$data['title']		= 'Advertise With Us';
		
		$this->form_validation->set_rules('first_name','Name','trim|alpha|required|max_length[30]');
		$this->form_validation->set_rules('company_name','Company Name','trim|max_length[100]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[80]');
		$this->form_validation->set_rules('mobile_number','Mobile Number','trim|required|max_length[16]');
		$this->form_validation->set_rules('phone_number','Phone Number','trim|max_length[20]');
		$this->form_validation->set_rules('banner_position','Banner Position',"required|max_length[200]");
		$this->form_validation->set_rules('banner_url','Banner URL',"trim|prep_url|max_length[255]");
		$this->form_validation->set_rules('image1','Image',"required|file_allowed_type[image]");
		$this->form_validation->set_rules('description','Description','trim|required|max_length[8500]');
		$this->form_validation->set_rules('verification_code','Word Verification','trim|required|valid_captcha_code');
			
		if($this->form_validation->run()===TRUE){
			
			$uploaded_file = "";	
			if( !empty($_FILES) && $_FILES['image1']['name']!='' ){
				$this->load->library('upload');	
				$uploaded_data =  $this->upload->my_upload('image1','banner');
				if( is_array($uploaded_data)  && !empty($uploaded_data) ){
					$uploaded_file = $uploaded_data['upload_data']['file_name'];
				}		
			}
			
			$posted_data=array(
					'first_name'    	=> $this->input->post('first_name'),
					'company_name'    	=> $this->input->post('company_name'),
					'type'     			=> '1',
					'email'         	=> $this->input->post('email'),
					'mobile_number' 			=> $this->input->post('mobile_number'),
					'phone_number' 			=> $this->input->post('phone_number'),
					'description'   	=> $this->input->post('description'),
					'banner_position'	=> $this->input->post('banner_position'),
					'banner_url'		=> $this->input->post('banner_url'),					
					'banner_added_date'	=> $this->config->item('config.date.time'),
					'status' => '0',
					'banner_image'		=> $uploaded_file
			);
				
			$this->pages_model->safe_insert('wl_banners',$posted_data,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success', 'Your advertisement enquiry has been added successfully.We will get back to you soon.');
			echo '<script>window.location.href="'.site_url('advertisement').'"</script>';
			exit;
		}
		$this->load->view('advertisement_view',$data);
	}

}

/* End of file pages.php */