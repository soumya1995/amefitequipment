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
<div style="background:#f5f3f5; padding:15px 1px;">
<div class="container">
<div>
	<p class="secure-payment"><span class="fs24">100%</span> <span class="fs19">Secure Payments</span><br> All major credit &amp; debit cards accepted</p>
    <p class="cards"><img src="<?php echo theme_url(); ?>images/visa.jpg" width="209" height="41"  alt="visa"> <br class="mob_only"> <img src="<?php echo theme_url(); ?>images/secure.jpg" width="296" height="41" alt="secure"> <span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=t3PQVHBjakgdIOMb1RCJXvqakEQrnqbWuEGczHoxp8eiYSIcvCr961JQaiV4"></script></span></p>
    <p class="social"><a href="https://www.facebook.com/AMEFitEquipment" title="Facebook" target="_blank"><img src="<?php echo theme_url(); ?>images/fb.png" width="40" height="40" alt="Facebook"></a> <a href="https://twitter.com/Amefitequipment" title="Twitter" target="_blank"><img src="<?php echo theme_url(); ?>images/tw.png" width="40" height="40" alt="Twitter"></a> <a href="https://www.linkedin.com/company/ame-fitness-equipment" title="Linkedin" target="_blank"><img src="<?php echo theme_url(); ?>images/in.png" width="40" height="40" alt="Linkedin"></a> <a href="https://plus.google.com/115512316066508696468" title="Google Plus" target="_blank"><img src="<?php echo theme_url(); ?>images/gp.png" width="40" height="40" alt="Google Plus"></a>  <a href="https://www.pinterest.com/AMEFitness/" title="Pinterest" target="_blank"><img src="<?php echo theme_url(); ?>images/pin.png" alt="Pinterest" width="40" height="40" ></a> <a href="http://www.scoop.it/t/ame-fitness-equipment" title="Scoop it" target="_blank"><img src="<?php echo theme_url(); ?>images/it.png" alt="Scoop it" width="40" height="40" ></a>
  <a href="<?php echo base_url();?>blog/" title="Blog" target="_blank"><img src="<?php echo theme_url(); ?>images/blog.png" alt="Blog" width="40" height="40" ></a>
    <!-- <a href="javascript: void(0);" title="Youtube"><img src="<?php echo theme_url(); ?>images/yt.png" alt="Youtube" width="40" height="40" ></a> --></p>
</div>
</div>
</div>

<div class="container pt45 footer-spe">
<div>
	<div class="col-lg-3 col-md-3 col-sm-4 mob-ss">
	<h3 class="bot-title">Subscribe Newsletter</h3>
	<?php $this->load->view('pages/view_newsletter_footer');?>
	<p class="clearfix"></p>
	</div>
    <div class="col-lg-2 col-md-2 col-sm-2 p0">
	<h3 class="bot-title">Quick Links</h3>
	<p class="botlink"><a href="<?php echo base_url();?>" title="Home">Home</a> <a href="<?php echo base_url();?>about-us" title="About Us">About Us</a> <a href="<?php echo base_url();?>pages/newsletter" title="Newsletter" class="pop1">Newsletter</a> <a href="<?php echo base_url();?>faq" title="FAQs">FAQs</a> <a href="<?php echo base_url();?>testimonials" title="Testimonials">Testimonials</a> <a href="<?php echo base_url();?>contact-us" title="Contact Us">Contact Us</a> 
    
    <a href="<?php echo base_url();?>financing" title="Financing">Financing</a>
    <a href="<?php echo base_url();?>gym-packages" title="Gym Packages">Gym Packages</a>
    
    <a href="<?php echo base_url();?>how-it-works" title="How it Works">How it Works</a>
    </p>
	<p class="clearfix"></p>
	</div>
    <div class="col-lg-2 col-md-2 col-sm-2 p0">
	<h3 class="bot-title">Login Info</h3>
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
	<h3 class="bot-title">Products</h3>
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
	<p class="clearfix"></p>
	</div>
    
    <div class="col-lg-1 col-md-2 col-sm-2 p0">
	<h3 class="bot-title">Other</h3>
	<p class="botlink"><a href="<?php echo base_url();?>pages/advanced_search" title="Advanced Search">Advanced Search</a> <a href="<?php echo base_url();?>privacy-policy" title="Privacy Policy">Privacy Policy</a> <a href="<?php echo base_url();?>terms-conditions" title="Terms and Conditions">Terms and Conditions</a> <a href="<?php echo base_url();?>return-policy" title="Return Policy">Return Policy</a> <a href="<?php echo base_url();?>legal-disclaimer" title="Legal Disclaimer">Legal Disclaimer</a><a href="<?php echo base_url();?>rss" title="RSS Feed">RSS Feed</a> <a href="<?php echo base_url();?>blog/" title="Blog" target="_blank">Blog</a></p>
	<p class="clearfix"></p>
	</div>
    
    <div class="col-lg-2 col-md-12 col-sm-4 p0 text-center hidden-sm hidden-xs">
    <p class="bot-logo"><img src="<?php echo theme_url();?>images/footer-img.png" class="img-responsive" alt="<?php echo $this->config->item('site_name');?>"></p>
    </div>
    
    <p class="clearfix"></p>
    
    <p class="fs12 text-center grey mt10 mb20 lht-18">Copyright &copy; <?php echo date("Y")." ".$this->config->item('site_name');?>. All rights reserved.</p>
    <p class="clearfix"></p>
</div>
</div>
</footer>
<div itemscope itemtype="http://schema.org/Person" class="dn">
   <span itemprop="name">Andy Serrano</span>
   <span itemprop="memberOf">AME Fitness Equipment</span>
   <span itemprop="telephone">+1-631-392-4750</span>
   <a itemprop="email" href="mailto:Info@amefitequipment.com">Info@amefitequipment.com</a>
</div> 