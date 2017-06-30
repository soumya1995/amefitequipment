<?php
class Cart extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('cart','products/product'));
		$this->load->model(array('products/product_model','members/members_model','cart_model','order/order_model','warranty/warranty_model'));
		$this->load->library(array('Dmailer'));
		$this->form_validation->set_error_delimiters("<div class='required'>","</div>");
	}

	public function index()
	{

		if( $this->input->post('EmptyCart')!="")
		{
			$this->empty_cart();
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',$this->config->item('cart_empty'));
			redirect('cart');
		}
///trace($_REQUEST);

		if($this->input->post('Update_Qty')!="")
		{
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',$this->config->item('cart_quantity_update'));
			$this->update_cart_qty();
			
			redirect('cart');
		}		
		
		if($this->input->post("action")=="update"){
			$data = array(
			'rowid' => $this->input->post("rowid"),
			'qty' => $this->input->post("qty")
			);
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',$this->config->item('cart_quantity_update'));
			$this->cart->update($data);	
			/*
			//if($this->session->userdata('total_amount_payable') > $this->admin_info->free_shipping_order_amount){				
								
				$data2 = array(
				'shipping_id' => 0,
				'coupon_id' => 0,
				'discount_amount'=>0
				);

				$this->session->unset_userdata($data2);
			//}*/
			redirect('cart');
		}

		$user_id=$this->session->userdata('user_id')>0?$this->session->userdata('user_id'):$this->session->userdata('guest');
		//$mres = $this->members_model->get_member_row( $user_id );
		$ship_data=$this->members_model->get_member_address_book($user_id,"Ship");
		$ship_data=$ship_data[0];
		$data['mres'] = $ship_data;		
		
		if($this->input->post('Checkout')!="" || $this->input->post('GustCheckout')!="")
		{

			$this->form_validation->set_rules('shipping_method', 'Shipping Method','trim|xss_clean');

			if($this->form_validation->run()=== TRUE){
				if($this->input->post('GustCheckout')!=""){
					redirect("cart/checkout");
				}
				if( $this->session->userdata('user_id') > 0 )
				{
					redirect('cart/checkout');
				}
				else
				{
					redirect('users/login?ref=cart/checkout');
				}
			}
		}		
		$data['title']              = "Cart";		
		$this->load->view('view_my_cart',$data);

	}

	public function apply_coupon_code($discount_res)
	{
		if( is_array($discount_res) && !empty($discount_res))
		{
			$cart_total      = $this->cart->total();
			$discount_type   =  $discount_res['coupon_type'];

			if( $discount_res['minimum_order_amount']!='' && $discount_res['minimum_order_amount']!='0.0000'  )
			{
				if( $discount_type=='p' )
				{
					$discount_amount  = ($cart_total*$discount_res['coupon_discount']/100);
					if( ($cart_total >= $discount_amount) &&  ($cart_total >= $discount_res['minimum_order_amount']) )
					{
						$this->session->set_userdata(array('coupon_id'=>$discount_res['coupon_id'], 'discount_amount'=>$discount_amount) );
					}
				}else
				{
					$discount_amount  = $discount_res['coupon_discount'];
					if( ($cart_total >= $discount_amount)  &&  ($cart_total >= $discount_res['minimum_order_amount']) )
					{
						$this->session->set_userdata(array('coupon_id'=>$discount_res['coupon_id'], 'discount_amount'=>$discount_amount) );
					}
				}
			}else
			{
				if( $discount_type=='p' )
				{
					$discount_amount  = ($cart_total*$discount_res['coupon_discount']/100);
					if( $cart_total >= $discount_amount )
					{
						$this->session->set_userdata(array('coupon_id'=>$discount_res['coupon_id'], 'discount_amount'=>$discount_amount) );
					}
				}else
				{
					$discount_amount  = $discount_res['coupon_discount'];
					if( $cart_total >= $discount_amount )
					{
						$this->session->set_userdata(array('coupon_id'=>$discount_res['coupon_id'], 'discount_amount'=>$discount_amount) );
					}
				}
			}
		}
	}
	
	public function make_payment()
	{
		if($this->input->post('pay_method')!=""){
			$this->session->set_userdata(array('payment_method'=>$this->input->post('pay_method')));
			if($this->input->post('pay_method')=="Cash On Delivery"){
				$this->form_validation->set_rules('verification_code','Verification Code','trim|required|valid_captcha_code');
				//trace($_POST);
				if($this->form_validation->run()==TRUE){
					redirect('cart/process');
					exit;
				}
			}
			if($this->input->post('pay_method')=="paypal"){
				redirect('cart/process');
				exit;
			}
		}
		$user_id=$this->session->userdata('user_id')>0?$this->session->userdata('user_id'):$this->session->userdata('guest');
		//$mres = $this->members_model->get_member_row( $user_id );
		$ship_data=$this->members_model->get_member_address_book($user_id,"Ship");
		$ship_data=$ship_data[0];
		$data['mres'] = $ship_data;		
		
		$this->load->view('view_make_payment',$data);
	}

	public function checkout()
	{
		if( ( !$this->cart->total_items() > 0 ) )
		{
			redirect('cart');
		}

		$user_id=$this->session->userdata('user_id')>0?$this->session->userdata('user_id'):$this->session->userdata('guest');

		$mres = $this->members_model->get_member_row( $user_id );

		$this->form_validation->set_rules('shipping_name', 'Name','required|xss_clean|alpha');
		$this->form_validation->set_rules('shipping_address', 'Address','required|xss_clean');
		$this->form_validation->set_rules('shipping_phone', 'Phone','min_length[10]|xss_clean');
		$this->form_validation->set_rules('shipping_mobile', 'Mobile','required|min_length[10]|xss_clean');
		$this->form_validation->set_rules('shipping_zipcode', 'Zip Code','required|xss_clean');
		$this->form_validation->set_rules('shipping_country', 'Country','required|xss_clean');
		$this->form_validation->set_rules('shipping_state', 'State','required|xss_clean');
		$this->form_validation->set_rules('shipping_city', 'City','required|xss_clean');

		if ($this->form_validation->run() ===TRUE){
			$posted_billing_data =  array(
			'name'        => $this->input->post('billing_name',TRUE),
			'address'     => $this->input->post('billing_address',TRUE),
			'zipcode'     => $this->input->post('billing_zipcode',TRUE),
			'phone'       => $this->input->post('billing_phone',TRUE),
			//'mobile'       => $this->input->post('billing_mobile',TRUE),
			'city'        => $this->input->post('billing_city',TRUE),
			'state'       => $this->input->post('billing_state',TRUE),
			'country'     => $this->input->post('billing_country')
			);
			
			/*$shipping_country=get_country_name($this->input->post('shipping_country'));
			$shipping_state=get_state_name($this->input->post('shipping_state'));
			$shipping_city=get_city_name($this->input->post('shipping_city'));*/
			
			$posted_shipping_data =  array(
			'name'        => $this->input->post('shipping_name',TRUE),
			'address'     => $this->input->post('shipping_address',TRUE),
			'zipcode'     => $this->input->post('shipping_zipcode',TRUE),
			'phone'       => $this->input->post('shipping_phone',TRUE),
			'mobile'       => $this->input->post('shipping_mobile',TRUE),
			'city'        => $this->input->post('shipping_city',TRUE),
			'state'       => $this->input->post('shipping_state',TRUE),
			'country'     => $this->input->post('shipping_country',TRUE),
			);

			if($user_id>0){

				$where       = "customers_id = '".$user_id."'";
				//$where_bill  = "customer_id = '".$user_id."' AND address_type='Bill' ";
				$where_ship  = "customer_id = '".$user_id."' AND address_type ='Ship'  ";


				//$this->cart_model->safe_update('wl_customers',$posted_user_data,$where,FALSE);
				//$this->cart_model->safe_update('wl_customers_address_book',$posted_billing_data,$where_bill,FALSE);
				$this->cart_model->safe_update('wl_customers_address_book',$posted_shipping_data,$where_ship,FALSE);
			}
			redirect('cart/make_payment','');
		}


		//$bill_data=$this->members_model->get_member_address_book($user_id,"Bill");
		//$bill_data=$bill_data[0];
		$ship_data=$this->members_model->get_member_address_book($user_id,"Ship");
		$ship_data=$ship_data[0];
		
		$mres["first_name"]								= @$mres["first_name"];
		$mres["last_name"]								= @$mres["last_name"];
		$mres["mobile_number"]					= @$mres["mobile_number"];
		$mres["email"]								= 				@$mres["user_name"];
		/*$mres['billing_name']        = $bill_data['name'];
		$mres['billing_address']     = $bill_data['address'];
		$mres['billing_phone']       = $bill_data['phone'];
		$mres['billing_mobile']       = $bill_data['mobile'];
		$mres['billing_zipcode']     = $bill_data['zipcode'];
		$mres['billing_country']     = $bill_data['country'];
		$mres['billing_state']       = $bill_data['state'];
		$mres['billing_city']        = $bill_data['city'];*/
		$mres['shipping_name']       = $ship_data['name'];
		$mres['shipping_address']    = $ship_data['address'];
		$mres['shipping_phone']      = $ship_data['phone'];
		$mres['shipping_mobile']      = $ship_data['mobile'];
		$mres['shipping_zipcode']    = $ship_data['zipcode'];
		$mres['shipping_country']    = $ship_data['country'];
		$mres['shipping_state']      = $ship_data['state'];
		$mres['shipping_city']       = $ship_data['city'];

		$data['mres'] = $mres;
		$this->load->view('view_cart_checkout',$data);

	}

	private function add_customer_order($costumer_data = array(),$is_same_bill_ship)
	{
	
		if( $this->cart->total_items() > 0 )
		{

			$userId            = $this->session->userdata('user_id');
			$invoice_number    = get_auto_increment('wl_order');
			$payment_method         = $this->session->userdata('payment_method');
			$currency_code     = $this->session->userdata('currency_code');
			$currency_value    = $this->session->userdata('currency_value');
			$currency_symbol_left    = $this->session->userdata('symbol_left');
			$currency_symbol_right    = $this->session->userdata('symbol_right');

			$customers_id   =  ( $userId!='') ? $userId :$costumer_data["customers_id"];
			
			$customer_type=$this->session->userdata("user_id")>0?"Member":"Guest";

			$tax_cent = 0 ;//$this->cart_model->get_vat();

			$tax  = ($this->admin_info->tax > 0) ?  $this->admin_info->tax : '0';
			$total_tax = ($this->session->userdata('sub_total')*$tax/100);

			$cart_total      = $this->cart->total();
			$total_amount      = $this->session->userdata('total_amount_payable')+$total_tax;						
			
			/*$total_amount = ($total_amount+$shipping_amount);
			
			trace($costumer_data);
			exit;*/
			$data_order =
			array(
			'customers_id'        =>$customers_id,
			'customer_type'        =>$customer_type,
			'invoice_number'      => $invoice_number,
			'first_name'          => $costumer_data['first_name'],
			'last_name'           => $costumer_data['last_name'],
			'email'               => $costumer_data['email'],
			'mobile_number'               => $costumer_data['mobile_number'],
			/*'billing_name'        => $costumer_data['billing_name'],
			'billing_address'     => $costumer_data['billing_address'],
			'billing_phone'       => $costumer_data['billing_phone'],
			'billing_mobile'       => $costumer_data['billing_mobile'],
			'billing_zipcode'     => $costumer_data['billing_zipcode'],
			'billing_country'     => $costumer_data['billing_country'],
			'billing_state'       => $costumer_data['billing_state'],
			'billing_city'        => $costumer_data['billing_city'],*/
			'shipping_name'       => $costumer_data['shipping_name'],
			'shipping_address'    => $costumer_data['shipping_address'],
			'shipping_phone'      => $costumer_data['shipping_phone'],
			'shipping_mobile'      => $costumer_data['shipping_mobile'],
			'shipping_zipcode'    => $costumer_data['shipping_zipcode'],
			'shipping_country'    => $costumer_data['shipping_country'],
			'shipping_state'      => $costumer_data['shipping_state'],
			'shipping_city'       => $costumer_data['shipping_city'],
			'shipping_method'     =>'',			
			'shipping_amount'     =>'',
			'total_amount'        =>$total_amount,	 		
			'vat_amount'		  =>$tax,
			'vat_applied_cent'	  =>$tax_cent,
			'currency_code'       =>$currency_code ,
			'currency_value'      =>$currency_value,
			'currency_symbol'      =>$currency_symbol_left,
			'order_status'       => 'Pending',
			'order_received_date' =>$this->config->item('config.date.time'),
			//'payment_method'    =>$this->input->post("pay_method"),    
			'member_type'       => $costumer_data['customer_type'],
			'payment_method'    =>$payment_method,
			'payment_status'   => 'Unpaid'
			);
/*trace($data_order);
exit;*/
			if(!$this->cart_model->is_order_no_exits($invoice_number) )
			{
				$orderId = $this->cart_model->safe_insert('wl_order',$data_order,FALSE);
				$this->session->set_userdata( array('working_order_id'=>$orderId) );

				foreach($this->cart->contents() as $items)
				{
					$thumbc['width'] =65;
					$thumbc['height']=85;
					$thumb_name = "thumb_".$thumbc['width']."_".$thumbc['height']."_".$items['img'];

					get_image("products",$items['img'],$thumbc['width'],$thumbc['height'],"R" );
					$image_file  = IMG_CACH_DIR."/".$thumb_name;

					$default_no_img = FCROOT."assets/developers/images/noimg1.gif";

					$file_data   = ( file_exists($image_file) ) ?  file_get_contents($image_file) : file_get_contents($default_no_img);
					//$tax=$items['price']*$items['qty']*$items['tax']/100;
					//$scharge=( $items['qty']*get_product_shipping_charges($items['pid']));					
					//$vres = $this->members_model->get_member_row( $vendor_id );					
									
				//trace($items);
					
					$warranty_name='';
					$package_name='';
					if(!empty($items['options']['warranty_id'])){
						
						$warranty_name=get_db_field_value("wl_warranty","title"," AND warranty_id='".$items['options']['warranty_id']."'");
					}
					if(!empty($items['options']['package_id'])){
						
						$package_name=get_db_field_value("wl_package","title"," AND package_id='".$items['options']['package_id']."'");
					}
					
					$data = array(
					'orders_id'      => $orderId,
					'products_id'    => $items['pid'],
					'product_name'   => $items['origname'], 					
					'product_code'   => $items['code'],
					
					'product_brand'       => $items['brand'],
					'product_color'           => $items['color'],
					'product_size'       => $items['size'],
					
					 'service_name'=>$items['options']['service_name'],
					 'service_type'=>$items['options']['service_type'],
					 'warranty_type'=>$items['options']['warranty_type'],
					 'package_type'=>$items['options']['package_type'],
					 'warranty_id'=>$items['options']['warranty_id'],
					 'package_id'=>$items['options']['package_id'],
					 'warranty_price'=>$items['options']['warranty_price'],
					 'package_price'=>$items['options']['package_price'],
                                         'service_price'=>$items['options']['service_price'],
					
					 'warranty_name'=>$warranty_name,
					 'package_name'=>$package_name,
					 
					'product_image'  => $file_data,
					'product_tax'  => '',
					'product_price'  => $items['price'],
					'payment_amount'  => $total_amount,
					'quantity'       => $items['qty']
					);
/*trace($data);
exit;*/
					$this->cart_model->safe_insert('wl_orders_products',$data,FALSE);

				}

				$ordmaster = $this->order_model->get_order_master( $orderId );
				$orddetail = $this->order_model->get_order_detail( $orderId);

				if( is_array( $ordmaster )  && !empty( $ordmaster ) )
				{

					ob_start();
					$mail_subject =$this->config->item('site_name')." Order overview";
					$from_email   = $this->admin_info->admin_email;
					$from_name    = $this->config->item('site_name');
					$mail_to      = $ordmaster['email'];
					$body         = order_invoice_content($ordmaster,$orddetail);

					$msg          = ob_get_clean();
					$mail_conf =  array(
					'subject'=>$this->config->item('site_name')." Order overview",
					'to_email'=>$mail_to,
					'from_email'=>$from_email,
					'from_name'=> $this->config->item('site_name'),
					'body_part'=>$msg);
					$this->dmailer->mail_notify($mail_conf);

					/******* End Invoice  mail */

				}

				/*$this->cart->destroy();
					$data = array('coupon_id'=>0,'discount_amount'=>0);
					$this->session->unset_userdata($data);*/
									
					$data = array('shipping_id' => 0,'total_amount_payable'=>0,'sub_total' => 0);
					$this->session->unset_userdata($data);
					
					echo form_open("payment",array("name"=>"frm","id"=>"frm"));
					echo form_hidden("pay_method",$payment_method);
					echo form_close();
					echo '<script type="text/javascript">document.frm.submit();</script>';
					exit;
			}
		}
	}

	public function invoice_mail_data($ordId)
	{
		if( $ordId !="")
		{
			$msgdata      = invoice_data($ordId);
			$msgdata      = str_replace('bgcolor="#333333"','',$msgdata);
			$msgdata      = str_replace('Print','',$msgdata);
			$msgdata      = str_replace('Close','',$msgdata);
			return $msgdata;
		}
	}

	public function invoice()
	{
		if( ( !$this->cart->total_items() > 0 ) )
		{
			redirect('cart');
		}

		$user_id=($this->session->userdata("user_id")>0)?$this->session->userdata("user_id"):$this->session->userdata("quest");

		if($user_id<=0)redirect('cart/checkout');

		$data['unq_section'] = "Checkout";

		$shipping_methods           =  $this->product_model->get_shipping_methods();



		$this->form_validation->set_error_delimiters("<p class='required'>","</p>");
		$this->form_validation->set_rules('shipping_method', 'Shipping Method','trim|required|xss_clean');
		$this->form_validation->set_message('required',$this->config->item('shipping_required'));

			if($this->form_validation->run()=== TRUE)
			{
					$posted_shipping_method     =  $this->input->post('shipping_method');
				$this->session->set_userdata('shipping_id',$posted_shipping_method);
				if($this->input->post("make_payment")!="")
				redirect('cart/make_payment');
			}
		$data["shipping_methods"]=$shipping_methods;
		$this->load->view('view_cart_invoice',$data);

		/*
		if( $this->session->userdata('working_order_id') > 0 )
		{
			$this->load->model(array('order/order_model'));
			$data['title'] = "Checkout";
			$order_res = $this->order_model->get_order_master( $this->session->userdata('working_order_id') );
			$order_details_res = $this->order_model->get_order_detail($order_res['order_id']);
			$data['orddetail']  = $order_details_res;
			$data['ordmaster']  = $order_res;
			$data['ordId']      = $order_res['order_id'];
			$data['unq_section'] = "Checkout";
			$this->load->view('view_cart_invoice',$data);

		}else
		{
			redirect('cart', '');
		}
		*/
	}

	public function print_invoice()
	{
		//$ordId  = $this->session->userdata('working_order_id');
		//$data['ordId'] = $ordId;
		$this->load->model(array('order/order_model'));
		$ordId              = (int) $this->uri->segment(3);
		$order_res = $this->order_model->get_order_master( $this->session->userdata('working_order_id') );
		$order_details_res = $this->order_model->get_order_detail($order_res['order_id']);
		$data['orddetail']  = $order_details_res;
		$data['ordmaster']  = $order_res;
		$this->load->view('members/view_invoice_print',$data);
	}

	public function add_to_wishlist()
	{

		if( $this->session->userdata('user_id') > 0 )
		{
			$product_id = (int) $this->uri->segment(3);
			$this->cart_model->add_wislists($product_id,$this->session->userdata('user_id'));
			redirect('members/wishlist');
		}else
		{
			redirect('users/login?ref='.$this->input->server('HTTP_REFERER').'');
		}
	}

	public function add_to_cart()
	{
		$this->add_cart();
	}

	public function check_product_exits_into_cart($pres)
	{
		 $service_type = $this->input->post('service_type');
		 $warranty_type = $this->input->post('warranty_type');
		 $warranty_id = $this->input->post('warranty_id');
		 
		 $package_type = $this->input->post('package_type');		 
		 $package_id = $this->input->post('package_id');
			
		
		 $cart_array =  $this->cart->contents();
		
		
		$insert_flag=FALSE;
		if( is_array( $cart_array ) && !empty($cart_array))
		{
			foreach($this->cart->contents() as $item )
			{
				if(array_key_exists('pid' ,$item ))
				{
					if( $item['pid']==$pres['products_id'])
					{
						if(($service_type !="" && $warranty_id !="" && array_key_exists("warranty_id",$item['options'])) && (($service_type !="" && $package_id !="" && array_key_exists("package_id",$item['options']) )) ){ //trace($cart_array);exit;
							if(($service_type==$item['options']["service_type"]) && ($warranty_id==$item['options']["warranty_id"]) && ($package_id==$item['options']["package_id"])){
								$insert_flag=TRUE;
							}
						}
						
					}
				}
			}
		}

		return $insert_flag;
	}

	private function add_cart()
	{
         
		$mtype=$this->mtype;
		$productId  = (int) $this->uri->segment(3);
				
		$option     = array('productid'=>$productId);
		$pres       =  $this->product_model->get_products(1,0, $option);		

		//trace($_REQUEST);
		//exit;
		
		if( (is_array($pres) && !empty($pres)))
		{
			$qty         = applyFilter('NUMERIC_GT_ZERO',$this->input->post('qty'));
			$qty         = ($qty > 0) ? $qty: 1;
			
			$service_name="";
			if($this->input->post('service_type') != ""){
				$sname = $this->input->post('service_type');
				$service_type_arr=($this->config->item('service_type'));
				$service_name=$service_type_arr[$sname];							  
			}
			
			$cart_price  = ( $pres[$mtype.'product_discounted_price']!= '0.0000') ? $pres[$mtype.'product_discounted_price'] : $pres[$mtype.'product_price'];
			$available_quantity=0;

			$is_exits_inot_cart = $this->check_product_exits_into_cart($pres);

			if( $is_exits_inot_cart )
			{
				$this->session->set_userdata(array('msg_type'=>'warning'));
				$this->session->set_flashdata('warning',$this->config->item('cart_product_exist'));
				redirect('cart');

			}else
			{				
				$cart_data  = array(
				'id'             => random_string('alnum',4),
				'qty'            => $qty,
				'tax'  => '',
				
				'shipping_charges'  => $pres['shipping_charges'],				
				'price'          => $cart_price,
				'product_price'  => $pres[$mtype.'product_price'],
				'discount_price' => $pres[$mtype.'product_discounted_price'],
				'name'           => url_title($pres['product_name']),
				'origname'       => $pres['product_name'],
				'code'           => $pres['product_code'],
				
				'brand'       => $pres['product_brand'],
				'color'           => $pres['product_color'],
				'size'       => $pres['product_size'],
				
				'pid'            => $pres['products_id'],
				'weight_name'=>$weight_name,
				'weight_id'=>$weightId,
				'img'            => $pres['media'],
				
				'friendly_url'    => $pres['friendly_url'],
				'max_qty'            => $pres['product_stock'],
				'options'		 => array(
				
				  'service_name'=>$service_name,
				  'service_type'=>$this->input->post('service_type'),
				  'warranty_type'=>$this->input->post('warranty_type'),
				  'package_type'=>$this->input->post('package_type'),
				  'warranty_id'=>$this->input->post('warranty_id'),
				  'package_id'=>$this->input->post('package_id'),
				  'warranty_price'=>$this->input->post('hidden1'),
				  'package_price'=>$this->input->post('hidden2'),
                                  'service_price'=>$this->input->post('hidden3')
				  )
				);
				//trace($cart_data); die();
				$this->cart->insert($cart_data);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',$this->config->item('cart_add'));
				redirect('cart');

			}
		}else
		{
			redirect("category");
		}

	}

	public function empty_cart()
	{
		$this->cart->destroy();
		$data2 = array(
				'shipping_id' => 0,
				'coupon_id' => 0,
				'discount_amount'=>0,
				'total_amount_payable'=>0				
		);

		$this->session->unset_userdata($data2);
		redirect('cart');

	}

	public function remove_item()
	{
		$data = array(
		'rowid' =>$this->uri->segment(3),
		'qty' => 0
		);

		$data2 = array(
		'shipping_id' => 0,
		'coupon_id' => 0,
		'discount_amount'=>0
		);

		$this->session->unset_userdata($data2);

		$this->cart->update($data);

		if($this->cart->total_items()==0)
		{
			$this->session->unset_userdata(array('coupon_id'=>0,'discount_amount'=>0));
		}else
		{
			$discount_res          =  $this->cart_model->get_discount( $this->session->userdata('coupon_id') );
			$this->apply_coupon_code( $discount_res );
		}

		$this->session->set_userdata(array('msg_type'=>'success'));
		$this->session->set_flashdata('success',$this->config->item('cart_delete_item'));

		redirect('cart','refresh');

	}

	public function update_cart_qty()
	{
		//trace($this->input->post());exit;
		for($i=1; $i<=$this->cart->total_items(); $i++)
		{
			$item = $this->input->post($i);

			$data = array(
			'rowid' => $item['rowid'],
			'qty' => $item['qty']
			);
			$this->cart->update($data);
			//trace($data);
		}

		if($this->cart->total_items()==0)
		{
			$this->session->unset_userdata(array('coupon_id'=>0,'discount_amount'=>0));
		}else
		{
			$discount_res          =  $this->cart_model->get_discount( $this->session->userdata('coupon_id') );
			$this->apply_coupon_code( $discount_res );
		}
	}

	public function count_cart_item()
	{
		return $this->cart->total_items();
	}

	public function cart_total_amount()
	{
		$total = $this->cart->total();
		return $total;
	}

	public function display_cart_image($orders_products_id)
	{
		$binary_data =  get_db_field_value('wl_orders_products','product_image',array('orders_products_id'=>$orders_products_id));
		header("Content-Type: image/jpeg");
		echo $binary_data;
	}

	public function thanksorder()
	{

		$data['page_text']=cms_page_content(9);
		$data['page_title'] = "Thanks";
		$this->load->view('view_order_thanks',$data);
	}
	
	public function addressbook()
	{
		$user_id=$this->session->userdata('user_id')>0?$this->session->userdata('user_id'):$this->session->userdata('guest');
				
		$mres = $this->members_model->get_member_row( $this->session->userdata('user_id') );
		$adr_mres	=	$this->members_model->get_member_all_address_book( $this->session->userdata('user_id'),'Ship' );
				
		$data['mres'] = $mres;
		$data['amres'] = $adr_mres;
		
		if ($this->form_validation->run() ===TRUE){			
						
			$where_bill  = "customer_id = '".$user_id."' AND address_type='Ship' ";	
			$this->cart_model->safe_update('wl_customers_address_book',array('default_status'=> 'N'),$where_bill,FALSE);
				
			$posted_billing_data =  array(
			'customer_id'        => $user_id,
			'name'        => $billing_name,
			'address'     => $this->input->post('address',TRUE),
			'zipcode'     => $this->input->post('zipcode',TRUE),
			'mobile'       => $this->input->post('mobile',TRUE),
			'city'        => get_city_name($this->input->post('city_id',TRUE)),
			'state'       => get_state_name($this->input->post('state_id',TRUE)),
			'address_type'     => 'Ship',
			'default_status'     => 'Y'
			);
			$this->members_model->safe_insert('wl_customers_address_book',$posted_billing_data);
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success','Address has been added');
			
			redirect('cart/make_payment', '');	
			}
		
		$data['page_title'] = "Address Book";
		$this->load->view('view_addressbook',$data);
	}
	
	public function select_address()
	{
		$user_id=$this->session->userdata('user_id')>0?$this->session->userdata('user_id'):$this->session->userdata('guest');
		$address_id=(int) $this->uri->segment(3);
		
		$where  = "customer_id = '".$user_id."' AND address_type='Ship' ";	
		$this->cart_model->safe_update('wl_customers_address_book',array('default_status'=> 'N'),$where,FALSE);
				
		if (!empty($user_id) && !empty($address_id)){			
						
			$where_bill  = "address_id = '".$address_id."' ";	
			$this->cart_model->safe_update('wl_customers_address_book',array('default_status'=> 'Y'),$where_bill,FALSE);				
			
			/*$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success','Address has been updated');*/
			
			redirect('cart/make_payment', '');	
			}
		
		$data['page_title'] = "Address Book";
		$this->load->view('view_addressbook',$data);
	}


	public function process(){
		if( ( !$this->cart->total_items() > 0 ) )
		{
			redirect('cart');
		}

		$user_id=($this->session->userdata("user_id")>0)?$this->session->userdata("user_id"):$this->session->userdata("guest");
		if($user_id<=0)redirect('cart/checkout');

		$mres = $this->members_model->get_member_row($user_id);

		//$bill_data=$this->members_model->get_member_address_book($user_id,"Bill");
		//$bill_data=$bill_data[0];
		$ship_data=$this->members_model->get_member_address_book($user_id,"Ship");
		$ship_data=$ship_data[0];

		$mres["email"]								=$mres["user_name"];
		/*$mres['billing_name']        = $bill_data['name'];
		$mres['billing_address']     = $bill_data['address'];
		$mres['billing_phone']       = $bill_data['phone'];
		$mres['billing_mobile']       = $bill_data['mobile'];
		$mres['billing_zipcode']     = $bill_data['zipcode'];
		$mres['billing_country']     = $bill_data['country'];
		$mres['billing_state']       = $bill_data['state'];
		$mres['billing_city']        = $bill_data['city'];*/
		$mres['shipping_name']       = $ship_data['name'];
		$mres['shipping_address']    = $ship_data['address'];
		$mres['shipping_phone']      = $ship_data['phone'];
		$mres['shipping_mobile']      = $ship_data['mobile'];
		$mres['shipping_zipcode']    = $ship_data['zipcode'];
		$mres['shipping_country']    = $ship_data['country'];
		$mres['shipping_state']      = $ship_data['state'];
		$mres['shipping_city']       = $ship_data['city'];

		$this->add_customer_order($mres,"");

	}

}

/* End of file member.php */
/* Location: .application/modules/products/controllers/cart.php */