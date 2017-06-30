<?php
class Payment extends Public_Controller
{
	
		public function __construct()
		{
		
		  parent::__construct();  			
		  $this->load->helper(array('payment/paypal','cart/cart','file'));
		  $this->load->model(array('order/order_model','payment/payment_model'));
		  $this->load->library(array('Dmailer'));		
		
		}
		
		public function index()
		{
			 $this->cart->destroy();
		 
			if( $this->input->post()!='' )
			{
			
				if($this->input->post('pay_method') == "paypal" )
				{	
				    $working_order_id =  $this->session->userdata('working_order_id');
				    $order_res = $this->order_model->get_order_master($working_order_id);
				    paypalForm($order_res);
				   
				
				}
				
							
			
			}  
		
		}
	   	 
	 
	   public function order_success()
	   {	
	   	   
		 $ordId = $this->uri->segment(4);
		 $payment_method = $this->uri->segment(3);		 
		 $data  = array('payment_method'=>$payment_method,'payment_status'=>'Paid');			 	 
		 $where = "MD5(order_id) = '$ordId' ";
		 		 
		   $this->payment_model->safe_update('wl_order',$data,$where,FALSE);		
		 
			$ordmaster = $this->order_model->get_order_master( $this->session->userdata('working_order_id') );
			$orddetail = $this->order_model->get_order_detail( $this->session->userdata('working_order_id'));	 
					
		     if( is_array( $ordmaster )  && !empty( $ordmaster ) ) 
			 {
			       /***** Send Invoice mail */
				    ob_start();	
					order_invoice_content($ordmaster,$orddetail);				
					$imess=ob_get_contents();
					ob_clean();
					$mail_subject =$this->config->item('site_name')." Order overview";
					$from_email   = $this->admin_info->admin_email;
					$from_name    = $this->config->item('site_name');
					$mail_to      = $ordmaster['email'];
					
					$body='<html xmlns="http://www.w3.org/1999/xhtml">
							<head>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							<title>Order Invoce</title>
							</head>
							<body style="font-size:12px; color:#fff; margin:0px; padding:0px; font-family:Arial, Helvetica, sans-serif; background:#fff;">
							<div style="width:800px; background:#f4f4f4;">';
														
					$body .= $imess; 
					
                    $body.='</div></body></html>';	
														
					$msg          = ob_get_contents();
					
					$mail_conf =  array(
					'subject'=>$this->config->item('site_name')." Order overview",
					'to_email'=>$mail_to,
					'from_email'=>$from_email,
					'from_name'=> $this->config->item('site_name'),
					'body_part'=>$msg);							
					$this->dmailer->mail_notify($mail_conf);					
				
				  /******* End Invoice  mail */		 
			 }
		 
		 $this->session->unset_userdata(array('working_order_id' =>0));
		 $this->session->set_flashdata('msg', $this->config->item('payment_success'));		
	     redirect('payment/thanks/'.$ordId, '');
	   
	 }
	 
	 
	  public function order_cancle()
	  {	 
	  
	     $ordId = $this->uri->segment(4);
		 $payment_method = $this->uri->segment(3);		 
		 $data  = array('payment_method'=>$payment_method,'order_status'=>'Canceled');			 	 
		 $where = "MD5(order_id) = '$ordId' ";
		 $this->payment_model->safe_update('wl_order',$data,$where,FALSE);			 
		 $this->session->unset_userdata(array('working_order_id' =>0));
		 $this->session->set_flashdata('msg', $this->config->item('payment_failed'));		 
	     redirect('payment/thanks/'.$ordId, '');
	   
	 }
	 
	
   
   public function thanks()
   {	   	
	 
	  $this->load->view('payment/pay_thanks');
	  
	 
   }
   
   
   

}
/* End of file member.php */
/* Location: .application/modules/products/controllers/cart.php */
