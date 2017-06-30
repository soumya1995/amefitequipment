<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cart_model extends MY_Model {
	/**
	* Get account by id
	*
	* @access public
	* @param string $account_id
	* @return object account object
	*/

	public function is_order_no_exits($ord)
	{
		$num =  $this->findCount('wl_order',"invoice_number = '$ord' ");
		return ($num > 0 ) ? TRUE : FALSE ;
	}

	public function get_discount($code)
	{

		if($code!="" )
		{
			$code = $this->db->escape_str($code);

			$condtion = "status ='1' AND coupon_code = '$code' AND end_date  >= '".$this->config->item('config.date')."' ";

			$fetch_config = array(
			'condition'=>$condtion,
			'debug'=>FALSE,
			'return_type'=>"array"
			);

			$res = $this->find('wl_coupons',$fetch_config);
			return $res;
		}

	}

	public function get_shipping_rate($shipId)
	{
		$id = (int) $shipId;
		if($id!='' && is_numeric($id))
		{
			$condtion = "status ='1' AND shipping_id ='$id'";
			$fetch_config = array(
			'condition'=>$condtion,
			'debug'=>FALSE,
			'return_type'=>"array"
			);

			$result = $this->find('wl_shipping',$fetch_config);
			return $result;
		}
	}


	public function add_wislists($prodId,$memId)
	{
		if($prodId > 0 && $memId > 0 )
		{
			$record =  $this->is_record_exits('wl_wishlists',array('condition'=>"customer_id =$memId AND product_id =$prodId") );
			
			if(!$record )
			{
				$data =  array(
				'customer_id'=>$memId ,
				'product_id'=>$prodId,
				'wishlists_date_added'=>$this->config->item('config.date.time')
				);
				$this->safe_insert('wl_wishlists',$data,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',$this->config->item('wish_list_add'));
							
			}else
			{
				$this->session->set_userdata(array('msg_type'=>'warning'));
				$this->session->set_flashdata('warning',$this->config->item('wish_list_product_exists'));
			}
		}
	}
	
	public function get_vat()
	{
		return 10;
	}

	public function is_coupon_used($coupon_id, $user_id)
	{
		$num =  $this->findCount('wl_coupon_customers',"coupon_id = '$coupon_id' AND customer_id = '$user_id' AND status = '1'");
		return ($num > 0 ) ? $num : '0' ;
	} 

}
/* End of file member_model.php */
/* Location: ./application/modules/cart/models/cart_model.php */