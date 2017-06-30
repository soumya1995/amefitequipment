<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="#" lang="#" xml:lang="#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 

<title><?php  echo $this->config->item("site_admin"); ?></title>


<script type="text/javascript" > var site_url = '<?php echo site_url();?>';</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/sitepanel/css/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/developers/css/proj.css" />    

<script type="text/javascript" src="<?php echo base_url(); ?>assets/sitepanel/js/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/sitepanel/js/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="<?php echo base_url(); ?>assets/sitepanel/js/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/sitepanel/js/jquery/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/sitepanel/js/jquery/superfish/js/superfish.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/sitepanel/js/common.js"></script>
    
</head>

<body>
<div id="header_pop">

  <div class="div1">
   <?php  echo $this->config->item("site_admin");  ?>    
   </div> 
   
   <div style="float:right;"> <a href="#" onclick="javascript:window.close();" style="text-decoration:none; " >
   
   <font color="#FFFFFF">X Close </font></a> </div>

</div>