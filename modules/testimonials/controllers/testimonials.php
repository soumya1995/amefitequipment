<?php
class Testimonials extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('testimonials/testimonial_model'));
		$this->form_validation->set_error_delimiters("<div class='required'>","</div>");
		
		$this->page_section_ct = 'testimonial';
	}

	public function index()
	{
		$record_per_page        = (int) $this->input->post('per_page')? $this->input->post('per_page'): $this->config->item('per_page');
		if(array_key_exists('entity_id',$this->meta_info) && $this->meta_info['entity_id'] > 0 ){
			$parent_segment         = (int) $this->meta_info['entity_id'];
		}else{
			$parent_segment     = (int) $this->uri->segment(3);
		}	
		$config['per_page']		= ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
		$offset                 = (int) $this->input->post('offset');
		$parent_id              = ( $parent_segment > 0 ) ?  $parent_segment : '0';
		$base_url               = ( $parent_segment > 0 ) ?  "testimonials/index/pg/" : "testimonials/index/pg/";
				
		$param= array('status'=>'1');	
		$res_array              = $this->testimonial_model->get_testimonial($config['per_page'],$offset,$param);
		$config['total_rows'] = $data['totalProduct']	=  get_found_rows();
		$data['frm_url'] = $base_url;			
		$data['res'] = $res_array;	
		
		if($this->input->is_ajax_request())
		{
			$this->load->view('testimonials/testimonial_data',$data);
		}
		else
		{
			$this->load->view('testimonials/view_testimonials',$data);
		}		
	}

	public function post()
	{
		
		//$this->form_validation->set_rules('testimonial_title','Title','trim|required|xss_clean|max_length[150]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[80]');
		$this->form_validation->set_rules('poster_name','Name','trim|required|alpha|xss_clean|max_length[30]');
		$this->form_validation->set_rules('testimonial_description','Description','trim|required|xss_clean|max_length[2500]');
		$this->form_validation->set_rules('verification_code','Verification code','trim|required|valid_captcha_code');
		
		if($this->form_validation->run()==TRUE)
		{
			
			$posted_data=array(
			'testimonial_title'      => "",
			'poster_name'             => $this->input->post('poster_name'),
			'email'                   => $this->input->post('email'),
			'testimonial_description' => $this->input->post('testimonial_description'),
			'posted_date'            =>$this->config->item('config.date.time')
			);
			$testimonialid=$this->testimonial_model->safe_insert('wl_testimonial',$posted_data,FALSE);

			$posted_friendly_url = $this->input->post('poster_name').'-'.$testimonialid;
			$this->cbk_friendly_url = seo_url_title($posted_friendly_url);
			
			$posted_data_update=array(
			'friendly_url'      => $this->cbk_friendly_url
			);
			
			$where = "testimonial_id = '".$testimonialid."'";
			$this->testimonial_model->safe_update('wl_testimonial',$posted_data_update,$where,FALSE);

			$redirect_url = "testimonials/details";
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
			$message = str_replace('<site_name>',$this->config->item('site_name'),$message);
			
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',$message);
			
			redirect('testimonials/post', '');
		}
		$this->load->view('testimonials/view_post_testimonials');
	}

	public function details()
	{
		$id = (int) $this->uri->rsegment(3);
		$param     = array('status'=>'1','where'=>"testimonial_id ='$id' ");
		$res       = $this->testimonial_model->get_testimonial(1,0,$param);

		if(is_array($res) && !empty($res))
		{
			$data['title'] = 'Testimonials';
			$data['res'] = $res;
			$this->load->view('testimonials/testimonials_details_view',$data);
		}else
		{
			redirect('testimonials', '');
		}

	}


}

/* End of file pages.php */
?>