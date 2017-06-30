<?php
class city extends Admin_Controller{

	public function __construct(){
	
			parent::__construct(); 					
					
			$this->load->helper(array('sitepanel/admin'));		
			$this->load->model(array('sitepanel/city_model'));  
			$this->config->set_item('menu_highlight','other management');	

	}
	
	
	 public  function index($page = NULL){
		 
			$stateID         = $this->uri->segment(4);			
			$contID         = $this->uri->segment(5);
			$data['stateID'] = $stateID;
			$data['contID'] = $contID;			
			
			
		
			$pagesize               =  (int) $this->input->get_post('pagesize');			
			$config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');			
			$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;				
			$base_url               =  current_url_query_string(array('filter'=>'result','pagesize'=>$pagesize),array('per_page'));			
			
			$res_array              =     $this->city_model->getCity($offset,$config['limit'],$stateID);			
			$total_record           =   $this->city_model->total_rec_found;			
			$config['total_rows']   =   $total_record;			
			
			$data['page_links']      =  admin_pagination("$base_url",$config['total_rows'],$config['limit'],$offset);
				
			$data['heading_title'] = 'Manage City';
			$data['total_rec'] = $config['total_rows'];
			$data['res']      = $res_array; 			
		    $this->load->view('location/view_city_list',$data);        
			
		
	    }
		
	public function change_status(){
		
		$stateID         = $this->uri->segment(4);	
		$contID=$this->uri->segment(5);
		
		$this->city_model->change_status();
		redirect('sitepanel/city/index/'.$stateID."/".$contID.query_string(), ''); 
		
	}
	
	
	public function add()
	{
		$stateID                =  $this->uri->segment(4);
		$contID                =  $this->uri->segment(5);
		$data['contID'] = $contID;
		$data['stateID'] = $stateID;
		$data['heading_title'] = 'Add City';
		
		$rule_options=array(
												array(
															'field'=>'city',
															'label'=>'City',
															'rules'=>"trim|required|xss_clean|unique[wl_city.city_name='".$this->db->escape_str($this->input->post('city'))."' AND region_id='$stateID' AND status!='2' ]"
												)
												
											);
		$this->form_validation->set_rules($rule_options);
		if($this->form_validation->run()===TRUE)
		{
			$this->city_model->add($stateID,$contID);
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			
			redirect('sitepanel/city/index/'.$stateID.'/'.$contID.query_string(), '');				
		}else
		{	
			$this->load->view('location/view_city_add',$data);		  
		}	   
	}
	
	
	
	public function edit(){
		$data['heading_title'] = 'Edit City';
		$stateID                =  $this->uri->segment(4);
		$contID                =  $this->uri->segment(5);
		$editId                = (int) $this->uri->segment(6);
		$data['stateID']        = $stateID;
		$data['contID']        = $contID;
		$data['id']            = $editId;
		
		
		$rowdata=$this->city_model->get_city_by_id($editId);
		if(!is_object($rowdata)){
			$this->session->set_flashdata('message', $this->config->item('idmissing'));	
			redirect('sitepanel/state/'.$contID, ''); 	
		}
		
		if($this->input->post('action')!='')
		{			
			$rule_options=array(
												array(
															'field'=>'city',
															'label'=>'City',
															'rules'=>"trim|required|xss_clean|unique[wl_city.city_name ='".$this->db->escape_str($this->input->post('city'))."' AND region_id='$contID' AND status!='2' AND id!='".$editId."']"
												)
												
											);
			$this->form_validation->set_rules($rule_options);
			if($this->form_validation->run()==TRUE)
			{
				$this->city_model->edit($rowdata);
		   		$this->session->set_userdata(array('msg_type'=>'success'));
			    $this->session->set_flashdata('success',lang('successupdate'));
			
				redirect('sitepanel/city/index/'.$stateID.'/'.$contID.query_string(), '');				
			}else
			{	$data['recresult']=$rowdata;		   
				$this->load->view('location/view_city_edit',$data);	
			}
		}			
		$data['recresult']=$rowdata;
		$this->load->view('location/view_city_edit',$data);
	}
	   
}
//controllet end