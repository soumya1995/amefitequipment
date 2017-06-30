<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Auth
{
	public $ci;
	public function __construct()
	{
	   if (!isset($this->ci))
	   {
			$this->ci =& get_instance();
	   }		
	   $this->ci->load->library('safe_encrypt');
	   $this->ci->load->helper('cookie');
	   $this->auth_tbl = 'wl_customers';
	  
	}	
	
	public function is_user_logged_in()
	{
		$is_logged_in = $this->ci->session->userdata('logged_in');
		
		$logged_in_username = $this->ci->session->userdata('username');
		if ($is_logged_in == TRUE)
		{
			 $user_data = array(
			   'user_name'=>$logged_in_username,			  
			   'status <>'=>'2'	
			   );						 
			 $num = $this->ci->db->get_where($this->auth_tbl,$user_data)->num_rows();
			 return ($num) ? true : false;
			
		}
		else
		{
			return false;
		}
	}
	
	public function is_vendor_logged_in()
	{
		$is_logged_in = $this->ci->session->userdata('logged_in');
		
		$logged_in_username = $this->ci->session->userdata('username');
		if ($is_logged_in == TRUE)
		{
			 $user_data = array(
			   'user_name'=>$logged_in_username,			  
			   'customer_type ='=>'1',
			   'status <>'=>'2'	
			   );						 
			 $num = $this->ci->db->get_where($this->auth_tbl,$user_data)->num_rows();
			 return ($num) ? true : false;
			
		}
		else
		{
			return false;
		}
	}
	
	public function is_auth_user()
	{
		if ($this->is_user_logged_in()!= TRUE)
		{
			$this->logout();
			redirect('users/login', '');
			
		}
	}
	
    public function update_last_login($login_data)
	{		
		
		$data = array(
						'last_login_date'=>$login_data['current_login'],
						'current_login'=>$this->ci->config->item('config.date.time') 
					  );
		$this->ci->db->where('customers_id', $this->ci->session->userdata('user_id'));
		$this->ci->db->update($this->auth_tbl, $data);
	}
		
	
   public function verify_user($username,$password,$status='1',$type='0')
   {
        $password = $this->ci->safe_encrypt->encode($password);
					
		$this->ci->db->select("customers_id,user_name,
		first_name,last_name,title,login_type,customer_type,is_blocked,
		last_login_date,current_login,block_time,mobile_number,country",FALSE);
		
		$this->ci->db->where('user_name', $username);
		$this->ci->db->where('password', $password);
		//if($status==1)$this->ci->db->where("status = '".$status."'");
		
		//$this->ci->db->where("customer_type = '".$type."'");
			
		$this->ci->db->where('status','1');			
		$this->ci->db->where('is_verified','1');		
		$query = $this->ci->db->get($this->auth_tbl);		
		
		if ($query->num_rows() == 1)
		{			
			$row  = $query->row_array();
            $name = $row['first_name']." ".$row['last_name'];		
			$data = array(
							'user_id'=>$row['customers_id'],
							'name'=>ucwords($name),
							'login_type'=>$row['login_type'],
							'username'=>$row['user_name'],							
							'title'=>$row['title'],
							'first_name'=>$row['first_name'],
							'last_name'=>$row['last_name'],
							'mobile_number'=>$row['mobile_number'],
							'country'=>$row['country'],
							'is_blocked'=>$row['is_blocked'],
							'customer_type'=>$row['customer_type'],	
							'blocked_time'=>$row['block_time'],
							'logged_in' => TRUE
						);
						
			$login_data = array('current_login'=>$row['current_login']);			
			$this->ci->session->set_userdata($data);			
			$this->update_last_login($login_data);	
			return TRUE;
			
		}else{			
			  return FALSE;			
		}
		
	}
	
	
	/** 
	* Logout - logs a user out
	* @access public
	*/
	
	 public function logout()
	 {		
		 
				
			$userId = $this->ci->session->userdata('user_id');
				
			if($userId!='' && $userId > 0 )
			{
				if ($this->ci->db->table_exists('tbl_user_online'))
				{   

			      $this->ci->db->query("DELETE FROM tbl_user_online WHERE user_id =".$userId." ");
			   
				}
			}
			
			$data = array('user_id' => 0,
						  'type'=> 0,
						  'login_type'=>0,
						  'username' => 0,
						  'first_name'=>0,
						  'last_name'=>0,
						  'name'=>0,
						  'mkey'=>0,
						  'customer_type'=>0,
						  'is_blocked'=>0,
						  'blocked_time'=>0,						  
						  'logged_in' => FALSE
						);
			 $this->ci->session->unset_userdata($data);
			//$this->ci->session->sess_destroy();           
			
		 
	 }	 
	 
	 public function logged_member_type(){
	 	return $this->ci->session->userdata("customer_type")==1?"vendor":"members";
	 }
	  
 	
	
}