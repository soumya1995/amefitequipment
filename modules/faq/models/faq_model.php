<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Faq_model extends MY_Model
{

	public function get_faq($limit='10',$offset='0',$param=array())
	{

		$status = @$param['status'];
		$id = @$param['id'];
		$keyword = trim($this->input->get_post('keyword',TRUE));
		$keyword = $this->db->escape_str($keyword);
		
		if($status!='')
		{
			$this->db->where("status","$status");
		}
		
		if($id!='')
		{
			$this->db->where("faq_id","$id");
		}

		if($keyword!='')
		{
			$this->db->like('faq_question',"$keyword");
		}

		$this->db->order_by('sort_order');
		//$this->db->order_by('faq_id',"DESC");

		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS*',FALSE);
		$this->db->from('wl_faq');
		$q=$this->db->get();
		//echo_sql();
		$result = $q->result_array();
		$result = ($limit=='1') ? $result[0]: $result;
		return $result;

	}

}?>