<?php $this->load->view('includes/header'); ?>

  <div id="content">
  <div class="breadcrumb">
     <?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo anchor('sitepanel/members','Members'); ?> &raquo; <?php echo $heading_title;?>        
      </div>
      
      <div class="box">
    <div class="heading">
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">&nbsp;</div>
    </div>
    <div class="content">          
  <?php echo validation_message();?>
 <?php echo error_message(); ?>
    <table class="list" width="100%" id="my_data">
    <?php
	
		$atts = array(
		'width'      => '650',
		'height'     => '600',
		'scrollbars' => 'yes',
		'status'     => 'yes',
		'resizable'  => 'yes',
		'screenx'    => '0',
		'screeny'    => '0'
		);
		
		$atts1 = array(
						'width'      => '600',
						'height'     => '300',
						'scrollbars' => 'yes',
						'status'     => 'yes',
						'resizable'  => 'yes',
						'screenx'    => '0',
						'screeny'    => '0'
					 );	
	
    if(is_array($res) && count($res) > 0 )
    {
      ?>
      <thead>
        <tr>
          <td width="31" style="text-align: center;">SL.NO.</td>
          <td  class="left">Seller Name / Id</td>
          <td width="250" class="left"><pre>Payment Amount</pre></td>
          <td width="210" class="center">Action</td>
        </tr>
      </thead>
      <tbody>
      <?php
	  $slno=1;
      foreach($res as $catKey=>$val){
		  
        $vendor_details=get_db_single_row('wl_customers','CONCAT(first_name," ",last_name) as name',' and customers_id='.$val['vendor_id'].' ');
		
		$paid_arr=get_db_multiple_row("wl_vendor_payments","SUM(paid_amount) as paid_amount","vendor_id='".$val['vendor_id']."' AND status='1' GROUP BY vendor_id ");		
		
		$total_payment_amount=$val['total_payment_amount'];
		if($paid_arr[0]['paid_amount'] > 0){
			$total_payment_amount=($val['total_payment_amount']-$paid_arr[0]['paid_amount']);
		}
		if($total_payment_amount > 0){
		?>
        <tr>
          <td style="text-align: center;"><?php echo $slno;?></td>
          <td class="left"><?php echo $vendor_details['name'];?> (<?php echo $val['vendor_id'];?>)</td>
          <td class="left"><?php echo display_price($total_payment_amount);?></td>
          <td class="center"><?php echo anchor_popup('sitepanel/members/pay_now/'.$val['vendor_id'], 'Pay Now!', $atts);?></td>
        </tr>
        <?php
		}
      $slno++;
	  }
      ?>         
      </tbody>
    <?php
    }
    else{
      echo "<div class='ac b'> No record(s) found !</div>" ;
    }
    ?>
    </table>
    
  </div>
</div>
<?php $this->load->view('includes/footer'); ?>