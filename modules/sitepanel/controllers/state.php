<?php
class State extends Admin_Controller{

	public function __construct(){
	
			/*parent::__construct(); 
			$this->load->model(array('sitepanel/state_model'));  
			$this->admin_lib->is_admin_logged_in(); 
			$this->config->set_item('menu_highlight','manage locations');*/
			
			
			parent::__construct(); 
			$this->load->helper(array('sitepanel/admin'));		
			$this->load->model(array('sitepanel/state_model'));  
			$this->config->set_item('menu_highlight','other management');	
	}
	
	
	 public  function index($page = NULL){
		 
			
			$contID=$this->uri->segment(4);
			$data['contID'] = $contID;
			
			$pagesize               =  (int) $this->input->get_post('pagesize');
			
			$config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
			
			$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
			
			$base_url               =  current_url_query_string(array('filter'=>'result','pagesize'=>$pagesize),array('per_page'));
			
			$res_array              =     $this->state_model->getState($offset,$config['limit'],$contID);		
			
			$total_record           =   $this->state_model->total_rec_found;
			
			$config['total_rows']   =   $total_record;
			
			
			$data['page_links']      =  admin_pagination("$base_url",$config['total_rows'],$config['limit'],$offset);
			
			
			
				
			$data['heading_title'] = 'Manage State';
			$data['total_rec'] = $config['total_rows'];
			$data['res']      = $res_array; 			
		    $this->load->view('location/view_state_list',$data);        
			


			
			  
			
		
	    }
		
	public function change_status(){
		
		$contID=$this->uri->segment(4);
		$this->state_model->change_status();
			redirect('sitepanel/state/index/'.$contID, '');				
		
	}
	
	
	public function add()
	{
		$contID=$this->uri->segment(4);
		$data['contID'] = $contID;
		$data['heading_title'] = 'Add State';
		
		$rule_options=array(
												array(
															'field'=>'state',
															'label'=>'State name',
															'rules'=>"trim|required|xss_clean|alpha|unique[wl_state.region_name ='".$this->db->escape_str($this->input->post('state'))."' AND country_id='$contID' AND status!='2']"
												)
												
											);
		$this->form_validation->set_rules($rule_options);
		if($this->form_validation->run()===TRUE)
		{
			$this->state_model->add($contID);
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			
			redirect('sitepanel/state/index/'.$contID.query_string(), '');				
		}else
		{	
			$this->load->view('location/view_state_add',$data);		  
		}	   
	}
	
	
	
	public function edit(){ 
		$data['heading_title'] = 'Edit State';
		$contID                =  $this->uri->segment(4);
		$editId                = (int) $this->uri->segment(5);
		$data['contID']        = $contID;
		$data['id']            = $editId;
		
		
		$rowdata=$this->state_model->get_state_by_id($editId);
		if(!is_object($rowdata)){
			$this->session->set_flashdata('message', $this->config->item('idmissing'));	
			redirect('sitepanel/state/'.$contID, ''); 	
		}
		
		if($this->input->post('action')!='')
		{
			$rule_options=array(
												array(
															'field'=>'state',
															'label'=>'State name',
															'rules'=>"trim|required|xss_clean|alpha|unique[wl_state.region_name ='".$this->db->escape_str($this->input->post('state'))."' AND country_id='$contID' AND status!='2' AND id!='".$editId."']"
												)
												
											);
			$this->form_validation->set_rules($rule_options);
			if($this->form_validation->run()==TRUE)
			{
				$this->state_model->edit($rowdata);
		   		$this->session->set_userdata(array('msg_type'=>'success'));
			    $this->session->set_flashdata('success',lang('successupdate'));
			
			redirect('sitepanel/state/index/'.$contID.query_string(), '');				
			}else
			{	$data['recresult']=$rowdata;		   
				$this->load->view('location/view_state_edit',$data);	
			}
		}			
		$data['recresult']=$rowdata;
		$this->load->view('location/view_state_edit',$data);
	}
	   
}
//controllet end