<?php 
   class calendar extends CI_Controller {
	   
	   public function __construct()
		{
		parent::__construct();

		$this->load->model(array('order/order_model','members/members_model'));
		$this->load->helper(array('cart/cart','file'));
		$this->config->set_item('menu_highlight','orders management');
		$this->load->library(array('Dmailer'));
		}
  
      public function index($page = NULL) { 
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
		$data['heading_title']  = 'Shipping Calendar';
		$data['res_count']  = $this->order_model->total_rec_found;
		$data['res']            = $res_array;
		$this->load->model(array('members/members_model'));
		$data['members']=$this->members_model->get_members(10000,0);
		$this->load->view('calendar/view_order_list',$data);
 
      }
	   
	  public function add_edit_courier()
	{
		$order_id = (int) $this->uri->segment(4);
		$res_data =  $this->db->get_where('wl_order', array('courier_company_name' =>$courier_company_name))->row();
		
		$this->form_validation->set_error_delimiters('<div class="required">', '</div>');
		$this->form_validation->set_rules('comments', 'Comments', 'trim|required');

			if ($this->form_validation->run() == TRUE){
				
				$courier_company_name=$this->input->get_post('comments');
				
				$query=$this->db->query("UPDATE wl_order SET courier_company_name='".$courier_company_name."' WHERE order_id='".$order_id."'");
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success','Shipper Updated!');
				echo '<script type="text/javascript">window.opener.location.reload(true);
					window.close();</script>';
					exit;
		}
		$data['comments'] = $res_data->comments;
		$data['heading_title'] = "Add/Edit Courier";
		$this->load->view('calendar/add_edit_courier',$data);
	}
	   
	 public function add_edit_ship_date()
	{
		$order_id = (int) $this->uri->segment(4);
		$res_data =  $this->db->get_where('wl_order', array('comments' =>$date))->row();
		
		$this->form_validation->set_error_delimiters('<div class="required">', '</div>');
		$this->form_validation->set_rules('date', 'Shipping Date', 'trim|required');

			if ($this->form_validation->run() == TRUE){
				
				$date=$this->input->get_post('date');
				
				$query=$this->db->query("UPDATE wl_order SET comments='".$date."' WHERE comments='".$date."'");
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success','Shipping Date Updated!');
				echo '<script type="text/javascript">window.opener.location.reload(true);
					window.close();</script>';
					exit;
		}
		$data['date'] = $res_data->date;
		$data['heading_title'] = "Add/Edit Shipping Date";
		$this->load->view('calendar/add_edit_ship_date',$data);
	}
	   
	public function view_edit_products()
	{
		$order_id = (int) $this->uri->segment(4);
		$res_data =  $this->db->get_where('wl_order', array('comments' =>$date))->row();
		
		//$this->form_validation->set_error_delimiters('<div class="required">', '</div>');
		//$this->form_validation->set_rules('date', 'Shipping Date', 'trim|required');

			//if ($this->form_validation->run() == TRUE){
				
				$date=$this->input->get_post('date');
				
				$query=$this->db->query("UPDATE wl_order SET comments='".$date."' WHERE comments='".$date."'");
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success','Product was updated');
				echo '<script type="text/javascript">window.opener.location.reload(true);
					window.close();</script>';
					exit;
		//}
		$data['date'] = $res_data->date;
		$data['heading_title'] = "Add/Edit Products";
		$this->load->view('calendar/view_edit_products',$data);
	}
   } 