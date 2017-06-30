<?php $this->load->view('top_application');
$this->load->model(array('category/category_model','products/product_model'));
$this->load->helper(array('category/category'));

$condtion_array = array(
'field' =>"*,(SELECT COUNT(category_id) FROM wl_categories AS b
	WHERE b.parent_id=a.category_id ) AS total_subcategories",
'condition'=>"AND parent_id = '0' AND status='1' ",
'order'=>'sort_order',
'debug'=>FALSE
);
$condtion_array['offset'] = 0;
$condtion_array['limit'] = 7;
$res = $this->category_model->getcategory($condtion_array);
$total_categories	=  $this->category_model->total_rec_found;
?>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<h1 class="heading">Sitemap</h1>   
    
<ul class="breadcrumb">
<li><a href="index.htm">Home</a></li>
<li class="active">Sitemap</li>
</ul>

	<div class="mt20">
    <p class="fs14 ttu blue mb5">Quick Links</p>
    <div class="catelink">
    <p class="mt5 sitemap"><a href="<?php echo base_url();?>" title="Home">Home</a> <a href="<?php echo base_url();?>about-us" title="About Us">About Us</a> <a href="<?php echo base_url();?>pages/newsletter" title="Newsletter" class="pop1">Newsletter</a> <a href="<?php echo base_url();?>faq" title="FAQs">FAQs</a> <a href="<?php echo base_url();?>testimonials" title="Testimonials">Testimonials</a> <a href="<?php echo base_url();?>contact-us" title="Contact Us">Contact Us</a> <a href="#" onclick="return search_form_submit('is_coming_soon');" title="Coming Soon">Coming Soon</a></p>
    <p class="clearfix"></p>
    </div>
    </div>
    
    <div class="mt20">
    <p class="fs14 ttu blue mb5">Categories</p>
    <div class="catelink">
    <p class="mt5 sitemap"><?php
	 if(is_array($res) && !empty($res)){?>
        	<?php
		  	$counter = 0;
		  	foreach($res as $val){			  
			  $link_url = base_url().$val['friendly_url'];
		      $category_name = strlen($val['category_name']) > 25 ? char_limiter($val['category_name'],25,'') : $val['category_name'];
			  ?>
            	<a href="<?php echo $link_url;?>" title="<?php echo $val['category_name'];?>"><?php echo $category_name;?></a> 
        		<?php
			}?>
        <?php
	 }?></p>
    <p class="clearfix"></p>
    <p class="mt10"><a href="<?php echo base_url();?>category" class="btn-style3">View All Categories</a></p>
    </div>
    </div>
    
    <div class="mt20">
    <p class="fs14 ttu blue mb5">Other</p>
    <div class="catelink">
    <p class="mt5 sitemap"><a href="<?php echo base_url();?>pages/advanced_search" title="Advanced Search">Advanced Search</a> <a href="<?php echo base_url();?>privacy-policy" title="Privacy Policy">Privacy Policy</a> <a href="<?php echo base_url();?>terms-conditions" title="Terms and Conditions">Terms and Conditions</a> <a href="<?php echo base_url();?>return-policy" title="Return Policy">Return Policy</a> <a href="<?php echo base_url();?>legal-disclaimer" title="Legal Disclaimer">Legal Disclaimer</a></p>
    <p class="clearfix"></p>
    </div>
    </div>
    
</div>
</div>
</div>
<?php $this->load->view("bottom_application");?>