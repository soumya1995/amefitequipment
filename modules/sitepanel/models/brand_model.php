<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Brand_model extends MY_Model{

   public function __construct(){
   
     parent::__construct();
	 
   }
	

	public function get_brand($offset=FALSE,$per_page=FALSE)
	{
	   
	    $keyword = $this->db->escape_str(trim($this->input->get_post('keyword',TRUE)));
	   
		$condtion = ($keyword!='')?"status !='2' AND brand_name  like '%".$keyword."%' ":"status !='2'";
				
		$fetch_config = array(
							  'condition'=>$condtion,
							  'order'=>"brand_id DESC",
							  'limit'=>$per_page,
							  'start'=>$offset,							 
							  'debug'=>FALSE,
							  'return_type'=>"array"							  
							  );		
		$result = $this->findAll('wl_brands',$fetch_config);
		return $result;	
		
	
	}
	
	
	public function get_brand_by_id($id)
	{
		
		$id = (int) $id;
	    
		if($id!='' && is_numeric($id))
		{
			
			$condtion = "status !='2' AND brand_id=$id";
			
			$fetch_config = array(
							  'condition'=>$condtion,							 					 
							  'debug'=>FALSE,
							  'return_type'=>"object"							  
							  );
			
			$result = $this->find('wl_brands',$fetch_config);
			return $result;		
		
		 }
		
	}
	
	
	
}