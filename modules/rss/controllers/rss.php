<?php
class Rss extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();				
		$this->load->model(array('rss/rss_model'));
		$this->load->helper(array('rss/rss'));	 
		
	}
	
	public function index()
	{
		
		$data['page_title']            = "Rss Feed";
		
		$base_url = base_url();
		$data['encoding'] = 'utf-8';
		$data['feed_name'] = $base_url;
		$data['feed_url'] = $base_url;
		$data['page_description'] = 'Welcome to '.$base_url.' feed page';
		$data['page_language'] = 'en-us';
		$data['creator_email'] = 'info@alexdaisy.com';

			$result = array();

			$rwcont = $this->db->query("SELECT category_id,category_name,category_description,friendly_url FROM wl_categories WHERE status ='1' LIMIT 0 , 200")->result_array();
			
			//$link_url=base_url()."product/detail/".url_title($res[$i]['product_name'],'dash',true)."/".$res[$i]['products_id'];

			if(is_array($rwcont) && count($rwcont) > 0 )
			{
			
				foreach($rwcont as $contVal)
				{
				
					$reclink = $contVal['friendly_url'];
					//$reclink = base_url()."product/detail/".url_title($contVal['product_name'],'dash',true)."/".$contVal['products_id'];
					
					
					//$reclink = base_url().$contVal['friendly_url'];
					//$reclink = base_url();
					$result[] = array(
										'title'=>$contVal['category_name'],															'url'=>$reclink,
										'description'=>$contVal['category_description']
									 );
				}
			}
			
			$rwcont = $this->db->query("SELECT products_id,product_name,products_description,friendly_url FROM wl_products WHERE status ='1' LIMIT 0 , 200")->result_array();
			
			//$link_url=base_url()."product/detail/".url_title($res[$i]['product_name'],'dash',true)."/".$res[$i]['products_id'];

			if(is_array($rwcont) && count($rwcont) > 0 )
			{
			
				foreach($rwcont as $contVal)
				{
				
					$reclink = $contVal['friendly_url'];
					
					$result[] = array(
										'title'=>$contVal['product_name'],															'url'=>$reclink,
										'description'=>$contVal['products_description']
									 );
				}
			}
			
			


						
	        $data['result'] = $result;
				
		    header("Content-Type: application/rss+xml");
		
		$this->load->view('rss',$data);	
	}

}