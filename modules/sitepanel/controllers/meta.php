<?php
class Meta extends Admin_Controller
{

	public function __construct()
	{
	
			parent::__construct();			
			$this->load->model(array('sitepanel/meta_model'));  
			$this->config->set_item('menu_highlight','other management');	
				
	}
	
	
	 public  function index($page = NULL)
	 {
		 
		  
			$keyword                =  trim($this->input->get_post('keyword',TRUE));
			       
			$pagesize               =  (int) $this->input->get_post('pagesize');
			
			$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
			
			$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
			
			$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
						
			$keyword               =  $this->db->escape_str($keyword);
						
        	$condtion              =  ( $keyword!='') ? "page_url LIKE '%".$keyword."%'":"NULL";	
									
			$res_array              = $this->meta_model->get_meta($offset,$config['limit'],$condtion);	
						
			$config['total_rows']	= $this->meta_model->total_rec_found;	
			
			$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
			if( $this->input->post('status_action')!='')
			{			
			   $this->update_status('wl_meta_tags','meta_id');			
			}
			$data['heading_title'] = 'Manage Meta Tags';
			$data['pagelist']      = $res_array; 			
		    $this->load->view('metatag/meta_list_view',$data);        
			
		
	    }
	
		
		public function add()
		{
			
			if( !empty($_POST) )
			{
				$_POST['page_url'] = str_replace(base_url(),"",$this->input->post('page_url'));
			}
				        
			$data['heading_title'] = 'Add Meta Tag';						
			$this->form_validation->set_rules('page_url','URL',"trim|required|unique[wl_meta_tags.page_url='".$this->db->escape_str($this->input->post('page_url'))."']");
			$this->form_validation->set_rules('meta_title','Title','trim|required|xss_clean|max_length[80]');
			$this->form_validation->set_rules('meta_keyword','Keyword','trim|required|xss_clean|max_length[160]');
			$this->form_validation->set_rules('meta_description','Description','trim|required|xss_clean|max_length[160]');
			
			if($this->form_validation->run()==TRUE)
			{
								
				$page_url = $this->input->post('page_url');
								
				$posted_data = array(
				'page_url' =>$page_url,
				'meta_title' =>$this->input->post('meta_title',TRUE),
				'meta_keyword' =>$this->input->post('meta_keyword',TRUE),
				'meta_description' =>$this->input->post('meta_description',TRUE),
				'meta_date_added'=>$this->config->item('config.date.time'),				
				);
				
				$this->meta_model->safe_insert('wl_meta_tags',$posted_data,FALSE);			  
			    $this->session->set_userdata('msg_type',"success" ); 
			    $this->session->set_flashdata('success',lang('success') ); 
				redirect('sitepanel/meta', '');
				
			
			}   
			
			 $this->load->view('metatag/meta_add_view',$data);	
				   
	   }
	   
	  
	   
	   public function edit()
	   {
		   
	      	$data['heading_title'] = 'Edit Meta Tag';			
			$Id        = (int) $this->uri->segment(4);	
			$condtion  = "meta_id ='$Id' ";	
			$res       =   $this->meta_model->get_meta(0,1,$condtion);	
			$res       = $res[0];
						
		 if( is_array($res) && !empty($res) )
		 { 
			 if( !empty($_POST) )
			 {
				$_POST['page_url'] = str_replace(base_url(),"",$this->input->post('page_url'));
			 }
			 			
			$this->form_validation->set_rules('page_url','URL',"trim|required|unique[wl_meta_tags.page_url='".$this->db->escape_str($this->input->post('page_url'))."' AND meta_id != ".$Id."]");
			$this->form_validation->set_rules('meta_title','Title','trim|required|xss_clean|max_length[80]');
			$this->form_validation->set_rules('meta_keyword','Keyword','trim|required|xss_clean|max_length[160]');
			$this->form_validation->set_rules('meta_description','Description','trim|required|xss_clean|max_length[160]');
			
			
					if($this->form_validation->run()==TRUE)
					{
						$page_url = $this->input->post('page_url');
						
						$posted_data = array(
						'page_url' =>$page_url,
						'meta_title' =>$this->input->post('meta_title',TRUE),
						'meta_keyword' =>$this->input->post('meta_keyword',TRUE),
						'meta_description' =>$this->input->post('meta_description',TRUE)
						);
						
						$where = "meta_id = '".$res['meta_id']."'"; 						
						$this->meta_model->safe_update('wl_meta_tags',$posted_data,$where,FALSE);	
						
						$this->session->set_userdata('msg_type',"success" ); 
						$this->session->set_flashdata('success',lang('successupdate') ); 
						redirect('sitepanel/meta/'.query_string(), ''); 	
						 
					}
				
					$data['res']=$res;
					$this->load->view('metatag/meta_edit_view',$data);
				
		   }
		   else
		   {
			  redirect('sitepanel/meta', ''); 	 
		   }
		   
		   
	   }
	   
	   
	   
	   
	   
}
//controllet end