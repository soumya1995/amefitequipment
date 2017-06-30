<?php $this->load->view('includes/header');?>

<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo $heading_title;?></a></div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title;?></h1>
   <div class="buttons"> &nbsp;</div>
  </div>
  
  <div class="content">
   <?php echo form_open("sitepanel/testimonial/",'id="pagingform"');?>
   <input type="hidden" name="keyword" value="<?php echo $this->input->post('keyword');?>"  />
   <input type="hidden" name="status" value="<?php echo $this->input->post('status');?>"  />
   <input type="hidden" name="per_page" value="<?php echo $this->input->post('per_page');?>"  />
   <?php echo form_close();
   echo validation_message();
   echo error_message();
   echo form_open("sitepanel/orders/",'id="search_form" method="get" ');?>
   <div align="right" class="breadcrumb">Records Per Page : <?php echo display_record_per_page();?></div>
   <table width="80%"  border="0" cellspacing="3" cellpadding="3" align="center">
    <tr>
     <td width="22%" align="right" >Search By</td>
     <td width="78%"><input type="text" name="keyword" placeholder="Keywords" value="<?php echo $this->input->get_post('keyword');?>" style="width:240px;" /> &nbsp;
     <?php
     	$order_status=$this->input->get_post('order_status');
     ?>
     	 <select name="order_status"  >
			     <option value="">Order Status</option>	  
			     <option value="Delivered" <?php echo ($order_status=="Delivered")?" selected='selected'":"" ?>>Delivered </option>
			     <option value="Dispatched"  <?php echo ($order_status=="Dispatched")?" selected='selected'":"" ?>>Dispatched</option>
			     <option value="Rejected" <?php echo ($order_status=="Rejected")?" selected='selected'":"" ?>>Rejected </option>
			     <option value="Canceled" <?php echo ($order_status=="Canceled")?" selected='selected'":"" ?>>Canceled </option>
			     <option value="Closed" <?php echo ($order_status=="Closed")?" selected='selected'":"" ?>>Closed</option>
			     <option value="Pending" <?php echo ($order_status=="Pending")?" selected='selected'":"" ?>>Pending</option>
                 <option value="Ready For Dispatch" <?php echo ($order_status=="Ready For Dispatch")?" selected='selected'":"" ?>>Ready For Dispatch</option>
			    </select>
     		<?php
     		/*	$options=array(""=>"Select Member");
     		
     			for($i=0;$i<count($members);$i++){
	     			$options[$members[$i]["customers_id"]]=$members[$i]["first_name"]." ".$members[$i]["last_name"];
	     		}	
	     		echo form_dropdown("customers_id",$options,$this->input->get_post("customers_id"));
     		
     		*/?>
     </td>
    </tr>
    <tr>
     <td>&nbsp;</td>
     <td><input name="from_date" type="text" id="textfield3" class="start_date1 input-bdr2 radius-5" placeholder="From Date" style="width:165px;">&nbsp;<input name="to_date" type="text" id="textfield4" class="end_date1 input-bdr2 radius-5" placeholder="To Date"  style="width:165px;"></td>
    </tr>
    <tr>
     <td>&nbsp;</td>
     <td>&nbsp;<a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a>&nbsp; Keywords Like : Invoice Number , name , email, payment status, order status <?php if( $this->input->get_post('keyword')!='' || $this->input->get_post('from_date')!='' || $this->input->get_post('to_date')!='' || $this->input->get_post('order_status')!='' || $this->input->get_post('customers_id')!=''){ echo anchor("sitepanel/orders/",'<span>Clear Search</span>'); }?> </td>
    </tr>
   </table>
   <?php echo form_close(); 
   //trace($res);
   if( is_array($res) && !empty($res)){
	   echo form_open("sitepanel/orders",'id="data_form"');
	   ?>
       <div><strong>Total No. of Records:</strong> <?php echo $res_count;?></div>
       <table class="list" width="100%">
		  <tr>
		   <td align="left" style="padding:2px">
		    <?php
		    if($this->deactivatePrvg===TRUE){
			    /*?>
			    <input name="unset_as" type="submit" class="button2" value="Unpaid" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]','Set Unpaid','Record','u_status_arr[]');"/>
			    <?php*/
		    }
			    ?>
			    <input name="Delete" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/>
			    <?php
		    
		    if($this->orderstatusPrvg===TRUE){
			    ?>
			    <select name="ord_status"  onchange="return onclickgroup()">
			     <option value="">Update Order Status</option>
			     <option value="Ready For Dispatch">Ready For Dispatch</option>
			     <option value="Delivered">Delivered </option>
			     <option value="Dispatched">Dispatched</option>
			     <option value="Rejected">Rejected </option>
			     <option value="Canceled">Canceled </option>
			     <option value="Closed">Closed</option>
			     <option value="Pending">Pending</option>
			    </select>
			    <?php
		    }?>
		   </td>
		  </tr>
		 </table>
	   <table class="list" width="100%" id="my_data">
	    <thead>
	     <tr>
	      <td width="5%" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
				<td width="25%" class="left">Customer</td>
			    <td width="8%" class="left">Shipper</td>
				<td width="5%" class="left">Order Date</td>
				<td width="5%" class="left">Balance</td>
				<td width="20%" class="left">Products</td>
				<?php /*<td width="15%" class="left">Courier Details</td>*/?>
			 	<td width="15%" class="left">Shipping Date</td>
				<td width="15%" class="left">Order Status</td>
			 </tr>
			</thead>
			<tbody>
			 <?php
			 $atts = array(
			 'width'      => '950',
			 'height'     => '600',
			 'scrollbars' => 'yes',
			 'status'     => 'yes',
			 'resizable'  => 'yes',
			 'screenx'    => '0',
			 'screeny'    => '0'
			 );
			 $atts_edit = array(
			 'width'      => '525',
			 'height'     => '375',
			 'scrollbars' => 'no',
			 'status'     => 'no',
			 'resizable'  => 'no',
			 'screenx'    => '0',
			 'screeny'    => '0'
			 );
			 foreach($res as $catKey=>$pageVal){
				 $payment_method = ($pageVal['payment_method']!="" ) ? $pageVal['payment_method'] : "N/A";
				 //$invoice_amount=$pageVal['total_amount']+ (float) $pageVal['shipping_amount'];
				 $invoice_amount=$pageVal['total_amount'];
				 if($pageVal['payment_status']=='Paid'){
				 	$invoice_amount=$pageVal['total_amount']-$pageVal['redeem_amount'];
				 }
				 ?>
				 <tr>
				  <td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['order_id'];?>" /></td>
				  <td class="left">
				  <!-- <strong><?php echo $pageVal['invoice_number'];?></strong><br /> -->
				  <!-- <?php echo $pageVal['order_received_date'];?><br /> -->
				   <?php echo $pageVal['first_name'];?> <?php echo $pageVal['last_name'];?><br />
				   <?php echo $pageVal['mobile_number'];?> (Mobile)<br />
				   <?php if($pageVal['phone']!=""){ echo $pageVal['phone'];?> (Phone)<br /><?php }
				   echo $pageVal['email'];?><br />
				  </td>
				  <td align="left"><?php echo $pageVal['courier_company_name']; ?>
					  <p><?php echo anchor_popup('sitepanel/calendar/add_edit_courier/'.$pageVal['order_id'], 'Add/Edit Courier', $atts_edit);?></p>
					 </td>
				 <td align="left"><?php echo $pageVal['order_received_date'];?><br />
				  <td align="left"><?php echo display_price($invoice_amount);?><br />
				  <td align="left"><?php echo anchor_popup('sitepanel/orders/print_invoice/'.$pageVal['order_id'], 'View Invoice', $atts);?><br />
					  				<?php echo anchor_popup('sitepanel/calendar/view_edit_products/', 'Add/Edit Product', $atts);?>
				  </td>
					  
				 <!-- <td align="left"><?php echo $pageVal['payment_status'];?><br /> -->
				   <?php
				   if($pageVal['payment_status']=='Unpaid'){
					   if($this->orderstatusPrvg===TRUE){
						   ?>
						   <a  onclick="return confirm('Are you sure you want to make this order paid');" href="<?php echo base_url();?>sitepanel/orders/make_paid/<?php echo $pageVal['order_id'];?><?php echo query_string();?>">Make Paid</a>
						   <?php
					   }
				   }else{
					   if($this->orderstatusPrvg===TRUE){
						   ?>
						   <a  onclick="return confirm('Are you sure you want to reverse stock and make this order unpaid');" href="<?php echo base_url();?>sitepanel/orders/make_unpaid/<?php echo $pageVal['order_id'];?><?php echo query_string();?>">Make Unpaid</a>
						   <?php
					   }
				   }?>
				  </td>
				  <?php /*<td class="left">
				   <?php if($pageVal['courier_company_name']){ echo $pageVal['courier_company_name'];}?><br /><br />
				   <?php if($pageVal['bill_number']){ echo $pageVal['bill_number'];}?><br />
				   <p><?php echo anchor_popup('sitepanel/orders/courierdetails/'.$pageVal['order_id'], 'Courier Details', $atts_edit);?></p>
				  </td>*/?>
				  <td class="left"><?php echo $pageVal['order_delivery_date']; ?>
					<p><?php echo anchor_popup('sitepanel/calendar/add_edit_ship_date/'.$pageVal['order_delivery_date'], 'Add/Edit Shipping Date', $atts_edit);?></p> 
				  </td>
				  <td class="left">
				  <?php echo $pageVal['order_status'];?>
                  <p><?php echo anchor_popup('sitepanel/orders/add_edit_comment/'.$pageVal['order_id'], 'Add/Edit Comments', $atts_edit);?></p>
                  </td>
				 </tr>
				 <?php
			 }?>
			</tbody>
		 </table>
		 <?php
		 if($page_links!=''){
			 ?>
			 <table class="list" width="100%">
			  <tr><td align="right" height="30"><?php echo $page_links;?></td></tr>
			 </table>
			 <?php
		 }?>
		 
		 
		 <?php
		 echo form_close();
	 }else{
		 echo "<center><strong> No record(s) found !</strong></center>" ;
	 }?>
	</div>
 </div>
</div> 
<?php
$default_date = '2013-08-12';
$posted_start_date = $this->input->post('from_date');
?>
<script type="text/javascript">
$(document).ready(function(){
	$('.btn_sbt2').live('click',function(e){
		e.preventDefault();
		$start_date = $('.start_date1:eq(0)').val();
		$end_date = $('.end_date1:eq(0)').val();
		$start_date = $start_date=='From' ? '' : $start_date;
		$end_date = $end_date=='To' ? '' : $end_date;
		$(':hidden[name="keyword2"]','#ord_frm').val($('input[type="text"][name="keyword2"]').val());
		$(':hidden[name="start_date"]','#ord_frm').val($start_date);
		$(':hidden[name="end_date"]','#ord_frm').val($end_date);
		$("#ord_frm").submit();
	});
	$('.start_date,.end_date').live('click',function(e){
		e.preventDefault();
		cls = $(this).hasClass('start_date') ? 'start_date1' : 'end_date1';
		$('.'+cls+':eq(0)').focus();
	});
	$( ".start_date1").live('focus',function(){
		$(this).datepicker({
			showOn: "focus",
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			defaultDate: 'y',
			buttonText:'',
			minDate:'<?php echo $default_date;?>' ,
			maxDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())."+180 days"));?>',
			yearRange: "c-100:c+100",
			buttonImageOnly: true,
			onSelect: function(dateText, inst) {
				$('.start_date1').val(dateText);
				$( ".end_date1").datepicker("option",{
					minDate:dateText ,
					maxDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())."+180 days"));?>',
				});			
			}
		});
	});
	$( ".end_date1").live('focus',function(){
		$(this).datepicker({
			showOn: "focus",
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			defaultDate: 'y',
			buttonText:'',
			minDate:'<?php echo $posted_start_date!='' ? $posted_start_date :  $default_date;?>' ,
			maxDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())."+180 days"));?>',
			yearRange: "c-100:c+100",
			buttonImageOnly: true,
			onSelect: function(dateText, inst) {
				$('.end_date1').val(dateText);
			}
		});
	});

});
</script>

<script type="text/javascript">
	function onclickgroup(){
		if(validcheckstatus('arr_ids[]','Update order status','record','u_status_arr[]')){
			$('#data_form').submit();
		}
	}
</script>
<?php $this->load->view('includes/footer');?>