<?php
class gym_packages extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('gym_packages/gym_packages_model'));
		$this->config->set_item('menu_highlight','menu management');
		$this->form_validation->set_error_delimiters("<div class='required'>","</div>");
		$this->default_view = 'gym_packages';		
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
		'field' =>"*,( SELECT COUNT(gym_packages_id) FROM wl_gym_packages AS b
		WHERE b.parent_id=a.gym_packages_id ) AS total_subcategories",
		'condition'=>$condtion,
		'limit'=>$config['limit'],
		'offset'=>$offset	,
		'debug'=>FALSE
		);
		$res_array              =  $this->gym_packages_model->getgym_packages($condtion_array);

		$config['total_rows']	=  $this->gym_packages_model->total_rec_found;

		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);

		$data['heading_title']  =  'Gym Packages';

		$data['res']            =  $res_array;
		$data['parent_id']      =  $parent_id;

		if( $this->input->post('status_action')!='')
		{
			if( $this->input->post('status_action')=='Delete')
			{
				$prod_id=$this->input->post('arr_ids');
				
				foreach($prod_id as $v){
					$rowdata=$this->gym_packages_model->get_gym_packages_by_id($v);
					$total_gym_packages  = count_gym_packages("AND parent_id='$v' ");
					$total_product   = count_products("AND gym_packages_id='$v' ");
					if( $total_gym_packages>0 || $total_product > 0 )
					{
					}else
					{
						$where = array('entity_type'=>'gym_packages/index','entity_id'=>$v);
						$this->gym_packages_model->safe_delete('wl_meta_tags',$where,TRUE);
					}
				}
			}
			$this->update_status('wl_gym_packages','gym_packages_id');
		}
		if( $this->input->post('update_order')!='')
		{
			$this->update_displayOrder('wl_gym_packages','sort_order','gym_packages_id');
		}
		
		// gym_packages set as a
		if( $this->input->post('set_as')!='' )
		{
			$set_as    = $this->input->post('set_as',TRUE);
			$this->set_as('wl_gym_packages','gym_packages_id',array($set_as=>'1'));
		}
		
		if( $this->input->post('unset_as')!='' )
		{
			$unset_as   = $this->input->post('unset_as',TRUE);
			$this->set_as('wl_gym_packages','gym_packages_id',array($unset_as=>'0'));
		}
		// End gym_packages set as a
		
		$this->load->view($this->default_view.'/view_gym_packages_list',$data);
		
	}
	
	public function add(){
		
		$data['ckeditor']  =  set_ck_config(array('textarea_id'=>'cat_desc'));
		$parent_id         =  (int) $this->uri->segment(4,0);

		$img_allow_size =  $this->config->item('allow.file.size');
		$img_allow_dim  =  $this->config->item('allow.imgage.dimension');

		$gym_packages_name = $this->db->escape_str($this->input->post('gym_packages_name'));
		$posted_friendly_url = $this->input->post('friendly_url');
		
		if( $parent_id!='' && $parent_id > 0 )
		{
			$parent_id = applyFilter('NUMERIC_GT_ZERO',$parent_id);
			$data['heading_title'] = 'Add Gym Packages';
			
			if($parent_id<=0)
			{
				redirect("sitepanel/gym_packages");
			}
			
			$parentdata=$this->gym_packages_model->get_gym_packages_by_id($parent_id);

			if(!is_array($parentdata))
			{
				$this->session->set_flashdata('message', lang('invalidRecord'));
				redirect('sitepanel/gym_packages', '');
			}
			
			$this->cbk_friendly_url = 	$parentdata['friendly_url']."/".seo_url_title($posted_friendly_url);
			$data['parentData'] = $parentdata;
			
		}else
		{
			$this->cbk_friendly_url = seo_url_title($posted_friendly_url);
			$data['parentData'] = '';
			$data['heading_title'] = 'Add Gym Packages';
		}
		
		$seo_url_length = $this->config->item('seo_url_length');
		$this->form_validation->set_rules('gym_packages_name','Gym Packages Title',"trim|required|max_length[100]|xss_clean|unique[wl_gym_packages.gym_packages_name='".$gym_packages_name."' AND status!='2' AND parent_id='".$parent_id."']");
		$this->form_validation->set_rules('friendly_url','Page URL',"trim|required|max_length[$seo_url_length]|xss_clean|callback_checkurl");

		$this->form_validation->set_rules('gym_packages_description','Description',"required|max_length[6000]");
		$this->form_validation->set_rules('gym_packages_alt','Alt',"trim|max_length[100]");
		
		if($this->form_validation->run()===TRUE)
		{
			$uploaded_file = "";
			
			if( !empty($_FILES) && $_FILES['gym_packages_image']['name']!='' )
			{
				$this->load->library('upload');
				$uploaded_data =  $this->upload->my_upload('gym_packages_image','gym_packages');
				
				if( is_array($uploaded_data)  && !empty($uploaded_data) )
				{
					$uploaded_file = $uploaded_data['upload_data']['file_name'];
					$watermark_img = UPLOAD_DIR."/gym_packages/".$uploaded_file;
					img_watermark($watermark_img);
				}
			}
			
			$redirect_url = "gym_packages/index";
			$gym_packages_alt = $this->input->post('gym_packages_alt');
			
			if($gym_packages_alt =='')
			{
				$gym_packages_alt = $this->input->post('gym_packages_name');
			}
			
			#-------------------MAX SORT ORDER------------#
			$this->db->select_max('sort_order');
			$query = $this->db->get('wl_gym_packages');
			$max_sort_order= $query->row_array();
			$max_sort_orders=$max_sort_order['sort_order']+1;
			#--------------------------------------------#

			$posted_data = array(
			'gym_packages_name'=>$this->input->post('gym_packages_name'),
			'gym_packages_alt'=>$gym_packages_alt,
			
			'gym_packages_description'=>$this->input->post('gym_packages_description'),
			'parent_id' =>$parent_id,
			'friendly_url'=>$this->cbk_friendly_url,
			'date_added'=>$this->config->item('config.date.time'),
			'gym_packages_image'=>$uploaded_file,
			'sort_order'=>$max_sort_orders
			);

			$insertId = $this->gym_packages_model->safe_insert('wl_gym_packages',$posted_data,FALSE);

			if( $insertId > 0 )
			{
				$meta_array  = array(
				'entity_type'=>$redirect_url,
				'entity_id'=>$insertId,
				'page_url'=>$this->cbk_friendly_url,
				'meta_title'=>get_text($this->input->post('gym_packages_name'),80),
				'meta_description'=>get_text($this->input->post('gym_packages_description')),
				'meta_keyword'=>get_keywords($this->input->post('gym_packages_description'))
				);
				
				create_meta($meta_array);
			}
			
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			$redirect_path= isset($parentdata) && is_array($parentdata) ? 'gym_packages/index/'.$parentdata['gym_packages_id'] : 'gym_packages';
			redirect('sitepanel/'.$redirect_path, '');

		}
		$data['parent_id'] = $parent_id;
		$this->load->view($this->default_view.'/view_gym_packages_add',$data);

	}
	
	public function edit()
	{
		$data['ckeditor'] = set_ck_config(array('textarea_id'=>'cat_desc'));
		$catId = (int) $this->uri->segment(4);
		$rowdata=$this->gym_packages_model->get_gym_packages_by_id($catId);

		$data['heading_title'] = 'Gym Packages';
		$img_allow_size =  $this->config->item('allow.file.size');
		$img_allow_dim  =  $this->config->item('allow.imgage.dimension');

		if( !is_array($rowdata) )
		{
			$this->session->set_flashdata('message', lang('idmissing'));
			redirect('sitepanel/gym_packages', '');
		}
		
		$gym_packagesId = $rowdata['gym_packages_id'];
		$this->form_validation->set_rules('gym_packages_name','Title',"trim|required|max_length[100]|xss_clean|unique[wl_gym_packages.gym_packages_name='".$this->db->escape_str($this->input->post('gym_packages_name'))."' AND status!='2' AND parent_id='".$rowdata['parent_id']."' AND gym_packages_id!='".$gym_packagesId."']");
		$seo_url_length = $this->config->item('seo_url_length');
		$this->cbk_friendly_url = seo_url_title($this->input->post('friendly_url',TRUE));
		
		$this->form_validation->set_rules('friendly_url','Page URL',"trim|required|max_length[$seo_url_length]|xss_clean|callback_checkurl");
		$this->form_validation->set_rules('gym_packages_description','Description',"required|max_length[6000]");
		$this->form_validation->set_rules('gym_packages_image','Image',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");
		$this->form_validation->set_rules('gym_packages_alt','Alt',"trim|max_length[100]");
		
		if($this->form_validation->run()==TRUE)
		{
			$uploaded_file = $rowdata['gym_packages_image'];
			$unlink_image = array('source_dir'=>"gym_packages",'source_file'=>$rowdata['gym_packages_image']);
			if($this->input->post('cat_img_delete')==='Y')
			{
				removeImage($unlink_image);
				$uploaded_file = NULL;
			}
			if( !empty($_FILES) && $_FILES['gym_packages_image']['name']!='' )
			{
				$this->load->library('upload');
				$uploaded_data =  $this->upload->my_upload('gym_packages_image','gym_packages');
				
				if( is_array($uploaded_data)  && !empty($uploaded_data) )
				{
					$uploaded_file = $uploaded_data['upload_data']['file_name'];
					removeImage($unlink_image);
					
					$watermark_img = UPLOAD_DIR."/gym_packages/".$uploaded_file;
					img_watermark($watermark_img);
				}
			}
			
			$gym_packages_alt = $this->input->post('gym_packages_alt');
			
			if($gym_packages_alt ==''){
				$gym_packages_alt = $this->input->post('gym_packages_name');
			}
			
			$posted_data = array(
			'gym_packages_name'=>$this->input->post('gym_packages_name'),
			'gym_packages_alt'=>$gym_packages_alt,
			
			'gym_packages_description'=>$this->input->post('gym_packages_description'),
			'friendly_url'=>$this->cbk_friendly_url,
			'gym_packages_image'=>$uploaded_file
			);
			
			$where = "gym_packages_id = '".$gym_packagesId."'";
			$this->gym_packages_model->safe_update('wl_gym_packages',$posted_data,$where,FALSE);

			$get_count_exits = count_record("wl_meta_tags", "entity_id ='" . $gym_packagesId . "' and entity_type ='gym_packages/index'");

            if ($get_count_exits == 0) {

                if ($gym_packagesId > 0) {
                    $meta_array = array(
                        'entity_type' => 'gym_packages/index',
                        'entity_id' => $gym_packagesId,
                        'page_url' => $this->cbk_friendly_url,
                        'meta_title' => get_text($this->input->post('gym_packages_name'), 80),
                        'meta_description' => get_text($this->input->post('gym_packages_name')),
                        'meta_keyword' => get_keywords($this->security->xss_clean($this->input->post('gym_packages_name')))
                    );

                    create_meta($meta_array);
                }
            } else {

                update_meta_page_url('gym_packages/index',$gym_packagesId,$this->cbk_friendly_url);			
            }
			

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));
			$redirect_path= $rowdata['parent_id']>0 ? 'gym_packages/index/'. $rowdata['parent_id'] : 'gym_packages';

			redirect('sitepanel/'.$redirect_path.'/'.query_string(), '');

		}

		$data['catresult']=$rowdata;
		$this->load->view($this->default_view.'/view_gym_packages_edit',$data);

	}
	
	public function delete()
	{
		$catId = (int) $this->uri->segment(4,0);
	  	$rowdata=$this->gym_packages_model->get_gym_packages_by_id($catId);

	  if( !is_array($rowdata) )
	  {
			$this->session->set_flashdata('message', lang('idmissing'));
			redirect('sitepanel/gym_packages', '');
		}
		else
		{
			  $where = array('gym_packages_id'=>$catId);
			  $this->gym_packages_model->safe_delete('wl_gym_packages',$where,TRUE);
			  $entity_type = "gym_packages/index";
			  $where = array('entity_id'=>$catId,"entity_type"=>$entity_type);
			  $this->utils_model->safe_delete('wl_meta_tags',$where,FALSE); 
			  $this->session->set_userdata(array('msg_type'=>'success'));
			  $this->session->set_flashdata('success',lang('deleted') );
		  		redirect($_SERVER['HTTP_REFERER'], '');
	  }
	}
	
	public function checkurl(){
		$gym_packages_id=(int)$this->input->post('gym_packages_id');
		
		if($gym_packages_id!=''){
			$cont='and entity_id !='.$gym_packages_id;
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