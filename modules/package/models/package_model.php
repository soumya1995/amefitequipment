<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Package_model extends MY_Model
 {


	 public function get_package($limit='10',$offset='0',$param=array()){

		$status			    =   @$param['status'];		
		$packageid			=   @$param['packageid'];
		$orderby			=	@$param['orderby'];
		$where			    =	@$param['where'];			
		$keyword			=   trim($this->input->get_post('keyword2',TRUE));
		$keyword			=   $this->db->escape_str($keyword);
		
		if($where!=''){
			$this->db->where($where);

		}		
		if($packageid!=''){
			$this->db->where("wlw.package_id  ","$packageid");
		}		
		if($status!=''){
			$this->db->where("wlw.status","$status");
		}		
		if($keyword!=''){
			$this->db->where("(wlw.title LIKE '%".$keyword."%')");
		}
		if($orderby!=''){
			$this->db->order_by($orderby);

		}else{
			$this->db->order_by('wlw.title ','ASC');
		}

	  	$this->db->group_by("wlw.package_id");
	  	if($limit!=""){
			$this->db->limit($limit,$offset);		
		}		
		$this->db->select("SQL_CALC_FOUND_ROWS wlw.*, wlw.status as product_status, wlwm.media,wlwm.media_type, wlwm.is_default",FALSE);
		$this->db->from('wl_package as wlw');		
		$this->db->join('wl_media AS wlwm','wlw.package_id=wlwm.products_id','left');
		
		$q=$this->db->get();
		//echo_sql();
		$result = $q->result_array();
		$result = ($limit=='1') ? @$result[0]: $result;
		return $result;

	}

	public function get_package_media($limit='4',$offset='0',$param=array())
    {
		 $default			    =   @$param['default'];
		 $productid			    =   @$param['productid'];
		 $media_type			=   @$param['media_type'];
		 $product_type			=   @$param['product_type'];
		 $where  =   @$param['where'];
		 if( is_array($param) && !empty($param) )
		 {
			$this->db->select('SQL_CALC_FOUND_ROWS *',FALSE);
			if($limit)
			$this->db->limit($limit,$offset);
			$this->db->from('wl_media');
			$this->db->where('products_id',$productid);

			if($default!='')
			{
				$this->db->where('is_default',$default);
			}
			if($media_type!='')
			{
				$this->db->where('media_type',$media_type);
			}
			if($product_type!='')
			{
				$this->db->where('product_type',$product_type);
			}
						
			if($where!=''){			
				$this->db->where($where);			
			}
			
			$this->db->order_by('id ASC');
			
			$q=$this->db->get();
			//echo_sql();
			$result = $q->result_array();
			//$result = @($limit=='1') ? $result[0]: $result;
			return $result;

		 }

	}

}