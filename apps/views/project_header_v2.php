<?php
$this->load->library(array('Auth'));
$this->load->model(array('category/category_model','products/product_model','cart/cart_model','members/members_model', 'about/about_model','gym_packages/gym_packages_model'));
$this->load->helper(array('category/category'));
?>
<!--top-->
<div class="topbg">
<div class="container">
<div class="row">
  <p class="col-lg-5 col-md-6 col-sm-9 pt3 p0 white">
 <img src="<?php echo theme_url();?>images/top-linkdn.png" alt="Mobile" class="vam mr10"><br /><img src="<?php echo theme_url();?>images/mobile.png" alt="Mobile" class="vam"> <?php echo $this->admin_info->phone;?> 
  <br /><img src="<?php echo theme_url();?>images/email.png" alt="Email ID" class="vam ml15 mr3"> <?php echo $this->admin_info->admin_email;?> </p>
  
  <div class="col-lg-2 col-md-2 col-sm-3 p0 mt5 lang-center">
        <div id="google_translate_element"></div>
        <script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>
        <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
  </div>
  
  <div class="col-lg-5 col-md-4 col-sm-12 p0 lang-center">
  <p class="white reg-log"><a href="<?php echo base_url();?>contact-us" title="Contact Us">Contact Us</a></p>
  
  		        <p class="white reg-log"><a href="<?php echo base_url();?>package" title="Warranty">Packings</a></p>
                <p class="white reg-log"><a href="<?php echo base_url();?>warranty" title="Warranty">Warranty</a></p>
                <p class="white reg-log reg-log1">
                <?php

	 if(!$this->auth->is_user_logged_in()){

		?>

        	<a href="<?php echo base_url();?>users/login/" title="Login">Login</a>/<a href="<?php echo base_url();?>users/register/" title="Register">Register</a>

        <?php

	 }else{?>

     		<a href="<?php echo base_url();?>members/myaccount" title="My Account">My Account</a>/<a href="<?php echo base_url();?>users/logout" title="Logout">Logout</a>

     <?php

	 }?>
</p>        
  </div>
  <p class="clearfix"></p>
</div>
</div>
</div>

<form name="searchFrm" id="searchFrm" action="<?php echo base_url();?>products/search" method="post">

	<input type="hidden" name="field_name" id="field_id" value="" />

</form>

<script>

function search_form_submit(val){

	

	$('#field_id').attr('name', val);

	$("#field_id").val('1');

	searchFrm.submit();

}

</script>

<form name="searchFrm2" id="searchFrm2" action="<?php echo base_url();?>products/search" method="post">

	<input type="hidden" name="field_name" id="field_id2" value="" />

</form>

<script>

function search_form_submit2(field_name,value){

	

	$('#field_id2').attr('name', field_name);

	$("#field_id2").val(value);

	searchFrm2.submit();

}

</script>
<!--Header-->
<header>
<div class="container">
<div class="row">
	<p class="logo-area-inn"><a href="<?php echo base_url();?>" title="AME Fitness Equipment"><img src="<?php echo theme_url();?>images/ame.png" alt="AME Fitness Equipment"></a></p>
    <div class="search-area">
    <?php echo form_open('products/search',array('name'=>"top_search_form",'method'=>'post'));?>
        <div class="search-field">
        <input name="keyword2" id="keyword2" type="text" placeholder="Keyword Search" value="">
        <input name="submit" type="image" alt="submit" src="<?php echo theme_url();?>images/search-icon.png" >
</div><div class="white cart-top"><a href="<?php echo base_url();?>cart" title="Shopping Cart"><?php echo count($this->cart->contents());?> </a> item<?php echo count($this->cart->contents())>1 ? 's': '';?></div>
   <?php echo form_close();?>     
    </div> 
                                        
    
    <p class="clearfix"></p>
</div>
</div>
<div class="bg-black">
<div class="container">
<div class="row">
<?php
 $query=get_table_content("*","wl_categories","status='1' ORDER BY sort_order ASC ");
foreach($query as $row){
        $menu_array[$row['category_id']] = array('name' => $row['category_name'],'parent' => $row['parent_id'],'id' => $row['category_id'],'friendly_url' => $row['friendly_url']);
}?>
<div class="col-lg-3 col-md-4 no_pad">
<div class="pro_cat_link show-hide"><img src="<?php echo theme_url();?>images/subicate-icon.png" class="sub-cat-icon" alt=""> <a href="javascript:void(0)" class="one"><span>Shop by Categories</span></a> </div>
        <div class="cat_link dn"> 
        
        <div class="navigation">
  			<?php echo buildcategory($menu_array,'0');?>
		</div>
        
       
        </div>
        </div>
        
<div class="col-lg-9 col-md-8 no_pad">
<div class="menu">
      <div class="navbar-header white">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <img src="<?php echo theme_url();?>images/menu.gif" alt="Navigation"> Navigation</button>
      </div>
      <div id="navbar" class="navbar-collapse collapse" style="margin:0; padding:0;">
        <ul class="nav navbar-nav menulink">
          <li><a href="<?php echo base_url();?>" title="Home">Home</a></li>          
          <?php 		  
		  $condtion = "AND status = '1'";

		$condtion_array = array(
								'field' =>"*",
								'condition'=>$condtion,
								'limit'=>200,
								'offset'=>0,
								'debug'=>FALSE
								);
		$result_data  =  $this->about_model->getabout($condtion_array);
		
		if(is_array($result_data) && !empty($result_data)){
		  ?>
          <li class="dropdown"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" title="About Us">About Us</a>
            <ul class="dropdown-menu" role="menu">
            <?php
				foreach($result_data as $data)
				{
					echo ' <li><a href="'.$data['friendly_url'].'" title="'.$data['about_name'].'">'.char_limiter($data['about_name'],25).'</a></li>';
				}
			?>
            </ul>
          </li>
      <?php }else{?>
      <li><a href="<?php echo base_url();?>about-us" title="About Us">About Us</a></li>
      <?php }?>              
          <li><a href="<?php echo base_url();?>pages/newsletter" title="Newsletter" class="pop1">Newsletter</a></li>          
          <?php /*?><li><a href="<?php echo base_url();?>faq" title="FAQs">FAQs</a></li><?php */?>
           <?php
		  $this->load->model(array('faq_category/faq_category_model'));
		  $condtion_left = "AND status = '1'";
		$condtion_array_left = array(
								'field' =>"*",
								'condition'=>$condtion_left,
								'limit'=>200,
								'offset'=>0,
								'debug'=>FALSE
								);
		$result_data_left  =  $this->faq_category_model->getfaq_category($condtion_array_left);
		if(is_array($result_data_left) && !empty($result_data_left)){
		  ?>
          <li class="dropdown"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" title="Gym Packages">FAQs</a>
            <ul class="dropdown-menu" role="menu">
            <?php
				foreach($result_data_left as $data)
				{
					echo ' <li><a href="'.$data['friendly_url'].'" title="'.$data['faq_category_name'].'">'.char_limiter($data['faq_category_name'],25).'</a></li>';
				}
			?>
            </ul>
          </li>
      <?php }?>          
          <li><a href="<?php echo base_url();?>testimonials" title="Testimonials">Testimonials</a></li>          
          <li><a href="<?php echo base_url();?>blog" title="Blog">Blog</a></li>  
          
          <?php
		  $condtion_gym_packages = "AND status = '1'";
		$condtion_array_gym_packages = array(
								'field' =>"*",
								'condition'=>$condtion_gym_packages,
								'limit'=>200,
								'offset'=>0,
								'debug'=>FALSE
								);
		$result_data_gym_packages  =  $this->gym_packages_model->getgym_packages($condtion_array_gym_packages);
		
		if(is_array($result_data_gym_packages) && !empty($result_data_gym_packages)){
		  ?>
          <li class="dropdown"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" title="Gym Packages">Gym Packages</a>
            <ul class="dropdown-menu" role="menu">
            <?php
				foreach($result_data_gym_packages as $data)
				{
					echo ' <li><a href="'.$data['friendly_url'].'" title="'.$data['gym_packages_name'].'">'.char_limiter($data['gym_packages_name'],25).'</a></li>';
				}
			?>
            </ul>
          </li>
      <?php }else{?>
      <li><a href="<?php echo base_url();?>gym-packages" title="Gym Packages">Gym Packages</a></li>
      <?php }?>
                  
          <li><a href="<?php echo base_url();?>financing" title="Financing">Financing</a></li>
        </ul>
      </div>
    </div>
    </div>
    </div>
</div>
    <p class="clearfix"></p>
</div>
</header>
<!--Header end-->
<!--top end-->