<?php
class Prices extends Public_Controller
{
	
	public function __construct()
	{
		parent::__construct();  
		$this->load->model(array('weight/weight_model'));
		
	}
	
	public function index()
	{}
	
}