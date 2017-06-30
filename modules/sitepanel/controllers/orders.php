<?php
class Orders extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array('order/order_model','members/members_model'));
		$this->load->helper(array('cart/cart','file'));
		$this->config->set_item('menu_highlight','orders management');
		$this->load->library(array('Dmailer'));
	}

	public  function index($page = NULL)
	{
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']		=  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		
		$mtype              = (int) $this->uri->segment(4);
				
		if($mtype){
			$condition = "AND member_type = '".$mtype."' ";
		}else{
			$condition = "AND member_type = '0' ";
		}
		
		$res_array              =  $this->order_model->get_orders($offset,$config['limit'],$condition);
		$config['total_rows']   =  $this->order_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);

		/* Order oprations  */
		

		if(  $this->input->post('unset_as')!='' )
		{
			$this->set_as('wl_order','order_id',array('payment_status'=>'Unpaid'));
		}

		if(  $this->input->post('ord_status')!='' )
		{
			$posted_order_status = $this->input->post('ord_status');
			$this->set_as('wl_order','order_id',array('order_status'=>$posted_order_status));
		}

		if(  $this->input->post('Delete')!='' )
		{
			$posted_order_status = $this->input->post('ord_status');
			$this->set_as('wl_order','order_id',array('order_status'=>'Deleted'));
		}
		
		/* End order oprations  */
		$data['heading_title']  = 'Order Lists';
		$data['res_count']  = $this->order_model->total_rec_found;
		$data['res']            = $res_array;
		$this->load->model(array('members/members_model'));
		$data['members']=$this->members_model->get_members(10000,0);
		$this->load->view('order/view_order_list',$data);
	}
	
	public function make_paid($order_id)
	{
		$order_id = (int) $order_id;
		$ordmaster = $this->order_model->get_order_master( $order_id );
		$orddetail = $this->order_model->get_order_detail($order_id);
		$query_string=query_string();					
		
		foreach($orddetail as $v){
			$condtion = array('field'=>"product_stock",'condition'=>"products_id ='".$v['products_id']."' ") ;
			$stock_res =  $this->order_model->findAll('wl_products',$condtion);
			/*echo $v['quantity'];
	   		trace($stock_res);
	   exit;*/
			if( is_array($stock_res) && !empty($stock_res))
			{
				foreach($stock_res as $sr){
					//echo $sr['product_stock']." -- ".$v['quantity']; exit;
					if($sr['product_stock'] < $v['quantity']){
						$this->session->set_userdata(array('msg_type'=>'error'));
						$this->session->set_flashdata('error', 'Some products are not in stock, please update the stock first.');
						redirect('sitepanel/orders'.$query_string, '');
					}
				}
			}else{
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success', lang('marked_paid'));
				redirect('sitepanel/orders'.$query_string, '');
			}
		}
		
		$where = "order_id = '".$order_id."'";
		$this->order_model->safe_update('wl_order',array('payment_status'=>'Paid'),$where,FALSE);
		$this->update_stocks($order_id);
		
		$ordmaster = $this->order_model->get_order_master( $order_id );
		$orddetail = $this->order_model->get_order_detail($order_id);

		/* Start  send mail */

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
		
		/* End  send mail */
		$this->session->set_userdata(array('msg_type'=>'success'));
		$this->session->set_flashdata('success', lang('marked_paid'));
		
		
		
		
		redirect('sitepanel/orders', '');

	}
	
	public function make_unpaid($order_id)
	{
		$order_id = (int) $order_id;
		$ordmaster = $this->order_model->get_order_master( $order_id );
		$orddetail = $this->order_model->get_order_detail($order_id);
		
		$where = "order_id = '".$order_id."'";
		$this->order_model->safe_update('wl_order',array('payment_status'=>'Unpaid'),$where,FALSE);
		$this->reverse_stocks($order_id);
		
		$this->session->set_userdata(array('msg_type'=>'success'));
		$this->session->set_flashdata('success', lang('marked_unpaid'));
		redirect('sitepanel/orders', '');

	}
	
	public function add_edit_comment()
	{
		$order_id = (int) $this->uri->segment(4);
		$res_data =  $this->db->get_where('wl_order', array('order_id' =>$order_id))->row();
		
		$this->form_validation->set_error_delimiters('<div class="required">', '</div>');
		$this->form_validation->set_rules('comments', 'Comments', 'trim|required');

			if ($this->form_validation->run() == TRUE){
				
				$comments=$this->input->get_post('comments');
				
				$query=$this->db->query("UPDATE wl_order SET comments='".$comments."' WHERE order_id='".$order_id."'");
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success','Comment Updated!');
				echo '<script type="text/javascript">window.opener.location.reload(true);
					window.close();</script>';
					exit;
		}
		$data['comments'] = $res_data->comments;
		$data['heading_title'] = "Add/Edit Comments";
		$this->load->view('order/view_comments',$data);
	}

	public function courierdetails($order_id)
	{
		$data['heading_title'] = 'Courier Details';
		$order_id = (int) $order_id;
		$res =  $this->order_model->get_order_master( $order_id );
		$this->form_validation->set_rules('courier_company_name','Courier Company Name',"trim|required");
		$this->form_validation->set_rules('bill_number','Airway Bill Number',"trim|required");
		if( is_array( $res ) && !empty( $res ))
		{
			if($this->input->post('action')=='edit')
			{
				if($this->form_validation->run()==TRUE)
				{
					$order_data = array(
					'courier_company_name'=>$this->input->post('courier_company_name',TRUE),
					'bill_number'=>$this->input->post('bill_number',TRUE)
					);
					
					$where = "order_id = '".$order_id."'";
					$this->order_model->safe_update('wl_order',$order_data,$where,FALSE);

					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success',lang('successupdate'));
					echo '<script type="text/javascript">window.opener.location.reload(true);
					window.close();</script>';
					exit;
				}
			}
			$data['res']=$res;
			$this->load->view('order/view_courier_details.php',$data);
		}
	}
	
	public function update_stocks($order_id)
	{
		$order_id = (int) $order_id;
		$condtion = array('field'=>"products_id,quantity",'condition'=>"orders_id ='$order_id'") ;
		$orders_res =  $this->order_model->findAll('wl_orders_products',$condtion);

		if( is_array($orders_res) && !empty($orders_res))
		{
			foreach($orders_res as $v)
			{
				$sql = "UPDATE wl_products SET product_stock = product_stock-$v[quantity]
				WHERE products_id = '".$v['products_id']."' ";
				$this->db->query($sql);
			}
		}
	}
	
	public function reverse_stocks($order_id)
	{
		$order_id = (int) $order_id;
		$condtion = array('field'=>"products_id,quantity",'condition'=>"orders_id ='$order_id'") ;
		$orders_res =  $this->order_model->findAll('wl_orders_products',$condtion);

		if( is_array($orders_res) && !empty($orders_res))
		{
			foreach($orders_res as $v)
			{
				$sql = "UPDATE wl_products  SET product_stock = product_stock+$v[quantity]
				WHERE products_id = '".$v['products_id']."' ";
				$this->db->query($sql);
			}
		}
	}
	
	public function print_invoice()
	{
		$this->load->helper(array('cart/cart'));
		$this->load->model(array('order/order_model'));
		$ordId              = (int) $this->uri->segment(4);
		$order_res          = $this->order_model->get_order_master( $ordId );
		$order_details_res  = $this->order_model->get_order_detail($order_res['order_id']);
		$data['orddetail']  = $order_details_res;
		$data['ordmaster']  = $order_res;
		$this->load->view('order/view_invoice_print',$data);
	}
	
	public function viewpayment(){
		$data['title']="payment Info";
		$ordID=(int)$this->uri->segment(4);
		$rwdata=get_db_single_row("wl_order_payment_info","*"," AND order_id ='".$ordID."'");
		if(is_array($rwdata) && count($rwdata) > 0 ){
			$data['rwdata']=$rwdata;
		$this->load->view('order/view_viewpayment',$data);
		}else{
		  echo "Invalid Access";	
		}
	}

}
// End of controller