<?php $this->load->view("top_application");
?>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<h1 class="heading">Advanced Search</h1>   
    
<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li class="active">Advanced Search</li>
</ul>

	<div class="adv-box">
  <div class="adv-img">
    <p><img src="<?php echo theme_url();?>images/adv-img.png" alt=""></p>   
   </div> 
    
        <div class="adv-form">
        <?php echo form_open('products/search',array('name'=>"frm11",'method'=>'post','target'=>'_parent'));?>
            <div class="bgW radius-5" style="border:#c9cbca 1px solid;">
            <p class="p10 bb"><input name="keyword2" id="keyword" type="text" placeholder="Keyword..." class="p8 w100 radius-3"></p>
            <p class="p10 bb">
               <select name="category_id" id="category_id" class="p8 w100 " onchange="onclickcategory(this.value,'<?php echo $url;?>','subcategory_list')"> 
               <option value="">Select Category</option>
               <?php echo get_nested_dropdown_menu(0);?>
              </select>
            </p> 
            <?php
			if( is_array($brand_res) && !empty($brand_res) ){?>     
            <p class="p10 bb">
            <select name="product_brand" id="product_brand" class="bgn p3 w100" style="border:none;">
            <option value="">Select Brand</option>
            <?php
			foreach($brand_res as $val){				
				//$brandImage=get_image('brand',$val["brand_image"],'307','99');
				?>
              	<option value="<?php echo $val["brand_name"];?>"><?php echo $val["brand_name"];?></option>
                <?php
			}?>
            </select>
            </p>
            <?php
			}?>
            </div> 
            
    
        <p class="mt15"><input name="submit" type="submit" value="Search" class="button-style"></p>      
         <?php echo form_open();?>            
        </div>
    <p class="cb"></p>
    </div>
    
    
</div>
</div>
</div>
<?php $this->load->view("bottom_application");?>
<script>
function onclickcategory(category_value,ajax_url,response_id){	 
	$.ajax({type: "POST",
		url: ajax_url,
		dataType: "html",
		data: {"category_id":category_value},
		cache:false,
		success:function(data){
			$("#"+response_id+" option").remove();
			$("#"+response_id).append(data);}    
	}); 	
}
</script>  
</body>
</html>