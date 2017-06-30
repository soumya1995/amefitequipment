<?php
class Testimonial extends Admin_Controller
{
	public function __construct()
	{		
		parent::__construct(); 				
		$this->load->model(array('testimonials/testimonial_model'));  		
		$this->config->set_item('menu_highlight','other management');				
	}
	 
	public  function index()
	{		
		$pagesize               =  (int) $this->input->get_post('pagesize');		 		
	    $config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');		 		 				
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;		
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));	
									 						 	
	 	$res_array               =  $this->testimonial_model->get_testimonial($config['limit'],$offset);						
	    $config['total_rows']    =  get_found_rows();		
		$data['page_links']      =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);				
		$data['heading_title']   =   'Testimonial';						
		$data['res']             =  $res_array; 			
		
		if($this->input->post('status_action')!='')
		{			
			$this->update_status('wl_testimonial','testimonial_id');			
		}						
		$this->load->view('testimonial/view_testimonial_list',$data);		
	}	
	
	
	public function post()
	{			
		$posted_friendly_url = $this->input->post('friendly_url');
		$this->cbk_friendly_url = seo_url_title($posted_friendly_url);
		$seo_url_length = $this->config->item('seo_url_length');		 
		$this->form_validation->set_rules('friendly_url','Page URL',"trim|required|max_length[$seo_url_length]|xss_clean|callback_checkurl");			
		//$this->form_validation->set_rules('testimonial_title','Title','trim|required|xss_clean|max_length[150]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[80]');
		$this->form_validation->set_rules('poster_name','Name','trim|required|alpha|xss_clean|max_length[30]');
		$this->form_validation->set_rules('testimonial_description','Description','trim|required|xss_clean|max_length[2500]');
		$data['ckeditor']  =  set_ck_config(array('textarea_id'=>'testimonial_description'));		
		 		
		if($this->form_validation->run()==TRUE)
		{
			$redirect_url="testimonials/details";			
			$posted_data=array(				
			'testimonial_title'      => $this->input->post('testimonial_title'),
			'poster_name'             => $this->input->post('poster_name'),
			'friendly_url'=>$this->cbk_friendly_url,
			'email'                   => $this->input->post('email'),
			'testimonial_description' => $this->input->post('testimonial_description'),
			'status'=>'1',						
			'posted_date'            =>$this->config->item('config.date.time')
			);			
			$testimonialid=$this->testimonial_model->safe_insert('wl_testimonial',$posted_data,FALSE); 			
			
			if($testimonialid>0) {	
					$meta_array  = array(
							  'entity_type'=>$redirect_url,
							  'entity_id'=>$testimonialid,
							  'page_url'=>$this->cbk_friendly_url,
							  'meta_title'=>get_text($this->input->post('poster_name'),80),
							  'meta_description'=>get_text($this->input->post('testimonial_description')),
							  'meta_keyword'=>get_keywords($this->input->post('testimonial_description'))
					);

			  create_meta($meta_array);
			}
			
			$message = $this->config->item('testimonial_post_success');			
			//$message = str_replace('<site_name>',$this->config->item('site_name'),$message);									
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success','Your testimonial has been added successfully.');
			redirect('sitepanel/testimonial', ''); 
			
		}		
		$data['heading_title'] = "Post Testimonial";	
		$this->load->view('testimonial/view_post_testimonials',$data);			
	}
	
	
	public function edit()
	{		
	  $id = (int) $this->uri->segment(4);		
	  $param     = array('where'=>"testimonial_id ='$id' ");	
	  $res       = $this->testimonial_model->get_testimonial(1,0,$param);	
	  
	  $posted_friendly_url = $this->input->post('friendly_url');
		$this->cbk_friendly_url = seo_url_title($posted_friendly_url);
		$seo_url_length = $this->config->item('seo_url_length');		
		
			if( is_array($res) && !empty($res) )
			{					
				//$this->form_validation->set_rules('testimonial_title','Title','trim|required|xss_clean|max_length[150]');
				$this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[80]');
				$this->form_validation->set_rules('poster_name','Name','trim|required|alpha|xss_clean|max_length[30]');
				$this->form_validation->set_rules('testimonial_description','Description','trim|required|xss_clean|max_length[2500]');
				
				$data['ckeditor']  =  set_ck_config(array('textarea_id'=>'testimonial_description'));		
				
				if($this->form_validation->run()==TRUE)
				{
				
					$posted_data=array(				
					'testimonial_title'       => $this->input->post('testimonial_title'),
					'poster_name'             => $this->input->post('poster_name'),
					'friendly_url'=>$this->cbk_friendly_url,
					'email'                   => $this->input->post('email'),
					'testimonial_description' => $this->input->post('testimonial_description')
					);					
					 $where = "testimonial_id = '".$id."'"; 				
					 $this->testimonial_model->safe_update('wl_testimonial',$posted_data,$where,FALSE);
					 
					 update_meta_page_url('testimonials/details',$res['testimonial_id'],$this->cbk_friendly_url);
					 
					 $this->session->set_userdata(array('msg_type'=>'success'));				
					 $this->session->set_flashdata('success',lang('successupdate'));	
					
					redirect('sitepanel/testimonial', ''); 
				
				}		
				$data['heading_title'] = "Edit Testimonial";	
				$data['res'] = $res;	
				$this->load->view('testimonial/view_edit_testimonials',$data);	
			}else
			{
				redirect('sitepanel/testimonial', ''); 
				
			}
		
	}
	
	public function checkurl(){
	  
	  		$product_id=(int)$this->input->post('products_id');
			
			if($product_id!=''){
				$cont='and entity_id !='.$product_id;
			}else{
				$cont='';
			}
			
	 		$posted_friendly_url = $this->input->post('friendly_url');
		
			$this->cbk_friendly_url = seo_url_title($posted_friendly_url);
			
			$urlcount=$this->db->query("select * from wl_meta_tags where page_url='".$this->cbk_friendly_url."'".$cont."")->num_rows();
			
			if($urlcount>0)
			{
				$this->form_validation->set_message('checkurl', 'URL already exists.');
			    return FALSE;
								
			}else
			{
				 return TRUE;
			}
  
  }
	
	
}
// End of controller