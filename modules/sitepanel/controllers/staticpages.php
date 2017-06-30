<?php
class Staticpages extends Admin_Controller {

	public function __construct()
	{		
		parent::__construct(); 			  
		$this->load->model(array('pages/pages_model'));  		
		$this->config->set_item('menu_highlight','other management');		
	}
	
	
	public  function index()
	{
		
		$pagesize               =  (int) $this->input->get_post('pagesize');
		
	    $config['limit']		=  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
			
		$offset                 = ($this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));	
				
		$res_array              =  $this->pages_model->get_all_cms_page($offset,$config['limit']);
		
		$total_record        	=  $this->pages_model->total_rec_found;	
		
		$data['page_links']     =  admin_pagination("$base_url",$total_record,$config['limit'],$offset);		
		$data['heading_title']  = 'Manage Static Pages';
		$data['pagelist']       = $res_array; 			
		$data['offset'] = $offset;		
		$this->load->view('staticpage/staticpage_list_index_view',$data); 	
		
		
	}

	public function pagedatadisplay()
	{
		$id = (int) $this->uri->segment(4);
		$res = $this->pages_model->getStaticpage_by_id($id); 
		
		$data['heading_title'] = 'Static Pages';
		$data['page_title']    = 'View Page Information';
		$data['pageresult']    =$res;		
		$this->load->view('staticpage/statispage_detail_view',$data);
	}

	public function edit()
	{
		
		$data['ckeditor']  =  set_ck_config(array('textarea_id'=>'page_desc'));					
		$page_id = (int) $this->uri->segment(4);
		$res = $this->pages_model->get_cms_page(array('page_id'=>$page_id));
				
		if( is_array( $res ) )
		{ 	
			
				$this->form_validation->set_rules('page_short_description', 'Heading','trim');
				$this->form_validation->set_rules('page_description', 'Description','required');				
				
				if ($this->form_validation->run() == TRUE)
				{
									
						$posted_data = array(
						'page_description'=>$this->input->post('page_description',TRUE),
						'page_updated_date'=>$this->config->item('config.date.time')
						);
						
						$where = "page_id = '".$res['page_id']."'"; 						
						$this->pages_model->safe_update('wl_cms_pages',$posted_data,$where,FALSE);	
						$this->session->set_userdata(array('msg_type'=>'success'));
						$this->session->set_flashdata('success',lang('successupdate'));				
						redirect('sitepanel/staticpages/'.query_string(), ''); 	
										
					
				}		 
			
			
		$data['heading_title']  = 'Edit Static Pages';
		$data['page_title']     = 'Edit Information';
		$data['pageresult']     = $res;		
		$this->load->view('staticpage/statispage_edit_view',$data);
			
		}else
		{
			redirect('sitepanel/staticpages','');
		}
	}
}
// End of controller