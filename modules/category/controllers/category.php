<?php
class Category extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('category/category'));
		$this->load->model(array('category/category_model','products/product_model'));

	}

	public function index(){
		@$category_id     = (int) $this->meta_info['entity_id'];
		$have_sub_cat    = get_db_field_value('wl_categories','parent_id'," AND parent_id = '$category_id' ");

		if( $category_id  > 0 ){
			if( $have_sub_cat > 0 || $this->uri->rsegment(3)=="featured"){
			  $this->category_listing($category_id);
			}else{
			  $this->products_listing($category_id);
			}
		}else{
		  $this->category_listing($category_id);
		}
	}

	public function category_listing(){
		
		$data['title'] = "Category";
		$page_title = 'Categories';
		//$record_per_page        = (int) $this->input->post('per_page');
		$record_per_page        = (int) $this->input->post('per_page')? $this->input->post('per_page'): $this->config->item('per_page');
		if(array_key_exists('entity_id',$this->meta_info) && $this->meta_info['entity_id'] > 0 ){
			$parent_segment         = (int) $this->meta_info['entity_id'];
		}else{
			$parent_segment     = (int) $this->uri->segment(3);
		}

		$parentdata='';
		if($parent_segment>0){
			$parentdata = get_db_single_row('wl_categories','*'," AND category_id='$parent_segment'");
			$page_title = $parentdata['category_name'];
		}

		$page_segment           = find_paging_segment();
		$config['per_page']		= ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
		$offset                 = (int) $this->input->post('offset');
		$parent_id              = ( $parent_segment > 0 ) ?  $parent_segment : '0';
		$base_url               = ( $parent_segment > 0 ) ?  "category/category_listing/$parent_id/pg/" : "category/category_listing/pg/";

		$condition = "";
		
		if($this->uri->rsegment(3)=="featured"){
			$condition = "AND is_fetaured = '1'";
			$page_title = 'Featured Categories';
		}
		
		$condtion_array = array(
		'field' =>"*,( SELECT COUNT(category_id) FROM wl_categories AS b
		WHERE b.parent_id=a.category_id ) AS total_subcategories",
		'condition'=>"AND parent_id = '$parent_id' AND status='1' ".$condition,
		'limit'=>$config['per_page'],
		'offset'=>$offset	,
		'debug'=>FALSE
		);
		

		$res_array              =  $this->category_model->getcategory($condtion_array);
		$config['total_rows'] = $data['totalProduct']	=  $this->category_model->total_rec_found;
		$data['frm_url'] = $base_url;
		
		$data['record_per_page'] = $record_per_page;
		$data['heading_title'] = $page_title;
		$data['res'] = $res_array;
		$data['cat_id']=$parent_segment;
		$data['parentres']=$parentdata;
		//$data['parentres']=isset($parentdata) && is_object($parentdata) ? $parentdata : "";

		$data['unq_section'] = isset($parentdata) && is_object($parentdata) ? "Subcategory" : "Category";

		if($this->input->is_ajax_request()){
			$this->load->view('category/category_data',$data);
		}else{
			$this->load->view('category/view_category',$data);
		}
	}

	public function products_listing($category_id){

		$this->page_section_ct = 'product';
		$mtype=$this->mtype;
		$condtion               = array();
		$cat_res = '';
	  	$record_per_page        = (int) $this->input->post('per_page')? $this->input->post('per_page'): $this->config->item('per_page');
		$category_id            = (int) $category_id;
		$page_segment           = find_paging_segment();
		$config['per_page']		= $record_per_page ;
		$offset                 = (int) $this->input->post('offset');
		$base_url      = ( $category_id!='' ) ?   "category/products_listing/$category_id/pg/" : "category/products_listing/pg/";	
		
		$orderby_price=	$this->input->get_post('order_by_price');
		
		$condtion['status']     = '1';		
		
		$product_discounted_price	=	$mtype."product_discounted_price";
		$product_price				=	$mtype."product_price";
		
		if(!empty($orderby_price)){	 	
			$condtion['orderby']     = 'IF(wlp.'.$product_discounted_price.' > 0, wlp.'.$product_discounted_price.' ,wlp.'.$product_price.' ) '.$orderby_price;						
		}
		
		$page_title             = "Product Lists";
		if( $category_id > 0 ){ 
			$condtion['category_id'] = $category_id;
			$cat_res = get_db_single_row('wl_categories','*'," AND category_id='$category_id'");
			$page_title = $cat_res['category_name'];
		}
		
		$res_array               =  $this->product_model->get_products($config['per_page'],$offset,$condtion);
		$config['total_rows'] = $data['totalProduct']	=  get_found_rows();
	  	//$data['page_links']    = front_pagination("$base_url",$config['total_rows'],$config['per_page'],$page_segment);
	  	$data['record_per_page'] = $record_per_page;
		$data['heading_title'] = $page_title;
		$data['res']           = $res_array;
		$data['cat_res'] = $cat_res;		
		$data['frm_url'] = $base_url;
		if($this->input->is_ajax_request()){
			$this->load->view('products/product_data',$data);
		}else{
			$this->load->view('products/view_product_listing',$data);
		}
	}
	
	public function show_category(){
		$category_id=($this->input->post("category_id"))?$this->input->post("category_id"):"-1";
		if($category_id > 0){
			$condtion_array = array(
			'field' =>"category_id, category_name,( SELECT COUNT(category_id) FROM wl_categories AS b
			WHERE b.parent_id=a.category_id ) AS total_subcategories",
			'condition'=>"AND parent_id = '$category_id' AND status='1' ",
			'debug'=>FALSE
			);

			$res_array              =  $this->category_model->getcategory($condtion_array);

			$drop_down='			<option value="">Select Sub-category</option>';
			if(is_array($res_array) && !empty($res_array)){
				foreach($res_array as $val){
					$drop_down.='<option value="'.$val['category_id'].'">'.$val['category_name'].'</option>';
				}
			}
			echo $drop_down;
		}

	}

}
/* End of file member.php */
/* Location: .application/modules/products/controllers/products.php */
