<?php
class Warranty extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('warranty/warranty_model'));
		$this->config->set_item('menu_highlight','product management');

	}

	public  function index($page = NULL){
		
		if( $this->input->post('status_action')!=''){
			
			$this->update_status('wl_warranty','warranty_id');
		}
		/* Product set as a */
		if( $this->input->post('set_as')!='' ){
		    $set_as    = $this->input->post('set_as',TRUE);
			$this->set_as('wl_warranty','warranty_id',array($set_as=>'1'));
		}

		if( $this->input->post('unset_as')!='' ){
		    $unset_as   = $this->input->post('unset_as',TRUE);
			$this->set_as('wl_warranty','warranty_id',array($unset_as=>'0'));
		}

		$condtion = array();
		$pagesize = (int) $this->input->get_post('pagesize');
		$config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url = current_url_query_string(array('filter'=>'result'),array('per_page'));

		$status = $this->input->get_post('status',TRUE);
		if($status!=''){
			$condtion['status'] = $status;
		}
		
		$data['heading_title']   =  'Warranty Lists';				
		$res_array               =  $this->warranty_model->get_warranty($config['limit'],$offset,$condtion);
		//echo_sql();
		$config['total_rows']    =  get_found_rows();
		
		$data['res']             =  $res_array;
		$data['page_links']      =   admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		
		/* End warranty set as a */

		$data['warranty_result_found'] = "Total ".$config['total_rows']." result(s) found ";
		$this->load->view('warranty/view_warranty_list',$data);
	}


	public function add(){

		$data['heading_title'] = 'Add Warranty';
		
		$data['ckeditor1']  =  set_ck_config(array('textarea_id'=>'description'));
		$img_allow_size =  $this->config->item('allow.file.size');
		$img_allow_dim  =  $this->config->item('allow.imgage.dimension');

		$this->form_validation->set_rules('title','Title',"trim|required|max_length[100]");		
		$this->form_validation->set_rules('price','Price',"trim|required|is_valid_amount|greater_than[0]|max_length[10]");			
		$this->form_validation->set_rules('description','Description',"trim|required|max_length[8500]"); 				
		$this->form_validation->set_rules('image1','Image',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");		

		if($this->form_validation->run()===TRUE){			
			
			$posted_data = array(		
			'title'=>$this->input->post('title',TRUE),
			'price'=>$this->input->post('price',TRUE),		
			'description'=>$this->input->post('description'),	
			'recv_date'=>$this->config->item('config.date.time')
			);			
			
			/*trace($posted_data);
			exit;*/
			$warrantyId = $this->warranty_model->safe_insert('wl_warranty',$posted_data,FALSE);
			$this->add_warranty_media($warrantyId);			
			
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/warranty', '');

		}
		$this->load->view('warranty/view_warranty_add',$data);

	}

	public function edit($warrantyId){

		$data['heading_title'] = 'Edit Warranty';
		$warrantyId = (int) $this->uri->segment(4);
		$option = array('warrantyid'=>$warrantyId);
		$res =  $this->warranty_model->get_warranty(1,0, $option);
		$data['ckeditor1']  =  set_ck_config(array('textarea_id'=>'description'));	

		$img_allow_size =  $this->config->item('allow.file.size');
		$img_allow_dim  =  $this->config->item('allow.imgage.dimension');
		
		$this->form_validation->set_rules('title','Title',"trim|required|max_length[255]");
		$this->form_validation->set_rules('price','Price',"trim|required|is_valid_amount|greater_than[0]|max_length[10]");
		$this->form_validation->set_rules('description','Description',"trim|required|max_length[8500]");		
		$this->form_validation->set_rules('images1','Image',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");

		if( is_array( $res ) && !empty( $res )){

			if($this->form_validation->run()==TRUE){

				$posted_data = array(							
				'title'=>$this->input->post('title',TRUE),
				'price'=>$this->input->post('price',TRUE),				
				'description'=>$this->input->post('description'),	
				'recv_date'=>$this->config->item('config.date.time')
				);

				$where = "warranty_id = '".$res['warranty_id']."'";
				$this->warranty_model->safe_update('wl_warranty',$posted_data,$where,FALSE);
				$this->edit_warranty_media($res['warranty_id']);
								
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('successupdate'));
				redirect('sitepanel/warranty/'. query_string(), '');

			}

			$data['res']=$res;	
			$media_option = array('productid'=>$warrantyId,'product_type'=>"W");
			$res_photo_media = $this->warranty_model->get_warranty_media(1,0, $media_option);
			$data['res_photo_media']=$res_photo_media;			
			$data['res']=$res;			
			$this->load->view('warranty/view_warranty_edit',$data);

		}else{
			redirect('sitepanel/warranty', '');
		}
	}

	public function add_warranty_media($warrantyId){
		
		if( !empty($_FILES) && ( $warrantyId > 0 ) ){
			$defalut_image = 'Y';

			foreach($_FILES as $key=>$val){
				$imgfld=$key;

				if(array_key_exists($imgfld,$_FILES)){
					
					$this->load->library('upload');
					$data_upload_sugg = $this->upload->my_upload($imgfld,"warranty");

					if( is_array($data_upload_sugg)  && !empty($data_upload_sugg) ){
						
					$watermark_img = UPLOAD_DIR."/warranty/".$data_upload_sugg['upload_data']['file_name'];
					img_watermark($watermark_img);
						
						$add_data = array(
						'products_id'=>$warrantyId,
						'media_type'=>'photo',
						'product_type'=>'W',
						'is_default'=>$defalut_image,
						'media'=>$data_upload_sugg['upload_data']['file_name'],
						'media_date_added' => $this->config->item('config.date.time')
						);
						$this->warranty_model->safe_insert('wl_media', $add_data ,FALSE );
					}
					$defalut_image = 'N';
				}
			}

		}

  }

	public function edit_warranty_media($warrantyId){
		
		//Current Media Files resultset
		$media_option = array('productid'=>$warrantyId);
		$res_photo_media = $this->warranty_model->get_warranty_media(1,0, $media_option);
		$res_photo_media = !is_array($res_photo_media ) ? array() : $res_photo_media ;

		$delete_media_files = $this->input->post('warranty_img_delete'); //checkbox items given for image deletion
		$arr_delete_items = array(); //holding our deleted ids for later use

		/* Tracking delete media ids coming from checkboxes */

		if(is_array($delete_media_files) && !empty($delete_media_files)){

			foreach($res_photo_media as $key=>$val){
				
				$media_id = $val['id'];
				if(array_key_exists($media_id,$delete_media_files)){
					 $media_file = $res_photo_media[$key]['media'];
					 $unlink_image = array('source_dir'=>"warranty",'source_file'=>$media_file);
					 removeImage($unlink_image);
					 array_push($arr_delete_items,$media_id);
				}
			}
		}

		/* Tracking Ends */

		/* Iterating Form Files */

		if( !empty($_FILES) && ( $warrantyId > 0 )){ 
			$sx = 0;
			foreach($_FILES as $key=>$val){
				$imgfld=$key;

				if(array_key_exists($imgfld,$_FILES)){
					$this->load->library('upload');
					$data_upload_sugg = $this->upload->my_upload($imgfld,"warranty");

					if( is_array($data_upload_sugg)  && !empty($data_upload_sugg) ){
						
					$watermark_img = UPLOAD_DIR."/warranty/".$data_upload_sugg['upload_data']['file_name'];
					img_watermark($watermark_img);
					
						/*  uploading successful  */
						$add_data = array(
						'products_id'=>$warrantyId,
						'media_type'=>'photo',
						'product_type'=>'W',
						'media'=>$data_upload_sugg['upload_data']['file_name'],
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
				               $this->warranty_model->safe_update('wl_media',$add_data,$where,FALSE);
							   $unlink_image = array('source_dir'=>"warranty",'source_file'=>$media_file);
							   removeImage($unlink_image);

							   /* New File has been browsed and delete checkbox also checked for this file */
							   /* This  media id cannot be removed as it been browsed and updated */
							   if(in_array($media_id,$arr_delete_items)){
									$media_del_index = array_search($media_id,$arr_delete_items);
									unset($arr_delete_items[$media_del_index]);
							   }

						}else{
							$this->warranty_model->safe_insert('wl_media', $add_data ,FALSE );
						}
					}
				}
				$sx++;
			}
		}

		if(!empty($arr_delete_items)){
			$del_ids = implode(',',$arr_delete_items);
			$where = " id IN(".$del_ids.") ";
			$this->warranty_model->delete_in('wl_media',$where,FALSE);
		}

  }

	
	public function download_pdf(){
		$pdfId=(int)$this->uri->segment(4,0);
		$pId=(int)$this->uri->segment(5,0);
		
		if($pId > 0 && $pdfId > 0){
			
			$pdf_name='warranty_pdf'.$pdfId;
			$file=get_db_field_value('wl_warranty', $pdf_name, array("warranty_id"=>$pId));
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
		$disc_price = floatval($this->input->post('warranty_discounted_price'));
		$price      = floatval($this->input->post('warranty_price'));
		if($disc_price>=$price){
			$this->form_validation->set_message('check_price', 'Discount price must be less than actual price.');
			return FALSE;
		}else{
			return TRUE;
		}
	}


	public  function price_variant($page = NULL){
		
		 $pagesize               =  (int) $this->input->get_post('pagesize');
	     $config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		 $offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		 $base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		 $warranty_id              =   (int) $this->uri->segment(4,0);

		 $condtion = " ";
		 $where="warranty_id = '".$warranty_id."'";
		 		 
		 $condtion_array = array(
		                'field' =>"*",
						 'condition'=>$condtion,
						 'where'=>$where,
						 'order'=>"attribute_id DESC",
						 'limit'=>$config['limit'],
						  'offset'=>$offset	,
						  'debug'=>FALSE
						 );
		$res_array              =  $this->price_model->get_prices($condtion_array);
		$config['total_rows']	=  $this->price_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Manage Weight [Price]';
		$data['res']            =  $res_array;
		$data['warranty_id']     =  $warranty_id;

		if( $this->input->post('status_action')!=''){			
			$this->update_status('wl_warranty_attributes','attribute_id');				
		}
		if( $this->input->post('update_order')!=''){
			$this->update_displayOrder('wl_warranty_attributes','sort_order','attribute_id');
		}
		if( $this->input->post('set_as')!='' ){
		    $set_as    = $this->input->post('set_as',TRUE);
			$this->set_as('wl_warranty_attributes','attribute_id',array($set_as=>'1'));
		}
		if( $this->input->post('unset_as')!='' ){
		    $unset_as   = $this->input->post('unset_as',TRUE);
			$this->set_as('wl_warranty_attributes','attribute_id',array($unset_as=>'0'));
		}
		$this->load->view('catalog/view_warranty_varient_list',$data);
	}


	public function editprice(){
		
		$data['heading_title'] = 'Edit Product';
		$warrantyId = (int) $this->uri->segment(4);
		$attribute_id = (int) $this->uri->segment(5);
		//$option = array('warrantyid'=>$warrantyId,'attribute_id'=>$attribute_id);
		$res =  $this->price_model->get_prices_by_id($attribute_id);
		
		$weightId=$this->db->escape_str($this->input->post('weight_id'));

		$this->form_validation->set_rules('weight_id','Weight',"trim|required|unique[wl_warranty_attributes.weight_id='".$weightId."' AND wl_warranty_attributes.warranty_id='".$this->db->escape_str($this->input->post('warranty_id'))."' AND status!='2' AND attribute_id!='".$attribute_id."']");
		
		$this->form_validation->set_rules('quantity','Stock',"trim|required|is_numeric|greater_than[0]");		
		
		$this->form_validation->set_rules('warranty_price','Price',"trim|required|is_valid_amount|greater_than[0]");
		//$this->form_validation->set_rules('warranty_discounted_price','Discount Price',"trim|is_valid_amount|callback_check_price");
		
		if( is_array( $res ) && !empty( $res )){			
		
			$discounted_price = $this->input->post('warranty_discounted_price',TRUE);
			$discounted_price = ($discounted_price=='') ? "0.0000" : $discounted_price;
			if($this->input->post('action')=='edit'){
				
				$weight_res=get_db_single_row('wl_weights','weight_name',' and  weight_id ='.$weightId.' ');
				$weight_name=$weight_res['weight_name'];
			
				if($this->form_validation->run()==TRUE){
					$warranty_data = array(
					'weight_id'=>$weightId,
					'quantity'=>$this->input->post('quantity',TRUE),
					'warranty_price'=>$this->input->post('warranty_price',TRUE),
					'warranty_discounted_price'=>$discounted_price,
					'variant_name'=>$weight_name
					);

					$where = "warranty_id = '".$warrantyId."' AND attribute_id='".$attribute_id."'";
					$this->warranty_model->safe_update('wl_warranty_attributes',$warranty_data,$where,FALSE);
					
					$min_price_res=get_minimum_warranty_price($warrantyId);
					if( is_array( $min_price_res ) && !empty( $min_price_res )){						
						
						$pdiscounted_price = $min_price_res['warranty_discounted_price'];
						$pdiscounted_price = ($pdiscounted_price=='') ? "0.0000" : $pdiscounted_price;
			
						$pwarranty_data = array(
						'weight_id'=>$min_price_res['weight_id'],
						'warranty_price'=>$min_price_res['warranty_price'],
						'warranty_discounted_price'=>$pdiscounted_price,
						);

						$where = "warranty_id = '".$min_price_res['warranty_id']."' ";
						$this->warranty_model->safe_update('wl_warranty',$pwarranty_data,$where,FALSE);						
					}					
					
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success','Price Variant updated successfully');
					echo '<script type="text/javascript">window.opener.location.reload(true);
					window.close();</script>';
					exit;
				}
			}
			$data['res']=$res;
			$weight_cond_config = array(
				'condition' => " AND status='1' ",
				'order'=>'weight_name '
			);
			$weights = $this->weight_model->get_weights($weight_cond_config);
			$data['weights'] = $weights;
			$this->load->view('catalog/view_edit_price',$data);
		}
	}

	public function addprice(){
		
		$data['heading_title'] = 'Add Product Price';
		$warrantyId = (int) $this->uri->segment(4);
		//$option = array('warrantyid'=>$warrantyId);
		//$res =  $this->warranty_model->get_warranty(1,0, $option);
		
		$weightId=$this->db->escape_str($this->input->post('weight_id'));
		
		$this->form_validation->set_rules('weight_id','Weight',"trim|required|unique[wl_warranty_attributes.weight_id='".$weightId."' AND wl_warranty_attributes.warranty_id='".$this->db->escape_str($this->input->post('warranty_id'))."' AND status!='2']");
		
		$this->form_validation->set_rules('quantity','Stock',"trim|required|is_numeric|greater_than[0]");	
		
		$this->form_validation->set_rules('warranty_price','Price',"trim|required|is_valid_amount|greater_than[0]");
		//$this->form_validation->set_rules('warranty_discounted_price','Discount Price',"trim|is_valid_amount|callback_check_price");

		$discounted_price = $this->input->post('warranty_discounted_price',TRUE);
		$discounted_price = ($discounted_price=='') ? "0.0000" : $discounted_price;

			if($this->form_validation->run()==TRUE){
				
				$weight_res=get_db_single_row('wl_weights','weight_name',' and  weight_id ='.$weightId.' ');
				$weight_name=$weight_res['weight_name'];
				
					$warranty_data = array(
					'weight_id'=>$this->input->post('weight_id',TRUE),
					'quantity'=>$this->input->post('quantity',TRUE),
					'warranty_price'=>$this->input->post('warranty_price',TRUE),
					'warranty_discounted_price'=>$discounted_price,
					'variant_name'=>$weight_name,
					'warranty_id'=>$this->input->post('warranty_id')
					);

					$this->warranty_model->safe_insert('wl_warranty_attributes',$warranty_data,FALSE);
					
					$min_price_res=get_minimum_warranty_price($warrantyId);
					if( is_array( $min_price_res ) && !empty( $min_price_res )){						
						
						$pdiscounted_price = $min_price_res['warranty_discounted_price'];
						$pdiscounted_price = ($pdiscounted_price=='') ? "0.0000" : $pdiscounted_price;
			
						$pwarranty_data = array(
						'weight_id'=>$min_price_res['weight_id'],
						'warranty_price'=>$min_price_res['warranty_price'],
						'warranty_discounted_price'=>$pdiscounted_price,
						);

						$where = "warranty_id = '".$min_price_res['warranty_id']."' ";
						$this->warranty_model->safe_update('wl_warranty',$pwarranty_data,$where,FALSE);						
					}	
					
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success','Price Variant added successfully');
					 echo '<script type="text/javascript">window.opener.location.reload(true);
					window.close();</script>';
					exit;
				}
			$weight_cond_config = array(
				'condition' => " AND status='1' ",
				'order'=>'weight_name '
			);
			$weights = $this->weight_model->get_weights($weight_cond_config);
			$data['weights'] = $weights;
			$this->load->view('catalog/view_add_price',$data);

	}
	
	
	 public function delete_price_variant()
	 {	
		$warranty_id = $ref_pid =  (int) $this->uri->segment(4);
		$attribute_id =  (int) $this->uri->segment(5);
		
		if ($warranty_id && $attribute_id) {
				
			$delete_data = array('attribute_id'=>$attribute_id );
			$this->warranty_model->safe_delete('wl_warranty_attributes',$delete_data,FALSE);	
			
			$min_price_res=get_minimum_warranty_price($warranty_id);
			if( is_array( $min_price_res ) && !empty( $min_price_res )){						
				
				$pdiscounted_price = $min_price_res['warranty_discounted_price'];
				$pdiscounted_price = ($pdiscounted_price=='') ? "0.0000" : $pdiscounted_price;
	
				$pwarranty_data = array(
				'weight_id'=>$min_price_res['weight_id'],
				'warranty_price'=>$min_price_res['warranty_price'],
				'warranty_discounted_price'=>$pdiscounted_price,
				);

				$where = "warranty_id = '".$min_price_res['warranty_id']."' ";
				$this->warranty_model->safe_update('wl_warranty',$pwarranty_data,$where,FALSE);						
			}else{
				$pwarranty_data = array(
				'weight_id'=>'',
				'warranty_price'=>'0.00',
				'warranty_discounted_price'=>'0.00',
				);

				$where = "warranty_id = '".$warranty_id."' ";
				$this->warranty_model->safe_update('wl_warranty',$pwarranty_data,$where,FALSE);
				
			}
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',"Weight [Price] has been deleted successfully." );
			redirect('sitepanel/warranty/price_variant/'.$warranty_id, '');
		}		

	 }


	public function checkurl(){

	  		$warranty_id=(int)$this->input->post('warranty_id');

			if($warranty_id!=''){
				$cont='and entity_id !='.$warranty_id;
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

	function bulk_uploading(){
		
		$this->form_validation->set_rules('bulk_data', 'Data Excel', "required|file_allow_type[document]");

		if ($this->form_validation->run() == TRUE) {
			$this->load->library('upload');
			$data = $this->upload->my_upload('bulk_data', 'warranty');

			if (is_array($data) && !empty($data)) {
				$file_path = $data['upload_data']['full_path'];
				$this->import_bulk_data_from_excel_sheet($file_path);
				redirect('sitepanel/warranty/bulk_uploading');
			}
		}
		$data['heading_title'] = "Bulk Upload";
		$this->load->view('catalog/bulk_upload_view', $data);
	}

	public function download_warranty_format(){
		$headers = '';
		$data = '';
		ob_start();

		$select =" category_id, title, warranty_code, warranty_description";

		$qry = $this->db->query("select ".$select." from wl_warranty where status !='2'");

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
			header('Content-Disposition: attachment;filename="warranty_'.date('dMy').'.xls"');
			header('Cache-Control: max-age=0');
			$sheet_writer->save('php://output');
		}

	}

	public function import_bulk_data_from_excel_sheet($path = '') {
		$this->load->library('excel');
		$objReader = new PHPExcel_Reader_Excel5();
		$objPHPExcel = $objReader->load($path);
		$worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

		if (is_array($worksheet) && count($worksheet) > 0) {

			$total = count($worksheet);
			$li="";

			for ($i = 2; $i <= $total; $i++) {
				//trace($worksheet);
				//exit;

				$worksheet[$i]=array_filter($worksheet[$i]);

				$category_id = trim($worksheet[$i]["A"]);
				$title = $worksheet[$i]["B"];
				$warranty_code = $worksheet[$i]["C"];				
				$warranty_description=@$worksheet[$i]["D"];

				$pic1 = @$worksheet[$i]["Q"];
				$pic2 = @$worksheet[$i]["R"];
				$pic3 = @$worksheet[$i]["S"];
				$pic4 = @$worksheet[$i]["T"];

				if($category_id==""){
					$li .="<li>Row $i Category Id is Required</li>";
					continue;
				}
				if($title==""){
					$li .="<li>Row $i Product Name is Required</li>";
					continue;
				}
				if($warranty_code==""){
					$li .="<li>Row $i Product Code is Required</li>";
					continue;
				}				

				$warranty_query = $this->db->query("select warranty_id from wl_warranty where warranty_code ='" . $warranty_code . "' and status !='2'");
				$warranty_found=$warranty_query->num_rows();

				$warranty_friendly_url=@url_title($title);
				$cbk_friendly_url = seo_url_title($warranty_friendly_url);

				$urlcount=$this->db->query("select * from wl_meta_tags where page_url='".$cbk_friendly_url."'")->num_rows();


				if ($warranty_found == 0 && $urlcount==0) {

					$category_links = get_parent_categories($category_id,"AND status='1'","category_id,parent_id");
					$category_links = @array_keys($category_links);
					$category_links = @implode(",",$category_links);

					$posted_data = array(
							'category_id'=>$category_id,
							'category_links'=>$category_links,
							'title'=>$title,
							'warranty_code'=>$warranty_code,
							"friendly_url"=>$warranty_friendly_url,
							'warranty_description'=>$warranty_description,
							"xls_type"=>'1'
					);
					
					//trace($posted_data);
					//exit;
					
					$posted_data['warranty_added_date']=$this->config->item('config.date.time');
					$warrantyId = $this->warranty_model->safe_insert('wl_warranty',$posted_data,FALSE);
					
					
					if(!empty($pic1)){
						$add_data = array(
								'warranty_id'=>$warrantyId,
								'media_type'=>'photo',
								'is_default'=>"Y",
								'media'=>$pic1,
								'media_date_added' => $this->config->item('config.date.time')
						);
						$this->warranty_model->safe_insert('wl_warranty_media', $add_data ,FALSE );
					}
					
					if(!empty($pic2)){
						$add_data = array(
								'warranty_id'=>$warrantyId,
								'media_type'=>'photo',
								'is_default'=>"N",
								'media'=>$pic2,
								'media_date_added' => $this->config->item('config.date.time')
						);
						$this->warranty_model->safe_insert('wl_warranty_media', $add_data ,FALSE );
					}
					
					if(!empty($pic3)){
						$add_data = array(
								'warranty_id'=>$warrantyId,
								'media_type'=>'photo',
								'is_default'=>"N",
								'media'=>$pic3,
								'media_date_added' => $this->config->item('config.date.time')
						);
						$this->warranty_model->safe_insert('wl_warranty_media', $add_data ,FALSE );
					}
					
					if(!empty($pic4)){
						$add_data = array(
								'warranty_id'=>$warrantyId,
								'media_type'=>'photo',
								'is_default'=>"N",
								'media'=>$pic4,
								'media_date_added' => $this->config->item('config.date.time')
						);
						$this->warranty_model->safe_insert('wl_warranty_media', $add_data ,FALSE );
					}

					if( $warrantyId > 0 ){

						$redirect_url = "warranty/detail";
			  			$meta_array  = array(
							  'entity_type'=>$redirect_url,
							  'entity_id'=>$warrantyId,
							  'page_url'=>$warranty_friendly_url,
							  'meta_title'=>get_text($title,80),
							  'meta_description'=>get_text($warranty_description,100),
							  'meta_keyword'=>get_text($warranty_description,100)
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