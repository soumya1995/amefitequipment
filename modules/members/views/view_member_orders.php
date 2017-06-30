<?php $this->load->view("top_application");
$account_link = site_url('members/myaccount');?>
<script type="text/javascript">function serialize_form() { return $('#ord_frm').serialize(); } </script>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<h1 class="heading">Shipping History</h1>   
    
<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li><a href="<?php echo base_url();?>members/myaccount">My Account</a></li>
<li class="active">Shipping History</li>
</ul>

	<div class="mt10">
      <div class="myacc-link">
      <?php $this->load->view("members/myaccount_links");?>
      </div>
      
      <p style="margin-top:-1px; border-bottom:#e3e3e3 1px solid;"></p>
      <p class="fs11 text-right mt10 text-uppercase">Welcome <?php echo ucwords($mres['first_name']." ".$mres['last_name']);?> <span class="red ml5 bl pl5 mob_hider">Last Login : <?php echo getDateFormat($mres['last_login_date'],7);?></span></p>
	      
	<div class="mt20" id="my_data">
    <?php
	echo error_message();	    	  
	validation_message();
    ?>
    
        <div class="form_box" id="form_1">
        <?php 
		echo form_open("",'id="pagingform"');
		?>
        <div>
	<div class="order-search">
	<p><input name="keyword" value="<?php echo $this->input->get_post('keyword');?>" type="text" class="txtbox w98" placeholder="Keywords"></p>
	
    <p><input name="from_date" value="<?php echo $this->input->get_post('from_date');?>" type="text" class="start_date1 txtbox w87" autocomplete="off" placeholder="From"> <img src="<?php echo theme_url();?>images/date.png" alt="" class="vam"></p>
	
    <p><input name="to_date" type="text" class="end_date1 txtbox w87" value="<?php echo $this->input->get_post('to_date');?>" autocomplete="off" placeholder="To"> <img src="<?php echo theme_url();?>images/date.png" alt="" class="vam"></p>
    <p>
    <?php
     	$order_status=$this->input->get_post('order_status');
     ?>
     	 <select name="order_status" class="txtbox w95">
			     <option value="">Order Status</option>	  
			     <option value="Delivered" <?php echo ($order_status=="Delivered")?" selected='selected'":"" ?>>Delivered </option>
			     <option value="Dispatched"  <?php echo ($order_status=="Dispatched")?" selected='selected'":"" ?>>Dispatched</option>
			     <option value="Rejected" <?php echo ($order_status=="Rejected")?" selected='selected'":"" ?>>Rejected </option>
			     <option value="Canceled" <?php echo ($order_status=="Canceled")?" selected='selected'":"" ?>>Canceled </option>
			     <option value="Closed" <?php echo ($order_status=="Closed")?" selected='selected'":"" ?>>Closed</option>
			     <option value="Pending" <?php echo ($order_status=="Pending")?" selected='selected'":"" ?>>Pending</option>
                 <option value="Ready For Dispatch" <?php echo ($order_status=="Ready For Dispatch")?" selected='selected'":"" ?>>Ready For Dispatch</option>
			    </select>
    </p>
	<p class="go-b"><input name="submit" type="submit" value="Go" class="btn">
    <span class="go-b"><?php if( $this->input->get_post('keyword')!='' || $this->input->get_post('from_date')!='' || $this->input->get_post('to_date')!='' || $this->input->get_post('order_status')!='' || $this->input->get_post('customers_id')!=''){ echo anchor("members/orders_history",'<span>Clear Search</span>'); }?></span></p>
	<p class="cb"></p>
	</div>
    <p class="cb"></p>
    </div>
        <?php echo form_close();
		
		if( is_array($res) && !empty($res)){
			?>
        <div class="cart-head">
            <p class="order-tab1">S. No.</p>
            <p class="order-tab2">Order ID</p>
            <p class="order-tab3">Amount</p>
            <p class="order-tab4">Date</p> 
            <p class="order-tab5">Delivery Status</p>
            <p class="order-tab6">Payment Status</p>        
            <p class="cb"></p>
        </div>
         <?php
	     $i=$this->uri->segment(4,0);
	     foreach($res as $val){
			 $i++;
		     $total           =  $val['total_amount'];
			 $shipping_total=$val['shipping_amount'];
		     $grand_total      = ($total+$shipping_total);
		     $curr_symbol=$val['currency_symbol'];
		     ?>
            <div class="cart-list">
                <p class="order-tab1"><?php echo $i;?>.</p>
                <p class="order-tab2 blue u"><span class="b black mob_only">Order ID<br></span><a href="<?php echo base_url();?>members/view_invoice/<?php echo $val['order_id'];?>"><?php echo $val['invoice_number'];?></a></p>
                <p class="order-tab3"><span class="b mob_only">Amount<br></span><?php echo $curr_symbol.''.(number_format($grand_total,2));?></p>
                <p class="order-tab4"><span class="b mob_only">Date<br></span><?php echo getDateFormat($val['order_received_date'],3);?></p> 
                <p class="order-tab5"><span class="b mob_only">Delivery Status<br></span><?php echo $val['order_status'];?></p>
                <p class="order-tab6"><span class="b mob_only">Payment Status<br></span><?php echo $val['payment_status'];?></p>        
                <p class="cb"></p>
            </div>
          <?php
	     }?>
<div class="col-sm-12 text-center"> 
			<ul class="pagination"><?php echo $page_links; ?></ul>
        </div>
		<?php 
	   }else{
		   ?>
		   <div align="center" class="mt50">No Record(s) found!</div>
		   <?php
	   }?>
        
        </div>
    </div>
    
</div>
</div>
</div>
</div>
<?php
echo form_open(base_url()."members/orders_history",'id="ord_frm"');?>
<input type="hidden" name="keyword" value="<?php echo $this->input->post('keyword');?>" />
<input type="hidden" name="start_date" value="<?php echo $this->input->post('start_date');?>" />
<input type="hidden" name="end_date" value="<?php echo $this->input->post('end_date');?>" />
<input type="hidden" name="per_page" class="per_page" value="<?php echo $per_page;?>" />
<?php echo form_close();?>

<script type="text/javascript" src="<?php echo base_url();?>assets/developers/js/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="<?php echo base_url();?>assets/developers/js/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<?php
$default_date = date('Y-m-d',strtotime(date('Y-m-d',time())."-1835 days")); //'2013-01-01';
$posted_start_date = $this->input->post('from_date');
?>
<script type="text/javascript">
$(document).ready(function(){
	jQuery('[id ^="per_page"]').live('change',function(){
		$("[id ^='per_page'] option[value=" + jQuery(this).val() + "]").attr('selected', 'selected'); 
		
		jQuery(".per_page").val(jQuery(this).val());
		jQuery('#ord_frm').submit();
	});
	$('.btnsubmit').live('click',function(e){
		e.preventDefault();
		$start_date = $('.start_date1:eq(0)').val();
		$end_date = $('.end_date1:eq(0)').val();
		$start_date = $start_date=='From' ? '' : $start_date;
		$end_date = $end_date=='To' ? '' : $end_date;
		$(':hidden[name="keyword"]','#ord_frm').val($('input[type="text"][name="keyword1"]').val());
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
			maxDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())));?>',
			yearRange: "c-100:c+100",
			buttonImageOnly: true,
			onSelect: function(dateText, inst) {
				$('.start_date1').val(dateText);
				$( ".end_date1").datepicker("option",{
					minDate:dateText ,
					maxDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())));?>',
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
			maxDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())));?>',
			yearRange: "c-100:c+100",
			buttonImageOnly: true,
			onSelect: function(dateText, inst) {
				$('.end_date1').val(dateText);
			}
		});
	});
});
</script>
<?php $this->load->view("bottom_application");?>