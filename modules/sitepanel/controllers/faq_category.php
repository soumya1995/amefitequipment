<?php
class faq_category extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('faq_category/faq_category_model'));
		$this->config->set_item('menu_highlight','faqs management');
		$this->form_validation->set_error_delimiters("<div class='required'>","</div>");
		$this->default_view = 'faq_category';		
	}

	public  function index(){
		
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url             =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$parent_id              =   (int) $this->uri->segment(4,0);
		
		$keyword = trim($this->input->get_post('keyword',TRUE));
		$keyword = $this->db->escape_str($keyword);
		
		$condtion = "AND parent_id = '$parent_id'";

		$condtion_array = array(
		'field' =>"*,( SELECT COUNT(faq_category_id) FROM wl_faq_category AS b
		WHERE b.parent_id=a.faq_category_id ) AS total_subcategories",
		'condition'=>$condtion,
		'limit'=>$config['limit'],
		'offset'=>$offset	,
		'debug'=>FALSE
		);
		$res_array              =  $this->faq_category_model->getfaq_category($condtion_array);

		$config['total_rows']	=  $this->faq_category_model->total_rec_found;

		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);

		$data['heading_title']  =  'Category';

		$data['res']            =  $res_array;
		$data['parent_id']      =  $parent_id;

		if( $this->input->post('status_action')!='')
		{
			if( $this->input->post('status_action')=='Delete')
			{
				$prod_id=$this->input->post('arr_ids');
				
				foreach($prod_id as $v){
					$rowdata=$this->faq_category_model->get_faq_category_by_id($v);
					$total_faq_category  = count_faq_category("AND parent_id='$v' ");
					$total_product   = count_products("AND faq_category_id='$v' ");
					if( $total_faq_category>0 || $total_product > 0 )
					{
					}else
					{
						$where = array('entity_type'=>'faq/index','entity_id'=>$v);
						$this->faq_category_model->safe_delete('wl_meta_tags',$where,TRUE);
					}
				}
			}
			$this->update_status('wl_faq_category','faq_category_id');
		}
		if( $this->input->post('update_order')!='')
		{
			$this->update_displayOrder('wl_faq_category','sort_order','faq_category_id');
		}
		
		// faq_category set as a
		if( $this->input->post('set_as')!='' )
		{
			$set_as    = $this->input->post('set_as',TRUE);
			$this->set_as('wl_faq_category','faq_category_id',array($set_as=>'1'));
		}
		
		if( $this->input->post('unset_as')!='' )
		{
			$unset_as   = $this->input->post('unset_as',TRUE);
			$this->set_as('wl_faq_category','faq_category_id',array($unset_as=>'0'));
		}
		// End faq_category set as a
		
		$this->load->view($this->default_view.'/view_faq_category_list',$data);
		
	}
	
	public function add(){
		
		$data['ckeditor']  =  set_ck_config(array('textarea_id'=>'cat_desc'));
		$parent_id         =  (int) $this->uri->segment(4,0);

		$img_allow_size =  $this->config->item('allow.file.size');
		$img_allow_dim  =  $this->config->item('allow.imgage.dimension');

		$faq_category_name = $this->db->escape_str($this->input->post('faq_category_name'));
		$posted_friendly_url = $this->input->post('friendly_url');
		
		if( $parent_id!='' && $parent_id > 0 )
		{
			$parent_id = applyFilter('NUMERIC_GT_ZERO',$parent_id);
			$data['heading_title'] = 'Add Category';
			
			if($parent_id<=0)
			{
				redirect("sitepanel/faq_category");
			}
			
			$parentdata=$this->faq_category_model->get_faq_category_by_id($parent_id);

			if(!is_array($parentdata))
			{
				$this->session->set_flashdata('message', lang('invalidRecord'));
				redirect('sitepanel/faq_category', '');
			}
			
			$this->cbk_friendly_url = 	$parentdata['friendly_url']."/".seo_url_title($posted_friendly_url);
			$data['parentData'] = $parentdata;
			
		}else
		{
			$this->cbk_friendly_url = seo_url_title($posted_friendly_url);
			$data['parentData'] = '';
			$data['heading_title'] = 'Add Category';
		}
		
		$seo_url_length = $this->config->item('seo_url_length');
		$this->form_validation->set_rules('faq_category_name','Category Title',"trim|required|max_length[100]|xss_clean|unique[wl_faq_category.faq_category_name='".$faq_category_name."' AND status!='2' AND parent_id='".$parent_id."']");
		$this->form_validation->set_rules('friendly_url','Page URL',"trim|required|max_length[$seo_url_length]|xss_clean|callback_checkurl");

		$this->form_validation->set_rules('faq_category_description','Description',"max_length[6000]");
		$this->form_validation->set_rules('faq_category_alt','Alt',"trim|max_length[100]");
		
		if($this->form_validation->run()===TRUE)
		{
			$uploaded_file = "";
			
			if( !empty($_FILES) && $_FILES['faq_category_image']['name']!='' )
			{
				$this->load->library('upload');
				$uploaded_data =  $this->upload->my_upload('faq_category_image','faq_category');
				
				if( is_array($uploaded_data)  && !empty($uploaded_data) )
				{
					$uploaded_file = $uploaded_data['upload_data']['file_name'];
					$watermark_img = UPLOAD_DIR."/faq_category/".$uploaded_file;
					img_watermark($watermark_img);
				}
			}
			
			$redirect_url = "faq/index";
			$faq_category_alt = $this->input->post('faq_category_alt');
			
			if($faq_category_alt =='')
			{
				$faq_category_alt = $this->input->post('faq_category_name');
			}
			
			#-------------------MAX SORT ORDER------------#
			$this->db->select_max('sort_order');
			$query = $this->db->get('wl_faq_category');
			$max_sort_order= $query->row_array();
			$max_sort_orders=$max_sort_order['sort_order']+1;
			#--------------------------------------------#

			$posted_data = array(
			'faq_category_name'=>$this->input->post('faq_category_name'),
			'faq_category_alt'=>$faq_category_alt,
			
			'faq_category_description'=>$this->input->post('faq_category_description'),
			'parent_id' =>$parent_id,
			'friendly_url'=>$this->cbk_friendly_url,
			'date_added'=>$this->config->item('config.date.time'),
			'faq_category_image'=>$uploaded_file,
			'sort_order'=>$max_sort_orders
			);

			$insertId = $this->faq_category_model->safe_insert('wl_faq_category',$posted_data,FALSE);

			if( $insertId > 0 )
			{
				$meta_array  = array(
				'entity_type'=>$redirect_url,
				'entity_id'=>$insertId,
				'page_url'=>$this->cbk_friendly_url,
				'meta_title'=>get_text($this->input->post('faq_category_name'),80),
				'meta_description'=>get_text($this->input->post('faq_category_description')),
				'meta_keyword'=>get_keywords($this->input->post('faq_category_description'))
				);
				
				create_meta($meta_array);
			}
			
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			$redirect_path= isset($parentdata) && is_array($parentdata) ? 'faq_category/index/'.$parentdata['faq_category_id'] : 'faq_category';
			redirect('sitepanel/'.$redirect_path, '');

		}
		$data['parent_id'] = $parent_id;
		$this->load->view($this->default_view.'/view_faq_category_add',$data);

	}
	
	public function edit()
	{
		$data['ckeditor'] = set_ck_config(array('textarea_id'=>'cat_desc'));
		$catId = (int) $this->uri->segment(4);
		$rowdata=$this->faq_category_model->get_faq_category_by_id($catId);

		$data['heading_title'] = 'Category';
		$img_allow_size =  $this->config->item('allow.file.size');
		$img_allow_dim  =  $this->config->item('allow.imgage.dimension');

		if( !is_array($rowdata) )
		{
			$this->session->set_flashdata('message', lang('idmissing'));
			redirect('sitepanel/faq_category', '');
		}
		
		$faq_categoryId = $rowdata['faq_category_id'];
		$this->form_validation->set_rules('faq_category_name','Category Title',"trim|required|max_length[100]|xss_clean|unique[wl_faq_category.faq_category_name='".$this->db->escape_str($this->input->post('faq_category_name'))."' AND status!='2' AND parent_id='".$rowdata['parent_id']."' AND faq_category_id!='".$faq_categoryId."']");
		$seo_url_length = $this->config->item('seo_url_length');
		$this->cbk_friendly_url = seo_url_title($this->input->post('friendly_url',TRUE));
		
		$this->form_validation->set_rules('friendly_url','Page URL',"trim|required|max_length[$seo_url_length]|xss_clean|callback_checkurl");
		$this->form_validation->set_rules('faq_category_description','Description',"max_length[6000]");
		$this->form_validation->set_rules('faq_category_image','Image',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");
		$this->form_validation->set_rules('faq_category_alt','Alt',"trim|max_length[100]");
		
		if($this->form_validation->run()==TRUE)
		{
			$uploaded_file = $rowdata['faq_category_image'];
			$unlink_image = array('source_dir'=>"faq_category",'source_file'=>$rowdata['faq_category_image']);
			if($this->input->post('cat_img_delete')==='Y')
			{
				removeImage($unlink_image);
				$uploaded_file = NULL;
			}
			if( !empty($_FILES) && $_FILES['faq_category_image']['name']!='' )
			{
				$this->load->library('upload');
				$uploaded_data =  $this->upload->my_upload('faq_category_image','faq_category');
				
				if( is_array($uploaded_data)  && !empty($uploaded_data) )
				{
					$uploaded_file = $uploaded_data['upload_data']['file_name'];
					removeImage($unlink_image);
					
					$watermark_img = UPLOAD_DIR."/faq_category/".$uploaded_file;
					img_watermark($watermark_img);
				}
			}
			
			$faq_category_alt = $this->input->post('faq_category_alt');
			
			if($faq_category_alt ==''){
				$faq_category_alt = $this->input->post('faq_category_name');
			}
			
			$posted_data = array(
			'faq_category_name'=>$this->input->post('faq_category_name'),
			'faq_category_alt'=>$faq_category_alt,
			
			'faq_category_description'=>$this->input->post('faq_category_description'),
			'friendly_url'=>$this->cbk_friendly_url,
			'faq_category_image'=>$uploaded_file
			);
			
			$where = "faq_category_id = '".$faq_categoryId."'";
			$this->faq_category_model->safe_update('wl_faq_category',$posted_data,$where,FALSE);

			$get_count_exits = count_record("wl_meta_tags", "entity_id ='" . $faq_categoryId . "' and entity_type ='faq/index'");

            if ($get_count_exits == 0) {

                if ($faq_categoryId > 0) {
                    $meta_array = array(
                        'entity_type' => 'faq/index',
                        'entity_id' => $faq_categoryId,
                        'page_url' => $this->cbk_friendly_url,
                        'meta_title' => get_text($this->input->post('faq_category_name'), 80),
                        'meta_description' => get_text($this->input->post('faq_category_name')),
                        'meta_keyword' => get_keywords($this->security->xss_clean($this->input->post('faq_category_name')))
                    );

                    create_meta($meta_array);
                }
            } else {

                update_meta_page_url('faq/index',$faq_categoryId,$this->cbk_friendly_url);			
            }
			

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));
			$redirect_path= $rowdata['parent_id']>0 ? 'faq_category/index/'. $rowdata['parent_id'] : 'faq_category';

			redirect('sitepanel/'.$redirect_path.'/'.query_string(), '');

		}

		$data['catresult']=$rowdata;
		$this->load->view($this->default_view.'/view_faq_category_edit',$data);

	}
	
	public function delete()
	{
		$catId = (int) $this->uri->segment(4,0);
	  	$rowdata=$this->faq_category_model->get_faq_category_by_id($catId);

	  if( !is_array($rowdata) )
	  {
			$this->session->set_flashdata('message', lang('idmissing'));
			redirect('sitepanel/faq_category', '');
		}
		else
		{
			  $where = array('faq_category_id'=>$catId);
			  $this->faq_category_model->safe_delete('wl_faq_category',$where,TRUE);
			  $entity_type = "faq/index";
			  $where = array('entity_id'=>$catId,"entity_type"=>$entity_type);
			  $this->utils_model->safe_delete('wl_meta_tags',$where,FALSE); 
			  $this->session->set_userdata(array('msg_type'=>'success'));
			  $this->session->set_flashdata('success',lang('deleted') );
		  		redirect($_SERVER['HTTP_REFERER'], '');
	  }
	}
	
	public function checkurl(){
		$faq_category_id=(int)$this->input->post('faq_category_id');
		
		if($faq_category_id!=''){
			$cont='and entity_id !='.$faq_category_id;
		}else{
			$cont='';
		}
		
		$posted_friendly_url = $this->input->post('friendly_url');
		$cbk_friendly_url = seo_url_title($posted_friendly_url);
		$urlcount=$this->db->query("select * from wl_meta_tags where page_url='".$cbk_friendly_url."'".$cont."")->num_rows();
		
		if($urlcount>0)
		{
			$this->form_validation->set_message('checkurl', 'URL already exists.');
			return FALSE;
		}else
		{
			return TRUE;
		}
		
	}

}
// End of controller