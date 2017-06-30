<?php
class Brand extends Admin_Controller
{
	public function __construct()
	{		
		parent::__construct(); 				
		$this->load->model(array('brand/brand_model'));
		$this->load->helper('category/category');
		$this->config->set_item('menu_highlight','product management');				
	}
	 
	public  function index()
	{
		
		
		 $pagesize               =  (int) $this->input->get_post('pagesize');
	     $config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');		 		 				
		 $offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;		
		 $base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));				 
		 $parent_id              =   (int) $this->uri->segment(4,0);			
	     
		 $keyword = trim($this->input->get_post('keyword',TRUE));		
		 $keyword = $this->db->escape_str($keyword);
	     $condtion = " ";
		 
		
									
		$condtion_array = array(
		                'field' =>"*",
						 'condition'=>$condtion,
						 'order'=>"brand_id DESC",
						 'limit'=>$config['limit'],
						  'offset'=>$offset	,
						  'debug'=>FALSE
						 );							 						 	
		$res_array              =  $this->brand_model->getbrands($condtion_array);
						
		$config['total_rows']	=  $this->brand_model->total_rec_found;	
		
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
				
		$data['heading_title']  =  'Brands';
						
		$data['res']            =  $res_array; 	
		
		$data['parent_id']      =  $parent_id; 	
		
		
		if( $this->input->post('status_action')!='')
		{			
			$this->update_status('wl_brands','brand_id');			
		}
		if( $this->input->post('update_order')!='')
		{			
			$this->update_displayOrder('wl_brands','sort_order','brand_id');			
		}
		
		if( $this->input->post('set_as')!='' )
		{	
		    $set_as    = $this->input->post('set_as',TRUE);			
			$this->set_as('wl_brands','brand_id',array($set_as=>'1'));			
		}
		
		if( $this->input->post('unset_as')!='' )
		{	
		    $unset_as   = $this->input->post('unset_as',TRUE);		
			$this->set_as('wl_brands','brand_id',array($unset_as=>'0'));			
		}
						
		$this->load->view('brand/view_brand_list',$data);		
		
		
	}	
	
	public function add()
	{
		 $img_allow_size =  $this->config->item('allow.file.size');
		 $img_allow_dim  =  $this->config->item('allow.imgage.dimension');
							
		
		 $data['heading_title'] = 'Add Brand';
		
		
		
		 $this->form_validation->set_rules('brand_name','Brand Name',"trim|required|max_length[32]|xss_clean|unique[wl_brands.brand_name='".$this->db->escape_str($this->input->post('brand_name'))."' AND status!='2']");
		 $this->form_validation->set_rules('brand_image','Image',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");
		 
		if($this->form_validation->run()===TRUE)
		{
			    $uploaded_file = "";	
				
			    if( !empty($_FILES) && $_FILES['brand_image']['name']!='' )
				{			  
					$this->load->library('upload');	
						
					$uploaded_data =  $this->upload->my_upload('brand_image','brand');
				
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{ 								
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
						
						//$watermark_img = UPLOAD_DIR."/brand/".$uploaded_file;
						//img_watermark($watermark_img);
					}		
					
				}
				
			  	$posted_data = array(
					'brand_name'=>$this->input->post('brand_name'),
					'brand_date_added'=>$this->config->item('config.date.time'),
					'brand_image'=>$uploaded_file				
				 );
								
		    $this->brand_model->safe_insert('wl_brands',$posted_data,FALSE);	
								
			$this->session->set_userdata(array('msg_type'=>'success'));			
			$this->session->set_flashdata('success',lang('success'));				
			redirect('sitepanel/brand', '');		
					
		}	
		$this->load->view('brand/view_brand_add',$data);		  
		  
	}
	
	
	public function edit()
	{
		$brandId = (int) $this->uri->segment(4);
		
		$rowdata=$this->brand_model->get_brand_by_id($brandId);
				
		$brandId = $rowdata['brand_id'];
		
		$data['heading_title'] = 'Brand';
		
		$img_allow_size =  $this->config->item('allow.file.size');
		$img_allow_dim  =  $this->config->item('allow.imgage.dimension');
		
		
		if( !is_array($rowdata) )
		{
			$this->session->set_flashdata('message', lang('idmissing'));	
			redirect('sitepanel/brand', ''); 	
			
		}
		
			$this->form_validation->set_rules('brand_name','Brand Name',"trim|required|max_length[32]|xss_clean|unique[wl_brands.brand_name='".$this->db->escape_str($this->input->post('brand_name'))."' AND status!='2' AND brand_id != ".$brandId."]");
			$this->form_validation->set_rules('brand_image','Image',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");		 		
			
			if($this->form_validation->run()==TRUE)
			{	
						
				$uploaded_file = $rowdata['brand_image'];				 
				$unlink_image = array('source_dir'=>"brand",'source_file'=>$rowdata['brand_image']);
			 	if($this->input->post('brand_img_delete')==='Y')
				 {					
					removeImage($unlink_image);						
					$uploaded_file = NULL;	
								
				 }				
				 if( !empty($_FILES) && $_FILES['brand_image']['name']!='' )
				 {			  
						$this->load->library('upload');	
							
						$uploaded_data =  $this->upload->my_upload('brand_image','brand');
					
						if( is_array($uploaded_data)  && !empty($uploaded_data) )
						{ 								
							$uploaded_file = $uploaded_data['upload_data']['file_name'];
						    removeImage($unlink_image);	
							
							//$watermark_img = UPLOAD_DIR."/brand/".$uploaded_file;
							//img_watermark($watermark_img);
						}
						
				}				
														
				$posted_data = array(
					'brand_name'=>$this->input->post('brand_name'),
					'brand_image'=>$uploaded_file				
				 );
				 
			 	$where = "brand_id = '".$brandId."'"; 				
				$this->brand_model->safe_update('wl_brands',$posted_data,$where,FALSE);	
							
				$this->session->set_userdata(array('msg_type'=>'success'));				
				$this->session->set_flashdata('success',lang('successupdate'));								
				
				redirect('sitepanel/brand'.'/'.query_string(), ''); 	
							
			}						
			
		$data['edit_result']=$rowdata;		
		$this->load->view('brand/view_brand_edit',$data);				
		
	}
	
	
}
// End of controller