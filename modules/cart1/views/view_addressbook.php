<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" href="favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>PI Ecommerce</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo theme_url();?>css/sl.css">
<link rel="stylesheet" href="<?php echo theme_url();?>css/conditional_sl.css">
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css" media="screen">
<!--
@import url("<?php echo resource_url();?>fancybox/jquery.fancybox.css");
-->
</style>
</head>
<body>
<div class="pop-inr">
<h2 class="mb10">Address Book</h2>
 <div class="addresbk" style="height:286px; overflow-y:scroll">
 <?php
	if( is_array($amres) && !empty($amres) && !empty($amres[0]['address'])){
		?>
         <table class="w100 tab-bdr1">
          <tr class=" blues ttu">
            <td class="w10"><b>S. No.</b></td>
            <td><b>Address Book</b></td>
            <td class="w10"><b>Select</b></td>
          </tr>
          <?php  	
			echo form_open('members/delete_address');
			$sl=1;
			foreach($amres as $aVal){
		  ?>
          <tr>
            <td>1.</td>
            <td><p><b><?php echo $aVal['name'];?></b></p>
              <p><b>Mobile </b> : <?php echo $aVal['mobile'];?> / <b>Phone :</b> <?php echo $aVal['phone'];?></p>
              <p class="mt10"><?php echo $aVal['address'];?>, <?php echo $aVal['city'];?>, <?php echo $aVal['state'];?> - <?php echo $aVal['zipcode'];?>, <?php echo strtoupper($aVal['country']);?></p> 
              </td>
            <td><a href="#" onClick="window.open('<?php echo base_url();?>cart/select_address/<?php echo $aVal['address_id'];?>','_parent')" class=" btn btn5">Select</a></td>
          </tr>
        <?php
		$sl++;
		}
		echo form_close();
	?> 
        </table>
	<?php
}else{
	?>
    <div class="cb pb15"></div>
	<div class="b mt10" align="center">No record(s) available</div>
	<div class="cb pb15"></div>
	<?php
}?>
 
 </div>
 
</div>
</body>
</html>