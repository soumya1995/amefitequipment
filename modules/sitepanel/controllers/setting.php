<?php
class Setting extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('ckeditor');
		$this->load->model(array('sitepanel/setting_model'));
	}

	public  function index($page = null)
	{
		$data['heading_title'] = 'Admin Setting';
		$data['admin_info'] = $this->setting_model->get_admin_info($this->session->userdata('admin_id'));
		$this->load->view('dashboard/setting_edit_view',$data);
	}
	
	public function edit()
	{
		$this->form_validation->set_rules('admin_email', 'Email ID',  'required|valid_email');
		$this->form_validation->set_rules('phone', 'Phone',  'required'); 
		$this->form_validation->set_rules('timings', 'Timings',  'xss_clean');
		$this->form_validation->set_rules('tax', 'Tax',  'xss_clean|is_numeric');
		$this->form_validation->set_rules('address', 'Address',  'required');
		$this->form_validation->set_rules('city', 'City',  'required|alpha');
		$this->form_validation->set_rules('state', 'State',  'alpha');
		$this->form_validation->set_rules('zipcode', 'Zipcode',  'required');
		$this->form_validation->set_rules('country', 'Country',  'required|alpha');		
		
		if ($this->form_validation->run() == TRUE)
		{
			$this->setting_model->update_info( $this->session->userdata('admin_id'));
			redirect('sitepanel/setting/','');
		}
		
		$data['heading_title'] = 'Admin Setting';
		$data['admin_info'] = $this->setting_model->get_admin_info($this->session->userdata('admin_id'));
		$this->load->view('dashboard/setting_edit_view',$data);
	}
	
	public function change()
	{
		$this->form_validation->set_rules('old_pass', 'Old Password', 'required');
		$this->form_validation->set_rules('new_pass', 'New Password', 'required|valid_password');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_pass]');
		
		if ($this->form_validation->run() === TRUE)
		{
		
			$this->setting_model->change_password( $this->input->post('old_pass'),$this->session->userdata('admin_id'));
			redirect('sitepanel/setting/change','');
		}
		
		$data['heading_title'] = 'Change Admin Password';
		//$data['admin_info'] = $this->setting_model->get_admin_info($this->session->userdata('admin_id'));
		$this->load->view('dashboard/setting_change_view',$data);
	}

}
// End of controller