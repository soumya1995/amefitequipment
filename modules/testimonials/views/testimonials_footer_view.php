<?php
$this->load->model(array('testimonials/testimonial_model'));
$param         = array('status'=>'1','orderby'=>'RAND()');
$res_array     = $this->testimonial_model->get_testimonial(2,0,$param);

if(is_array($res_array) && !empty($res_array)){
	?>
	<div class="testimonials">
	 <p class="treb fs22 black mb8 mt8 footer-heading">Testimonials</p>
	 <p class="treb fs22 black mb8 mt8 footer-small-heading">Testimonials</p>
	 <div class="testimonials-content">
	  <div class="testi-scroll">
	   <ul>
	    <?php foreach($res_array as $val){?>
	    <li>
	     <div class="testi-left"><img src="<?php echo theme_url(); ?>images/testimonial-img.jpg" width="50" height="50" alt="testimonials"></div>
	     <div class="testi-right">
	      <p><?php echo char_limiter($val['testimonial_description'],100);?><a href="<?php echo $val['friendly_url'];?>" class="red b">read all</a></p>
	      <p class="b mt10"><?php echo ucwords($val['poster_name']);?> </p>
	     </div>
	     <div class="cb"></div>
	    </li>
	    <?php }?>
	   </ul>
	   <div class="cb"></div>
	  </div>
	  <p class="b black ar"><a href="<?php echo base_url();?>testimonials"><img src="<?php echo theme_url(); ?>images/arrow1.jpg" width="14" height="15" alt="arrow" class="vam mr5">Click here to view all testimonials</a></p>
	 </div>
	</div>
	<?php
}?>