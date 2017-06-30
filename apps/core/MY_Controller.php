<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/* The MX_Controller class is autoloaded as required */
class MY_Controller extends CI_Controller
{

	public $spamwords = array();
	public $has_spamword;
	public $admin_info;
	public $meta_info;

	public function __construct()
	{
		ob_start();
		parent::__construct();
		
		$this->load->helper('seo/seo');
		$this->load->config('seo/config');
		$this->form_validation->set_error_delimiters("<div class='required'>","</div>");
		
		if($this->uri->segment(1)!='sitepanel')
		{
			$this->meta_info  = getMeta();
		}
		
		$this->db->select('admin_email, address, admin_type, phone, timings, cod_amount, tax, total_hits');
		$this->db->from('tbl_admin');
		$this->db->where('admin_id','1');
		$query = $this->db->get();
		if( $query->num_rows() > 0 )
		{
			$this->admin_info = $query->row();		
		}
		
		if($this->session->userdata("customer_type")=="0"){
			$this->mtype = 'buyer_';
		}
		if($this->session->userdata("customer_type")=="1"){
			$this->mtype = 'wholesaler_';
			$this->cart->destroy();
		}
		
		/*if($this->input->post('action')=="feedback"){
			$this->feedback();	
		}*/
		
		
	}
	
	public function fetch_spamwords()
	{
		if(is_array($this->spamwords) && empty($this->spamwords) )
		{
			
			$this->db->select('words');
			$this->db->where('status','1');
			$query=$this->db->get('tbl_spam_words');
			//echo $this->db->last_query();
			if($query->num_rows() > 0)
			{
				$this->spamwords=$query->result();
			}
		}
		return  $this->spamwords;
	}
	
	public function filter_spamwords($in_string)
	{
		$spam_words="";
		$res=$this->fetch_spamwords();
		$i=0;
		foreach($res as $val)
		{
			if( preg_match("/\b".$val->words."\b/i",$in_string) )
			{
				$spam_words.=$val->words.",";
			}
		}
		$spam_words=rtrim($spam_words,',');
		return  $spam_words;
	}
	
	public function has_spamwords($in_string)
	{
		$array = array_map('reset', $this->fetch_spamwords());
		$this->has_spamword=check_spam_words($array,$in_string);
		return  $this->has_spamword;
	}
	
	public function check_spamwords($str)
	{
		if($this->has_spamwords($str))
		{
			$this->form_validation->set_message("check_spamwords","The %s field contains some offensive words. Please remove them first. The Found Offensive Word(s): <b> ".$this->filter_spamwords($str)."</b>");
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	/*public function feedback(){
		$this->form_validation->set_rules('first_name','First Name','trim|alpha|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[80]');
		$this->form_validation->set_rules('phone_number','Phone','trim|max_length[15]');
		$this->form_validation->set_rules('mobile_number','Mobile Number','trim|required|max_length[15]');
		$this->form_validation->set_rules('address','Address','trim|required|max_length[150]');
		//$this->form_validation->set_rules('company_name','Company Name','trim');
		//$this->form_validation->set_rules('country','Country','trim');
		$this->form_validation->set_rules('message','Message','trim|required|max_length[2500]');
		//$this->form_validation->set_rules('verification_code','Verification code','trim|required|valid_captcha_code');			
		$data['page_error'] = "";

		if($this->form_validation->run()==TRUE)
		{
			
			$posted_data=array(
			'first_name'    => $this->input->post('first_name'),
			'last_name'     => '',
			'type'     => '2',
			'email'         => $this->input->post('email'),
			'phone_number'  => $this->input->post('phone_number'),
			'mobile_number'  => $this->input->post('mobile_number'),
			'company_name'  => '',
			'address'		=> $this->input->post('address'),
			'message'       => $this->input->post('message'),
			'receive_date'     =>$this->config->item('config.date.time')
			);

			$this->load->model('pages/pages_model');
			$this->pages_model->safe_insert('wl_enquiry',$posted_data,FALSE);

			// Send  mail to user

			$content    =  get_content('wl_auto_respond_mails','4');
			$subject    =  str_replace('{site_name}',$this->config->item('site_name'),$content->email_subject);
			$body       =  $content->email_content;

			$name = ucwords($this->input->post('first_name'));

			$body			=	str_replace('{mem_name}',$name,$body);
			$body			=	str_replace('{email}',$this->input->post('email'),$body);
			$body			=	str_replace('{phone}',$this->input->post('phone_number'),$body);
			$body			=	str_replace('{mobile}',$this->input->post('mobile_number'),$body);
			$body			=	str_replace('{address}',$this->input->post('address'),$body);
			$body			=	str_replace('{comments}',$this->input->post('message'),$body);
			$body			=	str_replace('{admin_email}',$this->admin_info->admin_email,$body);
			$body			=	str_replace('{site_name}',$this->config->item('site_name'),$body);			

			$mail_conf =  array(
			'subject'=>$subject,
			'to_email'=>$this->input->post('email'),
			'from_email'=>$this->admin_info->admin_email,
			'from_name'=> $this->config->item('site_name'),
			'body_part'=>$body
			);

			$this->load->library(array('Dmailer'));
			$this->dmailer->mail_notify($mail_conf);

			// End send  mail to user

			// Send  mail to admin

			$body       =  $content->email_content;

			$name = 'Admin';

			$body			=	str_replace('{mem_name}',$name,$body);
			$body			=	str_replace('{email}',$this->input->post('email'),$body);
			$body			=	str_replace('{phone}',$this->input->post('phone_number'),$body);
			$body			=	str_replace('{mobile}',$this->input->post('mobile_number'),$body);
			$body			=	str_replace('{address}',$this->input->post('address'),$body);
			$body			=	str_replace('{comments}',$this->input->post('message'),$body);
			$body			=	str_replace('{admin_email}',$this->admin_info->admin_email,$body);
			$body			=	str_replace('{site_name}',$this->config->item('site_name'),$body);

			$mail_conf =  array(
			'subject'=>$subject,
			'to_email'=>$this->admin_info->admin_email,
			'from_email'=>$this->admin_info->admin_email,
			'from_name'=> $this->config->item('site_name'),
			'body_part'=>$body
			);

			$this->dmailer->mail_notify($mail_conf);

			// End send  mail to admin
			
			$data['page_error'] = "";
			//$this->session->set_userdata(array('msg_type'=>'success'));
			//$this->session->set_userdata(array('msg_type_convs_request'=>'success_contect'));
			$this->session->set_flashdata('msg', 'Your feedback has been submitted successfully.');
			redirect('pages/thanks', '');

		}
		
	}*/

}