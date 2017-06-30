<?php
class Package extends Public_Controller
{
	
	public function __construct()
	{
		parent::__construct();  
		$this->load->model(array('package/package_model'));
		
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
		$base_url               = ( $parent_segment > 0 ) ?  "package/index/pg/" : "package/index/pg/";
				
		$param= array('status'=>'1');	
		$res_array              = $this->package_model->get_package($config['per_page']	,$offset,$param);
		$config['total_rows'] = $data['totalProduct']	=  get_found_rows();
		$data['frm_url'] = $base_url;
		//$data['page_links']      = front_pagination($base_url,$config['total_rows'],$config['per_page'],$page_segment);				
		$data['res'] = $res_array; 	
		
		if($this->input->is_ajax_request())
		{
			$this->load->view('package/package_data',$data);
		}
		else
		{
			$this->load->view('package/view_package',$data);
		}
			
	}
	
	public function details(){		
		
		$packageid = (int) $this->uri->rsegment(3);
		$option = array();			
		$option["where"]="`wlw`.`package_id` = '".$packageid."' ";
		$res =  $this->package_model->get_package(1,0,$option);
		
		if(is_array($res)&& !empty($res) ){			
			
			$data['title'] = "Products";
			$data['res']       = $res;			
			$media_res         = $this->package_model->get_package_media(4,0,array('productid'=>$res['package_id']));
			$data['media_res'] = $media_res;
			$data['heading'] = $res['title'];
			$this->load->view('package/view_package_details',$data);

		}else
		{
			redirect('package', '');
		}

	}
	
}