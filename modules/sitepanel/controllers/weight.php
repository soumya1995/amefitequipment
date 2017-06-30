<?php
class Weight extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('weight/weight_model'));
		$this->load->helper('category/category');
		$this->config->set_item('menu_highlight','product management');
	}

	public  function index()
	{
		 $pagesize               =  (int) $this->input->get_post('pagesize');
	     $config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		 $offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		 $base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		 $parent_id              =   (int) $this->uri->segment(4,0);

		 $condtion = " ";
		 $where="";
		 $keyword = trim($this->input->get_post('keyword',TRUE));
		 $keyword = $this->db->escape_str($keyword);
		 if(!empty($keyword)){
			 $where="weight_name like '%$keyword%'";
		 }
		 
		$condtion_array = array(
		                'field' =>"*",
						 'condition'=>$condtion,
						 'where'=>$where,
						 'order'=>"weight_name ASC",
						 'limit'=>$config['limit'],
						  'offset'=>$offset	,
						  'debug'=>FALSE
						 );
		$res_array              =  $this->weight_model->get_weights($condtion_array);

		$config['total_rows']	=  $this->weight_model->total_rec_found;

		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);

		$data['heading_title']  =  'Weights';

		$data['res']            =  $res_array;

		$data['parent_id']      =  $parent_id;


		if( $this->input->post('status_action')!='')
		{			
			$this->update_status('wl_weights','weight_id');				
		}
		if( $this->input->post('update_order')!='')
		{
			$this->update_displayOrder('wl_weights','sort_order','weight_id');
		}

		if( $this->input->post('set_as')!='' )
		{
		    $set_as    = $this->input->post('set_as',TRUE);
			$this->set_as('wl_weights','weight_id',array($set_as=>'1'));
		}

		if( $this->input->post('unset_as')!='' )
		{
		    $unset_as   = $this->input->post('unset_as',TRUE);
			$this->set_as('wl_weights','weight_id',array($unset_as=>'0'));
		}

		$this->load->view('weight/view_weight_list',$data);


	}

	public function add()
	{
		$img_allow_size =  $this->config->item('allow.file.size');
		$img_allow_dim  =  $this->config->item('allow.imgage.dimension');

		$posted_friendly_url = $this->input->post('friendly_url');
		$this->cbk_friendly_url = seo_url_title($posted_friendly_url);
		$seo_url_length = $this->config->item('seo_url_length');

		$data['heading_title'] = 'Add Weight';

		$this->form_validation->set_rules('weight_name','Weight Name',"trim|required|is_valid_amount|greater_than[0]|xss_clean|unique[wl_weights.weight_name='".$this->db->escape_str($this->input->post('weight_name'))."' AND status!='2']");
		//$this->form_validation->set_rules('friendly_url','Page URL',"trim|required|max_length[$seo_url_length]|xss_clean|callback_checkurl");
		//$this->form_validation->set_rules('weight_image','Image',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");

		if($this->form_validation->run()===TRUE)
		{
			$uploaded_file = "";

			if( !empty($_FILES) && $_FILES['weight_image']['name']!='' ){
				$this->load->library('upload');
				$uploaded_data =  $this->upload->my_upload('weight_image','weight');

				if( is_array($uploaded_data)  && !empty($uploaded_data) ){
					$uploaded_file = $uploaded_data['upload_data']['file_name'];
				}
			}

			$posted_data = array(
			'weight_name'=>$this->input->post('weight_name'),
			//'friendly_url'		=>	$this->cbk_friendly_url,
			'date_added'=>$this->config->item('config.date.time'),
			'weight_image'=>$uploaded_file
			);

			$entityId =  $this->weight_model->safe_insert('wl_weights',$posted_data,FALSE);
			/*if($entityId>0) {	
				$redirect_url="products/weight/".$entityId;
				$meta_array  = array(
				'entity_type'		=>	$redirect_url,
				'entity_id'		=>	$entityId,
				'page_url'		=>	$this->cbk_friendly_url,
				'meta_title'		=>	get_text($this->input->post('weight_name'),80),
				'meta_description'=>	get_text($this->input->post('news_description')),
				'meta_keyword'	=>	get_keywords($this->input->post('news_description'))
				);
				
				create_meta($meta_array);
			}*/

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/weight', '');

		}
		$this->load->view('weight/view_weight_add',$data);
	}


	public function edit()
	{
		$weightId = (int) $this->uri->segment(4);
		
		$rowdata=$this->weight_model->get_weight_by_id($weightId);
		
		$weightId = $rowdata['weight_id'];
		
		$data['heading_title'] = 'Edit Weight';
		
		$img_allow_size =  $this->config->item('allow.file.size');
		$img_allow_dim  =  $this->config->item('allow.imgage.dimension');
		
		//$posted_friendly_url = $this->input->post('friendly_url');
		//$this->cbk_friendly_url = seo_url_title($posted_friendly_url);
		//$seo_url_length = $this->config->item('seo_url_length');

		if( !is_array($rowdata) )
		{
			$this->session->set_flashdata('message', lang('idmissing'));
			redirect('sitepanel/weight', '');

		}

			$this->form_validation->set_rules('weight_name','Weigh Name',"trim|required|is_valid_amount|greater_than[0]|xss_clean|unique[wl_weights.weight_name='".$this->db->escape_str($this->input->post('weight_name'))."' AND status!='2' AND weight_id != ".$weightId."]");
			//$this->form_validation->set_rules('friendly_url','Page URL',"trim|required|max_length[$seo_url_length]|xss_clean|callback_checkurl");
			//$this->form_validation->set_rules('weight_image','Image',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");

			if($this->form_validation->run()==TRUE)
			{

				$uploaded_file = $rowdata['weight_image'];
				$unlink_image = array('source_dir'=>"weight",'source_file'=>$rowdata['weight_image']);
			 	if($this->input->post('weight_img_delete')==='Y')
				 {
					removeImage($unlink_image);
					$uploaded_file = NULL;

				 }
				 if( !empty($_FILES) && $_FILES['weight_image']['name']!='' )
				 {
						$this->load->library('upload');

						$uploaded_data =  $this->upload->my_upload('weight_image','weight');

						if( is_array($uploaded_data)  && !empty($uploaded_data) )
						{
							$uploaded_file = $uploaded_data['upload_data']['file_name'];
						    removeImage($unlink_image);
						}

				}

				$posted_data = array(
					'weight_name'=>$this->input->post('weight_name'),
					//'friendly_url'		=>	$this->cbk_friendly_url,
					'weight_image'=>$uploaded_file
				 );

			 	$where = "weight_id = '".$weightId."'";
				$this->weight_model->safe_update('wl_weights',$posted_data,$where,FALSE);
				//$id=$weightId;
				//update_meta_page_url('products/weight/'.$id,$id,$this->cbk_friendly_url);				

				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('successupdate'));

				redirect('sitepanel/weight'.'/'.query_string(), '');

			}

		$data['edit_result']=$rowdata;
		$this->load->view('weight/view_weight_edit',$data);

	}


}
// End of controller