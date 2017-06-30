<?php
class Members extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model(array('members/members_model','order/order_model'));
		$this->load->library(array('safe_encrypt'));
		$this->config->set_item('menu_highlight','members management');
	}

	public  function index($type=0)
	{

		$condtion = array();

		$pagesize = (int) $this->input->get_post('pagesize');

		$config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');

		$offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;

		$base_url = current_url_query_string(array('filter'=>'result'),array('per_page'));

		$status = $this->input->get_post('status',TRUE);

		if($status!='')
		{
			$condtion['status'] = $status;
		}

		$condtion["where"]="customer_type = '".$type."'";

		$res_array              = $this->members_model->get_members($config['limit'],$offset,$condtion);
		
		$total_record           = get_found_rows();
		$data['page_links']     =  admin_pagination($base_url,$total_record,$config['limit'],$offset);
		$data['heading_title']  = 'Manage '.(($type)?"Seller":"Buyer").' Members';  
		$data['pagelist']       = $res_array;
		$data['total_rec']      = $total_record  ;

		if( $this->input->post('status_action')!='')
		{
			$this->update_status('wl_customers','customers_id');
		}
		//trace($this->input->post());
		$data["type"]=($type==1)?"seller":"buyer";
		$this->load->view('member/member_list_view',$data);

	}

	public function seller(){
		$this->index(1);
	}

	public function details()
	{

		$customers_id   = (int) $this->uri->segment(4);
		$mres           = $this->members_model->get_member_row($customers_id);
		$res_bill       = $this->members_model->get_member_address_book($customers_id,'Bill');
		$res_ship       = $this->members_model->get_member_address_book($customers_id,'Ship');

		$data['heading_title']  = 'Members Details';
		$data['res_bill']  = $res_bill[0];
		$data['res_ship']  = $res_ship[0];
		$data['mres']      = $mres;
		$this->load->view('member/view_member_detail',$data);

	}
	
	public function verify()
	{ 
		$customers_id=(int) $this->uri->segment(4);
		$customer_type=(int) $this->uri->segment(5);
		$aarray =  array
					(
					'status'=>'1',
					'is_verified'=>'1',
					);
		$this->members_model->safe_update('wl_customers',$aarray,"customers_id = '".$customers_id."' ",FALSE);
		$this->session->set_userdata(array('msg_type'=>'success'));
		$this->session->set_flashdata('success','Member has been marked as Verified');
		if($customer_type=='1'){			
			redirect('sitepanel/members/seller','');
		}else{
			redirect('sitepanel/members/','');
		}
	}
	
	public function customer_type()
	{ 
		$customers_id=(int) $this->uri->segment(4);
		$customer_type=(int) $this->uri->segment(5);
		$type=($customer_type=='0')?'Buyer':'Wholesaler';
		
		$query=$this->db->query("UPDATE wl_customers SET customer_type='".$customer_type."' WHERE customers_id='".$customers_id."'");
		
		$this->session->set_userdata(array('msg_type'=>'success'));
		$this->session->set_flashdata('success','Member has been marked as '.$type.' ');		
		redirect('sitepanel/members/','');
		
	}


	public  function support_ticket($page = NULL)
	{
		$post_per_page =  $this->input->post('per_page');

		if($post_per_page!='')
		{
			$post_per_page=applyFilter('NUMERIC_GT_ZERO',$post_per_page);
			if($post_per_page>0)
			{
				$config['per_page']		 = $post_per_page;
			}else
			{
				$config['per_page']		 = $this->config->item('per_page');
			}
		}else
		{
			$config['per_page']		     = $this->config->item('per_page');
		}

		$offset                 = $this->uri->segment(4,0);
		$res_array              = $this->members_model->get_support_ticket($offset,$config['per_page']);
		$total_record           = get_found_rows();

		if($this->input->post('delete_ticket')!='' && $this->input->post('delete_ticket')=='Delete')
		{
			$arr_ids = $this->input->post('arr_ids');
			$str_ids = implode(',', $arr_ids);
			$where = "id IN( $str_ids)";
			$this->members_model->delete_in('tbl_ticket_support',$where,FALSE);
		}

		$data['page_links']     = admin_pagination("members/support_ticket/pages/",$total_record,$config['per_page']);
		$data['heading_title']  = 'Manage Support Ticket';
		$data['pagelist']       = $res_array;
		$data['total_rec'] = $total_record  ;
		$this->load->view('member/support_ticket_view',$data);

	}

	public function send_mail()
	{
		$rid =  $this->uri->segment(4);
		$res_data =  $this->db->get_where('wl_customers', array('customers_id' =>$rid))->row();

		if( is_object( $res_data ) )
		{
			$this->form_validation->set_rules('subject', 'Subject', 'required|xss_clean');
			$this->form_validation->set_rules('message', 'Message', 'required|xss_clean');
			if ($this->form_validation->run() == FALSE)
			{
				$data['heading_title'] = "Send Mail";
				$data['res'] = $res_data;
				$this->load->view('member/view_send_enq_reply',$data);

			}else
			{
				/* Reply  mail to user */

				$this->load->model(array('message/message_model'));

				$message_id=$this->message_model->safe_insert($this->message_model->table,array(
						"message_type"=>'1',
						"sender_id"=>'0',
						"name"=>$res_data->first_name,
						"email"=>$res_data->user_name,
						"message"=>$this->input->post("message"),
						"subject"=>$this->input->post('subject'),
						"created_at"=>$this->config->item("config.date.time"),
						"is_admin_approved"=>'1',
						"status"=>'1'));
				if($message_id){
					$this->message_model->safe_insert($this->message_model->table_relate,array(
							"message_id"=>$message_id,
							"user_id"=>$res_data->customers_id,
							"sender_id"=>0,
							"type"=>'INBOX',
							"posted_date"=>$this->config->item("config.date.time"),
							"message_status"=>"Unread"));
				}


				$this->load->library('email');
				$mail_to      = $res_data->user_name;
				$mail_subject = $this->input->post('subject');
				$from_email   =  $this->admin_info->admin_email;
				$from_name    =  $this->config->item('site_name');
				$body = "Dear ".ucwords($res_data->first_name." ".$res_data->last_name ) .",<br /><br />";
				$body .= $this->input->post('message');
				$body .= "<br /> <br />
				Thanks and Regards,<br />
				".$this->config->item('site_name')." Team ";

				$this->email->from($from_email, $from_name);
				$this->email->to($mail_to);
				$this->email->subject($mail_subject);
				$this->email->message($body);
				$this->email->set_mailtype('html');
				$this->email->send();

				$this->db->where('customers_id', $res_data->customers_id);
				$this->db->update('wl_customers',array('replied'=>'Y'));

				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('admin_mail_msg'));
					
				redirect('sitepanel/members/send_mail/'.$res_data->customers_id, '');

				/* End reply mail to user */
			}
		}
	}

	public function messages()
	{
		$mem_id=$this->uri->segment(4);
		$this->load->model(array('message/message_model'));
		if( $this->input->post('status_action')!='')
		{
			$this->update_status('wl_messages','id');
		}
		$condtion               = array();
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']		=  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$status			        =   $this->input->get_post('status',TRUE);

		$cond = "M.status != '3' AND MD.user_id ='".$mem_id."' ";

		$keyword=trim($this->input->get_post('keyword'));
		$date1=trim($this->input->get_post('from_date'));
		$date2=trim($this->input->get_post('to_date'));

		if($keyword)
		{
			$cond .=" AND (name LIKE '%".$this->db->escape_str($keyword)."%' || email LIKE '%".$this->db->escape_str($keyword)."%')";
		}
		$date_condition="";
		if(strpos($date1,"-")>0 and strpos($date2,"-")>0)
		{
			$date_condition=" and date(created_at) between '$date1' and '$date2'";
		}
		else if(strpos($date1,"-")>0)
		{
			$date_condition=" and date(created_at) between '$date1' and NOW()";
		}

		if($date_condition!="")
		{
			$cond .=$date_condition;
		}

		$res_array              = $this->message_model->get_records($offset,12,$cond,$this->input->post("sort_by"));

		$total_record           = get_found_rows();
		$data['page_links']     = admin_pagination($base_url,$total_record,$config['limit'],$offset);
		$data['heading_title']  = 'Manage Member Messages';
		$data['pagelist']       = $res_array;
		$data['total_rec']      = $total_record  ;
		$data["ckeditor"]			= set_ck_config(array('textarea_id'=>'message'));
		$this->load->view('member/member_message_list_view',$data);
	}


	public function view_reply()
	{
		$data['heading_title'] = "View Reply";
		$msg_id=$this->uri->segment(4);
		$this->load->model(array('message/message_model'));

		$data["message"]=$message=$this->message_model->get_record_by_id("id ='".$msg_id."'");

		$cond="message_id ='".$message->id."' AND status='1' AND message_reply!='NULL'";
		$data["rmessage"]=$this->message_model->get_reply_message(FALSE,0,$cond);

		$this->load->view('member/view_reply',$data);
	}

	public function send_reply()
	{
		$rid =  (int) $this->uri->segment(4);

		$this->db->select("*",FALSE);
		$res_data =  $this->db->get_where('wl_messages', array('id' =>$rid))->row();

			
		$this->load->library('email');

		if( is_object( $res_data ) )
		{
			$this->form_validation->set_error_delimiters('<div class="required">', '</div>');

			$this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean|max_length[8500]');

			if ($this->form_validation->run() == TRUE)
			{
				/* Reply  mail to user */


				$this->db->select("*")->from("wl_message_details")->where("message_id",$res_data->id)->order_by("id","ASC");
				$message_details=$this->db->get()->row();

				$this->load->model(array('message/message_model'));
				$this->db->select("*,CONCAT_WS(' ',first_name,last_name) AS name",FALSE);
				$user_data =  $this->db->get_where('wl_customers', array('customers_id' =>$message_details->user_id))->row();
					
				$mail_to      = $user_data->user_name;
				$mail_subject = 'Admin Reply';
				$from_email   = $this->admin_info->admin_email;
				$from_name    =  $this->config->item('site_name');
				$body = "Dear ".$user_data->name.",<br /><br />	";
				$body .= $this->input->post('message');
				$body .= "<br /> <br />
				Thanks and Regards,<br />
				".$this->config->item('site_name')." Team ";
					
				$this->email->from($from_email,$from_name);
				$this->email->to($mail_to);
				$this->email->subject($mail_subject);
				$this->email->message($body);
				$this->email->set_mailtype('html');
				$this->email->send();
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('admin_mail_msg'));



				$this->message_model->safe_insert($this->message_model->table_relate,array(
						"message_id"=>$res_data->id,
						"user_id"=>$message_details->user_id,
						"sender_id"=>0,
						"type"=>'INBOX',
						"message_reply"=>$this->input->post('message'),
						"posted_date"=>$this->config->item("config.date.time"),
						"message_status"=>"Unread"));

				redirect('sitepanel/members/send_reply/'.$res_data->id, '');

				/* End reply mail to user */
			}
			$data['heading_title'] = "Send Reply";
			$this->load->view('member/view_send_enq_reply',$data);

		}else
		{
			redirect('sitepanel/members/','');

		}
	}

	public function del_message()
	{
		$msg_id=$this->uri->segment(4);
		$msg_rply_id=$this->uri->segment(5);
		if($msg_rply_id>0)
		{
			$query=$this->db->query("UPDATE wl_message_details SET status='3' WHERE id='".$msg_rply_id."'");
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('deleted'));
			redirect('sitepanel/members/view_reply/'.$this->uri->segment(4),'');
		}
	}
	
	public function vendor_commission()
	{
		$customers_id=$this->uri->segment(4);
		$res_data =  $this->db->get_where('wl_customers', array('customers_id' =>$customers_id))->row();
		
		$this->form_validation->set_error_delimiters('<div class="required">', '</div>');
		$this->form_validation->set_rules('seller_commission', 'Commission', 'trim|required|is_valid_amount|max_length[10]');

			if ($this->form_validation->run() == TRUE){
				
				$customers_id=$this->uri->segment(4);
				$seller_commission=$this->input->get_post('seller_commission');
				
				$query=$this->db->query("UPDATE wl_customers SET seller_commission='".$seller_commission."' WHERE customers_id='".$customers_id."'");
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success','Commission Updated!');
				redirect('sitepanel/members/vendor_commission/'.$this->uri->segment(4),'');
		}
		$data['seller_commission'] = $res_data->seller_commission;
		$data['heading_title'] = "Seller Commission";
		$this->load->view('member/view_commission',$data);
	}
	
	public function upgratemembership(){
		
		$data['page_title'] = "Add/Upgrate Membership";
		$memID              = (int)$this->uri->segment(4);
		$data['rwmemsp']    = get_db_multiple_row("tbl_membership","*","status ='1' ORDER BY memship_type ASC ");
		if($this->input->post('action')=='Add'){
			
			$this->form_validation->set_rules('memship','Membership',"trim|required|max_length[50]|xss_clean");
			if($this->form_validation->run()==TRUE)
			{
			   $ramem=get_db_single_row("tbl_membership","*"," AND memship_id='".$this->input->post('memship')."'");
			  
			   $memstart_date=date('Y-m-d');
			   $membership_expiry=date("Y-m-d", mktime (0,0,0,date('m'),date('d')+$ramem['duration'], date('Y'))); 
			   
			   $this->db->query("UPDATE wl_customers SET membership_type='".$ramem['memship_type']."',membership_duration='".$ramem['duration']."',membership_start='$memstart_date',membership_expiry='$membership_expiry', membership_price='".$ramem['price']."', membership_percentage='".$ramem['percentage']."', membership_amount='".$ramem['amount']."' WHERE customers_id='$memID' ");
			   ?>
			   <script>
			    window.opener.location.reload();
			    window.close();
                </script>
            <?php
			exit; 
			}
		}
		$data['memID']      = $memID;
		$this->load->view('member/view_upgratemembership',$data);
	}
	
	
	public function payment_amount()
	{
		$data['heading_title'] = "Manage Payment Amount";		
		$param=array();
		$param['where']= " vendor_id != '0' ";
		
		$res_array=$this->order_model->get_vendor_sold_orders($param);
		$data['res']=$res_array;		
		
		$this->load->view('member/seller_order_list_view',$data);
	}
	
	public function pay_now()
	{
		$vendor_id=$this->uri->segment(4);
		//$res_data =  $this->db->get_where('wl_customers', array('customers_id' =>$customers_id))->row();
		
		$this->form_validation->set_error_delimiters('<div class="required">', '</div>');
		$this->form_validation->set_rules('paid_amount', 'Paid Amount', 'trim|required|is_valid_amount|max_length[10]');

			if ($this->form_validation->run() == TRUE){
				
				$paid_amount=$this->input->get_post('paid_amount');
				$param=array();
				$param['where']= " vendor_id = '".$vendor_id."' ";		
				$res_array=$this->order_model->get_vendor_sold_orders($param);
				
				if($res_array[0]['total_payment_amount'] >= $paid_amount){
					
					$balance_amount=($res_array[0]['total_payment_amount']-$paid_amount);
					
					$query=$this->db->query("INSERT INTO wl_vendor_payments SET vendor_id='".$vendor_id."', paid_amount='".$paid_amount."', balance_amount='".$balance_amount."', recv_date=now(), status='1' ");
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success','Amount Paid Successfully!');
					?>
					   <script>
                        window.opener.location.reload();
                        window.close();
                        </script>
                    <?php
                    exit;
				}
		}		
		$data['heading_title'] = "paid Amount";
		$this->load->view('member/view_commission',$data);
	}
	


}
// End of controller