<?php
$sitepanel_menu_array = lang('top_menu_list'); 
$sitepanel_menu_array = @$sitepanel_menu_array[$this->session->userdata('admin_id')];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="#" lang="#" xml:lang="#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php  echo $this->config->item("site_admin"); ?></title>
<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico"/>
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
<div id="container">
<div id="header">
  <div class="div1">
    <div class="div2">
    
    <div style=" color: #FFF; font-size: 14px; font-weight: bold;"> <?php  echo $this->config->item("site_admin");  ?> </div>
    
    </div>
    <?php if ( $this->session->userdata('admin_logged_in')==TRUE ){ ?>
    
    <div class="div3">
    <img src="<?php echo base_url(); ?>assets/sitepanel/image/lock.png" alt="" style="position: relative; top: 3px;" />&nbsp;
    
    <?php echo "You are logged in as administrator"; ?> | <?php echo anchor('sitepanel/logout','Logout',array('class' => "red",'style'=>"color:#f00;text-decoration:none;")); ?></div>
    
    <?php } ?>
    
  </div>
  
  <?php if ( $this->session->userdata('admin_logged_in')==TRUE ){ ?>
  
  
  <div id="menu">
   <ul class="left" style="display: none;"><?php createMenu($sitepanel_menu_array);?></ul>
    <div style="clear:both"></div>    
   <?php
	$cur_menu_highlight = $this->config->item('menu_highlight');
	?>
    <script type="text/javascript"><!--
$(document).ready(function() {
	$('#menu > ul').superfish({
		hoverClass	 : 'sfHover',
		pathClass	 : 'overideThisToUse',
		delay		 : 0,
		animation	 : {height: 'show'},
		speed		 : 'normal',
		autoArrows   : false,
		dropShadows  : false, 
		disableHI	 : false, /* set to true to disable hoverIntent detection */
		onInit		 : function(){},
		onBeforeShow : function(){},
		onShow		 : function(){},
		onHide		 : function(){}
	});
	
	$('#menu > ul').css('display', 'block');
});
 
$(document).ready(function() {
	
		
		<?php
		if($cur_menu_highlight!='')
		{
		?>
			$('#dashboard').removeClass('selected');
			$('li[id="<?php echo $cur_menu_highlight;?>"]').addClass('selected');
		<?php
		}		
		?>
	
});
//--></script>

  </div>
  
   <?php
   }
   ?>  
</div>