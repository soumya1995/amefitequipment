<?php 
$cat_id=(int) $this->uri->rsegment(3);
if(!$cat_id){
	$cat_id=(int) $this->input->get_post('category_id');	
}
$filter_cate_res["is_brand"]="0"; 
$filter_cate_res["is_material"]="0"; 
$filter_cate_res["is_size"]="0"; 
$filter_cate_res["is_color"]="0";

if( $cat_id!=""){
	
	$filter_cate_res=$this->category_model->get_category_by_id($cat_id);	
}

echo form_open('products/search','id="srcfrm" name="srcfrm"');?>
<input type="hidden" name="amount" id="amount" value="<?php echo $this->input->post('amount');?>" />
<?php
if($this->uri->rsegment(1)=="products" && $this->uri->rsegment(2)=="index"  ){
	?>
	<input type="hidden" name="category_id" id="category_id" value="<?php echo $this->uri->segment(3);?>" />
	<?php
}else{
	?>
	<input type="hidden" name="category_id" id="category_id" value="<?php echo $cat_id;?>" />
	<?php
}?>
<input type="hidden" name="keyword2" id="keyword2" value="<?php echo $this->input->get_post('keyword2');?>" />
<input type="hidden" name="brands" id="brand" value="<?php echo $this->input->post('brands');?>" />
<input type="hidden" name="materials" id="material" value="<?php echo $this->input->post('materials');?>" />
<input type="hidden" name="sizes" id="size" value="<?php echo $this->input->post('sizes');?>" />
<input type="hidden" name="colors" id="color" value="<?php echo $this->input->post('colors');?>" />
<?php echo form_close();
$curr_symbol = display_symbol();
?>
<div class="fl w21 D_w32 mr20 filter">
      <p class="red b fr mt30"><a href="<?php echo base_url();?>products" class="uu">Clear All</a></p>
      <h2 class="lh24"><b class="fs14 lh16 b">Filter</b><br>Records</h2>      
      <?php
		$this->load->view("category/category_left_view.php");
	  ?>
      
      <p class="bg-gray border2 p6 pl6 lh24 ttu black mt25 fs16"><img src="<?php echo theme_url(); ?>images/blt0.png" class="fl mr5 mt1" alt="">Price Range</p>
      <div class="p10 fs13 gray lht-20" style="height:140px;overflow:auto;">
     <?php
	 $posted_amount=$this->input->post('amount');
	 $posted_amount_arr='';
	 if($posted_amount!=''){
		 $posted_amount_arr=explode(",",$posted_amount);
	 }?>
	 <p class="mt3"><label><input name="amount_array" type="checkbox" value="1-500" class="pr fl mr10 mt4" <?php if(@in_array('1-500',$posted_amount_arr)) {?>checked="checked" <?php }?> onclick="multisearch('amount','amount_array','<?php echo $cat_id;?>');"><?php echo $curr_symbol;?> 1 - <?php echo $curr_symbol;?> 500</label></p>
	 <p class="mt3"><label><input name="amount_array" type="checkbox" value="501-1000" class="pr fl mr10 mt4" <?php if(@in_array('501-1000',$posted_amount_arr)) {?>checked="checked" <?php }?> onclick="multisearch('amount','amount_array','<?php echo $cat_id;?>');"><?php echo $curr_symbol;?> 501 - <?php echo $curr_symbol;?> 1000</label></p>
	 <p class="mt3"><label><input name="amount_array" type="checkbox" value="1001-2500" class="fl mr10 mt4" <?php if(@in_array('1001-2500',$posted_amount_arr)) {?>checked="checked" <?php }?> onclick="multisearch('amount','amount_array','<?php echo $cat_id;?>');"><?php echo $curr_symbol;?> 1001 - <?php echo $curr_symbol;?> 2500</label></p>
	 <p class="mt3"><label><input name="amount_array" type="checkbox" value="2501-5000" class="fl mr10 mt4" <?php if(@in_array('2501-5000',$posted_amount_arr)) {?>checked="checked" <?php }?> onclick="multisearch('amount','amount_array','<?php echo $cat_id;?>');"><?php echo $curr_symbol;?> 2501 - <?php echo $curr_symbol;?> 5000</label></p>
	 <p class="mt3"><label><input name="amount_array" type="checkbox" value="5001-10000" class="fl mr10 mt4" <?php if(@in_array('5001-10000',$posted_amount_arr)) {?>checked="checked" <?php }?> onclick="multisearch('amount','amount_array','<?php echo $cat_id;?>');"><?php echo $curr_symbol;?> 5001 - <?php echo $curr_symbol;?> 10000</label></p>
	 <p class="mt3"><label><input name="amount_array" type="checkbox" value=">10000" class="fl mr10 mt4" <?php if(@in_array('>10000',$posted_amount_arr)) {?>checked="checked" <?php }?> onclick="multisearch('amount','amount_array','<?php echo $cat_id;?>');">Above <?php echo $curr_symbol;?> 10000</label></p>       
      </div>
      
      
<?php
if($filter_cate_res["is_brand"]=="1" ){	 
	 $this->load->model("brand/brand_model");
	 
	 $condtion = array('field'=>"*",'condition'=>"status = '1' ");
	 if(!empty($cat_id)){
			$condtion = array('field'=>"*",'condition'=>"FIND_IN_SET( '".$cat_id."',category_id ) AND status='1' order by brand_name ASC ");
	 }
	 
	 $brandres = $this->brand_model->findAll('wl_brands',$condtion);
	 
  		if(!empty($brandres) && is_array($brandres)){
	 ?>
      <p class="bg-gray border2 p6 pl6 lh24 ttu black mt25 fs16"><img src="<?php echo theme_url(); ?>images/blt0.png" class="fl mr5 mt1" alt="">Brand</p>
      <div class="p10 fs13 gray lht-20" style="height:140px;overflow:auto;">
      <p class="mb5"><input type="text" onkeyup="lookup_brand(this.value,'<?php echo $cat_id;?>');" id="inputBrand"  placeholder="Enter Brand Name" class="w100 p5"></p>    
      <div id="brand_suggestions" style="display: none;">           
      <div id="brand_autoSuggestionsList"></div>  </div>
      <div id="brandID">
	  <?php
	 	 $brand_array=explode(",",$this->input->post("brands"));
	 
			foreach($brandres as $key=>$val){
				$sel=@in_array($val["brand_id"],$brand_array)?'checked="checked"':"";
				?>
					<p class="mt3"><input name="brand_array" type="checkbox" <?php echo $sel;?> value="<?php echo $val['brand_id'];?>" class="fl mr6 mt1"  onclick="multisearch('brand','brand_array');" ><?php echo $val['brand_name'];?></p>
				<?php
			}
		
		?>
        </div>
        </div>
      <?php
	  }
}
?>

<?php 
if($filter_cate_res["is_material"]=="1" ){	 
	 $this->load->model("material/material_model");
	 
	 $condtion = array('field'=>"*",'condition'=>"status = '1' ");
	 if(!empty($cat_id)){
			$condtion = array('field'=>"*",'condition'=>"FIND_IN_SET( '".$cat_id."',category_id ) AND status='1' order by material_name ASC ");
	 }
	 
	 $materialres = $this->material_model->findAll('wl_materials',$condtion);
	 
  		if(!empty($materialres) && is_array($materialres)){
	 ?>
      <p class="bg-gray border2 p6 pl6 lh24 ttu black mt25 fs16"><img src="<?php echo theme_url(); ?>images/blt0.png" class="fl mr5 mt1" alt="">Material</p>
      <div class="p10 fs13 gray lht-20" style="height:140px;overflow:auto;">
      <p class="mb5"><input type="text" onkeyup="lookup_material(this.value,'<?php echo $cat_id;?>');" id="inputMaterial"  placeholder="Enter Material Name" class="w100 p5"></p>    
      <div id="material_suggestions" style="display: none;">           
      <div id="material_autoSuggestionsList"></div>  </div>
      <div id="materialID">
	  <?php
	 	 $material_array=explode(",",$this->input->post("materials"));
	 
			foreach($materialres as $key=>$val){
				$sel=@in_array($val["material_id"],$material_array)?'checked="checked"':"";
				?>
					<p class="mt3"><input name="material_array" type="checkbox" <?php echo $sel;?> value="<?php echo $val['material_id'];?>" class="fl mr6 mt1"  onclick="multisearch('material','material_array');" ><?php echo $val['material_name'];?></p>
				<?php
			}
		
		?>
        </div>
        </div>
      <?php
	  }
}
?>    
        
        
<?php
if($filter_cate_res["is_size"]=="1" ){		 
	 $this->load->model("size/size_model");
	 $condtion = array('field'=>"*",'condition'=>"status = '1' ");
	 if(!empty($cat_id)){
			$condtion = array('field'=>"*",'condition'=>"FIND_IN_SET( '".$cat_id."',category_id ) AND status='1' order by size_name ASC ");
	 }
	 
	 $sizeres = $this->size_model->findAll('wl_sizes',$condtion);
  	 //$sizeres=$this->size_model->getsizes(array("condition"=>" AND status ='1'","order"=>"size_name ASC"));
	 
  		 if(!empty($sizeres) && is_array($sizeres)){	 
	 ?>
      <p class="bg-gray border2 p6 pl6 lh24 ttu black mt25 fs16"><img src="<?php echo theme_url(); ?>images/blt0.png" class="fl mr5 mt1" alt="">Size</p>
      <div class="p10 fs13 gray lht-20" style="height:140px;overflow:auto;">
      <p class="mb5"><input type="text" onkeyup="lookup_size(this.value,'<?php echo $cat_id;?>');" id="inputSize"  placeholder="Enter Size Name" class="w100 p5"></p>    
      <div id="size_suggestions" style="display: none;">           
      <div id="size_autoSuggestionsList"></div>  </div>
      <div id="sizeID"> 
      <?php
	 	 $size_array=explode(",",$this->input->post("sizes"));
	 
			foreach($sizeres as $key=>$val){
		    $sel=@in_array($val["size_id"],$size_array)?'checked="checked"':"";
				?>
					<p class="mt3"><input name="size_array" type="checkbox" <?php echo $sel;?> value="<?php echo $val['size_id'];?>" class="fl mr6 mt1"  onclick="multisearch('size','size_array');" ><?php echo $val['size_name'];?></p>
				<?php
			}		
		?>
         </div>
        </div>
      <?php
	}
}?>
      
      
      
<?php
if($filter_cate_res["is_color"]=="1" ){	 
	 $this->load->model("color/color_model");
  	 
	 $condtion = array('field'=>"*",'condition'=>"status = '1' ");
	 if(!empty($cat_id)){
			$condtion = array('field'=>"*",'condition'=>"FIND_IN_SET( '".$cat_id."',category_id ) AND status='1' order by color_name ASC ");
	 }
	 
	 $colorres = $this->color_model->findAll('wl_colors',$condtion);
	 //$colorres=$this->color_model->getcolors(array("condition"=>" AND status ='1'","order"=>"color_name ASC"));
	 
  		  if(!empty($colorres) && is_array($colorres)){
	 ?>
      <p class="bg-gray border2 p6 pl6 lh24 ttu black mt25 fs16"><img src="<?php echo theme_url(); ?>images/blt0.png" class="fl mr5 mt1" alt="">Color</p>
      <div class="p10 fs13 gray lht-20" style="height:140px;overflow:auto;">
      <p class="mb5"><input type="text" onkeyup="lookup_color(this.value,'<?php echo $cat_id;?>');" id="inputColor"  placeholder="Enter Color Name" class="w100 p5"></p>    
      <div id="color_suggestions" style="display: none;">           
      <div id="color_autoSuggestionsList"></div>  </div>
      <div id="colorID">
      <?php
	 	 $color_array=explode(",",$this->input->post("colors"));
	 
			foreach($colorres as $key=>$val){
		    $sel=@in_array($val["color_id"],$color_array)?'checked="checked"':"";
				?>
					<p class="mt3"><input name="color_array" type="checkbox" <?php echo $sel;?> value="<?php echo $val['color_id'];?>" class="fl mr6 mt1"  onclick="multisearch('color','color_array');" ><?php echo $val['color_name'];?></p>
				<?php
			}		
		?>
        </div>
        </div>
      <?php
	}
}?>
      
            
      
        
      <p class="red b ml10"><a href="<?php echo base_url();?>products" class="uu">Clear All</a></p>
      
      <!-- advertisement -->
      <?php
		$this->load->view("banner/left_banners");
	  ?>
</div>
<!--END-->

<script type="text/javascript">
jQuery(document).ready(function(e) {
	jQuery(':checkbox, :radio').live('click',function(){
		jQuery('#srcfrm').submit();
	});	
	jQuery('.clear_color').live('click',function(){
		jQuery('.col').attr('checked', false);
		jQuery('#color').val('');	
		jQuery('#srcfrm').submit();
	});
	jQuery('.clear_size').live('click',function(){
		jQuery('.sz').attr('checked', false);	
		jQuery('#size').val('');	
		jQuery('#srcfrm').submit();
	});	
	jQuery('.clear_price').live('click',function(){
		jQuery('.pr').attr('checked', false);	
		jQuery('#amount').val('');	
		jQuery('#srcfrm').submit();
	});
	jQuery('.clear_all').live('click',function(){
		jQuery('.pr').attr('checked', false);	
		jQuery('#srcfrm').submit();
	});
});
</script>