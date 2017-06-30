<?php
$brand_bottom_array = array();
$sql = "SELECT * FROM wl_brands WHERE brand_image!='' AND status='1' ORDER BY RAND()";
$query = $this->db->query($sql);
$total_brands=$query->num_rows();
if($total_brands > 0){
	$result_brand = $query->result_array();
	foreach($result_brand as $val){
		if($val['brand_image']!='' && file_exists(UPLOAD_DIR."/brand/".$val['brand_image'])){ 
			array_push($brand_bottom_array,$val);
		}
	}
}
if(!empty($brand_bottom_array)){
	?>
	<section class="mt35">
	 <div class="wrapper">
	  <div class="mob_m">
	   <div class="pro_heading"><h2><img src="<?php echo theme_url(); ?>images/brand-icon.gif" alt="">Our Brands </h2></div>
	   <div class="pro_btn"><p><a href="javascript:void(0)" class="prev8 img_scale"><img src="<?php echo theme_url(); ?>images/arrow_l.jpg" alt=""></a><a href="javascript:void(0)" class="next8 img_scale"><img src="<?php echo theme_url(); ?>images/arrow_r.jpg" class="ml10" alt=""></a></p></div>
	   <div class="cb mb18"></div>
	   <div class="scroll_8">
	    <ul class="float_6 floater">
	     <?php
	     foreach($brand_bottom_array as $key=>$val){
		     $link_url = $val['friendly_url']; 
		     ?>
		     <li>
		      <div class="logo-w">
		       <div class="logo-img"><figure><a href="<?php echo $link_url;?>" title="<?php echo escape_chars($val['brand_name']);?>"><img src="<?php echo get_image('brand',$val['brand_image'],'199','96','R'); ?>" alt="<?php echo escape_chars($val['brand_name']);?>"></a></figure></div>
		      </div>
		     </li>
		     <?php
	     }?>
	    </ul>
	    <div class="cb"></div>
	   </div>
	  </div>
	 </div>
	</section>
	<?php
}?>