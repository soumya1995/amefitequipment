<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu_model extends MY_Model{

   public function __construct()
   {
   
     parent::__construct();
     
    }

	public function getmenus(){
		
		$result = $this->db->query("SELECT a.* FROM wl_menu_listing AS a LEFT JOIN wl_categories AS b ON b.category_name=a.menu_title WHERE a.status='1' AND ((b.category_id IS NULL) OR (b.status!='2' ))")->result_array();
		
		return $result;
		
	}
}
// model end here