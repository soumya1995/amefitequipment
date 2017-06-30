<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Members_model extends MY_Model
 {
	 
	 public function get_members($limit='10',$offset='0',$param=array())
	 {

		$status			    =   @$param['status'];
		$customer_id		=   @$param['customer_id'];
		$keyword			=   trim($this->input->get_post('keyword',TRUE));
		$keyword			=   $this->db->escape_str($keyword);
		$where		=   @$param['where'];

		if($customer_id!='')
		{
			$this->db->where("customers_id","$customer_id");
		}
		if($status!='')
		{
			$this->db->where("status","$status");
		}
		if($where!='')
		{
			$this->db->where($where);
		}

		if($keyword!='')
		{
			$this->db->where("(user_name LIKE '%".$keyword."%' OR CONCAT_WS(' ',first_name,last_name) LIKE '%".$keyword."%' OR gender LIKE '%".$keyword."%' )");
		}

		$this->db->order_by('customers_id','desc');
		$this->db->limit($limit,$offset);
		$this->db->select("SQL_CALC_FOUND_ROWS *,CONCAT_WS(' ',first_name,last_name) AS name ",FALSE);
		$this->db->from('wl_customers');
		$this->db->where('status <','2');
		$q=$this->db->get();
		//echo_sql();
		$result = $q->result_array();
		$result = ($limit=='1') ? $result[0]: $result;
		return $result;

	}

	public function get_member_row($id,$condtion='')
	{
		$id = (int) $id;

		if($id!='' && is_numeric($id))
		{
			$condtion = "status !='2' AND customers_id=$id $condtion ";

			$fetch_config = array(
		  'condition'=>$condtion,
		  'debug'=>FALSE,
		  'return_type'=>"array"
			);

			$result = $this->find('wl_customers',$fetch_config);
			return $result;
		}

	}



	public function get_member_address_book($customer_id,$address_type='',$default_status='Y')
	{
		$customer_id = (int) $customer_id;

		if($customer_id!='' )
		{
			$condtion = "customer_id =$customer_id AND default_status='$default_status'  ";

			if( $address_type!='')
			{

				$condtion .= "AND address_type ='$address_type'";
			}

			$fetch_config = array(
		  'condition'=>$condtion,
		  'debug'=>FALSE,
		  'return_type'=>"array"
			);

			$result = $this->findAll('wl_customers_address_book',$fetch_config);
			return $result;
		}

	}
	
	public function get_member_all_address_book($customer_id,$address_type='')
	{
		$customer_id = (int) $customer_id;

		if($customer_id!='' )
		{
			$condtion = "customer_id =$customer_id AND name!='' ";

			if( $address_type!='')
			{

				$condtion .= "AND address_type ='$address_type'";
			}

			$fetch_config = array(
		  'condition'=>$condtion,
		  'debug'=>FALSE,
		  'return_type'=>"array"
			);

			$result = $this->findAll('wl_customers_address_book',$fetch_config);
			return $result;
		}

	}
	
	public function get_member_address($customer_id,$address_id)
	{
		$customer_id = (int) $customer_id;

		if($customer_id!='' )
		{
			$condtion = "customer_id =$customer_id ";

			if( $address_id!='')
			{

				$condtion .= "AND address_id ='$address_id'";
			}

			$fetch_config = array(
		  'condition'=>$condtion,
		  'debug'=>FALSE,
		  'return_type'=>"array"
			);

			$result = $this->findAll('wl_customers_address_book',$fetch_config);
			return $result;
		}

	}

	public function get_addresses($offset=FALSE,$per_page=FALSE,$condition)
	{
		$keyword = trim($this->db->escape_str($this->input->post('keyword')));		

		if($keyword!='')
		{
			$condition.=" AND ( name LIKE '%".$keyword."%' ) ";
		}
		
		$fetch_config = array(
							  'condition'=>$condition,
							  'order'=>'name ASC',
							  'limit'=>$per_page,
							  'start'=>$offset,							 
							  'debug'=>FALSE,
							  'return_type'=>"array"							  
							  );
		$result = $this->findAll('wl_customers_address_book',$fetch_config);
		return $result;	
	}
	
	public function get_wislists($offset=FALSE,$per_page=FALSE)
	{

		$keyword = trim($this->db->escape_str($this->input->post('keyword')));

		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');

		$condition="wp.status ='1' AND wis.customer_id = ".$this->session->userdata('user_id');

		if($keyword!='')
		{
			$condition.=" AND ( wp.product_name LIKE '%".$keyword."%' OR wp.product_code LIKE '%".$keyword."%' ) ";
		}
		if($from_date!='' ||  $to_date!='')
		{
			$condition_date=array();
			$condtion.=" AND (";
			if($from_date!='')
			{
				$condition_date[]="wis.wishlists_date_added>='$from_date'";
			}else
			{
				$condition_date[]="wis.wishlists_date_added<='$to_date'";
			}
			$condtion.=implode(" AND ",$condition_date)." )";
		}
		$opts=array(
		'condition'=>$condition,
		'limit'=>$per_page,
		'offset'=>$offset,
		'fromcond'=>'wl_products AS wp',
		'selectcond'=>'wp.*,wis.wishlists_date_added,wis.wishlists_id',
		'joins'=>array(array('tblname'=>'wl_wishlists AS wis','jclause'=>'wis.product_id=wp.products_id'))
		);
		return $this->myCustomJoin($opts);
	}
	
	 public function get_orders($offset='0',$per_page='10',$condition=''){	   
		 
		 $keyword   = $this->db->escape_str(trim($this->input->get_post('keyword',TRUE)));
		 $from_date = $this->db->escape_str(trim($this->input->get_post('from_date',TRUE)));
		 $to_date   = $this->db->escape_str(trim($this->input->get_post('to_date',TRUE)));
		 $order_status   = $this->db->escape_str(trim($this->input->get_post('order_status',TRUE)));		  
		 $customers_id   = $this->db->escape_str(trim($this->input->get_post('customers_id',TRUE)));		 
		 $condition="order_status !='Deleted' $condition ";		 
		 if($from_date!='' ||  $to_date!=''){
			 $condition_date=array();
			 $condition.=" AND (";
			 if($from_date!=''){
					$condition_date[] = "DATE(order_received_date)>='$from_date'";
			 }if($to_date!='')
				{
					 $condition_date[] ="DATE(order_received_date)<='$to_date'";
					 
				}
				
				$condition.=implode(" AND ",$condition_date)." )";
		}	
		
		if($keyword!='')
		{
			$condition.=" AND ( invoice_number LIKE '%".$keyword."%' OR  CONCAT_WS(' ',first_name,last_name) LIKE '%".$keyword."%' OR  email LIKE '%".$keyword."%'  OR  payment_status LIKE '".$keyword."%' OR  order_status LIKE '".$keyword."%' ) ";			
		}
		if($order_status!=""){
			
			$condition.=" AND ( order_status = '".$order_status."' ) ";	
		}
		if($customers_id!=""){
			
			$condition.=" AND ( customers_id = '".$customers_id."' ) ";	
		}
		
					
		$fetch_config = array(
							  'condition'=>$condition,
							  'order'=>'order_id DESC',
							  'limit'=>$per_page,
							  'start'=>$offset,							 
							  'debug'=>FALSE,
							  'return_type'=>"array"							  
							  );		
		$result = $this->findAll('wl_order',$fetch_config);
		return $result;	
		
	
	}

}