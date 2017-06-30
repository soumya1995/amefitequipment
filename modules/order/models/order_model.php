<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_model extends MY_Model
 {
	 	 
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
	
	
	public function get_order_master($ordId)
		{		
			$id = (int) $ordId;
			if($id!='' && is_numeric($id))
			{
				$condtion = "order_id =$id";
				$fetch_config = array(
				'condition'=>$condtion,							 					 
				'debug'=>FALSE,
				'return_type'=>"array"							  
				);
				
				$result = $this->find('wl_order',$fetch_config);
				return $result;		
			}
		}

		public function get_order_detail($ordno,$cond="")
		{
			$condtion = "orders_id ='$ordno' $cond ";
			$fetch_config = array(
				'condition'=>$condtion,
				'order'=>'NULL',
				'limit'=>'NULL',
				'start'=>'NULL',							 
				'debug'=>FALSE,
				'return_type'=>"array"							  
			);	
				
			$result = $this->findAll('wl_orders_products',$fetch_config);
			return $result;	
		}

	public function get_vendor_orders($offset='0',$limit='10',$param=array()){
		$return_type = !array_key_exists('return_type',$param) ? "result_array"     : $param['return_type'];		   			 
		$orderby			=	@$param['orderby'];
		$where			    =	@$param['where'];	 
		$where ="order_status !='Deleted' ".$where;	
		
		$jwhere			    =	@$param['jwhere'];	

		if($where!=''){
			$this->db->where($where);
		}
		if($orderby!='')
		{
			$this->db->order_by($orderby);
		}else{
			$this->db->order_by('wl_order.order_id ','desc');
		}

		$this->db->group_by("wl_order.order_id");

		if($limit)$this->db->limit($limit,$offset);

		$this->db->select('SQL_CALC_FOUND_ROWS sum(product_price) as total_product_price,sum(shipping_charge) as total_shipping_charge,wl_order.*',FALSE);
		$this->db->from('wl_order');		
		$this->db->join('wl_orders_products','wl_orders_products.orders_id=wl_order.order_id'.$jwhere,'left');		
		$q=$this->db->get();
		//echo_sql();			
		$result =  ($return_type!='')  ? $q->$return_type()  :  $q->result_array() ;
		return $result;
	}
	
	
	public function get_payment_history($offset='0',$per_page='10',$condition=''){
		
		 $keyword   = $this->db->escape_str(trim($this->input->get_post('keyword',TRUE)));
		 $from_date = $this->db->escape_str(trim($this->input->get_post('from_date',TRUE)));
		 $to_date   = $this->db->escape_str(trim($this->input->get_post('to_date',TRUE)));
		 $order_status   = $this->db->escape_str(trim($this->input->get_post('order_status',TRUE)));		  
		 $vendor_id   = $this->userId;		 
		 $condition="status ='1' $condition ";		 
		 if($from_date!='' ||  $to_date!=''){
			 $condition_date=array();
			 $condition.=" AND (";
			 if($from_date!=''){
					$condition_date[] = "DATE(recv_date)>='$from_date'";
			 }if($to_date!='')
				{
					 $condition_date[] ="DATE(recv_date)<='$to_date'";
					 
				}
				
				$condition.=implode(" AND ",$condition_date)." )";
		}	
		
		if($keyword!='')
		{
			$condition.=" AND ( transaction_id LIKE '%".$keyword."%' ) ";			
		}
		if($order_status!=""){
			
			$condition.=" AND ( status = '".$order_status."' ) ";	
		}
				
					
		$fetch_config = array(
							  'condition'=>$condition,
							  'order'=>'transaction_id DESC',
							  'limit'=>$per_page,
							  'start'=>$offset,							 
							  'debug'=>FALSE,
							  'return_type'=>"array"							  
							  );		
		$result = $this->findAll('wl_vendor_payments',$fetch_config);
		return $result;	
	}
	
	public function get_vendor_sold_orders($param){
		
		if(!empty($param['where'])){
			$where			    =	@$param['where'];	 
			$where ="order_status !='Deleted' AND payment_status='Paid' AND ".$where;	
			
			$jwhere			    =	@$param['jwhere'];	
	
			if($where!=''){
				$this->db->where($where);
			}		
		}

		$this->db->select('SQL_CALC_FOUND_ROWS sum(wl_orders_products.product_price) as total_product_price, sum(wl_orders_products.shipping_charge) as total_shipping_charge, sum(wl_orders_products.payment_amount) as total_payment_amount, wl_orders_products.vendor_id, wl_order.*',FALSE);
		$this->db->from('wl_order');		
		$this->db->join('wl_orders_products','wl_orders_products.orders_id=wl_order.order_id'.$jwhere,'left');	
		$this->db->order_by('wl_order.order_id','desc');
		$this->db->group_by("wl_orders_products.vendor_id");	
		$q=$this->db->get();
		//echo_sql();			
		$result =  $q->result_array() ;
		return $result;
	}
}