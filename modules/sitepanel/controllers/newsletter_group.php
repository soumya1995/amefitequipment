<?php
class Newsletter_group extends Admin_Controller {
	
	public $class_name="";

	public function __construct()
	{			
		parent::__construct();		
		  
		$this->load->model(array('newsletter_model','newsletter_group_model')); 
		
		$this->config->set_item('menu_highlight','newsletter');	 
	}

	public  function index($page = null)
	{
			
		$pagesize                =  (int) $this->input->get_post('pagesize');
		
		$config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		
		$offset                  =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		
		$base_url                =  current_url_query_string(array('filter'=>'result'),array('per_page'));
						
		$res_array 				 =  $this->newsletter_group_model->getallrecord($offset,$config['limit']);
		
		$config['total_rows']	 =  $this->newsletter_group_model->total_rec_found;		
				
		$data['page_links']      =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		
		$data['heading_title'] 		= 'Manage Newletter Group';
		
		$data['res'] 				= $res_array;	
		
		$this->load->view('newsletter_group/listing',$data);
	}	 

	public function change_status()
	{
		$this->newsletter_group_model->change_status();
		redirect('sitepanel/newsletter_group', '');
	}

	public function check_record()
	{
		$group_name = $this->db->escape_str($this->input->post('group_name'));
		$newsletter_groups_id     = $this->input->post('newsletter_groups_id');
		$cond=" AND group_name='".$group_name."'";
		
		if(strlen($newsletter_groups_id))
		$cond .=" AND newsletter_groups_id!='".$newsletter_groups_id."' AND status!='2'";
		
		if($this->newsletter_group_model->checkRecord($cond)>0){
			
			
			$this->form_validation->set_message('check_record','Record already exists...');
			return FALSE;
		}
	}

	public function add()
	{
		$data['heading_title'] = 'Add Newsletter Group ';
		
		$redirect_url=$this->input->post('refpage');
						
		$this->form_validation->set_rules('group_name','Group Name','trim|required|xss_clean|max_length[40]|callback_check_record');
		
		if($this->form_validation->run()==TRUE)
		{
			
			
			$posted_data = array('group_name'=>$this->input->post('group_name'),
			'groups_created_date'=>$this->config->item('config.date.time')			
			);
			
		    $this->newsletter_group_model->safe_insert('wl_newsletter_groups',$posted_data,FALSE);
		
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/newsletter_group','');	
						
		}else
		{
			
			$this->load->view('newsletter_group/add',$data);
		}
	}

	public function edit()
	{
		$data['heading_title'] = 'Edit Newsletter Group ';		
		
		$id = (int) $this->uri->segment(4);
		
	
		$rowdata=$this->newsletter_group_model->get_records_by_id($id);	
						
		if( is_object($rowdata) && !empty($rowdata) )
		{
			
			$this->form_validation->set_rules('group_name','Group Name',"trim|required|xss_clean|max_length[40]|callback_check_record");
			
			if($this->form_validation->run()==TRUE)
			{
				
				$posted_data = array(
				'group_name'=>$this->input->post('group_name',TRUE)
				);
				
				$where = "newsletter_groups_id = '".$rowdata->newsletter_groups_id."'"; 						
				$this->newsletter_model->safe_update('wl_newsletter_groups',$posted_data,$where,FALSE);					
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('successupdate'));
				redirect('sitepanel/newsletter_group/'.query_string(), '');
			}
			
		}else
		{
			redirect('sitepanel/newsletter_group/', '');
			
		}
		
		
		$data['catresult']=$rowdata;
		$this->load->view('newsletter_group/edit',$data);
		
	}
	
	public function send_mail()
	{
		$data['heading_title'] = 'Send Email';
		$data['ckeditor']      =  set_ck_config(array('textarea_id'=>'message'));
								
		$this->form_validation->set_rules('group_id','Group','trim|required');
		$this->form_validation->set_rules('subject','Subject','trim|required');
		$this->form_validation->set_rules('message','Message','trim|required|exclude_text[<br />]');
		
		if($this->form_validation->run()===true)
		{
				$this->load->library('email');
				$config['mailtype']="html";
				$this->email->initialize($config);
				
				$subject = $this->input->post('subject');
				$message = $this->input->post('message');
				$group_id  = (int) $this->input->post('group_id');
				$mail_to = explode(",",$this->newsletter_group_model->get_group_email($group_id) );
					
				  				
					$rwadmin=$this->newsletter_model->get_admin_email();							
					$this->email->from($rwadmin['admin_email'], $this->config->item('site_name'));
					
					if( is_array($mail_to) && !empty($mail_to))
					{
						foreach($mail_to as $to)
						{
							if($to!='')
							{
								$this->email->to($to);							
								$this->email->subject($subject);
								$this->email->message($message);							
								$this->email->send();
								//$this->email->print_debugger();
							}
												
						}
												
					}else
					{
						$this->session->set_userdata(array('msg_type'=>'success'));
				        $this->session->set_flashdata('success','Group have no subscribers');
						
					}				
				
				
				//Email send................
				
				
				 $this->session->set_userdata(array('msg_type'=>'success'));
				 $this->session->set_flashdata('success','Email has been sent successfully.');					
				 redirect('sitepanel/newsletter_group','');
								
		}
		$this->load->view('newsletter_group/send_mail',$data);	
	}
	
	
}
// End of controller