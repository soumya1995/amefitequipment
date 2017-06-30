<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mailcontents_model extends MY_Model{

     public function __construct(){
	 
	    parent::__construct();
		
	 }
	 
	public function getmailcontents($offset=FALSE,$per_page=FALSE){
		
		$keyword = $this->db->escape_str($this->input->post('keyword'));
		
		$condtion = ($keyword!='') ? "status !='2' AND email_section LIKE '%".$keyword."%'" :
		"status !='2' ";
		
		$fetch_config = array(
							  'condition'=>$condtion,
							  'order'=>"email_section DESC",
							  'limit'=>$per_page,
							  'start'=>$offset,							 
							  'debug'=>FALSE,
							  'return_type'=>"array"							  
							  );		
		$result = $this->findAll('wl_auto_respond_mails',$fetch_config);
		return $result;	
	
	}
	
	public function getmailcontents_by_id($id){
		
		$id = (int) $id;
		
		if($id!='' && is_numeric($id))
		{
			
			$condtion = "id = $id";
			
			$fetch_config = array(
							  'condition'=>$condtion,							 					 
							  'debug'=>FALSE,
							  'return_type'=>"object"							  
							  );
			
			$result = $this->find('wl_auto_respond_mails',$fetch_config);
			return $result;	
			
			
		}		
	
	}
	
	
	
}
// model end here