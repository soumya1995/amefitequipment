<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_Controller extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('sitepanel/jquery_pagination'));
		$this->load->model(array('utils_model'));
		$this->admin_lib->is_admin_logged_in();
		$this->admin_log_data = array(
		'admin_user' => $this->session->userdata('admin_user'),
		'adm_key'    => $this->session->userdata('adm_key'),
		'admin_type' => $this->session->userdata('admin_type'),
		'admin_id' => $this->session->userdata('admin_id'),
		);
		
		$this->admin_id=$this->admin_log_data['admin_type'];
		$this->admin_type=$this->admin_log_data['admin_type'];

		$this->deletePrvg = $this->admin_log_data['admin_type'] == '1' ? TRUE : FALSE;
		$this->editPrvg = $this->admin_log_data['admin_type'] == '3' ? FALSE : TRUE;
		$this->activatePrvg = $this->admin_log_data['admin_type'] == '3' ? FALSE : TRUE;
		$this->deactivatePrvg = $this->admin_log_data['admin_type'] == '3' ? FALSE : TRUE;
		$this->orderPrvg = $this->admin_log_data['admin_type'] == '3' ? FALSE : TRUE;
		$this->featuredPrvg = $this->admin_log_data['admin_type'] == '3' ? FALSE : TRUE;
		$this->orderstatusPrvg = $this->admin_log_data['admin_type'] == '3' ? FALSE : TRUE;
		$this->newslettermailPrvg = $this->admin_log_data['admin_type'] == '3' ? FALSE : TRUE;
	}

	public function update_status($table,$auto_field='id')
	{
		$current_controller    = $this->router->fetch_class();
		$action                = $this->input->post('status_action',TRUE);
		$arr_ids               = $this->input->post('arr_ids',TRUE);
		$category_count        = $this->input->post('category_count',TRUE);
		$product_count         = $this->input->post('product_count',TRUE);

		if( is_array($arr_ids) )
		{
			$str_ids = implode(',', $arr_ids);
			
			if($action=='Activate')
			{
				foreach($arr_ids as $k=>$v )
				{
					$data = array('status'=>'1');
					$where = "$auto_field ='$v'";
					$this->utils_model->safe_update($table,$data,$where,FALSE);
					//echo_sql();
					/*if($current_controller=='products'){
						$table1="wl_products_related";
						$where1 = "related_id ='$v'";
						$this->utils_model->safe_update($table1,$data,$where1,FALSE);							
					}*/
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success',lang('activate') );
				}
			}
			
			if($action=='Deactivate')
			{
				foreach($arr_ids as $k=>$v )
				{
					$total_category=($category_count!='')?count_category("AND parent_id='$v' AND status='1'") : '0';
					if($current_controller=='brand')
					{
						$total_product   = count_products("AND brand_id='$v' ");
					}else if($current_controller=='color')
					{
						$total_product   = count_products("AND FIND_IN_SET( '".$v."',product_color_ids ) ");
						
					}else if($current_controller=='size')
					{
						$total_product   = count_products("AND FIND_IN_SET( '".$v."',product_size_ids ) ");
						
					}else if($current_controller=='material')
					{
						$total_product   = count_products("AND FIND_IN_SET( '".$v."',product_material_ids ) ");
						
					}else {
						$total_product = ($product_count!='') ? count_products("AND category_id='$v' AND status='1'") : '0';
					}
					if( $total_category>0 || $total_product > 0 )
					{
						$this->session->set_userdata(array('msg_type'=>'error'));
						$this->session->set_flashdata('error',lang('child_to_deactivate'));
					}else
					{
						$data = array('status'=>'0');
						$where = "$auto_field ='$v'";
						$this->utils_model->safe_update($table,$data,$where,FALSE);
						/*if($current_controller=='products'){
							$table1="wl_products_related";
							$where1 = "related_id ='$v'";
							$this->utils_model->safe_update($table1,$data,$where1,FALSE);							
						}*/
						$this->session->set_userdata(array('msg_type'=>'success'));
						$this->session->set_flashdata('success',lang('deactivate') );
					}
				}
			}
			
			if($action=='Delete')
			{
				foreach($arr_ids as $k=>$v )
				{
					$total_category  = ( $category_count!='' ) ?  count_category("AND parent_id='$v' ")     : '0';
					if($current_controller=='brand')
					{
						$total_product   = count_products("AND brand_id='$v' ");
					}else if($current_controller=='color')
					{
						$total_product   = count_products("AND FIND_IN_SET( '".$v."',product_color_ids ) ");
						
					}else if($current_controller=='size')
					{
						$total_product   = count_products("AND FIND_IN_SET( '".$v."',product_size_ids ) ");
						
					}else if($current_controller=='material')
					{
						$total_product   = count_products("AND FIND_IN_SET( '".$v."',product_material_ids ) ");
						
					}else
					{
						$total_product   = ( $product_count!='' )  ?  count_products("AND category_id='$v' ")   : '0';
					}
					
					if( $total_category>0 || $total_product > 0 )
					{
						$this->session->set_userdata(array('msg_type'=>'error'));
						$this->session->set_flashdata('error',lang('child_to_delete'));
					}else
					{
						$where = array($auto_field=>$v);
						$this->utils_model->safe_delete($table,$where,TRUE);
						
						/*if($current_controller=='products'){
							$where = array('related_id'=>$v);							
							$this->utils_model->safe_delete('wl_products_related',$where,TRUE);
						}*/
						
						$this->session->set_userdata(array('msg_type'=>'success'));
						$this->session->set_flashdata('success',lang('deleted') );
					}
				}
			}
			
			if($action=='Tempdelete')
			{
				$data = array('status'=>'2');
				$where = "$auto_field IN ($str_ids)";
				$this->utils_model->safe_update($table,$data,$where,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('deleted'));
			}
		}
		
		redirect($_SERVER['HTTP_REFERER'], '');
	}
	
	public function set_as($table,$auto_field='id',$data=array())
	{
		$arr_ids               = $this->input->post('arr_ids',TRUE);
		if( is_array($arr_ids ) )
		{
			$str_ids = implode(',', $arr_ids);
			if( is_array($data) && !empty($data) )
			{
				$where = "$auto_field IN ($str_ids)";
				$this->utils_model->safe_update($table,$data,$where,FALSE);
				
				$current_controller    = $this->router->fetch_class();
				if($current_controller=="orders" && $this->input->post("ord_status")!="" && ($this->input->post("ord_status")!="Pending" && $this->input->post("ord_status")!="Closed")){
					$this->load->library("dmailer");
					$mail_subject =$this->config->item('site_name')." Order overview";
				  $from_email   = $this->admin_info->admin_email;
				  $from_name    = $this->config->item('site_name');
				  
				  foreach($arr_ids as $key=>$val){
					  $order=get_db_single_row("wl_order",'*',array('order_id'=>$val));
					  $courier_details="";
					  if($this->input->post("ord_status")=="Dispatched"){
						  if($order['courier_company_name']!=""){
							  $courier_details.="<br/>Courier Company Name: ".$order['courier_company_name'];
						  }
						  if($order['bill_number']!=""){
							  $courier_details.="<br/>Airway Bill Number: ".$order['bill_number'];
						  }
					  }

						$mail_to      = $order["email"];
						$body         = "Dear ".ucwords($order["first_name"]." ".$order["last_name"]);
						$body 					.=",<br /><br />";
						
						$body 					.="This is to notify you that your order is ".$this->input->post("ord_status")."  successfully .<br /><br />Here are the details<br /> Order Number: $order[invoice_number] <br/>".$this->input->post("ord_status")." Date/Time: ".date("d-m-Y h:i:s").$courier_details."<br /><br />Regards,<br />Customer Support Team<br />".$this->config->item('site_name');
						$mail_conf =  array(
						'subject'=>$this->config->item('site_name')." Order ".$this->input->post("ord_status"),
						'to_email'=>$mail_to,
						'from_email'=>$from_email,
						'from_name'=> $this->config->item('site_name'),
						'body_part'=>$body );
						$this->dmailer->mail_notify($mail_conf);
					}
				}
				
				$this->session->set_userdata(array('msg_type'=>'success'));
				if($this->input->post("Delete")=="Delete"){
					$this->session->set_flashdata('success',"Record has been successfully deleted.");
				}else{
					if(in_array(1,$data)){
					$this->session->set_flashdata('success',"Record has been set ".str_replace("_"," ",$this->input->post('set_as'))." successfully.");
					}
					if(in_array(0,$data)){
						if($this->input->post("ord_status")){						
								
								$this->session->set_flashdata('success',"Record has been  set as ".$this->input->post("ord_status")." successfully.");
						}else{							
					
							$this->session->set_flashdata('success',"Record has been  unset ".str_replace("_"," ",$this->input->post('unset_as'))." successfully.");
						}
					}
				}
			}
			
			redirect($_SERVER['HTTP_REFERER'], '');
		}
	}

	/*

	$tblname = name of table
	$fldname = order column name  of table
	$fld_id  =  auto increment column name of table

	*/

	public function update_displayOrder($tblname,$fldname,$fld_id)
	{
		$posted_order_data=$this->input->post('ord');
		
		while(list($key,$val)=each($posted_order_data))
		{
			if( $val!='' )
			{
				$val = (int) $val;
				$data = array($fldname=>$val);
				$where = "$fld_id=$key";
				$this->utils_model->safe_update($tblname,$data,$where,TRUE);
			}
		}
		$this->session->set_userdata(array('msg_type'=>'success'));
		$this->session->set_flashdata('success',lang('order_updated'));
		redirect($_SERVER['HTTP_REFERER'], '');
	}

}