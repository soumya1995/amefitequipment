<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends MY_Model
{

	/**
	* Get account by id
	*
	* @access public
	* @param string $account_id
	* @return object account object
	*/
	public function create_user($is_vendor='0', $status='0', $is_verified='0')
	{

		$password = $this->safe_encrypt->encode($this->input->post('password',TRUE));
		$is_same_bill_ship =   $this->input->post('is_same',TRUE);

		$register_array = array
		(
		'user_name'        => $this->input->post('user_name',TRUE),
		'password'         => $password,
		'title'            => $this->input->post('title',TRUE),
		'first_name'       => $this->input->post('first_name',TRUE),
		'last_name'        => $this->input->post('last_name',TRUE),
		'mobile_number'    => $this->input->post('mobile_number',TRUE),
		'address'    => $this->input->post('address',TRUE),
		'city'    => $this->input->post('city',TRUE),
		'state'    => $this->input->post('state',TRUE),
		'country'    => $this->input->post('country',TRUE),
		'zipcode'    => $this->input->post('zipcode',TRUE),
		'phone_number'     => $this->input->post('phone_number',TRUE),		
		'company_name'     => $this->input->post('company_name',TRUE),		
		'actkey'           =>md5($this->input->post('user_name',TRUE)),
		'account_created_date'=>$this->config->item('config.date.time'),
		'current_login'    =>$this->config->item('config.date.time'),
		
		'customer_type'     => $this->input->post('customer_type',TRUE),
		'status'=>$status,
		'is_verified'=>$is_verified,
		'ip_address'  =>$this->input->ip_address()
		);
		
		$this->db->select("customers_id")->from("wl_customers")->where("user_name",$this->input->post('user_name',TRUE))->where("status","3");
		
		$mqry=$this->db->get();
		
		$updId ="";
		
		if($mqry->num_rows()>0){
			$mr=$mqry->row();
			$insId = $mr->customers_id; 			
			$updId =$insId;
			$this->safe_update('wl_customers',$register_array,"customers_id = '".$insId."'",FALSE);
			
		}else{
			$insId =  $this->safe_insert('wl_customers',$register_array,FALSE);
	 }

		$data = array
		(
		'subscriber_email' => $this->input->post('user_name',TRUE)
		);

		if($this->input->post('subscribe_newsletter',TRUE)=="yes"){
			$subscribed = $this->is_subscribed($data);

			if(!$subscribed){
				$subscriber_name=$this->input->post('first_name',TRUE)." ".$this->input->post('last_name',TRUE);
				$newsletter_array = array
				(
				'subscriber_email'        => $this->input->post('user_name',TRUE),
				'subscriber_name'         => $subscriber_name,
				'subscribe_date'=>$this->config->item('config.date.time'),
				'status'=>'1'
				);

				$this->safe_insert('wl_newsletters',$newsletter_array,FALSE);
			}
		}

	
		if( $insId > 0 )
		{
			$billing_array = array
			(
			'customer_id'  =>$insId,
			/*'name'        => $this->input->post('billing_name',TRUE),
			'address'     => $this->input->post('billing_address',TRUE),
			'zipcode'     => $this->input->post('billing_zipcode',TRUE),
			'phone'       => $this->input->post('billing_phone',TRUE),
			'city'        => $this->input->post('billing_city',TRUE),
			'state'       => $this->input->post('billing_state',TRUE),
			'country'     => $this->input->post('billing_country'),*/
			'reciv_date'  => $this->config->item('config.date.time'),
			'address_type' =>'Bill',
			'default_status'=>'Y'
			);
			
			$bill_Id = get_db_field_value("wl_customers_address_book",'address_id',array("customer_id"=>$insId,"default_status"=>"Y","address_type"=>"Bill"));		
			
			if($bill_Id ==""){
			
				$bill_Id =  $this->safe_insert('wl_customers_address_book',$billing_array,FALSE);
		  }else{			   
			   $this->safe_update('wl_customers_address_book',$billing_array,"address_id = '". $bill_Id."'",FALSE);
			}
		
			if( $bill_Id > 0)
			{
				if( $is_same_bill_ship =='Y')
				{
					$shipping_array = array
					(
					'customer_id'  =>$insId,
					/*'name'        => $this->input->post('billing_name',TRUE),
					'address'     => $this->input->post('billing_address',TRUE),
					'zipcode'     => $this->input->post('billing_zipcode',TRUE),
					'phone'       => $this->input->post('billing_phone',TRUE),
					'city'        => $this->input->post('billing_city',TRUE),
					'state'       => $this->input->post('billing_state',TRUE),
					'country'     => $this->input->post('billing_country'),*/
					'reciv_date'  => $this->config->item('config.date.time'),
					'address_type' =>'Ship',
					'default_status'=>'Y'
					);
				}else
				{
					$shipping_array =  array
					(
					'customer_id'  =>$insId,
					/*'name'        => $this->input->post('shipping_name',TRUE),
					'address'     => $this->input->post('shipping_address',TRUE),
					'zipcode'     => $this->input->post('shipping_zipcode',TRUE),
					'phone'       => $this->input->post('shipping_phone',TRUE),
					'city'        => $this->input->post('shipping_city',TRUE),
					'state'       => $this->input->post('shipping_state',TRUE),
					'country'     => $this->input->post('shipping_country'),*/
					'reciv_date'  => $this->config->item('config.date.time'),
					'address_type' =>'Ship',
					'default_status'=>'Y'
					);
				}
				
				if($updId ==""){
					$this->safe_insert('wl_customers_address_book',$shipping_array,FALSE);
			  }else{	
				  $this->safe_update('wl_customers_address_book',$shipping_array,"customer_id = '".$insId."' AND default_status='Y' AND address_type ='Ship'",FALSE);
			  }
			}
			return  $insId ;
		}
	}
	
	
	public function create_guest_user()
	{
			$username  =  $this->input->post('user_name');
			$password  =  $this->input->post('password');	
			
			$register_array = array(
					'user_name'        => $this->input->post('user_name',TRUE),
					'password'         => $password,	
					'actkey'           =>md5($this->input->post('user_name',TRUE)),
					'account_created_date'=>$this->config->item('config.date.time'),
					'current_login'    =>$this->config->item('config.date.time'),	
					'is_verified'=>'1',
					'ip_address'  =>$this->input->ip_address()
					);
			
			
		$this->db->select("customers_id,password")->from("wl_customers")->where("user_name",	$username)->where("status <>","2");
		
		$mqry=$this->db->get();
		
		$updId ="";
		
		if($mqry->num_rows()>0){
			$mr=$mqry->row();
			$insId = $mr->customers_id; 		
			$password= $this->safe_encrypt->decode($mr->password);
			
			$updId =$insId;
			//$this->safe_update('wl_customers',$register_array,"customers_id = '".$insId."'",FALSE);
			
		}else{
			$password="123456";
			$pass = $this->safe_encrypt->encode($password);
			$register_array["password"]=$pass;
			$register_array["status"]='3';		
			$register_array["first_name"]='Guest';
			$register_array["last_name"]='Member';
			
			$insId =  $this->safe_insert('wl_customers',$register_array,FALSE);
	 }

		
		if( $insId > 0 )
		{
			$billing_array = array
			(
			'customer_id'  =>$insId,
			/*'name'        => $this->input->post('billing_name',TRUE),
			'address'     => $this->input->post('billing_address',TRUE),
			'zipcode'     => $this->input->post('billing_zipcode',TRUE),
			'phone'       => $this->input->post('billing_phone',TRUE),
			'city'        => $this->input->post('billing_city',TRUE),
			'state'       => $this->input->post('billing_state',TRUE),
			'country'     => $this->input->post('billing_country'),*/
			'reciv_date'  => $this->config->item('config.date.time'),
			'address_type' =>'Bill',
			'default_status'=>'Y'
			);
			
			$bill_Id = get_db_field_value("wl_customers_address_book",'address_id',array("customer_id"=>$insId,"default_status"=>"Y","address_type"=>"Bill"));		
			
			if($bill_Id ==""){
			
				$bill_Id =  $this->safe_insert('wl_customers_address_book',$billing_array,FALSE);
		  }else{			   
			   $this->safe_update('wl_customers_address_book',$billing_array,"address_id = '". $bill_Id."'",FALSE);
			}
			
			 $is_same_bill_ship ="Y";
		
			if( $bill_Id > 0)
			{
				if( $is_same_bill_ship =='Y')
				{
					$shipping_array = array
					(
					'customer_id'  =>$insId,
					/*'name'        => $this->input->post('billing_name',TRUE),
					'address'     => $this->input->post('billing_address',TRUE),
					'zipcode'     => $this->input->post('billing_zipcode',TRUE),
					'phone'       => $this->input->post('billing_phone',TRUE),
					'city'        => $this->input->post('billing_city',TRUE),
					'state'       => $this->input->post('billing_state',TRUE),
					'country'     => $this->input->post('billing_country'),*/
					'reciv_date'  => $this->config->item('config.date.time'),
					'address_type' =>'Ship',
					'default_status'=>'Y'
					);
				}else
				{
					$shipping_array =  array
					(
					'customer_id'  =>$insId,
					/*'name'        => $this->input->post('shipping_name',TRUE),
					'address'     => $this->input->post('shipping_address',TRUE),
					'zipcode'     => $this->input->post('shipping_zipcode',TRUE),
					'phone'       => $this->input->post('shipping_phone',TRUE),
					'city'        => $this->input->post('shipping_city',TRUE),
					'state'       => $this->input->post('shipping_state',TRUE),
					'country'     => $this->input->post('shipping_country'),*/
					'reciv_date'  => $this->config->item('config.date.time'),
					'address_type' =>'Ship',
					'default_status'=>'Y'
					);
				}
				
			  if($updId ==""){
					$this->safe_insert('wl_customers_address_book',$shipping_array,FALSE);
			  }else{	
				  $this->safe_update('wl_customers_address_book',$shipping_array,"customer_id = '".$insId."' AND default_status='Y' AND address_type ='Ship'",FALSE);
			  }
			}			
		
			return  array($insId,$username,$password) ;
		}
	}
	
	public function is_email_exits($data)
	{			
		$this->db->select('customers_id');
		$this->db->from('wl_customers');
		$this->db->where($data);
		$this->db->where('status !=', '2')->where('status !=', '3');

		$query = $this->db->get(); 

		if ($query->num_rows() >= 1)
		{
			return TRUE;
		}else
		{
			return FALSE;
		}
	}

	public function is_subscribed($data)
	{
		$this->db->select('subscriber_id');
		$this->db->from('wl_newsletters');
		$this->db->where($data);
		$this->db->where('status !=', '2');

		$query = $this->db->get();
		if ($query->num_rows() == 1)
		{
			return TRUE;
		}else
		{
			return FALSE;
		}
	}

	public function logout()
	{
		$data = array(
		'user_id' => 0,
		'email' => 0,
		'name'=>0,
		'user_photo'=>0,
		'logged_in' => FALSE
		);
		$this->session->sess_destroy();
		$this->session->unset_userdata($data);
	}
	
	public function activate_account($customers_id)
	{		
		 $aarray =  array
					(
					'status'=>'1',
					'is_verified'=>'1',
					);
		 $this->safe_update('wl_customers',$aarray,"customers_id = '".$customers_id."' ",FALSE);
	}	

}
/* End of file users_model.php */
/* Location: ./application/modules/users/models/users_model.php */