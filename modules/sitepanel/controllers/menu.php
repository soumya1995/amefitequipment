<?php
class Menu extends Admin_Controller
{
	public function __construct()
	{		
		parent::__construct(); 				
		$this->load->model(array('sitepanel/menu_model'));  
		$this->config->set_item('menu_highlight','menu ordering');				
	}
	 
	public  function index()
	{
									 						 	
		$res_array              =  $this->menu_model->getmenus();
						
		$config['total_rows']	=  $this->menu_model->total_rec_found;	
		
		$data['heading_title']  =  'Site Menu';
						
		$data['res']            =  $res_array; 	
		
		if( $this->input->post('update_order')!='')
		{			
			$this->update_displayOrder('wl_menu_listing','sort_order','menu_id');			
		}
						
		$this->load->view('menu/view_menu_list',$data);		
		
		
	}	
	
}
// End of controller