<?php
class Header_images extends Admin_Controller
{

	public function __construct()
	{
		  parent::__construct(); 				
			$this->load->model(array('header_images_model'));  			
			$this->config->set_item('menu_highlight','other management');
	}

	public  function index($page = NULL)
	{		
		$pagesize               =  (int) $this->input->get_post('pagesize');		
		$config['limit']		=  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');			
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
				
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));				
		$res_array              =  $this->header_images_model->get_header_images($offset,$config['limit']);			
		$config['base_url']     =  base_url().'sitepanel/header_images/index/pages/'; 		
		$config['total_rows']	=  $this->header_images_model->total_rec_found;	
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);				
		$data['heading_title'] = 'Header Images';
		$data['res'] = $res_array; 		
		
		if( $this->input->post('status_action')!='')
		{			
			$this->update_status('wl_header_images','id');			
		}
			
		$this->load->view('header_images/view_header_images_list',$data);	
			
	} 

	

	public function add()
	{		  
		$data['heading_title'] = 'Add Header Images';	
		
		 $this->form_validation->set_rules('image1','Header Image',"file_required|file_allowed_type[image]");
		 $this->form_validation->set_rules('header_url','Header Url',"prep_url");
		 		
		if($this->form_validation->run()==TRUE)
		{
			
			    $uploaded_file = "";	
				
			    if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{			  
					$this->load->library('upload');	
						
					$uploaded_data =  $this->upload->my_upload('image1','header_images');
				
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{ 								
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
						
						//$watermark_img = UPLOAD_DIR."/header_images/".$uploaded_file;
						//img_watermark($watermark_img);
					}		
					
				}
				
			
				$posted_data = array(
				'added_date'=>$this->config->item('config.date.time'),
				'header_image'=>$uploaded_file,
				'header_url'=>$this->input->get_post('header_url')					
				);
								
		    $this->header_images_model->safe_insert('wl_header_images',$posted_data,FALSE);									
			$this->session->set_userdata(array('msg_type'=>'success'));			
			$this->session->set_flashdata('success',lang('success'));			
			redirect('sitepanel/header_images', '');
			
						
		}
		
		$this->load->view('header_images/view_header_images_add',$data);		  
			   
	}

	public function edit()
	{
		$Id = (int) $this->uri->segment(4);		   
		$data['heading_title'] = 'Update Header Image';			
		$rowdata=$this->header_images_model->get_header_images_by_id($Id);
				 
		if( is_object($rowdata) )
		{
				$this->form_validation->set_rules('image1','Header Image',"file_allowed_type[image]");
				$this->form_validation->set_rules('header_url','Header Url',"prep_url");
				
		 
				if($this->form_validation->run()==TRUE)
				{
					 					 
					$uploaded_file = $rowdata->header_image;				 
					$unlink_image = array('source_dir'=>"header_images",'source_file'=>$rowdata->header_image);
													
					if( !empty($_FILES) && $_FILES['image1']['name']!='' )
					{			  
						  $this->load->library('upload');					
						  $uploaded_data =  $this->upload->my_upload('image1','header_images');
						  
						 						
						if( is_array($uploaded_data)  && !empty($uploaded_data) )
						{ 								
						   $uploaded_file = $uploaded_data['upload_data']['file_name'];
						   removeImage($unlink_image);	
						   
						   //$watermark_img = UPLOAD_DIR."/header_images/".$uploaded_file;
						   //img_watermark($watermark_img);
						}
					
				    }	
					
					$posted_data = array(
					'header_image'=>$uploaded_file,
					'header_url'=>$this->input->get_post('header_url')					
					);
					
					$where = "id = '".$rowdata->id."'"; 				
					$this->header_images_model->safe_update('wl_header_images',$posted_data,$where,FALSE);						
					$this->session->set_userdata(array('msg_type'=>'success'));				
				    $this->session->set_flashdata('success',lang('successupdate'));	
					redirect('sitepanel/header_images/'.query_string(), ''); 
					 
				}
				$data['res']=$rowdata;
				$this->load->view('header_images/view_header_images_edit',$data);
				
			
		}else
		{
			redirect('sitepanel/header_images', ''); 	 
		}
		
	}
}
// End of controller