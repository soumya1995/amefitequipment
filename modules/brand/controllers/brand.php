<?php
class Brand extends Public_Controller
{
	
	public function __construct()
	{
		parent::__construct();  
		$this->load->model(array('brand/brand_model'));
		
	}
	
	public function index()
	{
		$record_per_page        = (int) $this->input->post('per_page')? $this->input->post('per_page'): $this->config->item('per_page');
		if(array_key_exists('entity_id',$this->meta_info) && $this->meta_info['entity_id'] > 0 ){
			$parent_segment         = (int) $this->meta_info['entity_id'];
		}else{
			$parent_segment     = (int) $this->uri->segment(3);
		}	
		$config['per_page']		= ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
		$offset                 = (int) $this->input->post('offset');
		$parent_id              = ( $parent_segment > 0 ) ?  $parent_segment : '0';
		$base_url               = ( $parent_segment > 0 ) ?  "brand/index/pg/" : "brand/index/pg/";
				
		$param= array('status'=>'1','offset'=>$offset,'limit'=>$config['per_page']);	
		$res_array              = $this->brand_model->getbrands($param);
		$config['total_rows'] = $data['totalProduct']	=  $this->brand_model->total_rec_found;
		$data['frm_url'] = $base_url;
		//$data['page_links']      = front_pagination($base_url,$config['total_rows'],$config['per_page'],$page_segment);				
		$data['res'] = $res_array; 	
		
		if($this->input->is_ajax_request())
		{
			$this->load->view('brand/brand_data',$data);
		}
		else
		{
			$this->load->view('brand/view_brands',$data);
		}
			
	}
	
}