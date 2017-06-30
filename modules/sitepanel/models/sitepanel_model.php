<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sitepanel_model extends CI_Model{
	
  public function __construct(){
	  
		  parent::__construct();  
			
		
 }  
 public function check_admin_login($data){
	 
	
	 
	 $query = $this->db->get_where('tbl_admin',$data,1);	
	 
	
	 if ($query->num_rows() > 0) {
		 
		 $row = $query->row_array();
		 $sess_arr = array(
				           'admin_user' => $row['admin_username'],
				           'adm_key'    => $row['admin_key'],
				           'admin_type' => $row['admin_type'],
				           'admin_id' => $row['admin_id'],
				           'admin_logged_in' => TRUE
				           );
	 
	   $this->session->set_userdata($sess_arr);	  
	 
	 }else{	
	   $this->session->set_userdata(array('msg_type'=>'error'));		
	   $this->session->set_flashdata('error', 'Invalid username/password');
	   redirect('sitepanel');	
	
	 }
	 
 }
 

 

}
/* End of file mstudent.php */
/* Location: ./system/application/models/mstudent.php */