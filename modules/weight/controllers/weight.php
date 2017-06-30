<?php
class Weight extends Public_Controller
{
	
	public function __construct()
	{
		parent::__construct();  
		$this->load->model(array('weight/weight_model'));
		
	}
	
	public function index()
	{
		$record_per_page         = (int) $this->input->post('per_page');			
		$page_segment            =  find_paging_segment();				
		$config['per_page']	     =  ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');				
		
		$offset                 = (int) $this->input->post('offset');
		$base_url                =   "material/index/pg/";
		
		$param= array('status'=>'1');
		
		$res_array              = $this->material_model->get_materials($param,$offset,$config['per_page']);		
		//echo_sql();
		$config['total_rows'] = $data['totalProduct']	= get_found_rows();	
		//$data['page_links']      = front_pagination($base_url,$config['total_rows'],$config['per_page'],$page_segment);				
		$data['res'] = $res_array; 			
		$data['frm_url'] = $base_url;
		
		if($this->input->is_ajax_request())
		{
			$this->load->view('material/material_data',$data);
		}
		else
		{
			$this->load->view('material/view_materials',$data);
		}
			
	}
	
}