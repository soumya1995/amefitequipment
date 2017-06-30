<?php
$cat_limit = 12;
$this->load->model(array('category/category_model'));
$condtion_array = array(
'field' =>"*,( SELECT COUNT(category_id) FROM wl_categories AS b
		WHERE b.parent_id=a.category_id ) AS total_subcategories",
		'condition'=>"AND parent_id = '0' AND status='1' ",
'condition'=>"AND parent_id = '0' AND status='1' ",
'order'=>'sort_order',
'limit'=>$cat_limit,
'offset'=>0,
'debug'=>FALSE
);
$cat_res            = $this->category_model->getcategory($condtion_array);
$total_cat_found	=  $this->category_model->total_rec_found;
$selected_category = $this->uri->rsegment(3);
if(is_array($cat_res) && !empty($cat_res)){
	?>      
	<p class="bg-gray border2 p6 pl6 lh24 ttu black mt12 fs16"><a href="<?php echo base_url();?>category/"><img src="<?php echo theme_url(); ?>images/blt0.png" class="fl mr5 mt1" alt="">Category</a></p>
    <div class="mylinks1 mt15 ml9">
	  <?php
	  foreach($cat_res as $val){
		  $total_subcategories = $val['total_subcategories'];
		  if($total_subcategories<=0){
			  $link_url = base_url()."products/index/".$val['category_id'];
		  }else{
			  $link_url = "javascript:void(0)";
		  }?>
		   <b><a href="<?php echo $link_url;?>"><?php echo $val['category_name'];?></a></b>
		  <?php
		  if($total_subcategories>0){
			  $cond_array = array(
		    'field' =>"*,(SELECT COUNT(category_id) FROM wl_categories AS b WHERE b.parent_id=a.category_id ) AS total_subcats",
		    'condition'=>"AND parent_id = '".$val['category_id']."' AND status='1' ",
		    'order'=>'sort_order',
		    'debug'=>FALSE
		    );
			  $cond_array['offset'] = 0;
			  $cond_array['limit'] = 10;
		    $res1 = $this->category_model->getcategory($cond_array);
		    $total_rows	=  $this->category_model->total_rec_found;
		    if($total_rows>0){
			    $para="";
			    foreach($res1 as $val1){
				    $total_subcats = $val1['total_subcats'];
				    if($total_subcats>0){
					    $link_url = base_url()."category/index/".$val1['category_id'];
				    }else{
					    $link_url = base_url()."products/index/".$val1['category_id'];
				    }
					$act='';
					if($selected_category == $val1['category_id']){
						$act='class="act"';
					}
				    $para.='<p class="mt5 ml15"><a href="'.$link_url.'" '.$act.'>&raquo;&nbsp;'.char_limiter($val1['category_name'],30).'</a></p>';
			    }?>
			    
			     <?php echo $para;
			     if($total_rows>10){?>
			     <p class="mt5"><a href="<?php echo base_url()."category/index/".$val['category_id'];?>">View All &raquo;</a></p>
			     <?php }else{?>
			     <p class="mt5"></p>
			     <?php }?>
			    
			    <?php
			  }
		  }else{
			  ?>
			  <p class="mt5"></p>
			  <?php
		  }
	  }?>
	 </div><!--Category-Ends-->
	<?php
}?>