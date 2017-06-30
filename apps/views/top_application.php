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
<!--<meta name="google-site-verification" content="WYYdk3-V-uQcaBRBLlsNUa8NuVM85L6AsXt0fSk-2dI" />-->
<meta name="google-site-verification" content="xPq-9JJX8qgbx0RScM40fN47wzVh00xkIDI2Crf_X8U" />
<link href="<?php echo current_url();?>" rel="canonical" /> 
<link href="<?php echo base_url(); ?>assets/developers/css/proj.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico?v=2"/>
<script type="text/javascript">var _siteRoot='index.html',_root='index.html';</script>
<script type="text/javascript" > var site_url = '<?php echo site_url();?>';</script>
<script type="text/javascript" > var theme_url = '<?php echo theme_url();?>';</script>
<script type="text/javascript" > var resource_url = '<?php echo resource_url(); ?>'; var gObj = {}; var currency_symbol = '<?php echo $this->session->userdata('symbol_left');?>';</script>
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
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-90860942-1', 'auto');
  ga('send', 'pageview');

</script>
	<?php /*?><script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '<?php echo $this->config->item('analytics_id');?>']);
	_gaq.push(['_trackPageview']);
	(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	</script><?php */?>
	<?php
}?>



<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->

 
    
    <?php /*?><script src='//static.opentok.com/v2/js/opentok.min.js'></script> 
    <script> 
      var apiKey = '45500842';
      var sessionId = '1_MX40NTUwMDg0Mn5-MTQ1NTc4NDQ5NDk1Nn5CeVpvaDFKSkhPWmFTOEZNM0s4UmlDM1J-UH4'; 
      var token = 'T1==cGFydG5lcl9pZD00NTUwMDg0MiZzaWc9NzRkZjkyOTQ1NDdjYWM3ZTBkZTIwYmUxYmVkZWNlZmE3YjRmMTc3Nzpyb2xlPXB1Ymxpc2hlciZzZXNzaW9uX2lkPTFfTVg0ME5UVXdNRGcwTW41LU1UUTFOVGM0TkRRNU5EazFObjVDZVZwdmFERktTa2hQV21GVE9FWk5NMHM0VW1sRE0xSi1VSDQmY3JlYXRlX3RpbWU9MTQ1NTc5MDgwMCZub25jZT0wLjgxOTUzNzI3ODQ0MTQyMDEmZXhwaXJlX3RpbWU9MTQ1NTg3NzIwMA==';
      var session = OT.initSession(apiKey, sessionId); 
      session.on({ 
          streamCreated: function(event) { 
            session.subscribe(event.stream, 'subscribersDiv', {insertMode: 'append'}); 
          } 
      }); 
      session.connect(token, function(error) {
        if (error) {
          console.log(error.message);
        } else {
          session.publish('myPublisherDiv', {width: 320, height: 240}); 
        }
      });
    </script> <?php */?>
<?php if(!count($this->uri->segments)){ ?> 
	<script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "name": "AME Fitness Equipment",
       
      "logo": "http://www.amefitequipment.com/assets/designer/themes/default/images/ame.png",
      "description": "AmeFitEquipment.com is a leading Commercial Exercise Equipment Online shop in USA. We repair, remanufacture, reupholster and restore the latest brand-name, commercial fitness equipment.",
       "url" : "http://www.amefitequipment.com/",
       "sameAs" : [ "https://www.facebook.com/AMEFitEquipment",
        " https://twitter.com/Amefitequipment",
        "https://plus.google.com/115512316066508696468",
         "https://www.pinterest.com/AMEFitness/",
         "http://www.scoop.it/t/ame-fitness-equipment",
        "https://www.linkedin.com/company/ame-fitness-equipment"],
        
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Deer Park",
        "addressRegion": "New York",
        "streetAddress": "87E North Industry Court",
        "telephone" : "+1-631-392-4750",
         "email": "Info@amefitequipment.com" 
        }, 
        "contactPoint" : [
        { "@type" : "ContactPoint",
        "telephone" : "+1-631-392-4750.",
        "contactType" : "Customer Support",
        "areaServed" : "USA"
        } ]
          }
    </script>
<?php } ?>

</head>
<body>
<!-- google off index -->
<noscript><div style="height:30px;border:3px solid #6699ff;text-align:center;font-weight: bold;padding-top:10px">Java script is disabled , please enable your browser java script first.</div></noscript>
<?php $this->load->view('project_header');?>
<?php /*?>
<div id='myPublisherDiv'></div> 
<div id='subscribersDiv'></div>
<?php */?>