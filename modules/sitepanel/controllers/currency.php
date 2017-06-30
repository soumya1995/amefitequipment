<?php
class Currency extends Admin_Controller
{

	public function __construct()
	{
		     parent::__construct(); 				
			$this->load->model(array('currency_model'));  			
			$this->config->set_item('menu_highlight','other management');
			//$this->load->helper(array('banner','custom_form'));  		
	}

	public  function index($page = NULL)
	{		
		$pagesize               =  (int) $this->input->get_post('pagesize');		
		$config['limit']		=  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');			
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
				
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));				
		$res_array              =  $this->currency_model->get_currencies($offset,$config['limit']);			
		$config['base_url']     =  base_url().'sitepanel/currencies/pages/'; 		
		$config['total_rows']	=  $this->currency_model->total_rec_found;	
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);				
		$data['heading_title'] = 'Currencies Lists';
		$data['res'] = $res_array; 		
		
		if( $this->input->post('status_action')!='')
		{			
			$this->update_status('wl_currencies','currency_id');			
		}
			
		$this->load->view('currency/view_currency_list',$data);	
			
	} 

	

	public function add()
	{		  
		$data['heading_title'] = 'Add Currency';	
		
		$this->form_validation->set_rules('title','Currency Title',"required|max_length[32]");		 
		$this->form_validation->set_rules('code','Currency Code',"required|max_length[3]|unique[wl_currencies.code='".$this->db->escape_str($this->input->post('code'))."' AND status!='2']");
		$this->form_validation->set_rules('symbol','Symbol',"trim|required");
		$this->form_validation->set_rules('value','Value',"trim|required|is_valid_amount");
		$this->form_validation->set_rules('image1','Image',"file_required|file_allowed_type[image]");
		 		
		if($this->form_validation->run()==TRUE)
		{
			
			    $uploaded_file = "";	
				
			    if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{			  
					$this->load->library('upload');	
						
					$uploaded_data =  $this->upload->my_upload('image1','currency');
				
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{ 								
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					
					}		
					
				}
				
			
				$posted_data = array(
				'title'=>$this->input->post('title'),
				'code'=>$this->input->post('code'),
				'symbol_left'=>$this->input->post('symbol'),	
				'symbol_right'=>'',
				'value'=>$this->input->post('value'),
				'date_modified'=>$this->config->item('config.date.time'),
				'curr_image'=>$uploaded_file				
				);
								
		    $this->currency_model->safe_insert('wl_currencies',$posted_data,FALSE);									
			$this->session->set_userdata(array('msg_type'=>'success'));			
			$this->session->set_flashdata('success',lang('success'));			
			redirect('sitepanel/currency', '');
			
						
		}
		
		$this->load->view('currency/view_currency_add',$data);		  
			   
	}

	public function edit()
	{
		$Id = (int) $this->uri->segment(4);		   
		$data['heading_title'] = 'Update Currency';			
		$rowdata=$this->currency_model->get_currency_by_id($Id);
				 
		if( is_object($rowdata) )
		{
				
		$this->form_validation->set_rules('title','Currency Title',"required|max_length[32]");		 
		$this->form_validation->set_rules('code','Currency Code',"required|max_length[3]");
		$this->form_validation->set_rules('symbol','Symbol',"trim|required");
			$this->form_validation->set_rules('value','Value',"trim|required|is_valid_amount");
		$this->form_validation->set_rules('image1','Image',"file_allowed_type[image]");
		 
				if($this->form_validation->run()==TRUE)
				{
					 					 
					$uploaded_file = $rowdata->curr_image;				 
					$unlink_image = array('source_dir'=>"currency",'source_file'=>$rowdata->curr_image);
													
					if( !empty($_FILES) && $_FILES['image1']['name']!='' )
					{			  
						  $this->load->library('upload');					
						  $uploaded_data =  $this->upload->my_upload('image1','currency');
						
						if( is_array($uploaded_data)  && !empty($uploaded_data) )
						{ 								
						   $uploaded_file = $uploaded_data['upload_data']['file_name'];
						   removeImage($unlink_image);	
						}
					
				    }	
					
					$posted_data = array(
					'title'=>$this->input->post('title'),
					'code'=>$this->input->post('code'),
					'symbol_left'=>$this->input->post('symbol'),
					'symbol_right'=>'',	
					'value'=>$this->input->post('value'),
					'curr_image'=>$uploaded_file				
					);
					
					$where = "currency_id = '".$rowdata->currency_id."'"; 				
					$this->currency_model->safe_update('wl_currencies',$posted_data,$where,FALSE);						
					$this->session->set_userdata(array('msg_type'=>'success'));				
				    $this->session->set_flashdata('success',lang('successupdate'));	
					redirect('sitepanel/currency/'.query_string(), ''); 
					 
				}
				$data['res']=$rowdata;
				$this->load->view('currency/view_currency_edit',$data);
				
			
		}else
		{
			redirect('sitepanel/currency', ''); 	 
		}
		
	}
	

}
// End of controller