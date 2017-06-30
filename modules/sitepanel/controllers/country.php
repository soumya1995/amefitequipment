<?php
class country extends Admin_Controller{

	public function __construct(){
	
			parent::__construct(); 
			$this->load->helper(array('sitepanel/admin'));		
			$this->load->model(array('sitepanel/country_model'));  
			$this->config->set_item('menu_highlight','other management');	
	}
	
	
	 public  function index($page = NULL){
		 
		 $pagesize               =  (int) $this->input->get_post('pagesize');
		 		
	     $config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		 		 				
		 $offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		
		 $base_url               =  current_url_query_string(array('filter'=>'result','pagesize'=>$pagesize),array('per_page'));
			
		 $res_array              =    $this->country_model->getCountry($offset,$config['limit']);	
		 					
	     $total_record           =   $this->country_model->total_rec_found;
		 
		 $config['total_rows']   =   $total_record;
		
		
		 $data['page_links']      =  admin_pagination("$base_url",$config['total_rows'],$config['limit'],$offset);
								
			
				
			$data['heading_title'] = 'Manage Country';
			$data['total_rec'] = $config['total_rows'];
			$data['pagelist']      = $res_array; 			
		    $this->load->view('location/view_country_list',$data);        
			
		
	    }
		
		public function change_status(){
		
		$contID=$this->uri->segment(3);
		$this->country_model->change_status();
		redirect('sitepanel/country/', ''); 
		
	}
	
	public function add()
	{

		$data['heading_title'] = 'Add Country';
		$rule_options=array(
												array(
															'field'=>'country',
															'label'=>'Country name',
															'rules'=>"trim|required|xss_clean|alpha|unique_sp[wl_country.name ='".$this->db->escape_str($this->input->post('country'))."' AND status != '2']"
												)
												
											);
		$this->form_validation->set_rules($rule_options);
		if($this->form_validation->run()===TRUE)
		{
			$this->country_model->add();
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			
			redirect('sitepanel/country/index/'.query_string(), '');				
		}else
		{	
			$this->load->view('location/view_country_add',$data);		  
		}	   
	}
	
	
	
	public function edit(){
		$data['heading_title'] = 'Edit Country';
		$editId                = (int) $this->uri->segment(4);
		$data['country_id']            = $editId;
		
		
		$rowdata=$this->country_model->get_country_by_id($editId);
		if(!is_object($rowdata)){
			$this->session->set_flashdata('message', $this->config->item('idmissing'));	
			redirect('sitepanel/country/index', ''); 	
		}
		
		if($this->input->post('action')!='')
		{
			$rule_options=array(
												array(
															'field'=>'country',
															'label'=>'Country name',
															'rules'=>"trim|required|xss_clean|alpha|unique_sp[wl_country.name ='".$this->db->escape_str($this->input->post('country'))."' AND status!='2' AND country_id!='".$editId."']"
												)
												
											);
			$this->form_validation->set_rules($rule_options);
			if($this->form_validation->run()==TRUE)
			{
				$this->country_model->edit($rowdata);
		   		$this->session->set_userdata(array('msg_type'=>'success'));
			    $this->session->set_flashdata('success',lang('successupdate'));
			
			redirect('sitepanel/country/index/'.query_string(), '');				
			}else
			{	$data['recresult']=$rowdata;		   
				$this->load->view('location/view_country_edit',$data);	
			}
		}			
		$data['recresult']=$rowdata;
		$this->load->view('location/view_country_edit',$data);
	}
	   
}
//controllet end