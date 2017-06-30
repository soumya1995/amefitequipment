<?php
if(is_array($res) && !empty($res) ){
	$counter=0;
	foreach($res as $val){
		$brandImage=get_image('brand',$val["brand_image"],'199','96');
		?>
        <div class="col-lg-3 col-md-4 col-sm-6 pt10 p3 listpager">
            <p class="brand-pic"><span><a href="#" onclick="return search_form_submit2('product_brand','<?php echo $val['brand_name'];?>');" title="<?php echo $val['brand_name'];?>"><img src="<?php echo $brandImage;?>" alt="<?php echo $val['brand_name'];?>"></a></span></p>
        </div>           
		<?php
	}
}?>