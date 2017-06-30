<?php $this->load->view("top_application");?>
<!--Body-->
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<p class="heading"><?php echo $res['gym_packages_name'];?></p>   
    
<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li class="active"><?php echo $res['gym_packages_name'];?></li>
</ul>
<div class="clearfix"></div>
	<div class="row mt20">
    <?php 
		  $condtion_left = "AND status = '1' AND gym_packages_id != '".$res['gym_packages_id']."'";
		$condtion_array_left = array(
								'field' =>"*",
								'condition'=>$condtion_left,
								'limit'=>200,
								'offset'=>0,
								'debug'=>FALSE
								);
		$result_data_left  =  $this->gym_packages_model->getgym_packages($condtion_array_left);
		if(is_array($result_data_left) && !empty($result_data_left)){
		  ?>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
            <div class="heading-bg">Pages</div>
            <div>
          <ul class="links">
            <?php
				foreach($result_data_left as $data)
				{
					echo ' <li><a href="'.$data['friendly_url'].'" title="'.$data['gym_packages_name'].'">'.char_limiter($data['gym_packages_name'],25).'</a></li>';
				}
			?>
            </ul>
      
            </div>
        </div>
		<?php }?> 
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
            <div class="aj cms"><?php echo $res['gym_packages_description'];?></div>
        </div>
    </div>
</div>
</div>
</div>
<!--Body end-->
<?php $this->load->view("bottom_application");?>