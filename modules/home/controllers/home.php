<?php
class Home extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('home/home_model','products/product_model','category/category_model','brand/brand_model','testimonials/testimonial_model'));
		$this->load->helper(array('category/category','products/product'));
		//create_listing_page_meta();
	}

	public function index()
	{

		$data['page_title']            = "";
		$data['page_keyword']          = "";
		$data['page_description']      = "";
		$offset                 =  $this->uri->segment(2,0);
		$cat_limit = 11;
		$product_limit_featured = 6;	
		$product_limit_new = 4;	
		$product_limit_hot = 4;		

		$condtion_array = array(
		'field' =>"*,( SELECT COUNT(category_id) FROM wl_categories AS b
		WHERE b.parent_id=a.category_id ) AS total_subcategories",
		'condition'=>"AND parent_id = '0' AND status='1' AND is_fetaured='1' ",
		'limit'=>$cat_limit,
		'order'=>'sort_order',
		'offset'=>0,
		'debug'=>FALSE
		);

		$featured_cat_res  = $this->category_model->getcategory($condtion_array);
		$data['total_cat_found']	=  $this->category_model->total_rec_found;		
		
		$content = get_db_field_value('wl_cms_pages','page_description'," AND friendly_url='about-us' AND status='1'");
		$data['content']       = $content;
		
		$cond_new_product = array('status'=>'1','where'=>"new_arrival ='1' AND status='1'",'orderby'=>'rand()');
		$new_product=$this->product_model->get_products($product_limit_new,0,$cond_new_product);
		$data['total_new_product'] = get_found_rows();	
		$data['new_product']       = $new_product;
		
		$cond_hot_product = array('status'=>'1','where'=>"hot_product ='1' AND status='1'",'orderby'=>'rand()');
		$hot_product=$this->product_model->get_products($product_limit_hot,0,$cond_hot_product);
		$data['total_hot_product'] = get_found_rows();	
		$data['hot_product']       = $hot_product;
		
		$cond_featured_product = array('status'=>'1','where'=>"featured_product ='1' AND status='1'",'orderby'=>'rand()');
		$featured_product=$this->product_model->get_products($product_limit_featured,0,$cond_featured_product);
		$data['total_featured_product'] = get_found_rows();	
		$data['featured_product']       = $featured_product;
		
		$param= array('status'=>'1','order'=>'rand()');		
		$brand_res              = $this->brand_model->getbrands($param,0,4);		
		$data['total_brand']	= get_found_rows();
		$data['brand_res']       = $brand_res;
		
		$tparam = array('status'=>'1','orderby'=>'rand()');
		$tres_array              = $this->testimonial_model->get_testimonial('1',0,$tparam);	
		$data['tres_array']       = $tres_array;

		$this->load->view('home',$data);
	}
	
	public function keyword_suggestions(){
			
			$inputString = trim($this->input->post('mysearchString'));
			
			if($inputString!=""){
				$param = array();
				$data = array();
				$param['fields'] = "wlp.product_name";
				$param['where'] = "wlp.product_name LIKE '%".$inputString."%' ";				
				$result = $this->product_model->get_products(20,0,$param);
				//$result=$this->db->query("SELECT wlp.city_location FROM property_id WHERE wlp.city_location LIKE '%".$inputString."%' AND status='1' group by wlp.city_location ");
				$data['result'] = $result;				
			}			
				
		$this->load->view('home/keyword_suggestions',$data);
	}
	
	public function getstate(){
	
		  	$country_id=$_POST['country_id'];
		  	$selCountryID = (int) $country_id;
		
			$query=$this->db->query("SELECT id FROM wl_state WHERE country_id=".$country_id." AND status='1' ");
			$row_founds = $query->num_rows();
			
			if($row_founds > 0){
				$state_array=array('name'=>'shipping_state','id'=>'shipping_state','country_id'=>$country_id,'format'=>'class="form-control changeable" style="" onchange=getcity(this.value,"home/getcity");','default_text'=>'Select State','current_selected_val'=>$this->input->post('shipping_state'));
				echo StateSelectBox($state_array); 
			}else{
				echo '<div class="required" style="margin:10px;"> No Record Found!</div>';
			}
	}
	
	public function getcity(){
	
		  	$state_id=$_POST['state_id'];
		  	$selStateID = (int) $state_id;
		
			$query=$this->db->query("SELECT id FROM wl_city WHERE region_id=".$state_id." AND status='1' ");
			$row_founds = $query->num_rows();
			
			if($row_founds > 0){
				$city_array=array('name'=>'shipping_city','id'=>'shipping_city','state_id'=>$state_id,'format'=>' class="form-control changeable" style="" ','default_text'=>'Select City','current_selected_val'=>$this->input->post('shipping_city'));
				echo CitySelectBox($city_array); 
			}else{
				echo '<div class="required" style="margin:10px;"> No Record Found!</div>';
			}
	} 
	

}