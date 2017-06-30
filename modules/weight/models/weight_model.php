<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Weight_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_weights($param=array(),$offset='0',$limit='100')
	 {
		$status			    =   @$param['status'];
		$orderby		    =   @$param['orderby'];	
		$where		        =   @$param['where'];
		$keyword       		=   @$param['keyword'];
		
		if($status!='')
		{
			$this->db->where("status",$status);
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
		  $this->db->order_by('weight_name','asc');
		}
		
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS *',FALSE);		
		$this->db->from('wl_weights');
		$q=$this->db->get();
		//echo_sql();
		$result = $q->result_array();	
		$result = ($limit=='1') ? @$result[0]: $result;	
		return $result;
	}
	
	public function get_weight_by_id($id)
	{
		$id = applyFilter('NUMERIC_GT_ZERO',$id);
		
		if($id>0)
		{
			$condtion = "status !='2' AND weight_id=$id";
			$fetch_config = array(
														'condition'=>$condtion,							 					 
														'debug'=>FALSE,
														'return_type'=>"array"							  
													 );
			$result = $this->find('wl_weights',$fetch_config);
			return $result;
		}
	}
}
// model end here