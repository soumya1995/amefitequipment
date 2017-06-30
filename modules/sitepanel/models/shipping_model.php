<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Shipping_model extends MY_Model{

   public function __construct(){
   
     parent::__construct();
	 
   }
	

	public function get_shipping($offset=FALSE,$per_page=FALSE)
	{
	   
	    $keyword = $this->db->escape_str(trim($this->input->get_post('keyword',TRUE)));
	   
		$condtion = ($keyword!='')?"status !='2' AND shipping_type  like '%".$keyword."%' ":"status !='2'";
				
		$fetch_config = array(
							  'condition'=>$condtion,
							  'order'=>"shipping_id DESC",
							  'limit'=>$per_page,
							  'start'=>$offset,							 
							  'debug'=>FALSE,
							  'return_type'=>"array"							  
							  );		
		$result = $this->findAll('wl_shipping',$fetch_config);
		return $result;	
		
	
	}
	
	
	public function get_shipping_by_id($id)
	{
		
		$id = (int) $id;
	    
		if($id!='' && is_numeric($id))
		{
			
			$condtion = "status !='2' AND shipping_id=$id";
			
			$fetch_config = array(
							  'condition'=>$condtion,							 					 
							  'debug'=>FALSE,
							  'return_type'=>"object"							  
							  );
			
			$result = $this->find('wl_shipping',$fetch_config);
			return $result;		
		
		 }
		
	}
	
	
	
}