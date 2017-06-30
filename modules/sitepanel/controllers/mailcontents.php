<?php
class Mailcontents extends Admin_Controller
 {

	public function __construct() {
		
		parent::__construct(); 			  
		$this->load->model(array('sitepanel/mailcontents_model'));  
		$this->config->set_item('menu_highlight','other management');	
	
	}

	public  function index()
	{		
		
		 $pagesize                =  (int) $this->input->get_post('pagesize');
		 		
	     $config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		 		 				
		 $offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		
		 $base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
					
		 $res_array               =  $this->mailcontents_model->getmailcontents($offset,$config['limit']);	
		
		 $total_record        	=  $this->mailcontents_model->total_rec_found;	
		
	 	 $data['page_links']     =  admin_pagination($base_url,$total_record,$config['limit'],$offset);	
			
		 $data['heading_title']  = 'Manage Mail Contents';
		
		 $data['pagelist']      	= $res_array; 	
		
				
		$this->load->view('mailcontent/mailcontents_list_index_view',$data); 
		
				
	}

	public function edit()
	{
			
		
		$data['ckeditor']  =  set_ck_config(array('textarea_id'=>'mail_content'));					
		$id = (int) $this->uri->segment(4);
		$res = $this->mailcontents_model->getmailcontents_by_id($id);				
		$data['heading_title'] = 'Mail Contents';
		$data['page_title'] = 'Edit Information';
		$data['pageresult'] = $res;
		
		
		if( is_object( $res ) )
		{ 	
			
				$this->form_validation->set_rules('email_subject', 'Mail Subject','trim|required|max_length[80]');
				$this->form_validation->set_rules('email_content', 'Mail Contents','trim|required|max_length[8500]');
								
				if ($this->form_validation->run() == TRUE)
				{
					
					 $posted_data = array(
						'email_subject'=>$this->input->post('email_subject',TRUE),
						'email_content'=>$this->input->post('email_content',TRUE),						
						'updated_on'=>$this->config->item('config.date.time')
						);
						
						$where = "id = '".$res->id."'"; 						
						$this->mailcontents_model->safe_update('wl_auto_respond_mails',$posted_data,$where,FALSE);	
						$this->session->set_userdata(array('msg_type'=>'success'));
						$this->session->set_flashdata('success',lang('successupdate'));				
						redirect('sitepanel/mailcontents/'.query_string(), ''); 					
					
				}	
				
			$this->load->view('mailcontent/mailcontents_edit_view',$data);
		}else
		{
			redirect('sitepanel/mailcontents','');
		}
	}
}
// End of controller