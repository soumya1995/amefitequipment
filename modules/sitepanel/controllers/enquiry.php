<?php
class Enquiry extends  Admin_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('sitepanel/enquiry_model'));
		$this->config->set_item('menu_highlight','other management');
	}

	public  function index()
	{
		$keyword                 =  trim($this->input->post('keyword',TRUE));
		$pagesize                =  (int) $this->input->get_post('pagesize');
		$config['limit']		  =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset                  =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url             =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$condition               =  "type ='3' ";
		$keyword                 = $this->db->escape_str( $keyword );

		if($keyword!='')
		{
			$condition.=" AND  ( email like '%$keyword%' OR  city like '%$keyword%' OR country like '%$keyword%'  OR CONCAT_WS(' ',first_name,last_name) LIKE '%".$keyword."%' ) ";
		}
		
		$res_array     = $this->enquiry_model->get_enquiry($offset,$config['limit'],$condition);
		$config['total_rows']	= $this->enquiry_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		
		if( $this->input->post('status_action')!='')
		{
			$this->update_status('wl_enquiry','id');
		}
		
		$data['heading_title']  = 'Manage Contact Us Inquiries';
		$data['inq_type']       = 'General';
		$data['res']            = $res_array;
		$this->load->view('enquiry/view_enquiry_list',$data);
		
	}
	
	public  function feedback()
	{
		$keyword                 =  trim($this->input->post('keyword',TRUE));
		$pagesize                =  (int) $this->input->get_post('pagesize');
		$config['limit']		  =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset                  =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url             =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$condition               =  "type ='2' ";
		$keyword                 = $this->db->escape_str( $keyword );
		
		if($keyword!='')
		{
			$condition.=" AND  ( email like '%$keyword%' OR  city like '%$keyword%' OR country like '%$keyword%'  OR CONCAT_WS(' ',first_name,last_name) LIKE '%".$keyword."%' ) ";
		}
		
		$res_array              = $this->enquiry_model->get_enquiry($offset,$config['limit'],$condition);
		$config['total_rows']	= $this->enquiry_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);

		if( $this->input->post('status_action')!='')
		{
			$this->update_status('wl_enquiry','id');
		}
		
		$data['heading_title']  = 'Manage Feedback';
		$data['inq_type']       = 'feedback';
		$data['res']            = $res_array;
		$this->load->view('enquiry/view_enquiry_list',$data);

	}

	public function send_reply()
	{
		$rid =  (int) $this->uri->segment(4);
		$this->db->select("*,CONCAT_WS(' ',first_name,last_name) AS name",FALSE);
		$res_data =  $this->db->get_where('wl_enquiry', array('id' =>$rid))->row();
	    $this->load->library('email');

		if( is_object( $res_data ) )
		{
			$this->form_validation->set_rules('subject', 'Subject', 'required|xss_clean');
			$this->form_validation->set_rules('message', 'Message', 'required|xss_clean');

			if ($this->form_validation->run() == TRUE)
			{
				/* Reply  mail to user */

				$this->enquiry_model->safe_update('wl_enquiry',array('reply_status' =>"Y"),"id ='".$rid."'");

				$mail_to      = $res_data->email;
				$mail_subject = $this->input->post('subject');
				$from_email   = $this->admin_info->admin_email;
				$from_name    =  $this->config->item('site_name');
				$body = "Dear ".$res_data->name.",<br /><br />	";
				$body .= $this->input->post('message');
				$body .= "<br /> <br />Thanks and Regards,<br />".$this->config->item('site_name')." Team ";
				
				$this->email->from($from_email,$from_name);
				$this->email->to($mail_to);
				$this->email->subject($mail_subject);
				$this->email->message($body);
				$this->email->set_mailtype('html');
				$this->email->send();
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('admin_mail_msg'));

				redirect('sitepanel/enquiry/send_reply/'.$res_data->id, '');

				/* End reply mail to user */
			}
			
			$data['heading_title'] = "Send Reply";
			$this->load->view('enquiry/view_send_enq_reply',$data);
			
		}else
		{
			redirect('sitepanel/enquiry/','');
		}
		
	}

}
// End of controller