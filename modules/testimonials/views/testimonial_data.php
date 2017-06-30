<?php
if(is_array($res) && !empty($res) ){
	$counter=0;
	foreach($res as $val){
		$link=base_url().$val['friendly_url'];
		?>
        <div class="announcement-list listpager">
            <p class="col-xs-1 p0"><img src="<?php echo theme_url(); ?>images/col-l.png" alt=""></p>
            <div class="text-center lht-20 col-xs-10 p0">
            <p class="i blue2"><?php echo $val['testimonial_description'];?></p>
            <p class="mt5 fs16 b i blue2"><?php echo ucwords($val['poster_name']);?></p>
            <p class="fs10 grey">Posted on: <?php echo getDateFormat($val['posted_date'],1);?></p>
            </div>  
            <p class="col-xs-1 p0 text-right"><img src="<?php echo theme_url(); ?>images/col-r.png" alt=""></p>  
            <p class="clearfix"></p> 
        </div>           
		<?php
	}
}?>