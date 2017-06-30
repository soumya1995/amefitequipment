<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class State_model extends MY_Model{

   public function __construct(){
   
     parent::__construct();
	 
   }
 
	
	// Get help center listing
	
	public function getState($offset=FALSE,$per_page=FALSE,$contID){
	   
	    $keyword = $this->db->escape_str($this->input->post('keyword'));
	   
		$condtion = ($keyword!='')?"status !='2' AND country_id='$contID' AND region_name like '%".$keyword."%' ":"status !='2' AND country_id='$contID'  ";
				
		$fetch_config = array(
							  'condition'=>$condtion,
							  'order'=>"region_name ASC",
							  'limit'=>$per_page,
							  'start'=>$offset,							 
							  'debug'=>FALSE,
							  'return_type'=>"array"							  
							  );		
		$result = $this->findAll('wl_state',$fetch_config);
		return $result;	
		
	
	}
	
	
	public function change_status()
	{
		$arr_ids = $this->input->post('arr_ids');	   
		if( is_array($arr_ids) )
		{
			$str_ids = implode(',', $arr_ids);
			$where = "id IN ($str_ids)";
			$where1 = "country_id IN ($str_ids)";
			
			if($this->input->post('Activate')=='Activate')
			{	
				$this->safe_update('wl_city', array('status'=>'1'),$where1,FALSE);
				$this->safe_update('wl_state', array('status'=>'1'),$where,FALSE);						   
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('activate'));
				
			}
	
			if($this->input->post('Deactivate')=='Deactivate')
			{
				$this->safe_update('wl_city', array('status'=>'0'),$where1,FALSE);
				$this->safe_update('wl_state',array('status'=>'0'),$where,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('deactivate'));					   
				
			}
	
			if($this->input->post('Delete')=='Delete')
			{	
				$this->delete_in('wl_city',$where1,FALSE);
				$this->delete_in('wl_state',$where,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('deleted'));	
				
			}
		}
	}
	
	
	public function get_state_by_id($id)
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
			$result = $this->find('wl_state',$fetch_config);
			return $result;
		}
	}
	
	
	// Add record......
	
	public function add($contID)
	{
		$data = array(
						'country_id'   =>  $contID,
						'region_name'  =>  $this->security->xss_clean($this->input->post('state')),
						'status'       =>  '1'
					 );
		$recId =  $this->safe_insert('wl_state',$data,FALSE);
	}
	
	public function edit($pre_edit_data)
	{
		$id = applyFilter('NUMERIC_GT_ZERO',$this->input->post('id'));
		if($id>0)
		{
			$data = array(						  
										'region_name'     => $this->security->xss_clean($this->input->post('state'))
									 );
	
			$where = "id = '".$this->input->post('id')."'"; 
			$this->safe_update('wl_state',$data,$where,FALSE);				
		}
	}
	
	public function getStateByCountryId($contID){
	   
		$condtion = "status = '1' AND country_id='$contID' ";
				
		$fetch_config = array(
							  'condition'=>$condtion,
							  'order'=>"region_name ASC",
							  'limit'=>'500',
							  'start'=>'',							 
							  'debug'=>FALSE,
							  'return_type'=>"array"							  
							  );		
		$result = $this->findAll('wl_state',$fetch_config);
		return $result;	
		
	
	}

	
	
}
// model end here