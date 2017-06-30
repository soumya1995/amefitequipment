<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
$meta_rec = $this->meta_info;
if( is_array($meta_rec) && !empty($meta_rec) ){
	?>
<title><?php echo $meta_rec['meta_title'];?></title>
<meta name="description" content="<?php echo $meta_rec['meta_description'];?>" />
<meta  name="keywords" content="<?php echo $meta_rec['meta_keyword'];?>" />
	<?php
}?>
<link href="<?php echo base_url(); ?>assets/developers/css/proj.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico"/>
<script type="text/javascript">var _siteRoot='index.html',_root='index.html';</script>
<script type="text/javascript" > var site_url = '<?php echo site_url();?>';</script>
<script type="text/javascript" > var theme_url = '<?php echo theme_url();?>';</script>
<script type="text/javascript" > var resource_url = '<?php echo resource_url(); ?>'; var gObj = {};</script>
<link href="<?php echo theme_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo theme_url(); ?>css/ame-preet.css" type="text/css" rel="stylesheet">
<style type="text/css" media="screen">
<!--
@import url("<?php echo resource_url(); ?>fancybox/jquery.fancybox.css");
@import url("<?php echo theme_url(); ?>css/fluid_dg.css");

-->
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> 

<script type="text/javascript" src="<?php echo base_url(); ?>assets/developers/js/common.js"></script>
<?php
if ($this->config->item('analytics_id')!=""){
	?>
	<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '<?php echo $this->config->item('analytics_id');?>']);
	_gaq.push(['_trackPageview']);
	(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	</script>
	<?php
}?>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
</head>
<body>
<!-- google off index -->
<noscript><div style="height:30px;border:3px solid #6699ff;text-align:center;font-weight: bold;padding-top:10px">Java script is disabled , please enable your browser java script first.</div></noscript>
<?php $this->load->view('project_header');?>