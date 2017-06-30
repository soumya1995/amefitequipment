<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Header_images_model extends MY_Model{

	public function __construct()
	{
		parent::__construct();
	}


	
	
	public function get_header_images($offset=FALSE,$per_page=FALSE)
	{
		
		$keyword = $this->db->escape_str(trim($this->input->get_post('keyword',TRUE)));		
		$status = $this->db->escape_str($this->input->get_post('status',TRUE));
		$condtion = ($keyword!='') ? "status !='2' ":"status !='2'";

		if($status!='')
		{
			$condtion.= " AND status='$status' ";
		}
		
		$fetch_config = array(
		'condition'=>$condtion,
		'order'=>"id DESC",
		'limit'=>$per_page,
		'start'=>$offset,							 
		'debug'=>FALSE,
		'return_type'=>"array"							  
		);		
		$result = $this->findAll('wl_header_images',$fetch_config);
		return $result;	
		
	}




	
	public function get_header_images_by_id($id)
	{
		
		$id = applyFilter('NUMERIC_GT_ZERO',$id);
		
		if($id>0)
		{
			$condtion = "status !='2' AND id=$id";
			$fetch_config = array(
			'condition'=>$condtion,							 					 
			'debug'=>FALSE,
			'return_type'=>"object"							  
			);
			$result = $this->find('wl_header_images',$fetch_config);
			return $result;		
		}
		
	}	
	
	
}
// model end here