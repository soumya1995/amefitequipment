<?php
Class Seo extends CI_Controller
{
	public function __construct()
	{
		ob_start();
	    parent::__construct(); 
		$this->load->helper(array('xml','seo/seo'));		 		
		
	}		

     public  function sitemap()
     {

        $data['result'] = array('url'=>"http://localhost/hundia_ecommerce/contactus");
		header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view("seo/sitemap",$data);
     }
	 
	 public function rss_feed()
	 {
		
		    $data['encoding'] = 'utf-8';
	        $data['feed_name'] = 'www.xyz.com';
	        $data['feed_url'] = 'http://www.xyz.com';
	        $data['page_description'] = 'Welcome to www.xyz.com feed page';
	        $data['page_language'] = 'en-us';
	        $data['creator_email'] = 'abc@gmail.com';
						
	        $data['result'] = array('0'=>array(
						'title'=>'Create Feed Controller',			
						'url'=>"http://localhost/hundia_ecommerce/contactus",
						'description'=>"Create Feed Controller Create Feed ControllerCreate Feed ControllerCreate Feed ControllerCreate Feed ControllerCreate Feed Controller"
						
				)
	        );	
				
		    header("Content-Type: application/rss+xml");
	        $this->load->view('rss', $data);
		
	}
	
	public function create_seo_url()
	{
	  $msg_arr = array();
	  $rec_id = (int) $this->input->post('rec_id');
	  $pg_title = $this->input->post('title',TRUE);
	  $pg_title = str_replace(base_url(),"",$pg_title);
	  $pre_title = $this->input->post('pre_title',TRUE);
	  $pre_title = str_replace(base_url(),"",$pre_title);
	  $pg_title = seo_url_title($pg_title);
	  
	  if($pre_title!=''){
		  
		$friendly_url = $pre_title.$pg_title;
	  }
	  else
	  {
		$friendly_url = $pg_title;
	  }
	  $this->db->select('meta_id');
	  $this->db->from('wl_meta_tags');
	  $this->db->where('page_url',$friendly_url);
	  if($rec_id > 0)
	  {
		$this->db->where('entity_id !=',$rec_id);
	  }
	  $meta_qry = $this->db->get();

	  if($meta_qry->num_rows() > 0)
	  {
		  $msg_arr['error'] = 1;
		  $msg_arr['msg'] = 'URL already exists';
	  }
	  else
	  {
		$msg_arr['error'] = 0;
		$msg_arr['msg'] = 'URL passed';
	  }
	  $msg_arr['friendly_name'] = $pg_title;
	  echo json_encode($msg_arr);
	}
	
	
}