<?php
if(is_array($res) && !empty($res) ){
	$counter=0;
	foreach($res as $val){
		$link_url = base_url().$val['friendly_url'];
		$brandImage=get_image('brand',$val["brand_image"],'199','96');
		?>
		<li>
		 <div class="logo-w listpager">
		  <div class="logo-img"><figure><a href="<?php echo $link_url;?>" title="<?php echo $val['brand_name'];?>"><img src="<?php echo $brandImage;?>" alt="<?php echo $val['brand_name'];?>"></a></figure></div>
		  <div class="ac gray fs14 mt10 h30 pt5 pb10"><?php echo $val['brand_name'];?></div>
		 </div>
		</li>
		<?php
	}
}?>