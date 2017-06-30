<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Private_Controller extends MY_Controller
{

	public $userId;	
	public $userType;

	public function __construct()
	{
		ob_start();
		parent::__construct();
		$this->load->library(array('Auth'));
		$this->auth->is_auth_user();
		$this->userId = (int) $this->session->userdata('user_id');
		$this->load->model(array('members/members_model'));
		$mres = $this->members_model->get_member_row( $this->userId );

		$this->title =  $mres ['title'];
		$this->fname =  $mres ['first_name'];
		$this->lname =  $mres ['last_name'];
		$this->phone_number =  $mres ['phone_number'];
		$this->mobile_number =  $mres ['mobile_number'];
		$this->last_login =  $mres ['last_login_date'];
		$this->userType =  $mres ['customer_type'];
		
		$this->load->library(array('safe_encrypt','Dmailer','cart'));
		
	}
}