<?php
$this->load->model(array('category/category_model','pages/pages_model'));

//******Fixed Category*********/
$condtion_array = array(
'field' =>"*,(SELECT COUNT(category_id) FROM wl_categories AS b
	WHERE b.parent_id=a.category_id ) AS total_subcategories",
'condition'=>"AND parent_id = '0' AND status='1' AND is_fixed='1' ",
'order'=>'sort_order',
'debug'=>FALSE
);
$condtion_array['offset'] = 0;
$condtion_array['limit'] = 6;
$res = $this->category_model->getcategory($condtion_array);
$total_categories	=  $this->category_model->total_rec_found;
/********************END Fixed Category*******************/

$friendly_url = 'aboutus';
$condition       = array('friendly_url'=>$friendly_url,'status'=>'1');
$content         =  $this->pages_model->get_cms_page( $condition );

?>
<footer class="minmax">
<div style="background:#f5f3f5; padding:15px;">
<div class="container">
<div>
	<p class="secure-payment"><span class="fs24">100%</span> <span class="fs19">Secure Payments</span><br> All major credit &amp; debit cards accepted</p>
    <p class="cards"><img src="<?php echo theme_url(); ?>images/visa.jpg" alt=""> <br class="mob_only"> <img src="<?php echo theme_url(); ?>images/secure.jpg" alt=""></p>
    <p class="social"><a href="#" title="Facebook"><img src="<?php echo theme_url(); ?>images/fb.png" alt="Facebook"></a> <a href="#" title="Twitter"><img src="<?php echo theme_url(); ?>images/tw.png" alt="Twitter"></a> <a href="https://www.linkedin.com/pub/andy-serrano/72/a90/704" title="Linkedin" target="_blank"><img src="<?php echo theme_url(); ?>images/in.png" alt="Linkedin"></a> <a href="#" title="Google Plus"><img src="<?php echo theme_url(); ?>images/gp.png" alt="Google Plus"></a> <a href="#" title="Youtube"><img src="<?php echo theme_url(); ?>images/yt.png" alt="Youtube"></a></p>
</div>
</div>
</div>

<div class="container pt45">
<div>
	<div class="col-lg-2 col-md-2 col-sm-2 p0">
	<p class="bot-title">Quick Links</p>
	<p class="botlink"><a href="<?php echo base_url();?>" title="Home">Home</a> <a href="<?php echo base_url();?>about-us" title="About Us">About Us</a> <a href="<?php echo base_url();?>pages/newsletter" title="Newsletter" class="pop1">Newsletter</a> <a href="<?php echo base_url();?>faq" title="FAQs">FAQs</a> <a href="<?php echo base_url();?>testimonials" title="Testimonials">Testimonials</a> <a href="<?php echo base_url();?>contact-us" title="Contact Us">Contact Us</a> <a href="<?php echo base_url();?>pages/sitemap" title="Sitemap">Sitemap</a>
    <a href="#" onclick="return search_form_submit('is_coming_soon');" title="Coming Soon">Coming Soon</a>
    </p>
	<p class="clearfix"></p>
	</div>
    
    <div class="col-lg-2 col-md-2 col-sm-2 p0">
	<p class="bot-title">Login Info</p>
	<p class="botlink">
    <?php  
	if($this->auth->is_user_logged_in()=='' ){?>
    	<a href="<?php echo base_url();?>users/login" title="Login">Login</a> <a href="<?php echo base_url();?>users/register" title="Register">Register</a> 
    <?php
	}else{?>
       	<a href="<?php echo base_url();?>users/logout" title="Logout">Logout</a> <a href="<?php echo base_url();?>members/myaccount" title="My Account">My Account</a>
	<?php
	}
	?>
    <a href="<?php echo base_url();?>cart" title="My Cart">My Cart</a></p>
	<p class="clearfix"></p>
	</div>
    
    <div class="col-lg-2 col-md-2 col-sm-2 p0">
	<p class="bot-title">Products</p>
    <?php
	 if(is_array($res) && !empty($res)){?>
        <p class="botlink">
        	<?php
		  	$counter = 0;
		  	foreach($res as $val){			  
			  $link_url = base_url().$val['friendly_url'];
		      $category_name = strlen($val['category_name']) > 25 ? char_limiter($val['category_name'],25,'') : $val['category_name'];
			  ?>
            	<a href="<?php echo $link_url;?>" title="<?php echo $val['category_name'];?>"><?php echo $category_name;?></a> 
        		<?php
			}?>
        	<a href="<?php echo base_url();?>category" title="More">More »</a></p>
        <p class="clearfix"></p>
        <?php
	 }?>
	</div>
    
    <div class="col-lg-2 col-md-2 col-sm-2 p0">
	<p class="bot-title">Other</p>
	<p class="botlink"><a href="<?php echo base_url();?>pages/advanced_search" title="Advanced Search">Advanced Search</a> <a href="<?php echo base_url();?>privacy-policy" title="Privacy Policy">Privacy Policy</a> <a href="<?php echo base_url();?>terms-conditions" title="Terms and Conditions">Terms and Conditions</a> <a href="<?php echo base_url();?>return-policy" title="Return Policy">Return Policy</a> <a href="<?php echo base_url();?>legal-disclaimer" title="Legal Disclaimer">Legal Disclaimer</a></p>
	<p class="clearfix"></p>
	</div>
    
    <div class="col-lg-4 col-md-4 col-sm-4 p0 text-right">
    <p class="mt45 bot-logo"><img src="<?php echo theme_url(); ?>images/ame.png" alt="AME Fitness Equipment"></p>
    </div>
    
    <p class="clearfix"></p>
    
    <p class="fs12 text-center grey mt50 mb20 lht-18">Copyright &copy; <?php echo date("Y")." ".$this->config->item('site_name');?>. All rights reserved<br>Developed and Managed by <a href="http://weblinkindia.net/" target="_blank" title="WeblinkIndia.NET" rel="nofollow">WeblinkIndia.NET</a></p>
</div>
</div>
</footer>