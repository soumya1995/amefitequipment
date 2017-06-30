<?php
class Payment extends Public_Controller
{

	public function __construct()
	{

		parent::__construct();
		$this->load->helper(array('payment/paypal','payment/PayZippy','cart/cart','file'));
		$this->load->model(array('order/order_model','payment/payment_model'));
		$this->load->library(array('Dmailer'));

	}

	public function index()
	{
		$this->cart->destroy();
		$this->session->unset_userdata("guest");

		if( $this->input->post()!='' )
		{
			//if($this->input->post('pay_method') == "paypal" )
			//{
				$working_order_id =  $this->session->userdata('working_order_id');
				$ordmaster = $this->order_model->get_order_master($working_order_id);


			//	paypalForm($order_res);
			//}
			
			
			if($this->input->post('pay_method') == "PayZippy" )
				{	
				    $working_order_id =  $this->session->userdata('working_order_id');
				    $order_res = $this->order_model->get_order_master($working_order_id);
				    PayZippylForm($order_res);
				   
				
				}
			
			// temp code to adjust stock
			$ordId = $working_order_id;
			$data  = array('payment_status'=>'Paid');
			$where = "order_id = '$ordId' ";
			//$this->payment_model->safe_update('wl_order',$data,$where,FALSE);
			//echo_sql(); exit;
		
			if($ordmaster['payment_status']=="Paid"){
				$orderproduct= $this->db->query("select * from wl_orders_products where MD5(orders_id) = '".$ordId."' ")->result_array();
				/*Minus quantity in tbl_product_stock*/
				$get_order="SELECT * FROM wl_orders_products WHERE orders_id='".$ordId."'";
				$query_res=$this->db->query($get_order);
				//trace($query_res);
				//echo $query_res->num_rows();
				//exit;
				if($query_res->num_rows()>0){
					$order_list=$query_res->result_array();
					//trace($order_list); exit;
					foreach($order_list as $key=>$val){
						$prd_qty=$val['quantity'];
						$this->db->set('product_quantity',"product_quantity-$prd_qty",FALSE);
						$this->db->where('product_id', $val['products_id']);
						if($val['product_color_id']){
							$this->db->where('product_color', $val['product_color_id']);
						}
						if($val['product_size_id']){
							$this->db->where('product_size', $val['product_size_id']);
						}
						$this->db->update('wl_product_stock');
					}
				}
			}
			/*End Minus quantity in tbl_product_stock*/
			
			$ordmaster = $this->order_model->get_order_master( $working_order_id );
			$orddetail = $this->order_model->get_order_detail( $working_order_id);
			if( is_array( $ordmaster )  && !empty( $ordmaster ) )
			{
				if($ordmaster['payment_method']=="Cash On Delivery"){
					
					//Send Invoice mail
					ob_start();
					$mail_subject =$this->config->item('site_name')." Order Details";
					$from_email   = $this->admin_info->admin_email;
					$from_name    = $this->config->item('site_name');
					$mail_to      = $ordmaster['email'];
					$body         = order_invoice_content($ordmaster,$orddetail,"yes");
					$msg          = ob_get_contents();
		
					$mail_conf =  array(
					'subject'=>$this->config->item('site_name')." Order Details",
					'to_email'=>$mail_to,
					'from_email'=>$from_email,
					'from_name'=> $this->config->item('site_name'),
					'body_part'=>$msg);
					$this->dmailer->mail_notify($mail_conf);
		
					// End Invoice  mail
					
					// stock adjusted as client request
					$data  = array('payment_status'=>'Paid');
					$where = "order_id = '$ordId' ";
					$this->payment_model->safe_update('wl_order',$data,$where,FALSE);
					
					/*Minus quantity in tbl_product_stock*/
					$get_order="SELECT * FROM wl_orders_products WHERE orders_id='".$ordId."'";
					$query_res=$this->db->query($get_order);
					//trace($query_res);
					//echo $query_res->num_rows();
					//exit;
					if($query_res->num_rows()>0){
						$order_list=$query_res->result_array();
						foreach($order_list as $key=>$val){
							$prd_qty=$val['quantity'];
							$this->db->set('product_quantity',"product_quantity-$prd_qty",FALSE);
							$this->db->where('product_id', $val['products_id']);
							if($val['product_color_id']){
								$this->db->where('product_color', $val['product_color_id']);
							}
							if($val['product_size_id']){
								$this->db->where('product_size', $val['product_size_id']);
							}
							$this->db->update('wl_product_stock');
						}
					}
					/*End Minus quantity in tbl_product_stock*/
					
					
				}
			}
			redirect('payment/thanks', '');
		}
	}

	public function order_success()
	{

		$ordId = $this->uri->segment(4);
		$payment_method = $this->uri->segment(3);
		
	
		$data  = array('payment_method'=>$payment_method,'payment_status'=>'Paid');
		$where = "md5(order_id) = '$ordId' ";

		$this->payment_model->safe_update('wl_order',$data,$where,FALSE);

		$orderproduct= $this->db->query("select * from wl_orders_products where md5(orders_id) = '".$ordId."' ")->result_array();
		/*Minus quantity in tbl_product_stock*/
		$get_order="SELECT * FROM wl_orders_products WHERE md5(orders_id)='".$ordId."'";
		$query_res=$this->db->query($get_order);
		//trace($query_res);
		//echo $query_res->num_rows();
		//exit;
		if($query_res->num_rows()>0){
			$order_list=$query_res->result_array();
			foreach($order_list as $key=>$val){
				$prd_qty=$val['quantity'];
				$this->db->set('product_quantity',"product_quantity-$prd_qty",FALSE);
				$this->db->where('product_id', $val['products_id']);
				if($val['product_color_id']){
					$this->db->where('product_color', $val['product_color_id']);
				}
				if($val['product_size_id']){
					$this->db->where('product_size', $val['product_size_id']);
				}
				$this->db->update('wl_product_stock');
			}
		}
		/*End Minus quantity in tbl_product_stock*/

		$ordmaster = $this->order_model->get_order_master( $this->session->userdata('working_order_id') );
		$orddetail = $this->order_model->get_order_detail( $this->session->userdata('working_order_id'));

		if( is_array( $ordmaster )  && !empty( $ordmaster ) )
		{
			/***** Send Invoice mail */
			ob_start();
			$mail_subject =$this->config->item('site_name')." Order Details";
			$from_email   = $this->admin_info->admin_email;
			$from_name    = $this->config->item('site_name');
			$mail_to      = $ordmaster['email'];
			$body         = order_invoice_content($ordmaster,$orddetail);
			$msg          = ob_get_contents();

			$mail_conf =  array(
			'subject'=>$this->config->item('site_name')." Order Details",
			'to_email'=>$mail_to,
			'from_email'=>$from_email,
			'from_name'=> $this->config->item('site_name'),
			'body_part'=>$msg);
			$this->dmailer->mail_notify($mail_conf);

			/******* End Invoice  mail */
		}

		//$this->session->unset_userdata(array('working_order_id' =>0));
		$this->session->set_flashdata('msg', $this->config->item('payment_success'));
		redirect('payment/thanks/', '');
	}

	public function order_cancle()
	{

		$ordId = $this->uri->segment(4);
		$payment_method = $this->uri->segment(3);		
		$data  = array('payment_method'=>$payment_method,'order_status'=>'Canceled');
		$where = "order_id = '$ordId' ";
		$this->payment_model->safe_update('wl_order',$data,$where,FALSE);
		$this->session->unset_userdata(array('working_order_id' =>0));
		$this->session->set_flashdata('msg', $this->config->item('payment_failed'));
		redirect('payment/thanks/'.$ordId, '');

	}
	
	public function responce()
	{		
		
	//	$ordId = $this->input->get("merchant_transaction_id");		
	
		 $ordId =$this->uri->segment(3);		
		
		$payment_method = 'PayZippy';
		
		if($this->input->get("transaction_status")=="FAILED"){
			
			redirect('payment/order_cancle/'.$payment_method.'/'.$ordId, '');
		}else{
			
			redirect('payment/order_success/'.$payment_method.'/'.$ordId, '');
		}
		
	}
	
	public function thanks()
	{
		if($this->session->userdata('working_order_id')){
			
			$ordId =  $this->session->userdata('working_order_id');
		}else{
			$ordId =  $this->uri->segment(3);	
		}
		
		//$ordId =  $this->session->userdata('working_order_id');
		$this->load->model(array('order/order_model'));
		$order_res          = $this->order_model->get_order_master( $ordId );
		$order_details_res  = $this->order_model->get_order_detail($order_res['order_id']);
		$data['orddetail']  = $order_details_res;
		$data['ordmaster']  = $order_res;

			$this->load->view('payment/pay_thanks',$data);
	}

}
/* End of file member.php */
/* Location: .application/modules/products/controllers/cart.php */
