<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Country_model extends MY_Model{

   public function __construct(){
   
     parent::__construct();
	 
   }
 
	
	// Get help center listing
	
	public function getCountry($offset=FALSE,$per_page=FALSE){
	   
	    $keyword			=   trim($this->input->get_post('keyword',TRUE));
		$keyword			=   $this->db->escape_str($keyword);
	   
		$condtion = ($keyword!='')?"status !='2' AND name like '%".$keyword."%' ":"status !='2'  ";
				
		$fetch_config = array(
							  'condition'=>$condtion,
							  'order'=>"(country_id='184') DESC, name ASC",
							  'limit'=>$per_page,
							  'start'=>$offset,							 
							  'debug'=>FALSE,
							  'return_type'=>"array"							  
							  );		
		$result = $this->findAll('wl_countries',$fetch_config);
		return $result;	
		
	
	}
	
	public function change_status()
	{
		$arr_ids = $this->input->post('arr_ids');	   
		if( is_array($arr_ids) )
		{
			$str_ids = implode(',', $arr_ids);
			$where = "country_id IN ($str_ids)";
			$where1 = "country_id IN ($str_ids)";
			
			if($this->input->post('Activate')=='Activate')
			{	
				$this->safe_update('wl_city', array('status'=>'1'),$where1,FALSE);
				$this->safe_update('wl_state', array('status'=>'1'),$where1,FALSE);
				
				$this->safe_update('wl_countries', array('status'=>'1'),$where,FALSE);						   
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('activate'));
				
			}
	
			if($this->input->post('Deactivate')=='Deactivate')
			{
				$this->safe_update('wl_city', array('status'=>'0'),$where1,FALSE);
				$this->safe_update('wl_state', array('status'=>'0'),$where1,FALSE);
				$this->safe_update('wl_countries',array('status'=>'0'),$where,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('deactivate'));					   
				
			}
	
			if($this->input->post('Delete')=='Delete')
			{	
				$this->safe_update('wl_city', array('status'=>'2'),$where1,FALSE);
				$this->safe_update('wl_state', array('status'=>'2'),$where1,FALSE);
				$this->safe_update('wl_countries',array('status'=>'2'),$where,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('deleted'));	
				
			}
		}
	}
	
	// Add record......
	
	public function add()
	{
		$data = array(
						'name'  =>  $this->security->xss_clean($this->input->post('country')),
						'status'       =>  '1'
					 );
		$recId =  $this->safe_insert('wl_countries',$data,FALSE);
	}
	
	public function edit($pre_edit_data)
	{
		$id = applyFilter('NUMERIC_GT_ZERO',$this->input->post('id'));
		if($id>0)
		{
			$data = array(						  
										'name'     => $this->security->xss_clean($this->input->post('country'))
									 );
	
			$where = "country_id = '".$this->input->post('id')."'"; 
			$this->safe_update('wl_countries',$data,$where,FALSE);				
		}
	}
	
	public function get_country_by_id($id)
	{
		$id = applyFilter('NUMERIC_GT_ZERO',$id);
		if($id>0)
		{
			$condtion = "status !='2' AND country_id=$id";
			$fetch_config = array(
									'condition'=>$condtion,							 					 
									'debug'=>FALSE,
									'return_type'=>"object"							  
								 );
			$result = $this->find('wl_countries',$fetch_config);
			return $result;
		}
	}
	
	
}
// model end here