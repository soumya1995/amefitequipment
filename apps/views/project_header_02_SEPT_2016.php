<?php $this->load->library(array('Auth'));

$this->load->model(array('category/category_model','products/product_model','cart/cart_model','members/members_model'));

$this->load->helper(array('category/category'));



$cls='';

$minmax='minmax';

$logo_area_inn='logo-area';

if($this->uri->rsegment(1)!='home' || $this->uri->rsegment(1)!=''){

	$cls='inn-header';

	$logo_area_inn='logo-area-inn';

	$minmax='';

}

//******Fixed Category*********/

$condtion_array1 = array(

'field' =>"*,(SELECT COUNT(category_id) FROM wl_categories AS b

	WHERE b.parent_id=a.category_id ) AS total_subcategories",

'condition'=>"AND parent_id = '0' AND status='1' AND is_fixed='1' ",

'order'=>'sort_order',

'debug'=>FALSE

);

$condtion_array1['offset'] = 0;

$condtion_array1['limit'] = 6;

$res1 = $this->category_model->getcategory($condtion_array1);

$total_categories1	=  $this->category_model->total_rec_found;

/********************END Fixed Category*******************/



//******Non Fixed Category*********/

$condtion_array3 = array(

'field' =>"*,(SELECT COUNT(category_id) FROM wl_categories AS b

	WHERE b.parent_id=a.category_id ) AS total_subcategories",

'condition'=>"AND parent_id = '0' AND status='1' AND is_fixed='0' ",

'order'=>'sort_order',

'debug'=>FALSE

);

$condtion_array3['offset'] = 0;

$condtion_array3['limit'] = 20;

$res3 = $this->category_model->getcategory($condtion_array3);

$total_categories3	=  $this->category_model->total_rec_found;

/********************END Non Fixed Category*******************/



?>

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

<!--top-->



<div class="topbg <?php echo $minmax;?>">

<div class="container">

<div class="row">

  <p class="col-lg-5 col-md-4 col-sm-9 hidden-xs pt3 p0 white"><a href="https://www.linkedin.com/pub/andy-serrano/72/a90/704" title="Linkedin" target="_blank"><img src="<?php echo theme_url(); ?>images/top-linkdn.png" alt="Mobile" width="98" height="25" class="vam mr10"></a><img src="<?php echo theme_url(); ?>images/mobile.png" alt="Mobile" width="25" height="25" class="vam"> <?php echo $this->admin_info->phone;?> <img src="<?php echo theme_url(); ?>images/email.png" width="25" height="25" alt="Email ID" class="vam ml15 mr3"> <?php echo $this->admin_info->admin_email;?> </p>
  
  <div class="col-lg-2 col-md-2 col-sm-3 p0 mt5">
        <div id="google_translate_element"></div>
        <script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>
        <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
  </div>

  <div class="col-lg-5 col-md-6 col-sm-12 p0">

     <div class="search-area">

     <?php echo form_open('products/search',array('name'=>"top_search_form",'method'=>'post'));?>

    	<p class="show-hide"><a href="javascript:void(0)" title="Search"><img src="<?php echo theme_url(); ?>images/search-icon.jpg" alt="Search" width="26" height="25"></a></p>

        <div class="search-field"><input name="keyword2" id="keyword2" type="text" placeholder="Keyword Search" style="width:190px;" value=""> <input name="submit" type="submit" value="GO" class="btn-style" style="padding:6px;"></div>

    <?php echo form_close();?>

    </div>

    

    <div class="white cart-top"><a href="<?php echo base_url();?>cart" title="Shopping Cart"><?php echo count($this->cart->contents());?></a></div> 

    <p class="white reg-log"><a href="<?php echo base_url();?>package" title="Packing">Packing</a></p>

    <p class="white reg-log"><a href="<?php echo base_url();?>warranty" title="Warranty">Warranty</a></p>

    

	<p class="white reg-log">

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

<!--top end-->



<!--Header-->

<header class="<?php echo $minmax;?>">

<div class="rel <?php echo $cls;?>">

<div class="w100 abs" style="z-index:9999;">

<div class="container">

<div class="row">

	<p class="<?php echo $logo_area_inn;?>"><a href="<?php echo base_url();?>" title="AME Fitness Equipment"><img src="<?php echo theme_url(); ?>images/ame.png" width="275" height="99" alt="AME Fitness Equipment"></a></p>

    

<?php

if($this->uri->rsegment(1)=='home' || $this->uri->rsegment(1)==''){

	?>

        <nav>

        <?php

}else{?>

		<div class="menu">

<?php

}?>

      <div class="navbar-header white">

        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <img src="<?php echo theme_url(); ?>images/menu.gif" width="24" height="20" alt="Navigation"> Navigation</button>

      </div>

     <?php

	 if(is_array($res1) && !empty($res1)){?>

      <div id="navbar" class="navbar-collapse collapse" style="margin:0; padding:0;">

        <ul class="nav navbar-nav menulink">

          <?php

		  $counter = 0;

		  foreach($res1 as $val){

			  $sub_link_url = base_url().$val['friendly_url'];
		      $category_name = strlen($val['category_name']) > 12 ? char_limiter($val['category_name'],12,'...') : $val['category_name'];
			  
			  ?>

              <li class="dropdown"> <?php if($val['total_subcategories'] > 0){?><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" title="<?php echo $val['category_name'];?>"><?php echo $category_name;?><br class="hidden-sm hidden-xs"><span class="caret"></span></a><?php }else{ ?>   <a href="<?php echo $sub_link_url;?>" class="dropdown-toggle" title="<?php echo $val['category_name'];?>"><?php echo $category_name;?></a><?php } ?>

                 <?php

			         if($val['total_subcategories'] > 0){

				         $condtion_array2 = array(

				         'field' =>"*",

				         'condition'=>"AND parent_id = '".$val['category_id']."' AND status='1'",

				         'order'=>'sort_order',

				         'debug'=>FALSE

				         );



				         $condtion_array2['offset'] = 0;

				         $condtion_array2['limit'] = 5;

				         $res2 = $this->category_model->getcategory($condtion_array2);

				         $total_sub_categories2	=  $this->category_model->total_rec_found;

				         ?>

                        <ul class="dropdown-menu" role="menu">

					    <?php

                          foreach($res2 as $val2){

                              $sub_link_url2 = base_url().$val2['friendly_url'];

                              $sub_category_name = strlen($val2['category_name']) > 25 ? char_limiter($val2['category_name'],25,'') : $val2['category_name'];

                              ?>

                                <li><a href="<?php echo $sub_link_url2;?>" title="<?php echo $val2['category_name'];?>"><?php echo $sub_category_name;?></a></li>

                                <?php

                         }
						 if($total_sub_categories2 > 5){
						 ?>
							<li><a href="<?php echo $sub_link_url;?>" title="View All">View All</a></li>
                        <?php
						 }?>
                        </ul>

                      <?php

				}?>

                

              </li>

              <?php

		  $counter++;

		  }?>

          <?php

	 		//if(is_array($res3) && !empty($res3)){?>                 

              <li class="dropdown"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" title="More">More<br class="hidden-sm hidden-xs"><span class="caret"></span></a>

                <ul class="dropdown-menu" role="menu">

                 <?php
				  foreach($res3 as $val){					  

					  $link_url = base_url().$val['friendly_url'];
					  $category_name = strlen($val['category_name']) > 25 ? char_limiter($val['category_name'],25,'') : $val['category_name'];
					  ?>

                  		<li><a href="<?php echo $link_url;?>" title="<?php echo $val['category_name'];?>"><?php echo $category_name;?></a></li>

                        <?php

				  }?>

                   <li><a href="<?php echo base_url();?>testimonials" title="Testimonials">Testimonials</a></li>

            <li><a href="<?php echo base_url();?>contact-us" title="Contact Us">Contact Us</a></li>

                </ul>

              </li>

              <?php

			//}?>           

        </ul>

      </div>

      <?php

	 }?>

    </nav>                                    

    

    <p class="clearfix"></p>

</div>

</div>

</div>

<?php

if($this->uri->rsegment(1)=='home' || $this->uri->rsegment(1)==''){

 	$this->load->view("header_images/top_header_images");

}

?>

  <p class="cb"></p>



</div>

<?php

if($this->uri->rsegment(1)=='home' || $this->uri->rsegment(1)==''){

	?>

	<div class="border-sep"></div>

    <?php

}?>

</header>

<!--Header end-->



