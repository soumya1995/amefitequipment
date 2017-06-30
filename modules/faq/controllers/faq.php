<?php
class Faq extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('faq/faq_model','category/category_model','members/members_model'));
		$this->load->helper(array('category/category'));	
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
		$category_id              = ( $parent_segment > 0 ) ?  $parent_segment : '0';
		$base_url               = ( $parent_segment > 0 ) ?  "faq/index/".$category_id."/pg/" : "faq/index/pg/";
				
		$where = ($category_id) ? array('faq_parent_id'=>$category_id): '';		
		$param= array('status'=>'1','where'=>$where);	
		$res_array              = $this->faq_model->get_faq($config['per_page'],$offset,$param);
		//echo_sql();
		$config['total_rows'] = $data['totalProduct']	=  get_found_rows();
		$data['frm_url'] = $base_url;			
		$data['res'] = $res_array;	
		
		$data['category_id'] 	= $category_id;
		if($this->input->is_ajax_request())
		{
			$this->load->view('faq/faq_data',$data);
		}
		else
		{
			$this->load->view('faq/view_faq',$data);
		}	
		
	}
	
	public function ajax_load_faq_view()
	{
		$data['title']			  	= 'Ajax Load Faq';
		$config['per_page']		  	= $this->config->item('per_page');
		$offset                  	= $this->input->get_post('stOffSet');
		$param = array('status'=>'1');				
		$res_array                	= $this->faq_model->get_faq($offset,$config['per_page'],$param);			
		$config['base_url']       	= base_url().'testimonials/index/pages/'; 		
		$data['total_rows']	  		= $this->faq_model->total_rec_found;
		$config['uri_segment']		= 3;						
		$data['res'] 				= $res_array;
		$this->load->view('ajax_load_faq',$data);
	}
		
}?>