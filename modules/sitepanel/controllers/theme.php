<?php
class Theme extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('theme/theme_model'));
		$this->config->set_item('menu_highlight','product management');
	}

	public  function index()
	{

		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$parent_id              =   (int) $this->uri->segment(4,0);

		$keyword = trim($this->input->get_post('keyword',TRUE));
		$keyword = $this->db->escape_str($keyword);
		$condtion = " ";

		$condtion_array = array(
		'field' =>"*",
		'condition'=>$condtion,
		'limit'=>$config['limit'],
		'offset'=>$offset	,
		'debug'=>FALSE
		);

		$res_array              =  $this->theme_model->getthemes($condtion_array);

		$config['total_rows']	=  $this->theme_model->total_rec_found;

		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);

		$data['heading_title']  =  'Theme';

		$data['res']            =  $res_array;

		$data['parent_id']      =  $parent_id;


		if( $this->input->post('status_action')!='')
		{
			$this->update_status('wl_themes','theme_id');
		}
		if( $this->input->post('update_order')!='')
		{
			$this->update_displayOrder('wl_themes','sort_order','theme_id');
		}

		$this->load->view('theme/view_theme_list',$data);

	}

	public function add()
	{
		$data['heading_title'] = 'Add Theme';
		$posted_friendly_url = $this->input->post('friendly_url');
		$this->cbk_friendly_url = seo_url_title($posted_friendly_url);
		$seo_url_length = $this->config->item('seo_url_length');
		
		$this->form_validation->set_rules('theme_name','Theme Name',"trim|required|max_length[32]|xss_clean|unique[wl_themes.theme_name='".$this->db->escape_str($this->input->post('theme_name'))."' AND status!='2']");
		$this->form_validation->set_rules('friendly_url','Page URL',"trim|required|max_length[$seo_url_length]|xss_clean|callback_checkurl");
		
		if($this->form_validation->run()===TRUE)
		{
			#-------------------MAX SORT ORDER------------#
			$this->db->select_max('sort_order');
			$query = $this->db->get('wl_themes');
			$max_sort_order= $query->row_array();
			$max_sort_orders=$max_sort_order['sort_order']+1;
			#--------------------------------------------#
			$posted_data = array(
			'theme_name'=>$this->input->post('theme_name'),
			'friendly_url'		=>	$this->cbk_friendly_url,
			'sort_order'=>$max_sort_orders,			
			'theme_date_added'=>$this->config->item('config.date.time')
			);
			
			$entityId =  $this->theme_model->safe_insert('wl_themes',$posted_data,FALSE);
			if($entityId>0) {	
				$redirect_url="products/theme/".$entityId;
				$meta_array  = array(
				'entity_type'		=>	$redirect_url,
				'entity_id'		=>	$entityId,
				'page_url'		=>	$this->cbk_friendly_url,
				'meta_title'		=>	get_text($this->input->post('brand_name'),80),
				'meta_description'=>	get_text($this->input->post('news_description')),
				'meta_keyword'	=>	get_keywords($this->input->post('news_description'))
				);
				
				create_meta($meta_array);
			}
			
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/theme', '');

		}
		$this->load->view('theme/view_theme_add',$data);
		
	}


	public function edit()
	{
		$themeId = (int) $this->uri->segment(4);
		
		$rowdata=$this->theme_model->get_theme_by_id($themeId);
		
		$themeId = $rowdata['theme_id'];
		
		$data['heading_title'] = 'Theme';
		$posted_friendly_url = $this->input->post('friendly_url');
		$this->cbk_friendly_url = seo_url_title($posted_friendly_url);
		$seo_url_length = $this->config->item('seo_url_length');

		if( !is_array($rowdata) )
		{
			$this->session->set_flashdata('message', lang('idmissing'));
			redirect('sitepanel/theme', '');

		}

		$this->form_validation->set_rules('theme_name','Theme Name',"trim|required|max_length[32]|xss_clean|unique[wl_themes.theme_name='".$this->db->escape_str($this->input->post('theme_name'))."' AND status!='2' AND theme_id != ".$themeId."]");
		$this->form_validation->set_rules('friendly_url','Page URL',"trim|required|max_length[$seo_url_length]|xss_clean|callback_checkurl");
		
		
		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'theme_name'=>$this->input->post('theme_name'),
			'friendly_url'		=>	$this->cbk_friendly_url,
			'theme_date_updated'=>$this->config->item('config.date.time')
			);
			
			$where = "theme_id = '".$themeId."'";
			$this->theme_model->safe_update('wl_themes',$posted_data,$where,FALSE);
			
			$id=$themeId;
			update_meta_page_url('products/theme/'.$id,$id,$this->cbk_friendly_url);				
			
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));
			
			redirect('sitepanel/theme'.'/'.query_string(), '');
			
		}

		$data['res']=$rowdata;
		$this->load->view('theme/view_theme_edit',$data);

	}

}
// End of controller