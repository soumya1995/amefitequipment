<?php
if(is_array($res) && !empty($res) ){
	$counter=0;
	foreach($res as $val){
		//$packageImage=get_image('package',$val["media"],'199','96');
		?>
        <div class="col-lg-3 col-md-4 col-sm-6 p10">
    <div class="warranty listpager">
            <p class="pro"><span>
            <a href="<?php echo base_url();?>package/details/<?php echo $val['package_id'];?>" class=""><img src="<?php echo get_image('package',$val['media'],160,208,'AR');?>" alt="<?php echo $val['title'];?>"></a></span></p>
            <p class="pro-price2">
         <strong><?php echo $val['title'];?></strong>  <br>
         <?php echo  display_price($val['price']);?></p>
        <div class="war-des" style="height:120px;overflow:hidden;"><?php echo $val['description'];?></div>
         </div> 
          </div>                 
		<?php
	}
}?>