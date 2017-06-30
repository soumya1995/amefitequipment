<?php
class Products extends Public_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('category/category_model','products/product_model','members/members_model','brand/brand_model','cart/cart_model','warranty/warranty_model'));
		$this->load->helper(array('products/product','category/category','cart/cart','query_string'));
		$this->load->library(array('Dmailer'));
		$this->form_validation->set_error_delimiters("<div class='required'>","</div>");
	}

	public function index(){
	
		$this->page_section_ct = 'product';
		$mtype=$this->mtype;
		$condition               = array();
		$cat_res = '';
		//$record_per_page        = (int) $this->input->post('per_page');
		$record_per_page        = (int) $this->input->post('per_page')? $this->input->post('per_page'): $this->config->item('per_page');
		$category_id            =  (int) $this->uri->rsegment(3)?$this->uri->rsegment(3):$this->input->post('category_id');
		$page_segment           = find_paging_segment();
		$config['per_page']		= ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');		
		$offset                 = (int) $this->input->post('offset');
		$base_url      = ( $category_id!='' ) ?   "products/index/$category_id/pg/" : "products/index/pg/";

		$orderby_price=	$this->input->get_post('order_by_price');

		$condition['status']     = '1';		
		//$condition['orderby']     = 'products_id asc';
		
		$product_discounted_price	=	$mtype."product_discounted_price";
		$product_price				=	$mtype."product_price";
		
		if(!empty($orderby_price)){	 	
			$condition['orderby']     = 'IF(wlp.'.$product_discounted_price.' > 0, wlp.'.$product_discounted_price.' ,wlp.'.$product_price.' ) '.$orderby_price;						
		}
		
		$page_title             = "Product Lists";
				
		if($this->uri->rsegment(3)=="featured"){
			$condition['where'].= " AND featured_product = '1'";
			$page_title = 'Featured Products';
		}
		
		if($this->uri->rsegment(3)=="newarrival"){
			$condition['where'].= " AND new_arrival = '1'";
			$page_title = 'New Arrivals';
		}
		
		if($this->uri->rsegment(3)=="hotproducts"){
			$condition['where'].= " AND hot_product = '1'";
			$page_title = 'Hot Products';
		}

		if( $category_id > 0 ){ 
			$condition['category_id'] = $category_id;
			$cat_res = get_db_single_row('wl_categories','*'," AND category_id='$category_id'");
			$page_title = $cat_res['category_name'];
		}
		
		$res_array               =  $this->product_model->get_products($config['per_page'],$offset,$condition);
		//echo_sql();
		$config['total_rows'] = $data['totalProduct']	=  get_found_rows();

	  	$data['frm_url'] = $base_url;
		//$data['page_links']    = front_pagination("$base_url",$config['total_rows'],$config['per_page'],$page_segment);
		$data['record_per_page'] = $record_per_page;
		$data['heading_title'] = $page_title;
		$data['res']           = $res_array;
		$data['cat_res'] = $cat_res;
		
		if($this->input->is_ajax_request()){
			$this->load->view('products/product_data',$data);
		}else{
			$this->load->view('products/view_product_listing',$data);
		}
	}
	
	public function search(){

		$this->page_section_ct = 'search';
		$mtype=$this->mtype;
		$curr_symbol = display_symbol();
		$condition               = array();
		$where                   = "wlp.status ='1'";
		$cat_res = '';
		$page_segment           = 3;
		//$record_per_page=$this->input->post("per_page");
		$record_per_page        = (int) $this->input->post('per_page')? $this->input->post('per_page'): $this->config->item('per_page');
		$config['limit']		= ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
		//$offset                 = (int) $this->uri->segment($page_segment,0);
		$offset                 = (int) $this->input->post('offset');
		$base_url      =  "products/search/";

		$category_id     = (int) $this->input->get_post('category_id',TRUE);
		$keyword			=   trim($this->input->get_post('keyword',TRUE));
		$keyword			=   $this->db->escape_str($keyword);
		
		$new_arrival                 =  $this->input->get_post('new_arrival',TRUE);
		$featured_product                 =  $this->input->get_post('featured_product',TRUE);
		$hot_product                 =  $this->input->get_post('hot_product',TRUE);
		$offered_product                 =  $this->input->get_post('offered_product',TRUE);
		
		$product_brand                 =  $this->input->get_post('product_brand',TRUE);
		$is_coming_soon                 =  $this->input->get_post('is_coming_soon',TRUE);
		
		$prange                 =  $this->input->get_post('amount',TRUE);					
		$prange = str_replace("$curr_symbol","",$prange);
		$availability                 =  $this->input->get_post('availability',TRUE);

		
		$orderby_price=	$this->input->get_post('order_by_price');
		//$condition['orderby']     = 'products_id asc';
		
		$product_discounted_price	=	$mtype."product_discounted_price";
		$product_price				=	$mtype."product_price";
		
		$data['heading_title']    = "Search Result";
		
		if(!empty($orderby_price)){	 	
			$condition['orderby']     = 'IF(wlp.'.$product_discounted_price.' > 0, wlp.'.$product_discounted_price.' ,wlp.'.$product_price.' ) '.$orderby_price;						
		}
		
		if($category_id!='' ){
			$condition['category_id'] = $category_id;
		  	$where.=" AND FIND_IN_SET( '".$category_id."',wlp.category_links )";
		}
		if($is_coming_soon){
			$data['heading_title']    = "Coming Soon";
			$condition['is_coming_soon'] = $is_coming_soon;
		  	$where.=" AND wlp.is_coming_soon = '".$is_coming_soon."'";
		}
		if($new_arrival){
			$data['heading_title']    = "New Arrivals";
			$condition['new_arrival'] = $new_arrival;
		  	$where.=" AND wlp.new_arrival = '".$new_arrival."'";
		}
		if($featured_product){
			$data['heading_title']    = "Featured Products";
			$condition['featured_product'] = $featured_product;
		  	$where.=" AND wlp.featured_product = '".$featured_product."'";
		}
		if($hot_product){
			$data['heading_title']    = "Hot Products";
			$condition['hot_product'] = $hot_product;
		  	$where.=" AND wlp.hot_product = '".$hot_product."'";
		}
		if($offered_product){
			$data['heading_title']    = "Offered Product";
			$condition['offered_product'] = $offered_product;
		  	$where.=" AND wlp.offered_product = '".$offered_product."'";
		}
		if($product_brand){
			$data['heading_title']    = "Search by Brand";
			$condition['product_brand'] = $product_brand;
		  	$where.=" AND wlp.product_brand = '".$product_brand."'";
		}
			
		if($prange!='' ){
			if(strstr($prange,"-")){
				
				$arr_price=explode("-",$prange);
				$min_price_range = trim($arr_price[0]);
				$max_price_range = trim($arr_price[1]);
				if(is_numeric($min_price_range)){
					$where.=" AND ( IF(wlp.product_discounted_price>0 , wlp.product_discounted_price,wlp.product_price) >='".$min_price_range."' ) ";
				}
				if(is_numeric($max_price_range)){
					$where.=" AND ( IF(wlp.product_discounted_price>0 , wlp.product_discounted_price,wlp.product_price) <='".$max_price_range."' ) ";
				}
			}elseif( strstr($prange,">" )){
				$arr_price=explode(">",$prange);
				if(is_numeric($arr_price[1])){
					$where.=" AND ( IF(wlp.product_discounted_price>=0, wlp.product_discounted_price,wlp.product_price) >='".$arr_price[1]."' ) ";
				}
			}elseif(strstr($prange,"&lt;")){
				$arr_price=explode("&lt;",$prange);
				if(is_numeric($arr_price[1])){
					$where.=" AND ( IF(wlp.product_discounted_price>0 , wlp.product_discounted_price,wlp.product_price) <='".$arr_price[1]."' ) ";
				}
			}
		}
		
		if($keyword){
			$condition['keyword'] = $keyword;
			$where.=" AND (wlp.product_name LIKE '%".$keyword."%' OR  wlp.product_code LIKE '%".$keyword."%')";
		}
		
		$where.=' AND is_verified ="1" ';
		$condition['where'] = $where;
		$res_array                =  $this->product_model->get_products($config['limit'],$offset,$condition);
		/*echo_sql();
		exit;*/
		$config['total_rows'] = $data['totalProduct']	=  get_found_rows();
		$data['res']              =  $res_array;
		//$data['page_links']       =  front_pagination($base_url,$config['total_rows'],$config['limit'],$page_segment);
		$data['record_per_page'] = $record_per_page;
		
		$data['cat_res'] = '';
		$data['frm_url'] = $base_url;
		if($this->input->is_ajax_request()){
			$this->load->view('products/product_data',$data);
		}else{
			$this->load->view('products/view_product_listing',$data);
		}
		//$this->load->view('products/view_product_listing',$data);
	}
	
	public function check_product_exits_into_cart($pres){
		
		$prod_size=(int) $this->input->post('prod_size');
		$prod_color=(int) $this->input->post('prod_color');		
		
		$cart_array =  $this->cart->contents();
		
		$insert_flag=FALSE;
		if( is_array( $cart_array ) && !empty($cart_array))
		{
			foreach($this->cart->contents() as $item )
			{
				if(array_key_exists('pid' ,$item ))
				{
					if( $item['pid']==$pres['products_id'])
					{						
						if(($prod_size !="" && array_key_exists("size_id",$item['options'])) && ($prod_color !="" && array_key_exists("color_id",$item['options'])) ){
							if(($prod_size==$item['options']["size_id"]) && ($prod_color==$item['options']["color_id"])){
								$insert_flag=TRUE;
							}
						}
					}
				}
			}
		}

		return $insert_flag;
	}
	
	public function quickview(){
		
		$data['unq_section'] = "Product";
		$productId = (int) $this->uri->rsegment(3);
		$option = array('productid'=>$productId);
			
		$option["where"]="`wlp`.`status` = '1'";

		$res =  $this->product_model->get_products(1,0,$option);
		
		if(is_array($res)&& !empty($res) ){			
			
			$data['title'] = "Products";
			$data['res']       = $res;
			$media_res         = $this->product_model->get_product_media(4,0,array('productid'=>$res['products_id']));
			$data['media_res'] = $media_res;			
			
			$weight_name=get_db_field_value("wl_weights","weight_name"," AND weight_id='".$res['weight_id']."'");
			$data['weight_name']       = $weight_name;
			
			$this->load->view('products/view_quickview',$data);

		}else
		{
			redirect('category', '');
		}

	}

	public function detail(){
		
		$this->meta_info['entity_id'];
		$this->page_section_ct = 'product';
		$data['unq_section'] = "Product";
		$productId = (int) $this->uri->rsegment(3);
		$option = array('productid'=>$productId);			
		$option["where"]="`wlp`.`status` = '1' AND wlp.product_stock > '0'";
		$res =  $this->product_model->get_products(1,0,$option);

		/*$record_per_page        = (int) $this->input->post('per_page');
		$parent_segment         = (int) $this->uri->segment(3);
		$page_segment           = find_paging_segment();		
		$config['per_page']		= ( $record_per_page > 0 ) ? $record_per_page  : 4;
		$offset                 =  (int) $this->uri->segment($page_segment,0);			
		$parent_id              = ( $parent_segment > 0 ) ?  $parent_segment : '0';			
		$base_url               = ( $parent_segment > 0 ) ?  "products/detail/$productId/pg/" : "products/detail/$productId/pg/";*/
		////////////////////
		$record_per_page        = (int) $this->input->post('per_page');
		$parent_segment         = (int) $this->uri->segment(3);
		$page_segment           = find_paging_segment();
		$config['per_page']		= ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
		$offset                 =  (int) $this->uri->segment($page_segment,0);
		$parent_id              = ( $parent_segment > 0 ) ?  $parent_segment : '0';
		$base_url               = ( $parent_segment > 0 ) ?  "products/detail/$productId/pg/" : "products/detail/$productId/pg/";
		
		
		if(is_array($res)&& !empty($res) ){			
			
			$data['title'] = "Products";
			$data['res']       = $res;
			
			$media_res         = $this->product_model->get_product_media(4,0,array('productid'=>$res['products_id']));
			$related_products         = $this->product_model->related_products($res['products_id'],4,0);
			
			$data['media_res'] = $media_res;
			$data['related_products'] = $related_products;
			
			$param = array('where'=>"status ='1' AND prod_id ='$productId'");
			$res_array   = $this->product_model->get_product_review($config['per_page'],$offset,$param);	
			$total_reviews =  $this->product_model->get_total_review($param);	
			$config['total_rows']	 = get_found_rows();	
								
			$data['page_links']      = front_pagination("$base_url",$config['total_rows'],$config['per_page'],$page_segment);			
			$data['total_reviews']=$total_reviews;	
			$data['review_res']           = 	$res_array;	
			
			if($this->input->post('button',TRUE)=='Post'){
				
					$this->form_validation->set_rules('name','Name','trim|alpha|required|max_length[30]');
					//$this->form_validation->set_rules('product_id','','');
					$this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[80]');	
					$this->form_validation->set_rules('comments','Comments','trim|required|xss_clean|max_length[15000]');
					$this->form_validation->set_rules('verification_code','Verification code','trim|required|valid_captcha_code');
					
					}
					if($this->form_validation->run()==TRUE){	
						
						$product_id = (int) $this->uri->rsegment(3);								
							$posted_data=array(				
							'prod_id'=>$product_id,
							'mem_id'=>$this->input->post('mem_id',TRUE),
							'poster_name'=>$this->input->post('name',TRUE),
							'email'=>$this->input->post('email',TRUE),								
							'comment' =>$this->input->post('comments',TRUE),
							'status'=>'0',						
							'posted_date'  =>$this->config->item('config.date.time')
							);	
									
							$this->product_model->safe_insert('wl_review',$posted_data,FALSE); 
							$this->session->set_userdata(array('msg_type'=>'success')); 
							$this->session->set_flashdata('success', 'Your Review has been posted successfully. We will get back to you soon.');
							redirect($res['friendly_url']."#reviews");
					}
						
			$this->load->view('products/view_product_details',$data);

		}else
		{
			$this->session->set_userdata(array('msg_type' => 'info'));
      		$this->session->set_flashdata('info', 'This Product is sold out, please try again.');
			redirect('category', '');
		}

	}
	
	public function download_pdf(){
		$pdfId=(int)$this->uri->segment(3,0);
		$pId=(int)$this->uri->segment(4,0);
		
		if($pId > 0 && $pdfId > 0){
			
			$pdf_name='product_pdf'.$pdfId;
			$file=get_db_field_value('wl_products', $pdf_name, array("products_id"=>$pId));
			if($file !="" && @file_exists(UPLOAD_DIR."/pdf/".$file)){
				$this->load->helper('download');
				$data = file_get_contents(UPLOAD_DIR."/pdf/".$file);
				$name = $file;
				force_download($name, $data);
			}else{
				redirect('sitepanel', '');
			}
		}else{
			redirect('sitepanel', '');
		}
	}
	
	public function add_amount(){
			
		$warranty_id	=	$this->input->post('warranty_id',TRUE);
		$productId	=	 $this->input->post('productId',TRUE);
		$service_type	=	$this->input->post('service_type',TRUE);
		$type	=	 $this->input->post('type',TRUE); 
		
		if(!empty($warranty_id) && !empty($productId) && !empty($service_type) && !empty($type)){
			
			$option["where"] = array('product_id'=>$productId,'type_id'=>$warranty_id,'service_type'=>$service_type,'type'=>$type);
			$wres=$this->warranty_model->get_product_base_price($option);
				
			if(!empty($wres['product_price'])){
				$price=$wres['product_price'];
				echo $price;					
			}
		}
	}	
	
	
	public function send_enquiry() {
		
    $this->form_validation->set_rules('first_name', 'First Name', 'trim|alpha|required|max_length[80]');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[80]');
    $this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|max_length[20]');
    $this->form_validation->set_rules('country', 'Country', 'trim|required');
    $this->form_validation->set_rules('description', 'Message', 'trim|required|max_length[8500]');
   // $this->form_validation->set_rules('verification_code', 'Verification code', 'trim|required|valid_captcha_code');

    if ($this->form_validation->run() === TRUE) {
    	
    	$this->load->model(array('message/message_model'));
    	
    	$message_id=$this->message_model->safe_insert($this->message_model->table,array(
    			"message_type"=>'0',
    			"sender_id"=>$this->session->userdata("user_id"),
    			"name"=>$this->input->post('first_name'),
    			"email"=>$this->input->post('email'),
    			'phone_number' => $this->input->post('phone_number'),
    			'country' => $this->input->post('country'),
    			'product_id' => $this->input->post('prod_id'),
    			'product_name' => $this->input->post('product_service'),
    			'product_code' => $this->input->post('product_code'),    			
    			"message"=>$this->input->post("description"),
    			"created_at"=>$this->config->item("config.date.time"),
    			"is_admin_approved"=>'1',
    			"status"=>'1'));
    	if($message_id){
    		$this->message_model->safe_insert($this->message_model->table_relate,array(
    				"message_id"=>$message_id,
    				"user_id"=>$this->input->post('sellers_id'),
    				"sender_id"=>$this->session->userdata("user_id"),
    				"type"=>'INBOX',
    				"posted_date"=>$this->config->item("config.date.time"),
    				"message_status"=>"Unread"));
    	}

  

      //trace($posted_data);
      $this->session->set_userdata(array('msg_type' => 'success'));
      $this->session->set_flashdata('success', 'Your enquiry has been posted successfully. We will get back to you soon.');


      /*       * ******* Send  mail to admin ********** */
      $fullname = $this->input->post('first_name');
      $admin_email = $this->admin_info->admin_email;
      $content = get_content('wl_auto_respond_mails', '7');

      $body = $content->email_content;
      $body = str_replace('{mem_name}', 'Admin', $body);
      $body = str_replace('{body_text}', 'You have received an enquiry and details are given below.', $body);
      $body = str_replace('{name}', $fullname, $body);
      $body = str_replace('{enq}', $this->input->post('product_service'), $body);
      $body = str_replace('{email}', $this->input->post('email'), $body);
      $body = str_replace('{country}', $this->input->post('country'), $body);
      $body = str_replace('{mobile}', 'NA', $body);
      if ($this->input->post('phone_number') != '') {
        $body = str_replace('{phone}', $this->input->post('phone_number'), $body);
      } else {
        $body = str_replace('{phone}', 'NA', $body);
      }
      $body = str_replace('{comments}', $this->input->post('description'), $body);
      $body = str_replace('{site_name}', $this->config->item('site_name'), $body);
      $body = str_replace('{admin_email}', $admin_email, $body);
      $body = str_replace('{url}', base_url(), $body);

      $mail_conf = array(
          'subject' => "Enquiry from " . $this->input->post('first_name') . " " . $this->input->post('last_name'),
          'to_email' => $admin_email,
          'from_email' => $this->input->post('email'),
          'from_name' => $this->input->post('first_name'),
          'body_part' => $body
      );
    
      $this->dmailer->mail_notify($mail_conf);

      /* End Send  mail to admin */

      /*       * ******* Send  mail to user ********** */
      $body = $content->email_content;
      $body = str_replace('{mem_name}', $fullname, $body);
      $body = str_replace('{body_text}', 'You have placed an enquiry and details are given below.', $body);

      $body = str_replace('{name}', $fullname, $body);
      $body = str_replace('{enq}', $this->input->post('product_service'), $body);
      $body = str_replace('{email}', $this->input->post('email'), $body);
      $body = str_replace('{mobile}', 'NA', $body);
      if ($this->input->post('phone_number') != '') {
        $body = str_replace('{phone}', $this->input->post('phone_number'), $body);
      } else {
        $body = str_replace('{phone}', 'NA', $body);
      }
      $body = str_replace('{comments}', $this->input->post('description'), $body);
      $body = str_replace('{site_name}', $this->config->item('site_name'), $body);
      $body = str_replace('{admin_email}', $admin_email, $body);
      $body = str_replace('{url}', base_url(), $body);

      $mail_conf = array(
          'subject' => "Enquiry placed at " . $this->config->item('site_name') . " ",
          'to_email' => $this->input->post('email'),
          'from_email' => $admin_email,
          'from_name' => $this->config->item('site_name'),
          'body_part' => $body
      );
      //trace($mail_conf);
     // $this->dmailer->mail_notify($mail_conf);
      /* End Send  mail to user */      
      
      $product_frindly_url=get_db_field_value('wl_products','friendly_url',array("products_id"=>$this->input->post('prod_id')));
      redirect($product_frindly_url);
    }
   
    
  }
	
	function product_post_review(){
		$this->form_validation->set_rules('poster_name',"Name",'trim|alpha|required|max_length[100]');
		$this->form_validation->set_rules('email',"Email",'trim|required|valid_email|max_length[80]');
		$this->form_validation->set_rules('rating',"Select Rating",'trim|required');
		$this->form_validation->set_rules('ven_id',"ven_id",'trim|required|max_length[80]');
		$this->form_validation->set_rules('comment',"Review",'trim|required|max_length[1000]');
		$this->form_validation->set_rules('verification_code',"Word Verification",'trim|required|valid_captcha_code');
			
		if($this->form_validation->run()===TRUE){
			$posted_data=array(
					'rev_type'   	=> 'P',
					'poster_name'   => $this->input->post('poster_name'),
					'email'    		=> $this->input->post('email'),
					'rate'        	=> $this->input->post('rating'),
					'prod_id' 		=> $this->input->post('prod_id'),
					'mem_id' 		=> $this->session->userdata('user_id'),
					'ven_id' 		=> $this->input->post('ven_id'),
					'comment'       => $this->input->post('comment'),
					'posted_date'  	=> $this->config->item('config.date.time'),
					'status'       	=> '0',
			);
			$this->product_model->safe_insert('wl_review',$posted_data,FALSE);
			
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success', 'Your review has been posted successfully.We will get back to you soon.');
			
			$product_frindly_url=get_db_field_value('wl_products','friendly_url',array("products_id"=>$this->input->post('prod_id')));
			
			redirect($product_frindly_url,TRUE);
		}
	}
	
	public function ajax_search_zip_location()
	{
		$post_location=$this->input->post('zip_location');
		//$pId=$this->uri->segment(3);
		//$pres=$this->products_model->get_product_by_id($pId);
		
		//$product_location=$pres->location;
		if($post_location!='')
		{
			//$get_location=get_db_single_row('wl_zip_location','*'," AND zip_code = '".$post_location."'");
			$get_location=count_record('wl_zip_location',"zip_code = '".$post_location."'");
			if($get_location>0)
			{
				echo '<p class="mt5 green weight600 fs12 lh14 av_check">COD is available at your location and servicable.</p>';
				//echo '<p class="mt10"><b>Cash On Delivery Available :</b> <img src="'.theme_url().'images/ys.jpg"  alt="" class="vab"></p><p class="fs12  mt10"><b>Your Pin Code :</b> '.$post_location.' <span class=" orange"> <a href="javascript:void(0);" onclick="window.location.reload()">Change</a></span></p>';
			}
			else
			{
				echo '<p class="mt5 red weight600 fs12 lh14 av_check">COD not available at your location and not servicable.</p>';
				//echo '<p class="mt10"><b>Cash On Delivery Available :</b> <img src="'.theme_url().'images/no.jpg" alt="" class="vam"></p><p class="fs12  mt10"><b>Your Pin Code :</b> '.$post_location.' <span class=" orange"> <a href="javascript:void(0);" onclick="show_location_form()">Change</a></span></p>';
			}
		}
		else
		{
			echo '<p class="mt5 red weight600 fs12 lh14 av_check">COD not available at your location and not servicable.</p>';
			//echo '<p class="mt10"><b>Cash On Delivery Available :</b> <img src="'.theme_url().'images/no.jpg" alt="" class="vam"></p><p class="fs12  mt10"><b>Your Pin Code :</b> '.$post_location.' <span class=" orange"> <a href="javascript:void(0);" onclick="show_location_form()">Change</a></span></p>';
		}
	}
	
}
?>