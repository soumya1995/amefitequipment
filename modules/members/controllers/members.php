<?php
class Members extends Private_Controller
{

	private $mId;

	public function __construct()
	{
		parent::__construct();
		//if($this->userType==1)redirect('vendor');
		$this->load->model(array('order/order_model','members/members_model', 'pages/pages_model'));
    $this->load->helper(array('cart/cart'));
    $this->load->library(array('safe_encrypt', 'Dmailer'));
	}

	public function index()
	{
		$this->myaccount();
	}

	public function myaccount()
	{
		
	    $config['per_page']		=   4;$this->config->item('per_page');
		$offset                 =   $this->uri->segment(3,0);
		$limit				    =	4;//$config['per_page'];
		$next				    = 	$offset+$limit;

		$user_id = $this->userId;
		
		$condtion = "AND customers_id = '$user_id' ";
		$res_array   = $this->order_model->get_orders($offset,$config['per_page'],$condtion);
		$config['total_rows']	        = $this->order_model->total_rec_found;
		
		$fav_res                      = $this->members_model->get_wislists(0,4);
		$data['fav_res']                 = 	$fav_res;
		
		$ship_data=$this->members_model->get_member_address_book($user_id,"Ship");
		$ship_data=$ship_data[0];
		
		$more_paging['start_tag']       ='<div class="mt15 black u b" style="text-align:center">';
		$more_paging['text']            ='View More';
		$more_paging['end_tag']         ='</div>';
		$more_paging['more_container']  = 'more_data';
		$data['more_link']           =    more_paging("members/myaccount/$next",$config['total_rows'],$limit,$next,$more_paging);

		$data['res']                 = 	$res_array;
		$data['offset'] = $offset;

		$data['unq_section'] = "Myaccount";
		$data['title'] = "My Account";
		$mres = $this->members_model->get_member_row( $this->session->userdata('user_id') );
		if( is_array($mres) && !empty($mres))
		{
			$mres = array(
			'customers_id'        =>$mres['customers_id'],
			'title'               => $mres['title'],
			'user_name'               => $mres['user_name'],
			'first_name'          => $mres['first_name'],
			'last_name'           => $mres['last_name'],
			'fax_number'          => $mres['fax_number'],
			'mobile_number'       => $mres['mobile_number'],
			'phone_number'        => $mres['phone_number'],
			'last_login_date'        => $mres['last_login_date']
			);			
		}
		$data['mres'] = $mres;
		$data['ship_data'] = $ship_data;
				
		$friendly_url = 'account-guide';
		$condition       = array('friendly_url'=>$friendly_url,'status'=>'1');
		$content         =  $this->pages_model->get_cms_page( $condition );
		$data['content']=$content;
		$this->load->view('view_member_myaccount',$data);
	}
	
	public function edit_account()
	{
		$data['unq_section'] = "Myaccount";
		$data['title'] = "My Account";

		$mres = $this->members_model->get_member_row( $this->userId);
		
		$ship_data=$this->members_model->get_member_address_book($this->userId,"Ship");
		$ship_data=$ship_data[0];
		
		if($this->input->post("action")=="edit_account"){
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha|xss_clean');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|alpha|xss_clean');
			$this->form_validation->set_rules('mobile_number', 'Mobile', 'trim|required|xss_clean');
			$this->form_validation->set_rules('phone_number', 'Phone', 'trim|xss_clean');
			
			$this->form_validation->set_rules('name', 'Name','trim|required|max_length[200]|xss_clean');
			$this->form_validation->set_rules('address', 'Address','trim|required|max_length[200]|xss_clean');
			$this->form_validation->set_rules('zipcode', 'Post Code','trim|max_length[20]|required|xss_clean');
			$this->form_validation->set_rules('country', 'Country','trim|required|max_length[80]|xss_clean');
			$this->form_validation->set_rules('state', 'State','trim|required|max_length[50]|xss_clean');
			$this->form_validation->set_rules('city', 'City','trim|required|max_length[50]|xss_clean');
			$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|min_length[9]|max_length[32]|xss_clean');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|max_length[32]|xss_clean');
			

			if ($this->form_validation->run() == TRUE){

				$posted_user_data = array(
						'first_name'     	=> $this->input->post('first_name'),
						'last_name'       => $this->input->post('last_name'),
						'mobile_number'   => $this->input->post('mobile_number'),
						'phone_number'   => $this->input->post('phone_number')/*,
						'address'         => $this->input->post('address'),
						'city'        		=> $this->input->post('city'),
						'state'        	=> $this->input->post('state'),
						'country'        	=> $this->input->post('country'),
						'zipcode'        	=> $this->input->post('zipcode')*/
				);

				$where       = "customers_id = '".$mres['customers_id']."'";

				$this->members_model->safe_update('wl_customers',$posted_user_data,$where,FALSE);
				
				$posted_shipping_data =  array(
				'name'        => $this->input->post('name',TRUE),
				'address'     => $this->input->post('address',TRUE),
				'zipcode'     => $this->input->post('zipcode',TRUE),
				'phone'       => $this->input->post('phone',TRUE),
				'mobile'       => $this->input->post('mobile',TRUE),
				'city'        => $this->input->post('city',TRUE),
				'state'       => $this->input->post('state',TRUE),
				'country'     => $this->input->post('country',TRUE),
				);
	
				if($this->userId > 0){	
					$where       = "customers_id = '".$mres['customers_id']."'";
					$where_ship  = "customer_id = '".$mres['customers_id']."' AND address_type ='Ship'  ";	
					$this->members_model->safe_update('wl_customers_address_book',$posted_shipping_data,$where_ship,FALSE);
				}

				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',$this->config->item('myaccount_update'));
				redirect('members/edit_account', '');
			}
		}
		$data['mres'] = $mres;
		$data['ship_data'] = $ship_data;
		$this->load->view('view_member_edit_account',$data);
	}

	public function change_password()
	{
		$mres = $this->members_model->get_member_row( $this->userId);
		
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|valid_password');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');

		if ($this->form_validation->run() == TRUE)
		{
			$password_old   =  $this->safe_encrypt->encode($this->input->post('old_password',TRUE));
			$mres           =  $this->members_model->get_member_row($this->userId," AND password='$password_old' ");

			if( is_array($mres) && !empty($mres) )
			{
				$password = $this->safe_encrypt->encode($this->input->post('new_password',TRUE));
				$data = array('password'=>$password);
				$where = "customers_id=".$this->userId." ";
				$this->members_model->safe_update('wl_customers',$data,$where,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',$this->config->item('myaccount_password_changed'));
			}else
			{
				$this->session->set_userdata(array('msg_type'=>'warning'));
				$this->session->set_flashdata('warning',$this->config->item('myaccount_password_not_match'));
			}
			redirect('members/change_password','');
		}
		
		$data['mres'] = $mres;
		$this->load->view('view_member_change_password',$data);
		
	}
	
	public function wishlist()
	{
		$this->load->model('products/product_model');
		$record_per_page         = (int) $this->input->post('per_page');
		$config['per_page']	  =  ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
		$page_segment            =  find_paging_segment();
		$offset                 =   (int) $this->uri->segment($page_segment,0);
		$limit				    =	$config['per_page'];
		$next				    = 	$offset+$limit;

		$res_array                      = $this->members_model->get_wislists($offset,$config['per_page']);
		$config['total_rows']	        = $this->members_model->total_rec_found;

		$base_url                =   "members/wishlist/pg/";

		$data['page_links']      = front_pagination("$base_url",$config['total_rows'],$config['per_page'],$page_segment);

		$data['per_page'] = $config['per_page'];

		$data['res']                 = 	$res_array;
		$data['title']               = "My Wish List";
		$data['unq_section']         = "Myaccount";
		$mres = $this->members_model->get_member_row( $this->session->userdata('user_id') );
		if( is_array($mres) && !empty($mres))
		{
			$mres_address = $this->members_model->get_member_address_book($mres['customers_id']);
			$mres_bill =	 @$mres_address[0];
			$mres_ship =	 @$mres_address[1];

			$mres = array(
			'customers_id'        =>$mres['customers_id'],
			'title'               => $mres['title'],
			'user_name'               => $mres['user_name'],
			'first_name'          => $mres['first_name'],
			'last_name'           => $mres['last_name'],
			'fax_number'          => $mres['fax_number'],
			'mobile_number'       => $mres['mobile_number'],
			'phone_number'        => $mres['phone_number'],
			'last_login_date'        => $mres['last_login_date'],
			'billing_name'        => $mres_bill['name'],
			'billing_address'     => $mres_bill['address'],
			'billing_phone'       => $mres_bill['phone'],
			'billing_zipcode'     => $mres_bill['zipcode'],
			'billing_country'     => $mres_bill['country'],
			'billing_state'       => $mres_bill['state'],
			'billing_city'        => $mres_bill['city'],
			'shipping_name'       => $mres_ship['name'],
			'shipping_address'    => $mres_ship['address'],
			'shipping_phone'      => $mres_ship['phone'],
			'shipping_zipcode'    => $mres_ship['zipcode'],
			'shipping_country'    => $mres_ship['country'],
			'shipping_state'      => $mres_ship['state'],
			'shipping_city'       => $mres_ship['city']
			);
		}
		$data['mres'] = $mres;
		$this->load->view('members/view_member_wishlists',$data);
	}
	
	public function remove_wislist($wishlists_id)
	{
		if( $wishlists_id!='' )
		{
			$where = array('wishlists_id'=>$wishlists_id,'customer_id'=>$this->userId);
			$this->members_model->safe_delete('wl_wishlists', $where,FALSE);
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',$this->config->item('wish_list_delete'));
			redirect('members/wishlist','');
		}
	}
	
	public function orders_history()
	{	
		$mres = $this->members_model->get_member_row( $this->userId);
		
		$record_per_page        = (int) $this->input->post('per_page');
		$parent_segment         = (int) $this->uri->segment(3);
		$page_segment           = find_paging_segment();
		$config['per_page']		= ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
		$offset                 =  (int) $this->uri->segment($page_segment,0);
		$parent_id              = ( $parent_segment > 0 ) ?  $parent_segment : '0';

		$data['unq_section'] = "Myaccount";

		//$base_url                =   "members/orders_history/pg/";
		$base_url               = ( $parent_segment > 0 ) ?  "members/orders_history/$parent_id/pg/" : "members/orders_history/pg/";
		
		$condtion = "AND customers_id = '$this->userId' ";
		$res_array   = $this->order_model->get_orders($offset,$config['per_page'],$condtion);

		$config['total_rows']	 =  $this->order_model->total_rec_found;				
		
		$data['page_links']      = front_pagination("$base_url",$config['total_rows'],$config['per_page'],$page_segment);
		
		$data['per_page'] = $config['per_page'];
		$data['res']                 = 	$res_array;
		$data['mres'] = $mres;	
		$this->load->view('view_member_orders',$data);

	}
	
	public function view_invoice()
	{
		
		$ordId              = (int) $this->uri->segment(3);
		$order_res          = $this->order_model->get_order_master( $ordId );
		$order_details_res  = $this->order_model->get_order_detail($order_res['order_id']);
		$site_details=get_db_single_row('tbl_admin','*',' and  admin_id =1');
		
		$data['order_id']  = $ordId;
		$data['site_details']  = $site_details;
		$data['orddetail']  = $order_details_res;
		$data['ordmaster']  = $order_res;
		
		$mres = $this->members_model->get_member_row( $this->session->userdata('user_id') );
		if( is_array($mres) && !empty($mres))
		{
			$mres_address = $this->members_model->get_member_address_book($mres['customers_id']);
			$mres_bill =	 @$mres_address[0];
			$mres_ship =	 @$mres_address[1];

			$mres = array(
			'customers_id'        =>$mres['customers_id'],
			'title'               => $mres['title'],
			'user_name'               => $mres['user_name'],
			'first_name'          => $mres['first_name'],
			'last_name'           => $mres['last_name'],
			'fax_number'          => $mres['fax_number'],
			'mobile_number'       => $mres['mobile_number'],
			'phone_number'        => $mres['phone_number'],
			'last_login_date'        => $mres['last_login_date'],
			'billing_name'        => $mres_bill['name'],
			'billing_address'     => $mres_bill['address'],
			'billing_phone'       => $mres_bill['phone'],
			'billing_zipcode'     => $mres_bill['zipcode'],
			'billing_country'     => $mres_bill['country'],
			'billing_state'       => $mres_bill['state'],
			'billing_city'        => $mres_bill['city'],
			'shipping_name'       => $mres_ship['name'],
			'shipping_address'    => $mres_ship['address'],
			'shipping_phone'      => $mres_ship['phone'],
			'shipping_zipcode'    => $mres_ship['zipcode'],
			'shipping_country'    => $mres_ship['country'],
			'shipping_state'      => $mres_ship['state'],
			'shipping_city'       => $mres_ship['city']
			);
		}
		$data['mres'] = $mres;
		
		$this->load->view('view_member_invoice',$data);
	}
	
	public function print_invoice()
	{		
		$ordId              = (int) $this->uri->segment(3);
		$order_res          = $this->order_model->get_order_master( $ordId );
		$order_details_res  = $this->order_model->get_order_detail($order_res['order_id']);
		$data['orddetail']  = $order_details_res;
		$data['ordmaster']  = $order_res;
		$this->load->view('view_invoice_print',$data);
	}
	
	public function newsletter_subscription()
	{		
		$mres = $this->members_model->get_member_row( $this->session->userdata('user_id') );
		$data['mres'] = $mres;
		$this->load->view('view_newsletter_subscription',$data);
	}
	
	public function newsletter()
	{
		$mres = $this->members_model->get_member_row( $this->session->userdata('user_id') );
		$data['mres'] = $mres;
		
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
			redirect('members/newsletter_subscription', '');
		}
		$this->load->view('view_newsletter_subscription',$data);
	}
	
	public function manage_products_enquiries() {
		
		$this->load->model("message/message_model");
		$mres = $this->members_model->get_member_row($this->session->userdata('user_id'));
		$condtion = array();
		$record_per_page = (int) $this->config->item('per_page');
		
		$page_segment = find_paging_segment();
		$config['per_page'] = ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
		
		$offset = $this->input->get_post('stOffSet');
		
		$base_url = "members/manage_products_enquiries/";
		
		
		$cond = "M.status = '1' AND is_admin_approved = '1' AND MD.sender_id ='".$this->userId."' AND M.message_type='0'";
		$keyword=trim($this->input->post('keyword'));
		
		if($keyword){
			$cond .=" AND (message LIKE '%".$this->db->escape_str($keyword)."%' OR product_name LIKE '%".$this->db->escape_str($keyword)."%' OR product_code LIKE '%".$this->db->escape_str($keyword)."%')";
		}
		
		$res_array              = $this->message_model->get_records($offset,12,$cond,$this->input->post("sort_by"));
		
		
		$config['total_rows'] = get_found_rows();
		$data['total_rows'] = $config['total_rows'];
		
		$data['page_links'] = front_pagination("$base_url", $config['total_rows'], $config['per_page'], $page_segment);
		$data['res'] = $res_array;
		$data['title']="Product Enquiries";
		$data['mres'] = $mres;
		
		if($this->input->is_ajax_request())
		{
			$this->load->view('members/ajax_load_products_enquiries', $data);
		}else{
			$this->load->view('members/view_product_enquiries', $data);
		}
   }

 	public function message_reply(){
 		$mid = (int) $this->uri->segment(3);
 		
 		
 		$this->load->model(array('message/message_model'));
 		
 		$data["message"]=$message=$this->message_model->get_record_by_id("id ='".$mid."'");
 		
 		if(!is_object($message) || empty($message))redirect('vendor/admin_messages');
 		
 		$cond="message_id ='".$message->id."' AND status='1' AND message_reply!='NULL'";
 		$data["res"]=$this->message_model->get_reply_message(FALSE,0,$cond);
 		$data['title'] = "Message Reply";
 		$this->load->view('members/view_reply_enquiry', $data);
 	}
 	
 	public function delete_reply(){
 		$msg_reply_id=$this->uri->segment(3);
 			
 		$msg_id=get_db_field_value('wl_message_details', 'message_id',array("id"=>$msg_reply_id));
 			
 		if($msg_reply_id>0)
 		{
 				$query=$this->db->query("UPDATE wl_message_details SET status='3' WHERE id='".$msg_reply_id."' AND (user_id = '".$this->userId."' OR sender_id = '".$this->userId."' )");

 			$this->session->set_userdata(array('msg_type'=>'success'));
 			$this->session->set_flashdata('success',"Your message reply has been successfuly deleted");
 			redirect('members/message_reply/'.$msg_id,'');
 		}
 	}

 	public function reply(){
 		$msg_id=$this->uri->segment(3);
 		$this->load->model("message/message_model");
 			
 		$message=$this->message_model->get_record_by_id("id ='".$msg_id."'");
 		if(!is_object($message) || empty($message)){
 			redirect_top("members/admin_messages");
 		}
 			
 		$this->form_validation->set_rules("message_reply","Message","trim|required|max_length[8500]|xss_clean");
 		if($this->form_validation->run()===TRUE){
 	
 	
 			$this->message_model->safe_insert($this->message_model->table_relate,array(
 					"message_id"=>$msg_id,
 					"user_id"=>0,
 					"sender_id"=>$this->userId,
 					"type"=>'INBOX',
 					"message_reply"=>$this->input->post('message_reply'),
 					"posted_date"=>$this->config->item("config.date.time"),
 					"message_status"=>"Unread"));
 			
 			$this->session->set_userdata(array('msg_type'=>'success'));
 			$this->session->set_flashdata('success',"Your reply has been sent successfully.");
 	
 			redirect_top('members/message_reply/'.$msg_id,'');
 	
 		}
 		$data["title"]="Reply";
 		$this->load->view("vendor/mreply",$data);
 			
 	}
 	
 	public function admin_messages(){
 		
		$this->load->model("message/message_model");
 		$mres = $this->members_model->get_member_row($this->session->userdata('user_id'));
 		$condtion = array();
 		$record_per_page = (int) $this->config->item('per_page');
 	
 		$page_segment = find_paging_segment();
 		$config['per_page'] = ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
 	
 		$offset = $this->input->get_post('stOffSet');
 	
 		$base_url = "members/admin_messages/";
 	
 	
 		$cond = "M.status = '1' AND is_admin_approved = '1' AND MD.user_id ='".$this->userId."' AND M.message_type='1'";
 		$keyword=trim($this->input->post('keyword'));
 	
 		if($keyword){
 			$cond .=" AND message LIKE '%".$this->db->escape_str($keyword)."%'";
 		}
 	
 		$res_array              = $this->message_model->get_records($offset,12,$cond,$this->input->post("sort_by"));
 	
 		$config['total_rows'] = get_found_rows();
 		$data['total_rows'] = $config['total_rows'];
 	
 		$data['page_links'] = front_pagination("$base_url", $config['total_rows'], $config['per_page'], $page_segment);
 		$data['res'] = $res_array;
 		$data['title']="Admin Messages";
 		$data['mres'] = $mres;
 	
 		if($this->input->is_ajax_request())
 		{
 			$this->load->view('members/ajax_load_products_enquiries', $data);
 		}else{
 			$this->load->view('members/view_product_enquiries', $data);
 		}
 	}

	public function del_enquiry(){
		$msg_id=$this->uri->segment(3);			
		$msg=get_db_single_row('wl_messages', 'id,message_type',array("id"=>$msg_id));

		$rm=@$msg["message_type"]=="1"?"admin_messages":"manage_products_enquiries";
			
		if(@$msg["id"]>0)
		{

			$query=$this->db->query("UPDATE wl_messages SET status='3' WHERE id='".$msg_id."'");
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',"Your message has been successfuly deleted");			
		}
		redirect('members/'.$rm,'');

	}
	
	public function member_address_list()
	{
		$data['unq_section'] = "Myaccount";
		$data['title'] = "My Account";		
		$address_id=$this->uri->segment(3);
	
		$mres = $this->members_model->get_member_row( $this->session->userdata('user_id') );
		//$adr_mres	=	$this->members_model->get_member_all_address_book( $this->session->userdata('user_id'),'Ship');
		
		$data['mres'] = $mres;
		//$data['amres'] = $adr_mres;
		////////////////////////////
		$record_per_page        = (int) $this->input->post('per_page');
		$parent_segment         = (int) $this->uri->segment(3);
		$page_segment           = find_paging_segment();
		$config['per_page']		= ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
		$offset                 =  (int) $this->uri->segment($page_segment,0);
		$parent_id              = ( $parent_segment > 0 ) ?  $parent_segment : '0';

		$data['unq_section'] = "Myaccount";

		//$base_url                =   "members/orders_history/pg/";
		$base_url               = ( $parent_segment > 0 ) ?  "members/member_address_list/$parent_id/pg/" : "members/member_address_list/pg/";
		
		$condtion = "customer_id = '$this->userId' AND name!='' AND address_type='Ship'";
		$res_array   = $this->members_model->get_addresses($offset,$config['per_page'],$condtion);

		$config['total_rows']	 =  $this->members_model->total_rec_found;				
		
		$data['page_links']      = front_pagination("$base_url",$config['total_rows'],$config['per_page'],$page_segment);
		
		$data['per_page'] = $config['per_page'];
		$data['amres']                 = 	$res_array;	
		/////////////////////////////
		if($this->input->get_post('del')=='delete') {
				$querystr = $this->db->query("delete from wl_customers_address_book  WHERE address_id='".$address_id."' AND customer_id='".$mres['customers_id']."'");		

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success','Address has been deleted');
		 	redirect('members/member_address_list','');
		}
		
		
		if($this->input->get_post('default')=='d') {
			$this->db->query("update wl_customers_address_book set default_status='N' WHERE customer_id='".$mres['customers_id']."'");
			$this->db->query("update wl_customers_address_book set default_status='Y' WHERE address_id='".$address_id."' AND customer_id='".$mres['customers_id']."'");

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success','Address has been Set as Default');
		 	redirect('members/member_address_list','');
		}		
		$this->load->view('view_member_address',$data);
	}
	
	
	 public function address_add() {
		
		$user_id=$this->session->userdata('user_id')>0?$this->session->userdata('user_id'):$this->session->userdata('guest');
				
		$mres = $this->members_model->get_member_row( $this->session->userdata('user_id') );
		$adr_mres	=	$this->members_model->get_member_address_book( $this->session->userdata('user_id'),'Ship' );
		
		$data['mres'] = $mres;
		$data['amres'] = $adr_mres;
		$this->form_validation->set_rules('shipping_name', 'Name','required|xss_clean|alpha');
		$this->form_validation->set_rules('shipping_address', 'Address','required|xss_clean');
		$this->form_validation->set_rules('shipping_phone', 'Phone','min_length[10]|xss_clean');
		$this->form_validation->set_rules('shipping_mobile', 'Mobile','required|min_length[10]|xss_clean');
		$this->form_validation->set_rules('shipping_zipcode', 'Zip Code','required|xss_clean');
		$this->form_validation->set_rules('shipping_country', 'Country','required|xss_clean');
		$this->form_validation->set_rules('shipping_state', 'State','required|xss_clean');
		$this->form_validation->set_rules('shipping_city', 'City','required|xss_clean');
		$this->form_validation->set_rules('default_address', 'Default Address','xss_clean');
		
		if ($this->form_validation->run() ===TRUE){
			
			$is_default='N';
			if($this->input->post('default_address')=='Y'){
				
				$where_bill  = "customer_id = '".$user_id."' AND address_type='Ship' ";	
				$this->members_model->safe_update('wl_customers_address_book',array('default_status'=> 'N'),$where_bill,FALSE);
				$is_default='Y';
			}
			
			$shipping_country=get_country_name($this->input->post('shipping_country'));
			$shipping_state=get_state_name($this->input->post('shipping_state'));
			$shipping_city=get_city_name($this->input->post('shipping_city'));
			
			$posted_shipping_data =  array(
			'customer_id'        => $user_id,
			'name'        => $this->input->post('shipping_name',TRUE),
			'address'     => $this->input->post('shipping_address',TRUE),		
			'mobile'       => $this->input->post('shipping_mobile',TRUE),
			'phone'       => $this->input->post('shipping_phone',TRUE),
			'city'        => $shipping_city,
			'state'       => $shipping_state,
			'country'       => $shipping_country,
			'zipcode'     => $this->input->post('shipping_zipcode',TRUE),
			'address_type'     => 'Ship',
			'default_status'     => $is_default
			);
						
			$this->members_model->safe_insert('wl_customers_address_book',$posted_shipping_data);
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success','Address has been added');
			
			redirect('members/member_address_list', '');	
			}	
		$data['title'] = 'Add New Address';
		$this->load->view('members/view_member_address_add',$data);	
		
	}
	 
	 public function address_edit() {
		
		$user_id=$this->session->userdata('user_id')>0?$this->session->userdata('user_id'):$this->session->userdata('guest');
		$address_id=$this->uri->segment(3);		
		$mres = $this->members_model->get_member_row( $this->session->userdata('user_id') );
		$adr_mres	=	$this->members_model->get_member_address( $this->session->userdata('user_id'),$address_id);
		
		$data['mres'] = $mres;
		$data['amres'] = $adr_mres;
		$this->form_validation->set_rules('shipping_name', 'Name','required|xss_clean|alpha');
		$this->form_validation->set_rules('shipping_address', 'Address','required|xss_clean');
		$this->form_validation->set_rules('shipping_phone', 'Phone','min_length[10]|xss_clean');
		$this->form_validation->set_rules('shipping_mobile', 'Mobile','required|min_length[10]|xss_clean');
		$this->form_validation->set_rules('shipping_zipcode', 'Zip Code','required|xss_clean');
		$this->form_validation->set_rules('shipping_country', 'Country','required|xss_clean');
		$this->form_validation->set_rules('shipping_state', 'State','required|xss_clean');
		$this->form_validation->set_rules('shipping_city', 'City','required|xss_clean');
		
		$default_address=$this->input->post('default_address')?$this->input->post('default_address'):'N';
		if ($this->form_validation->run() ===TRUE){
			
			if($default_address=='Y') {
				
				$querystr = $this->db->query("UPDATE wl_customers_address_book SET default_status='N'  WHERE customer_id='".$user_id."' AND address_type='Ship' ");
			}
			
			$shipping_country=get_country_name($this->input->post('shipping_country'));
			$shipping_state=get_state_name($this->input->post('shipping_state'));
			$shipping_city=get_city_name($this->input->post('shipping_city'));
			
			$posted_shipping_data =  array(
			'name'        => $this->input->post('shipping_name',TRUE),
			'address'     => $this->input->post('shipping_address',TRUE),
			'zipcode'     => $this->input->post('shipping_zipcode',TRUE),
			'mobile'       => $this->input->post('shipping_mobile',TRUE),
			'phone'       => $this->input->post('shipping_phone',TRUE),
			'country'       => $shipping_country,
			'city'        => $shipping_city,
			'state'       => $shipping_state,
			'default_status'       => $default_address
			);
			
			$where = "address_id=".$address_id." ";			
			
			$this->members_model->safe_update('wl_customers_address_book',$posted_shipping_data,$where,FALSE);
				
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success','Address has been updated');
			
			redirect('members/member_address_list', '');	
			}	
		$data['title'] = 'Update Address';
		
		$this->load->view('members/view_member_address_edit',$data);	
		
	}
	
	public function credit_points()
	{		
		$this->load->model("message/message_model");
		$user_id=$this->session->userdata('user_id')>0?$this->session->userdata('user_id'):$this->session->userdata('guest');
		
		$record_per_page         = (int) $this->input->post('per_page');
		$config['per_page']	  =  ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
		$page_segment            =  find_paging_segment();
		$offset                 =   (int) $this->uri->segment($page_segment,0);
		$limit				    =	$config['per_page'];
		$next				    = 	$offset+$limit;
		
		$condtion1=array();
		$condtion2=array();
		
		$condtion1['customer_id']=$user_id;
		$condtion1['type']='1';		
		$res_array1                      = $this->members_model->get_credit_points(100,0,$condtion1);
		$config['total_rows1']	        = $this->members_model->total_rec_found;
		$data['res1']                 = 	$res_array1;
		
		$condtion2['customer_id']=$user_id;
		$condtion2['type']='2';		
		$res_array2                      = $this->members_model->get_credit_points(100,0,$condtion2);
		$config['total_rows2']	        = $this->members_model->total_rec_found;
		$data['res2']                 = 	$res_array2;

		$base_url                =   "members/credit_points/pg/";

		$data['page_links']      = front_pagination("$base_url",$config['total_rows1'],$config['per_page'],$page_segment);

		$data['per_page'] = $config['per_page'];

		
		$data['title']               = "Credit Points";
		$data['unq_section']         = "Creditpoints";
		$mres = $this->members_model->get_member_row( $this->session->userdata('user_id') );
		if( is_array($mres) && !empty($mres))
		{
			$mres_address = $this->members_model->get_member_address_book($mres['customers_id']);
			$mres_bill =	 $mres_address[0];
			$mres_ship =	 $mres_address[1];

			$mres = array(
			'customers_id'        =>$mres['customers_id'],
			'title'               => $mres['title'],
			'first_name'          => $mres['first_name'],
			'last_name'           => $mres['last_name'],
			'fax_number'          => $mres['fax_number'],
			'mobile_number'       => $mres['mobile_number'],
			'phone_number'        => $mres['phone_number'],
			'last_login_date'        => $mres['last_login_date'],
			'billing_name'        => $mres_bill['name'],
			'billing_address'     => $mres_bill['address'],
			'billing_phone'       => $mres_bill['phone'],
			'billing_zipcode'     => $mres_bill['zipcode'],
			'billing_country'     => $mres_bill['country'],
			'billing_state'       => $mres_bill['state'],
			'billing_city'        => $mres_bill['city'],
			'shipping_name'       => $mres_ship['name'],
			'shipping_address'    => $mres_ship['address'],
			'shipping_phone'      => $mres_ship['phone'],
			'shipping_zipcode'    => $mres_ship['zipcode'],
			'shipping_country'    => $mres_ship['country'],
			'shipping_state'      => $mres_ship['state'],
			'shipping_city'       => $mres_ship['city']
			);
		}
		$data['mres'] = $mres;
		$this->load->view('members/view_member_credit_points',$data);
	}
 
	
}
/* End of file member.php */
/* Location: .application/modules/member/member.php */