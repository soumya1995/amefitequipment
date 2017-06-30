<?php
class Products extends Admin_Controller
{

	public function __construct()
	{
            
		parent::__construct();
		$this->load->model(array('products/product_model','warranty/warranty_model','package/package_model','prices/price_model','brand/brand_model'));
		$this->load->helper(array('products/product','category/category'));
		$this->config->set_item('menu_highlight','product management');

	}

	public  function index($page = NULL){
		
		if( $this->input->post('status_action')!=''){
			
			if( $this->input->post('status_action')=='Delete'){
				$prod_id=$this->input->post('arr_ids');
				foreach($prod_id as $v){
					$where = array('entity_type'=>'products/detail','entity_id'=>$v);
					$this->product_model->safe_delete('wl_meta_tags',$where,TRUE);
				}
			}
			$this->update_status('wl_products','products_id');
		}
		/* Product set as a */
		if( $this->input->post('set_as')!='' ){
		    $set_as    = $this->input->post('set_as',TRUE);
			$this->set_as('wl_products','products_id',array($set_as=>'1'));
		}

		if( $this->input->post('unset_as')!='' ){
		    $unset_as   = $this->input->post('unset_as',TRUE);
			$this->set_as('wl_products','products_id',array($unset_as=>'0'));
		}

		$condtion = array();
		$pagesize = (int) $this->input->get_post('pagesize');
		$config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url = current_url_query_string(array('filter'=>'result'),array('per_page'));

		$category_id = (int) $this->input->get_post('category_id');
		$status = $this->input->get_post('status',TRUE);
		$cat_name = '';

		if($category_id > 0 ){
			$condtion['category_id'] = $category_id;
			$cat_name       = 'in ';
			$cat_name .= get_db_field_value('wl_categories','category_name'," AND category_id='$category_id'");
		}

		if($status!=''){
			$condtion['status'] = $status;
		}
		
		$condtion['orderby']     ="products_id DESC";
		
		$data['heading_title']   =  'Product Lists';				
		$res_array               =  $this->product_model->get_products($config['limit'],$offset,$condtion);
		//echo_sql();
		$config['total_rows']    =  get_found_rows();
		
		$data['res']             =  $res_array;
		$data['page_links']      =   admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		
		/* End product set as a */

		$data['category_result_found'] = "Total ".$config['total_rows']." result(s) found ".strtolower($cat_name)." ";
		$this->load->view('catalog/view_product_list',$data);
	}


	public function add(){
		$data['heading_title'] = 'Add Product';
		$categoryposted=$this->input->post('catid');
		$data['categoryposted']=$categoryposted;
		$categoryposted=$this->input->post('catid');
		$data['ckeditor1']  =  set_ck_config(array('textarea_id'=>'description'));		

		$posted_friendly_url = $this->input->post('friendly_url');
		$this->cbk_friendly_url = seo_url_title($posted_friendly_url);
		$seo_url_length = $this->config->item('seo_url_length');

		$img_allow_size =  $this->config->item('allow.file.size');
		$img_allow_dim  =  $this->config->item('allow.imgage.dimension');

		$this->form_validation->set_rules('category_id','Category Name',"trim|required");
		$this->form_validation->set_rules('product_name','Product Name',"trim|required|max_length[100]");
		
		$this->form_validation->set_rules('product_code','Product Code',"trim|required|max_length[65]|unique[wl_products.product_code='".$this->db->escape_str($this->input->post('product_code'))."' AND status!='2']");		
		
		$this->form_validation->set_rules('product_weight','Weight',"trim|required|greater_than[0]");
		$this->form_validation->set_rules('product_width','Width',"trim|required|greater_than[0]");
		$this->form_validation->set_rules('product_height','Height',"trim|required|greater_than[0]");
		$this->form_validation->set_rules('product_length','Length',"trim|required|greater_than[0]");
		
		$this->form_validation->set_rules('product_brand','Brand',"trim");
		$this->form_validation->set_rules('product_color','Color',"trim");
		$this->form_validation->set_rules('product_size','Size',"trim");
		
		$this->form_validation->set_rules('product_coming_soon','Coming Soon',"trim");
		
		$this->form_validation->set_rules('buyer_product_price','Buyer Price',"trim|required|is_valid_amount|greater_than[0]|max_length[10]");
		$this->form_validation->set_rules('buyer_product_discounted_price','Buyer Discount Price',"trim|is_valid_amount|less_than[".$this->input->post("buyer_product_price")."]|max_length[10]");
		
		$this->form_validation->set_rules('wholesaler_product_price','Wholesaler Price',"trim|required|is_valid_amount|greater_than[0]|max_length[10]");
		$this->form_validation->set_rules('wholesaler_product_discounted_price','Wholesaler Discount Price',"trim|is_valid_amount|less_than[".$this->input->post("wholesaler_product_price")."]|max_length[10]");
		
		$this->form_validation->set_rules('delivery_time','Duration for delivery',"trim|max_length[8500]"); 			
		$this->form_validation->set_rules('products_description','Description',"trim|required|max_length[8500]"); 
		
		$this->form_validation->set_rules('product_stock','Stock',"trim|required|greater_than[0]");
		$this->form_validation->set_rules('low_stock','Low Stock',"trim|required|greater_than[0]|less_than[".$this->input->post("product_stock")."]|max_length[10]");	
				
		$this->form_validation->set_rules('product_images1','Image1',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");
		$this->form_validation->set_rules('product_images2','Image2',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");
		$this->form_validation->set_rules('product_images3','Image3',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");
		$this->form_validation->set_rules('product_images4','Image4',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");			
              
		if($this->form_validation->run()===TRUE){
			
			$redirect_url = "products/detail";
			$product_alt = $this->input->post('product_alt');

			if($product_alt ==''){
				$product_alt = $this->input->post('product_name');
			}

		        $category_links = get_parent_categories($this->input->post('category_id'),"AND status='1'","category_id,parent_id");
			$category_links = array_keys($category_links);
			$category_links = implode(",",$category_links);

			$buyer_discounted_price = $this->input->post('buyer_product_discounted_price',TRUE);
			$buyer_discounted_price = ($buyer_discounted_price=='') ? "0.0000" : $buyer_discounted_price;
			
			$wholesaler_discounted_price = $this->input->post('wholesaler_product_discounted_price',TRUE);
			$wholesaler_discounted_price = ($wholesaler_discounted_price=='') ? "0.0000" : $wholesaler_discounted_price;

			//$tax = $this->input->post('product_tax',TRUE);
			//$tax = ($tax=='') ? "0.0000" : $tax;
			
			$is_coming_soon = ($this->input->post('product_coming_soon')=='') ? "0" : '1';
			
			$posted_data = array(
			'category_id'=>$this->input->post('category_id'),
			'category_links'=>$category_links,			
			'product_name'=>$this->input->post('product_name',TRUE),
			'product_alt'=>$this->input->post('product_alt',TRUE),
			'friendly_url'=>url_title($this->input->post('product_name')),
			'product_code'=>$this->input->post('product_code',TRUE),
			
			'buyer_product_price'=>$this->input->post('buyer_product_price',TRUE),
			'buyer_product_discounted_price'=>$buyer_discounted_price,
			'wholesaler_product_price'=>$this->input->post('wholesaler_product_price',TRUE),
			'wholesaler_product_discounted_price'=>$wholesaler_discounted_price,
			
			'product_weight'=>$this->input->post('product_weight'),
			'product_width'=>$this->input->post('product_width'),
			'product_height'=>$this->input->post('product_height'),
			'product_length'=>$this->input->post('product_length'),
				
			'product_brand'=>$this->input->post('product_brand'),
			'product_color'=>$this->input->post('product_color'),
			'product_size'=>$this->input->post('product_size'),
			
			'product_coming_soon'=>$this->input->post('product_coming_soon'),
			'is_coming_soon'=>$is_coming_soon,
			
			'product_stock'=>$this->input->post('product_stock'),
			'low_stock'=>$this->input->post('low_stock'),
			
			'delivery_time'=>$this->input->post('delivery_time'),					
			'products_description'=>$this->input->post('products_description'),	
			'product_added_date'=>$this->config->item('config.date.time')
			);
			$productId = $this->product_model->safe_insert('wl_products',$posted_data,FALSE);
                        $services = $this->input->post('service');
                        $cnt=0;
                        foreach($this->input->post('price') as $value)
                        {
                            if(!empty($value))
                            {
                                $post_service_data['price'] = $value;
                                $post_service_data['service_id'] = $services[$cnt];
                                $post_service_data['product_id'] = $productId;
                                $this->product_model->safe_insert('tbl_product_services',$post_service_data,FALSE);
                                 $cnt++; 
                            }
                          
                        }

			$this->add_product_media($productId);

			if( $productId > 0 ){
				
			  $meta_array  = array(
							  'entity_type'=>$redirect_url,
							  'entity_id'=>$productId,
							  'page_url'=>$this->cbk_friendly_url,
							  'meta_title'=>get_text($this->input->post('product_name'),80),
							  'meta_description'=>get_text($this->input->post('products_description')),
							  'meta_keyword'=>get_keywords($this->input->post('products_description'))
							  );

			  create_meta($meta_array);
			}
			
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/products?category_id='.$this->input->post('category_id'), '');

		}
		$param= array('status'=>'1');		
		$brand_res              = $this->brand_model->getbrands($param,0,100);		
		$data['total_brand']	= get_found_rows();
		$data['brand_res']       = $brand_res;
		$this->load->view('catalog/view_product_add',$data);

	}

	public function edit($productId){

		$data['heading_title'] = 'Edit Product';
		$productId = (int) $this->uri->segment(4);
		$option = array('productid'=>$productId);
		$res =  $this->product_model->get_products(1,0, $option);
		$data['ckeditor1']  =  set_ck_config(array('textarea_id'=>'description'));	

		$img_allow_size =  $this->config->item('allow.file.size');
		$img_allow_dim  =  $this->config->item('allow.imgage.dimension');

		$posted_friendly_url = $this->input->post('friendly_url');
		$this->cbk_friendly_url = seo_url_title($posted_friendly_url);
		$seo_url_length = $this->config->item('seo_url_length');

		$this->form_validation->set_rules('category_id','Category Name',"trim|required");
		$this->form_validation->set_rules('product_name','Product Name',"trim|required|max_length[255]");
		$this->form_validation->set_rules('product_code','Product Code',"trim|required|max_length[65]|unique[wl_products.product_code='".$this->db->escape_str($this->input->post('product_code'))."' AND status!='3' AND products_id != '".$productId."']");
		
		$this->form_validation->set_rules('product_weight','Weight',"trim|required|greater_than[0]");
		$this->form_validation->set_rules('product_width','Width',"trim|required|greater_than[0]");
		$this->form_validation->set_rules('product_height','Height',"trim|required|greater_than[0]");
		$this->form_validation->set_rules('product_length','Length',"trim|required|greater_than[0]");
		
		$this->form_validation->set_rules('product_brand','Brand',"trim");
		$this->form_validation->set_rules('product_color','Color',"trim");
		$this->form_validation->set_rules('product_size','Size',"trim"); 
		$this->form_validation->set_rules('product_coming_soon','Coming Soon',"trim");
		
		$this->form_validation->set_rules('product_stock','Stock',"trim|required|greater_than[0]");
		$this->form_validation->set_rules('low_stock','Low Stock',"trim|required|greater_than[0]|less_than[".$this->input->post("product_stock")."]|max_length[10]");
		
		$this->form_validation->set_rules('buyer_product_price','Buyer Price',"trim|required|is_valid_amount|greater_than[0]|max_length[10]");
		$this->form_validation->set_rules('buyer_product_discounted_price','Buyer Discount Price',"trim|is_valid_amount|less_than[".$this->input->post("buyer_product_price")."]|max_length[10]");
		
		$this->form_validation->set_rules('wholesaler_product_price','Wholesaler Price',"trim|required|is_valid_amount|greater_than[0]|max_length[10]");
		$this->form_validation->set_rules('wholesaler_product_discounted_price','Wholesaler Discount Price',"trim|is_valid_amount|less_than[".$this->input->post("wholesaler_product_price")."]|max_length[10]");
		
		$this->form_validation->set_rules('delivery_time','Duration for delivery',"trim|max_length[8500]"); 			
		$this->form_validation->set_rules('products_description','Description',"trim|required|max_length[8500]"); 		
				
		$this->form_validation->set_rules('product_images1','Image1',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");
		$this->form_validation->set_rules('product_images2','Image2',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");
		$this->form_validation->set_rules('product_images3','Image3',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");
		$this->form_validation->set_rules('product_images4','Image4',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");				
		

		if( is_array( $res ) && !empty( $res )){

			if($this->form_validation->run()==TRUE){
				
				$category_links = get_parent_categories($this->input->post('category_id'),"AND status='1'","category_id,parent_id");
				$category_links = array_keys($category_links);
				$category_links = implode(",",$category_links);

				$buyer_discounted_price = $this->input->post('buyer_product_discounted_price',TRUE);
				$buyer_discounted_price = ($buyer_discounted_price=='') ? "0.0000" : $buyer_discounted_price;
				
				$wholesaler_discounted_price = $this->input->post('wholesaler_product_discounted_price',TRUE);
				$wholesaler_discounted_price = ($wholesaler_discounted_price=='') ? "0.0000" : $wholesaler_discounted_price;
				
				$is_coming_soon = ($this->input->post('product_coming_soon')=='') ? "0" : '1';
								
				$posted_data = array(
				'category_id'=>$this->input->post('category_id'),
				'category_links'=>$category_links,				
				'product_name'=>$this->input->post('product_name',TRUE),
				'friendly_url'=>$this->cbk_friendly_url,
				'product_alt'=>$this->input->post('product_alt',TRUE),
				'product_code'=>$this->input->post('product_code',TRUE),				
				
				'buyer_product_price'=>$this->input->post('buyer_product_price',TRUE),
				'buyer_product_discounted_price'=>$buyer_discounted_price,
				'wholesaler_product_price'=>$this->input->post('wholesaler_product_price',TRUE),
				'wholesaler_product_discounted_price'=>$wholesaler_discounted_price,
				
				'product_weight'=>$this->input->post('product_weight'),
				'product_width'=>$this->input->post('product_width'),
				'product_height'=>$this->input->post('product_height'),
				'product_length'=>$this->input->post('product_length'),
				
				'product_brand'=>$this->input->post('product_brand'),
				'product_color'=>$this->input->post('product_color'),
				'product_size'=>$this->input->post('product_size'), 
				
				'product_coming_soon'=>$this->input->post('product_coming_soon'),
				'is_coming_soon'=>$is_coming_soon,
				
				'product_stock'=>$this->input->post('product_stock'),
				'low_stock'=>$this->input->post('low_stock'),
				
				'delivery_time'=>$this->input->post('delivery_time'),					
				'products_description'=>$this->input->post('products_description'),	
				'product_added_date'=>$this->config->item('config.date.time')
				);
				$services = $this->input->post('service');
                                $price = $this->input->post('price');
                                $services = array_values($services);
                               	$where = "products_id = '".$res['products_id']."'";
				$this->product_model->safe_update('wl_products',$posted_data,$where,FALSE);
                                $cnt = 0;
                              
                                foreach($this->input->post('price') as $key=>$value)
                                {
                                    $service_id = $key+1;
                                    if(in_array($service_id,$services))
                                    {
                                       $post_service_data['price'] = $value;
                                       $check = custom_result_set("select count(id) as count from tbl_product_services where product_id ='$productId' AND status='1' AND service_id='$service_id'");
                                      if($check[0]['count'] > 0)
                                        {
                                            $where = " service_id='$service_id' AND product_id = '$productId'";
                                            $this->product_model->safe_update('tbl_product_services',$post_service_data,$where,FALSE); 
                                        }
                                       else
                                       {
                                          $post_service_data['service_id'] = $service_id;
                                          $post_service_data['product_id'] = $productId;
                                          $this->product_model->safe_insert('tbl_product_services',$post_service_data,FALSE); 
                                       }
                                       $cnt++;
                                    }
                                    else
                                    {
                                       $this->db->where(array('service_id'=>$service_id,'product_id'=>$productId));
                                       $this->db->delete("tbl_product_services");
                                    }
                                }
				$this->edit_product_media($res['products_id']);
				update_meta_page_url('products/detail',$res['products_id'],$this->cbk_friendly_url);

				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('successupdate'));
				redirect('sitepanel/products/'. query_string(), '');

			}

			$data['res']=$res;			
			$media_option = array('productid'=>$res['products_id']);
			$res_photo_media = $this->product_model->get_product_media(4,0, $media_option);
			$data['res_photo_media']=$res_photo_media;
			
			$param= array('status'=>'1');		
			$brand_res              = $this->brand_model->getbrands($param,0,100);
                        $service_option = array('productid'=>$res['products_id']);
			$data['services'] = $this->product_model->get_product_services(4,0, $service_option);
			$data['total_brand']	= get_found_rows();
			$data['brand_res']       = $brand_res;

			$this->load->view('catalog/view_product_edit',$data);

		}else{
			redirect('sitepanel/products', '');
		}
	}

	public function add_product_media($productId){
		
		if( !empty($_FILES) && ( $productId > 0 ) ){
			$defalut_image = 'Y';

			foreach($_FILES as $key=>$val){
				$imgfld=$key;

				if(array_key_exists($imgfld,$_FILES)){
					
					$this->load->library('upload');
					$data_upload_sugg = $this->upload->my_upload($imgfld,"products");

					if( is_array($data_upload_sugg)  && !empty($data_upload_sugg) ){
						$watermark_img = UPLOAD_DIR."/products/".$data_upload_sugg['upload_data']['file_name'];
						img_watermark($watermark_img);
						
						$add_data = array(
						'products_id'=>$productId,
						'media_type'=>'photo',
						'is_default'=>$defalut_image,
						'media'=>$data_upload_sugg['upload_data']['file_name'],
						'media_date_added' => $this->config->item('config.date.time')
						);
						$this->product_model->safe_insert('wl_products_media', $add_data ,FALSE );
					}
					$defalut_image = 'N';
				}
			}

		}

  }

	public function edit_product_media($productId){
		
		//Current Media Files resultset
		$media_option = array('productid'=>$productId);
		$res_photo_media = $this->product_model->get_product_media(4,0, $media_option);
		$res_photo_media = !is_array($res_photo_media ) ? array() : $res_photo_media ;

		$delete_media_files = $this->input->post('product_img_delete'); //checkbox items given for image deletion
		$arr_delete_items = array(); //holding our deleted ids for later use

		/* Tracking delete media ids coming from checkboxes */

		if(is_array($delete_media_files) && !empty($delete_media_files)){

			foreach($res_photo_media as $key=>$val){
				
				$media_id = $val['id'];
				if(array_key_exists($media_id,$delete_media_files)){
					 $media_file = $res_photo_media[$key]['media'];
					 $unlink_image = array('source_dir'=>"products",'source_file'=>$media_file);
					 removeImage($unlink_image);
					 array_push($arr_delete_items,$media_id);
				}
			}
		}

		/* Tracking Ends */

		/* Iterating Form Files */

		if( !empty($_FILES) && ( $productId > 0 ) ){ 
			$sx = 0;
			foreach($_FILES as $key=>$val){
				$imgfld=$key;

				if(array_key_exists($imgfld,$_FILES)){
					$this->load->library('upload');
					$data_upload_sugg = $this->upload->my_upload($imgfld,"products");

					if( is_array($data_upload_sugg)  && !empty($data_upload_sugg) ){
						/*  uploading successful  */
						$watermark_img = UPLOAD_DIR."/products/".$data_upload_sugg['upload_data']['file_name'];
						img_watermark($watermark_img);
						
						$add_data = array(
						'products_id'=>$productId,
						'media_type'=>'photo',
						'media'=>$data_upload_sugg['upload_data']['file_name'],
						'product_code'=>$this->input->post('product_code'),
						'media_date_added' => $this->config->item('config.date.time')
						);

						/* If there already exists record in the database update then else insert new entry
						   $res_photo_media  holding existing resultset from databse in the form given below:
						   $res_photo_media = array( 0 => array(row1) )

						*/

						if(array_key_exists($sx,$res_photo_media)){
						       $media_id  = $res_photo_media[$sx]['id'];
							   $media_file = $res_photo_media[$sx]['media'];
						       $where = "id = '".$media_id."'";
				               $this->product_model->safe_update('wl_products_media',$add_data,$where,FALSE);
							   $unlink_image = array('source_dir'=>"products",'source_file'=>$media_file);
							   removeImage($unlink_image);

							   /* New File has been browsed and delete checkbox also checked for this file */
							   /* This  media id cannot be removed as it been browsed and updated */
							   if(in_array($media_id,$arr_delete_items)){
									$media_del_index = array_search($media_id,$arr_delete_items);
									unset($arr_delete_items[$media_del_index]);
							   }

						}else{
							$this->product_model->safe_insert('wl_products_media', $add_data ,FALSE );
						}
					}
				}
				$sx++;
			}
		}

		if(!empty($arr_delete_items)){
			$del_ids = implode(',',$arr_delete_items);
			$where = " id IN(".$del_ids.") ";
			$this->product_model->delete_in('wl_products_media',$where,FALSE);
		}

  	}
   
   
   
   	public function related()
	{
		$productId =  (int) $this->uri->segment(4);
		$option = array('productid'=>$productId);
		$res =  $this->product_model->get_products(1,0, $option);


		if( is_array($res) )
		{
			$data['heading_title'] = "Add Related Products";

			$fetch_related_products  = $this->product_model->related_products_added($res['products_id']);

			if(empty($fetch_related_products))
			{
				$fetch_not_ids = array($res['products_id']);

			}else
			{
				$fetch_not_ids=array_values($fetch_related_products);
				array_push($fetch_not_ids,$res['products_id']);

			}

			$res_array  = $this->product_model->get_related_products($fetch_not_ids);
			$data['res'] = $res_array;

				/* Add related products */

				if($this->input->post('add_related')=='Add related product')
				{

					$this->add_related_products($res['products_id']);
					$this->session->set_flashdata('message',"Related Product has been added successfully." );
					redirect('sitepanel/products/related/'.$productId, '');

				}

			/* End of  related products */

			$this->load->view('catalog/view_add_related_products',$data);
		}

	}

	public function add_related_products($product_id)
	{
		$arr_ids = $this->input->post('arr_ids');

		if( is_array($arr_ids))
		{
			foreach($arr_ids as $val )
			{
				$rec_exits = $this->product_model->is_record_exits('wl_products_related', array('condition'=>"related_id =".$val." AND product_id =".$product_id." "));
				if( !$rec_exits )
				{
					$posted_data = array(
					'product_id'=>$product_id,
					'related_id'=>$val,
					'related_date_added'=>$this->config->item('config.date.time')
					);
					$this->product_model->safe_insert('wl_products_related',$posted_data,FALSE);
				}
			}
		}
	}

	public function remove_related_products($productId)
	{
		$arr_ids = $this->input->post('arr_ids');
		if( is_array($arr_ids) )
		{
			if($this->input->post('remove_related')=='Remove product')
			{
				foreach($arr_ids as $val )
				{
					$data = array('id'=>$val );
					$this->product_model->safe_delete('wl_products_related',$data,FALSE);
				}

			}
		}
	}

	public function view_related()
	{
		$productId =  (int) $this->uri->segment(4);
		$option = array('productid'=>$productId);
		$res =  $this->product_model->get_products(1,0, $option);

		if( is_array($res) )
		{
			$data['heading_title'] = "View Related Products";
			$res_array  = $this->product_model->related_products($res['products_id']);
			$data['res'] = $res_array;

			/* Remove related products */

				if($this->input->post('remove_related')=='Remove product')
				{
					$this->remove_related_products($res['products_id']);
					$this->session->set_flashdata('message',"Related Product has been removed successfully." );
				    redirect('sitepanel/products/view_related/'.$productId, '');

				}

			/* End of  remove related products */

			$this->load->view('catalog/view_related_products',$data);


		}

	}
   
   

	
	public function download_pdf(){
		$pdfId=(int)$this->uri->segment(4,0);
		$pId=(int)$this->uri->segment(5,0);
		
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
	
	/* Size Attribute Management Ends */

	public function check_price(){
		$disc_price = floatval($this->input->post('product_discounted_price'));
		$price      = floatval($this->input->post('product_price'));
		if($disc_price>=$price){
			$this->form_validation->set_message('check_price', 'Discount price must be less than actual price.');
			return FALSE;
		}else{
			return TRUE;
		}
	}


	public  function packages($page = NULL){
		
		 $pagesize               =  (int) $this->input->get_post('pagesize');
                 $config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		 $offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		 $base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));

		 $product_id              =   (int) $this->uri->segment(4,0);

		 $condtion = " ";
		 $where="product_id = '".$product_id."' AND type = 'P' ";
		 		 
		 $condtion_array = array(
		                'field' =>"*",
						 'condition'=>$condtion,
						 'where'=>$where,
						 'limit'=>$config['limit'],
						  'offset'=>$offset	,
						  'debug'=>FALSE
						 );
		$res_array              =  $this->price_model->get_prices($condtion_array);
		$config['total_rows']	=  $this->price_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Manage Packages';
		$data['res']            =  $res_array;
		$data['product_id']     =  $product_id;

		if( $this->input->post('status_action')!=''){			
			$this->update_status('wl_product_attributes','attribute_id');				
		}
		if( $this->input->post('update_order')!=''){
			$this->update_displayOrder('wl_product_attributes','sort_order','attribute_id');
		}
		if( $this->input->post('set_as')!='' ){
		    $set_as    = $this->input->post('set_as',TRUE);
			$this->set_as('wl_product_attributes','attribute_id',array($set_as=>'1'));
		}
		if( $this->input->post('unset_as')!='' ){
		    $unset_as   = $this->input->post('unset_as',TRUE);
			$this->set_as('wl_product_attributes','attribute_id',array($unset_as=>'0'));
		}
		$this->load->view('catalog/view_product_varient_list',$data);
	}
        
        
        	public  function warranty(){
		
		 $pagesize               =  (int) $this->input->get_post('pagesize');
	         $config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		 $offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		 $base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		 $product_id              =   (int) $this->uri->segment(4,0);
		 $condtion = " ";
		 $where="product_id = '".$product_id."' AND type = 'W' ";
		 		 
		 $condtion_array = array(
		                'field' =>"*",
						 'condition'=>$condtion,
						 'where'=>$where,
						 'limit'=>$config['limit'],
						  'offset'=>$offset	,
						  'debug'=>FALSE
						 );
		$res_array              =  $this->price_model->get_prices($condtion_array);
		$config['total_rows']	=  $this->price_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Manage Warranty';
		$data['res']            =  $res_array;
		$data['product_id']     =  $product_id;

		if( $this->input->post('status_action')!=''){			
			$this->update_status('wl_product_attributes','attribute_id');				
		}
		if( $this->input->post('update_order')!=''){
			$this->update_displayOrder('wl_product_attributes','sort_order','attribute_id');
		}
		if( $this->input->post('set_as')!='' ){
		    $set_as    = $this->input->post('set_as',TRUE);
			$this->set_as('wl_product_attributes','attribute_id',array($set_as=>'1'));
		}
		if( $this->input->post('unset_as')!='' ){
		    $unset_as   = $this->input->post('unset_as',TRUE);
			$this->set_as('wl_product_attributes','attribute_id',array($unset_as=>'0'));
		}
		$this->load->view('catalog/view_product_varient_list',$data);
	}


	public function editservice(){
		
		$data['heading_title'] = 'Edit Product';
		$product_id = (int) $this->uri->segment(5);		
		$attribute_id = (int) $this->uri->segment(6);
		$res =  $this->price_model->get_prices_by_id($attribute_id);
		$this->form_validation->set_rules('type_id','Warranty/Package',"trim|required|unique[wl_product_attributes.type_id='".$this->input->post('type_id')."' AND wl_product_attributes.product_id='".$product_id."' AND type='".$this->input->post('type')."' AND attribute_id!='".$attribute_id."' ]");		
		//$this->form_validation->set_rules('quantity','Stock',"trim|required|is_numeric|greater_than[0]");
		
		if( is_array( $res ) && !empty( $res )){			
		
		
			if($this->input->post('action')=='edit'){
				
				if($this->form_validation->run()==TRUE){
					
					if($this->input->post('type') == 'W' ){
						$warranty_res=get_db_single_row('wl_warranty','title,price',' and  warranty_id ='.$this->input->post('type_id').' ');
						$variant_name=$warranty_res['title']; 
						$product_price=$warranty_res['price'];
						$type_val="Warranty";
					}
					if($this->input->post('type') == 'P' ){
						$package_res=get_db_single_row('wl_package','title,price',' and  package_id ='.$this->input->post('type_id').' ');
						$variant_name=$package_res['title'];
						$product_price=$package_res['price'];
						$type_val="Package";
					}
								
					$product_data = array(
						'product_id'=>$product_id,
						'service_type'=>$service_type,
						'type'=>$this->input->post('type',TRUE),
						//'quantity'=>$this->input->post('quantity',TRUE),
						'product_price'=>$product_price,
						'variant_name'=>$variant_name
					);
										
					$where = "attribute_id='".$attribute_id."'";
					$this->product_model->safe_update('wl_product_attributes',$product_data,$where,FALSE);						
					
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success',"".$type_val." Variant updated successfully");
					echo '<script type="text/javascript">window.opener.location.reload(true);
					window.close();</script>';
					exit;
				}
			}
			$data['res']=$res;
			$warranty_cond_config = array(
				'condition' => " AND status='1' ",
				'order'=>'warranty_id '
			);	
			$warranty = $this->warranty_model->get_warranty(0,0,$warranty_cond_config);
			$data['warranty'] = $warranty;
			
			$package_cond_config = array(
				'condition' => " AND status='1' ",
				'order'=>'package_id '
			);	
			$package = $this->package_model->get_package(0,0,$package_cond_config);
			$data['package'] = $package;
			$this->load->view('catalog/view_edit_price',$data);
		}
	}

	public function addservice(){
		
		$data['heading_title'] = 'Add Product Service';	
		$product_id = (int) $this->uri->segment(5);		
		//trace($_REQUEST);
		
		$this->form_validation->set_rules('type','Type',"trim|required");
		$this->form_validation->set_rules('type_id','Warranty/Package',"trim|required|unique[wl_product_attributes.type_id='".$this->input->post('type_id')."' AND wl_product_attributes.product_id='".$product_id."' AND type='".$this->input->post('type')."' ]");		
		//$this->form_validation->set_rules('quantity','Stock',"trim|required|is_numeric|greater_than[0]");

			if($this->form_validation->run()==TRUE){				
				
				if($this->input->post('type') == 'W' ){
					$warranty_res=get_db_single_row('wl_warranty','title,price',' and  warranty_id ='.$this->input->post('type_id').' ');
					$variant_name=$warranty_res['title']; 
					$product_price=$warranty_res['price'];
					$type_val="Warranty";
				}
				if($this->input->post('type') == 'P' ){
					$package_res=get_db_single_row('wl_package','title,price',' and  package_id ='.$this->input->post('type_id').' ');
					$variant_name=$package_res['title'];
					$product_price=$package_res['price'];
					$type_val="Package";
				}
								
					$product_data = array(
						'product_id'=>$product_id,
						'type'=>$this->input->post('type',TRUE), 	
						'type_id'=>$this->input->post('type_id',TRUE),
						//'quantity'=>$this->input->post('quantity',TRUE),
						'product_price'=>$product_price,
						'variant_name'=>$variant_name
					);
										
					$this->product_model->safe_insert('wl_product_attributes',$product_data,FALSE);
										
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success',"".$type_val." Variant added successfully");
					echo '<script type="text/javascript">window.opener.location.reload(true);
						window.close();</script>';
					exit;
				}
			
			$warranty_cond_config = array(
				'condition' => " AND status='1' ",
				'order'=>'warranty_id '
			);	
			$warranty = $this->warranty_model->get_warranty(0,0,$warranty_cond_config);
			$data['warranty'] = $warranty;
			
			$package_cond_config = array(
				'condition' => " AND status='1' ",
				'order'=>'package_id '
			);	
			$package = $this->package_model->get_package(0,0,$package_cond_config);
			$data['package'] = $package;
			
			$this->load->view('catalog/view_add_price',$data);
	}
	
	
	 public function delete_price_variant()
	 {	
		$type = $this->uri->segment(4);
                $page = ($type=='P')?"packages":"warranty";
		$product_id = (int) $this->uri->segment(5);		
		$attribute_id = (int) $this->uri->segment(6);
		if ($product_id && $type && $attribute_id) {
				
			$delete_data = array('attribute_id'=>$attribute_id );
			$this->product_model->safe_delete('wl_product_attributes',$delete_data,FALSE);
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',"Variant has been deleted successfully." );
                        $redirect = base_url()."sitepanel/products/$page/$product_id";
			redirect($redirect, '');
		}		

	 }


	public function checkurl(){

	  		$product_id=(int)$this->input->post('products_id');

			if($product_id!=''){
				$cont='and entity_id !='.$product_id;
			}else{
				$cont='';
			}

	 		$posted_friendly_url = $this->input->post('friendly_url');
			$this->cbk_friendly_url = seo_url_title($posted_friendly_url);
			$urlcount=$this->db->query("select * from wl_meta_tags where page_url='".$this->cbk_friendly_url."'".$cont."")->num_rows();

			if($urlcount>0){
				$this->form_validation->set_message('checkurl', 'URL already exists.');
			    return FALSE;

			}else{
				 return TRUE;
			}

  }
	
	public function review()
	{
		$condtion               = array();
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$category_id            =  (int) $this->uri->segment(4,0);
		$status			        =   $this->input->get_post('status',TRUE);


		$condtion['rev_type']	=	'P';

		if($this->uri->segment(4)>0)
		{
			$condtion['productid'] =	$this->uri->segment(4);
		}


		$res_array               =  $this->product_model->get_review($config['limit'],$offset,$condtion);
		//echo_sql();
		$config['total_rows']    =  get_found_rows();
		$data['heading_title']   =  'Review Lists';
		$data['res']             =  $res_array;
		$data['page_links']      =   admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);

		if( $this->input->post('status_action')!='')
		{
			$this->update_status('wl_review','review_id');
		}

		$this->load->view('catalog/view_review_list',$data);
	}
	
	function bulk_uploading(){

		$this->form_validation->set_rules('upload_file', 'Data Excel', "file_required|file_allow_type[xls]");

		if ($this->form_validation->run() == TRUE) {
			if(!empty($_FILES) && $_FILES['upload_file']['name'] != ''){
				//$file_path = $data['upload_data']['full_path'];
				$this->import_bulk_data_from_excel_sheet();
				redirect('sitepanel/products/bulk_uploading');
			}
		}
		$data['heading_title'] = "Bulk Upload";
		$this->load->view('catalog/bulk_upload_view', $data);
	}

	public function download_product_format(){
		$headers = '';
		$data = '';
		ob_start();

		$select =" category_id, product_name, product_code, products_description";

		$qry = $this->db->query("select ".$select." from wl_products where status !='2'");

		if ($qry->num_rows() > 0) {
			$data = array();
			$res = $qry->result_array();

			$this->load->library('excel');
			$sheet = new PHPExcel();
			$sheet->getProperties()->setTitle('Admin Products')->setDescription('Admin Products');
			$sheet->setActiveSheetIndex(0);
			$col = 0;

			$select.=", Image 1, Image 2, Image 3, Image 4";
			$fields_array = explode(",",$select);
			$p=0;
			foreach($fields_array as $field){
				$sheet->getActiveSheet()->setCellValueByColumnAndRow($p, 1, ucwords(str_replace("_"," ",trim($field))));
				$p++;
			}

			//$sheet->getActiveSheet()->setCellValueByColumnAndRow(0, 1,"Product Code");
			//$sheet->getActiveSheet()->setCellValueByColumnAndRow(1, 1,"Product Name");


			$row = 2;
			foreach ($res as $key) {
				$col = 0;
				foreach ($key as $k=>$field_val) {
					$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, html_entity_decode($field_val));
					$col++;
				}
				$row++;
			}

			$sheet_writer = PHPExcel_IOFactory::createWriter($sheet, 'Excel5');
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="products_'.date('dMy').'.xls"');
			header('Cache-Control: max-age=0');
			$sheet_writer->save('php://output');
		}

	}

	public function import_bulk_data_from_excel_sheet() {
		
			require_once FCPATH.'apps/third_party/Excel/reader.php';
             $objReader = new Spreadsheet_Excel_Reader();
             $objReader->setOutputEncoding('CP1251');

             //$data->setUTFEncoder('');
             chmod($_FILES["upload_file"]["tmp_name"], 0777);
             $objReader->read($_FILES["upload_file"]["tmp_name"]);
             $worksheet = $objReader->sheets[0]['cells'];


		if (is_array($worksheet) && count($worksheet) > 0) {

			$total = count($worksheet);
			$li="";

			for ($i = 2; $i <= $total; $i++) {
				//trace($worksheet);
				//exit;

				$worksheet[$i]=array_filter($worksheet[$i]);

				$category_id = trim($worksheet[$i][1]);
				$product_name = $worksheet[$i][2];
				$product_code = $worksheet[$i][3];				
				$products_description=@$worksheet[$i][4];
				
				$buyer_product_price=@$worksheet[$i][5];
				$buyer_discounted_price=@$worksheet[$i][6];
				$wholesaler_product_price=@$worksheet[$i][7];
				$wholesaler_discounted_price=@$worksheet[$i][8];
				$product_weight=@$worksheet[$i][9];
				$product_width=@$worksheet[$i][10];
				$product_height=@$worksheet[$i][11];
				$product_length=@$worksheet[$i][12];
				$product_brand=@$worksheet[$i][13];
				$product_color=@$worksheet[$i][14];
				$product_size=@$worksheet[$i][15];
				$product_stock=@$worksheet[$i][16];
				$low_stock=@$worksheet[$i][17];
				$delivery_time=@$worksheet[$i][18];

				$pic1 = @$worksheet[$i][19];
				$pic2 = @$worksheet[$i][20];
				$pic3 = @$worksheet[$i][21];
				$pic4 = @$worksheet[$i][22];

				if($category_id==""){
					$li .="<li>Row $i Category Id is Required</li>";
					continue;
				}
				if($product_name==""){
					$li .="<li>Row $i Product Name is Required</li>";
					continue;
				}
				if($product_code==""){
					$li .="<li>Row $i Product Code is Required</li>";
					continue;
				}				

				$product_query = $this->db->query("select products_id from wl_products where product_code ='" . $product_code . "' and status !='2'");
				$product_found=$product_query->num_rows();

				$product_friendly_url=@url_title($product_name);
				$cbk_friendly_url = seo_url_title($product_friendly_url);

				$urlcount=$this->db->query("select * from wl_meta_tags where page_url='".$cbk_friendly_url."'")->num_rows();


				if ($product_found == 0 && $urlcount==0) {

					$category_links = get_parent_categories($category_id,"AND status='1'","category_id,parent_id");
					$category_links = @array_keys($category_links);
					$category_links = @implode(",",$category_links);


			$buyer_discounted_price = $this->input->post('buyer_product_discounted_price',TRUE);
			$buyer_discounted_price = ($buyer_discounted_price=='') ? "0.0000" : $buyer_discounted_price;
			
			$wholesaler_discounted_price = $this->input->post('wholesaler_product_discounted_price',TRUE);
			$wholesaler_discounted_price = ($wholesaler_discounted_price=='') ? "0.0000" : 	$wholesaler_discounted_price;
					
					//-------------------------------//
					
					$is_coming_soon = ($this->input->post('product_coming_soon')=='') ? "0" : '1';
			
			$posted_data = array(
									'category_id'=>$category_id,
									'category_links'=>$category_links,			
									'product_name'=>$product_name,
									'product_alt'=>$product_alt,
									'friendly_url'=>$product_friendly_url,
									'product_code'=>$product_code,
									
									'buyer_product_price'=>$buyer_product_price,
									'buyer_product_discounted_price'=>$buyer_discounted_price,
									'wholesaler_product_price'=>$wholesaler_product_price,
									'wholesaler_product_discounted_price'=>$wholesaler_discounted_price,
									
									'product_weight'=>$product_weight,
									'product_width'=>$product_width,
									'product_height'=>$product_height,
									'product_length'=>$product_length,
										
									'product_brand'=>$product_brand,
									'product_color'=>$product_color,
									'product_size'=>$product_size,
								
									'product_stock'=>$product_stock,
									'low_stock'=>$low_stock,
									
									'delivery_time'=>$delivery_time,
									'status'=>'0',					
									'products_description'=>$products_description,	
									'product_added_date'=>$this->config->item('config.date.time')
								);
								
		
			$productId = $this->product_model->safe_insert('wl_products',$posted_data,FALSE);
					//-------------------------------//
					
					
					
					
					if(!empty($pic1)){
						$add_data = array(
								'products_id'=>$productId,
								'media_type'=>'photo',
								'is_default'=>"Y",
								'media'=>$pic1,
								'media_date_added' => $this->config->item('config.date.time')
						);
						$this->product_model->safe_insert('wl_products_media', $add_data ,FALSE );
					}
					
					if(!empty($pic2)){
						$add_data = array(
								'products_id'=>$productId,
								'media_type'=>'photo',
								'is_default'=>"N",
								'media'=>$pic2,
								'media_date_added' => $this->config->item('config.date.time')
						);
						$this->product_model->safe_insert('wl_products_media', $add_data ,FALSE );
					}
					
					if(!empty($pic3)){
						$add_data = array(
								'products_id'=>$productId,
								'media_type'=>'photo',
								'is_default'=>"N",
								'media'=>$pic3,
								'media_date_added' => $this->config->item('config.date.time')
						);
						$this->product_model->safe_insert('wl_products_media', $add_data ,FALSE );
					}
					
					if(!empty($pic4)){
						$add_data = array(
								'products_id'=>$productId,
								'media_type'=>'photo',
								'is_default'=>"N",
								'media'=>$pic4,
								'media_date_added' => $this->config->item('config.date.time')
						);
						$this->product_model->safe_insert('wl_products_media', $add_data ,FALSE );
					}

					if( $productId > 0 ){
						$redirect_url = "products/detail";
			  			$meta_array  = array(
							  'entity_type'=>$redirect_url,
							  'entity_id'=>$productId,
							  'page_url'=>$product_friendly_url,
							  'meta_title'=>get_text($product_name,80),
							  'meta_description'=>get_text($products_description,100),
							  'meta_keyword'=>get_text($products_description,100)
							  );

			  			create_meta($meta_array);
					}

				}else{
					$li .="<li>Row $i Product already exist!</li>";
					continue;
				}
			}
			if($li){
				$this->session->set_userdata(array('msg_type' => 'error'));
				$this->session->set_flashdata('error', "<ul>$li</ul>");
			}else{

				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', "Bulk Record has been successfully updated");
			}
		}
		@unlink($path);
	}
	
public function download_brand_format() {
		$headers = '';
		$data = '';
		ob_start();

		$qry = $this->db->query("select brand_id, brand_name from wl_brands where status ='1' ");

		if ($qry->num_rows() > 0) {
			$data = array();
			$res = $qry->result_array();

			$this->load->library('excel');
			$sheet = new PHPExcel();
			$sheet->getProperties()->setTitle('Brands')->setDescription('Brands');
			$sheet->setActiveSheetIndex(0);
			$col = 0;


			$sheet->getActiveSheet()->setCellValueByColumnAndRow(0, 1,"Brand Name");
			$sheet->getActiveSheet()->setCellValueByColumnAndRow(1, 1,"Brand Id");

			$row = 2;

			foreach ($res as $val) {

					$sheet->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $val['brand_name']);
					$sheet->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $val['brand_id']);
				
				$row++;
			}
			$sheet_writer = PHPExcel_IOFactory::createWriter($sheet, 'Excel5');
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="brand_'.date('dMy').'.xls"');
			header('Cache-Control: max-age=0');
			$sheet_writer->save('php://output');
		}
	}	

	public function download_cat_format() {
		$headers = '';
		$data = '';
		ob_start();

		$qry = $this->db->query("select category_id,parent_id from wl_categories where status ='1'  and category_id NOT IN(select a.category_id from wl_categories as a join wl_categories as b on a.category_id=b.parent_id where a.status ='1' and b.status='1')");

		if ($qry->num_rows() > 0) {
			$data = array();
			$res = $qry->result_array();

			$this->load->library('excel');
			$sheet = new PHPExcel();
			$sheet->getProperties()->setTitle('Categories')->setDescription('Categories');
			$sheet->setActiveSheetIndex(0);
			$col = 0;


			$sheet->getActiveSheet()->setCellValueByColumnAndRow(0, 1,"Last Label Category");
			$sheet->getActiveSheet()->setCellValueByColumnAndRow(1, 1,"Category Id");

			$row = 2;

			foreach ($res as $val) {
				$cid = $val['category_id'];
				$st=get_db_field_value('wl_categories','status',array('category_id'=>$cid));

				if($st==1){
					$dt = str_replace("&raquo;", "-->", get_category_chain($cid, '', ''));
					$data[] = array("category_name" => $dt, "catid" => $cid);
					$sheet->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $dt);
					$sheet->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $cid);
				}
				$row++;
			}
			$sheet_writer = PHPExcel_IOFactory::createWriter($sheet, 'Excel5');
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="category_'.date('dMy').'.xls"');
			header('Cache-Control: max-age=0');
			$sheet_writer->save('php://output');
		}
	}
	
	public function download_weight_format() {
		$headers = '';
		$data = '';
		ob_start();

		$qry = $this->db->query("select weight_name, weight_id from wl_weights where status ='1'");

		if ($qry->num_rows() > 0) {
			$data = array();
			$res = $qry->result_array();

			$this->load->library('excel');
			$sheet = new PHPExcel();
			$sheet->getProperties()->setTitle('Weights')->setDescription('Weights');
			$sheet->setActiveSheetIndex(0);
			$col = 0;

			$sheet->getActiveSheet()->setCellValueByColumnAndRow(0, 1,"Weight Name");
			$sheet->getActiveSheet()->setCellValueByColumnAndRow(1, 1,"Weight Id");

			$row = 2;
			foreach ($res as $key) {
				$col = 0;
				foreach ($key as $k=>$field_val) {
					$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, html_entity_decode($field_val));
					$col++;
				}
				$row++;
			}

			$sheet_writer = PHPExcel_IOFactory::createWriter($sheet, 'Excel5');
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="weights_'.date('dMy').'.xls"');
			header('Cache-Control: max-age=0');
			$sheet_writer->save('php://output');
		}

	}

}
// End of controller