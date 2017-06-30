<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class city_model extends MY_Model{

   public function __construct(){
   
     parent::__construct();
	 
   }
 
	
	// Get help center listing
	
	public function getCity($offset=FALSE,$per_page=FALSE,$stateID){
	   
	    $keyword = trim($this->input->post('keyword'));
	   
		$condtion = ($keyword!='')?"status !='2' AND region_id='$stateID' AND city_name like '%".$keyword."%' ":"status !='2' AND region_id='$stateID'  ";
				
		$fetch_config = array(
							  'condition'=>$condtion,
							  'order'=>"city_name ASC",
							  'limit'=>$per_page,
							  'start'=>$offset,							 
							  'debug'=>FALSE,
							  'return_type'=>"array"							  
							  );		
		$result = $this->findAll('wl_city',$fetch_config); 
		return $result;	
		
	
	}
	
	
	public function change_status()
	{
		$arr_ids = $this->input->post('arr_ids');	   
		if( is_array($arr_ids) )
		{
			$str_ids = implode(',', $arr_ids);
			$where = "id IN ($str_ids)";
			if($this->input->post('Activate')=='Activate')
			{	
				$this->safe_update('wl_city', array('status'=>'1'),$where,FALSE);						   
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('activate'));
				
			}
	
			if($this->input->post('Deactivate')=='Deactivate')
			{
				$this->safe_update('wl_city',array('status'=>'0'),$where,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('deactivate'));					   
				
			}
	
			if($this->input->post('Delete')=='Delete')
			{	
				$this->delete_in('wl_city',$where,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('deleted'));	
				
			}
			
			if($this->input->post('set_as')=='is_fetaured')
			{	
				$this->safe_update('wl_city', array('is_fetaured'=>'1'),$where,FALSE);						   
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success','Record has been set as Top Destinations successfully. ');
				
			}
	
			if($this->input->post('unset_as')=='is_fetaured')
			{
				$this->safe_update('wl_city',array('is_fetaured'=>'0'),$where,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success','Record has been unset as Top Destinations successfully.');					   
				
			}
			
		}
	}
	
	public function getCityByCountryId($contID){
	   
		$condtion = "status = '1' AND country_id='$contID' ";
				
		$fetch_config = array(
							  'condition'=>$condtion,
							  'order'=>"city_name ASC",
							  'limit'=>'500',
							  'start'=>'',							 
							  'debug'=>FALSE,
							  'return_type'=>"array"							  
							  );		
		$result = $this->findAll('wl_city',$fetch_config);
		return $result;	
		
	
	}
	
	public function get_city_by_id($id)
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
			$result = $this->find('wl_city',$fetch_config);
			return $result;
		}
	}
	
	
	// Add record......
	
	public function add($stateID,$contID="")
	{
		if($contID==""){
			$res = get_db_single_row("wl_state","country_id,country_code,state_code",array("id"=>$stateID));
			$contID=$res->country_id;
		}
		
		$data = array(
						'country_id'    => $contID,
						'country_code'    => '',
						'state_code'    => '',
						'region_id'    =>  $stateID,
						'city_name'    =>  $this->security->xss_clean($this->input->post('city')),
						'status'       =>  '1'
					 );
		$recId =  $this->safe_insert('wl_city',$data,FALSE);
	}
	
	
	public function edit($pre_edit_data)
	{
		$id = applyFilter('NUMERIC_GT_ZERO',$this->input->post('id'));
		if($id>0)
		{
			
			
			$data = array(						  
							'city_name'  => $this->security->xss_clean($this->input->post('city')),
							
						 );
	
			$where = "id = '".$this->input->post('id')."'"; 
			$this->safe_update('wl_city',$data,$where,FALSE);				
		}
	}
	
	
	
}