<?php
class Subadmin extends Admin_Controller
{
	public $view_path;
	public $current_controller;
	public $section_title;
	public function __construct()
	{		
		parent::__construct();
		
		$this->current_controller	=$this->router->fetch_class();
		 				
		$this->load->model(array('subadmin_model'));
		$this->config->set_item('menu_highlight','other management');				
		
		$this->view_path					=$this->current_controller."/";
		$this->section_title="Subadmin";
		
	}
	
	//Country 
	public  function index()
	{
		$pagesize            =  (int) $this->input->get_post('pagesize');
		$config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset              =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url            =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		
		
		$keyword = trim($this->input->get_post('keyword',TRUE));
		$keyword = $this->db->escape_str($keyword);
		$condtion = " ";
		
		if($keyword!='')
		{
			$condtion = "AND (admin_username like '%".$keyword."%' OR contact_person like '%".$keyword."%'  OR admin_email like '%".$keyword."%')";
		}
		
		$condtion_array = array(
											 'condition'=>$condtion,
											 'limit'=>$config['limit'],
											  'offset'=>$offset	,
											  'debug'=>FALSE
											 );
											 							 						 	
		$res_array              =  $this->subadmin_model->get_record($condtion_array);
		$config['total_rows']		=  $this->subadmin_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  "Manage Subadmin";
		$data['res']            =  $res_array;
		
		
		if( $this->input->post('status_action')!='')
		{		
		     //trace($this->input->post());
			
			$this->update_status('tbl_admin','admin_id');			
		}
		
		$this->load->view('subadmin/list_vew',$data);
		
	}
	
	public function add()
	{
		$data['heading_title']	="Add ".$this->section_title;
		$data['method']					="add";
		$section_res         = get_section_data($this->admin_id,$this->admin_type);
		$data['section_res']		=$section_res;
		
		if($this->input->post('action')!='')
		{
			
			$this->form_validation->set_rules('username','Username',"trim|required|xss_clean|max_length[50]|unique[tbl_admin.admin_username='".$this->db->escape_str($this->input->post('username'))."' AND status!='2']");
			$this->form_validation->set_rules('password','Password',"trim|required|xss_clean|min_length[6]|max_length[20]");
			$this->form_validation->set_rules('cpassword','Confirm Password',"trim|required|xss_clean|min_length[6]|max_length[20]|matches[password]");
			$this->form_validation->set_rules('subadminname', 'Subadmin Name',  'trim|required|max_length[30]');
			$this->form_validation->set_rules('subadminemail', 'Subadmin Email',  'trim|required|valid_email|max_length[60]');
			
			if($this->form_validation->run()==TRUE)
			{
				
				$productid=$this->subadmin_model->add();
				
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('success'));
				
				redirect("sitepanel/".$this->current_controller, '');
			}
				
		}
		$this->load->view('subadmin/add_view',$data);
		
	}
	
	public function edit()
	{
		$data['method']			="edit";
		$data['heading_title']="Edit ".$this->section_title;
				
		$item_id=(int) $this->uri->segment('4');
		
		if($this->input->post('id')!='')
		{
			$item_id=$this->input->post('id');	
		}
		
		$rowdata=$this->subadmin_model->get_record_by_id($item_id);
		
		if(empty($rowdata))
		{		
			redirect($this->current_controller, ''); 	
		}
		
		$data['prodresult']				=$rowdata;
		
		$data['section_res']			= get_section_data($this->admin_id,$this->admin_type);
		$data['allocated_secid_arr']	= $this->subadmin_model->get_allocated_sections($rowdata->admin_id);
		
		//trace($data['allocated_secid_arr']);exit;
		if($this->input->post('action')!='')
		{
			$this->form_validation->set_rules('username','Username',"trim|required|xss_clean|max_length[50]|unique[tbl_admin.admin_username='".$this->db->escape_str($this->input->post('username'))."' AND status!='2' and admin_id!='".$item_id."']");
			$this->form_validation->set_rules('password','Password',"trim|required|xss_clean|min_length[6]|max_length[20]");
			$this->form_validation->set_rules('subadminname', 'Subadmin Name',  'trim|required|max_length[30]');
			$this->form_validation->set_rules('subadminemail', 'Subadmin Email',  'trim|required|valid_email|max_length[60]');
			
			
			if($this->form_validation->run()==TRUE)
			{
				
				$this->subadmin_model->edit($rowdata);
				
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('successupdate'));				
				redirect("sitepanel/".$this->current_controller, '');
			}
				
		}
		$this->load->view('subadmin/edit_view',$data);
	}	
		
}
// End of controller