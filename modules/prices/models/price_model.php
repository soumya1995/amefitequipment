<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Price_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_prices($param=array(),$offset='0',$limit='100')
	 {
		$status			    =   @$param['status'];
		$orderby		    =   @$param['orderby'];	
		$where		        =   @$param['where'];
		$keyword			=   trim($this->input->get_post('keyword',TRUE));
		$keyword			=   $this->db->escape_str($keyword);
		
		$type              =   $this->input->get_post('type'); 
		
		if($type!='')
		{
			$this->db->where("type",$type);
		}
		
		if($status!='')
		{
			$this->db->where("status",$status);
		}
		
		if($keyword!=''){
			$this->db->where("(variant_name LIKE '%".$keyword."%' )");
		}
		
		if($where!='')
		{
			$this->db->where($where);
		}
		
		if($orderby!='')
		{
			 $this->db->order_by($orderby);
			
		}else
		{
		  $this->db->order_by('type','DESC');
		}
		
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS *',FALSE);		
		$this->db->from('wl_product_attributes');
		$q=$this->db->get();
		//echo_sql();
		$result = $q->result_array();	
		$result = ($limit=='1') ? @$result[0]: $result;	
		return $result;
	}
	
	public function get_prices_by_id($id)
	{
		$id = applyFilter('NUMERIC_GT_ZERO',$id);
		
		if($id>0)
		{
			$condtion = "status !='2' AND attribute_id=$id";
			$fetch_config = array(
														'condition'=>$condtion,							 					 
														'debug'=>FALSE,
														'return_type'=>"array"							  
													 );
			$result = $this->find('wl_product_attributes',$fetch_config);
			return $result;
		}
	}
}
// model end here