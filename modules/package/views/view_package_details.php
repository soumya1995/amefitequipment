<?php $this->load->view("top_application");
$thumbc['width']=285;
$thumbc['height']=371;
$thumbc['source_path']=UPLOAD_DIR.'/package/';	
?>
<script type="text/javascript" src="<?php echo resource_url();?>zoom/magiczoomplus.js"></script> 
<script type="text/javascript">function serialize_form() { return $('#myform').serialize();   } </script>
<div class="container pt10 minmax">
  <div class="row">
    <div class="inner-cont">
      <ul class="breadcrumb" style="border:0; margin:-10px 0 0 0;">
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li><a href="<?php echo base_url();?>package">Packing</a></li>
        <li class="active"><?php echo $heading;?></li>
      </ul>
      <div class="mt40">
        <div class="col-lg-4 col-md-5 col-sm-12 p0">
          <div class="pro-thmb">
            <div>
              <ul class="thmb-pic">
                <?php
				   $ix=0;
				   foreach($media_res as $v){ 
					   $thumbc['org_image']=$v['media'];
					   Image_thumb($thumbc,'R');
					   $cache_file="thumb_".$thumbc['width']."_".$thumbc['height']."_".$thumbc['org_image'];
					   $catch_img_url=thumb_cache_url().$cache_file;
					   ?>
						<li>
							<p class="thmb"><span><a href="<?php echo img_url();?>package/<?php echo $v['media'];?>" rel="zoom-id:Zoomer" rev="<?php echo $catch_img_url;?>"><img src="<?php echo get_image('package',$v['media'],65,85,'R');?>"  alt="" ></a></span></p></li>   
					<?php
				}?>
              </ul>
              <p class="clearfix"></p>
            </div>
          </div>
          <div class="pro-dtl" style="border:1px solid #ccc;padding:5px;"><span><a href="<?php echo img_url();?>package/<?php echo $res['media']?>" class="MagicZoomPlus" id="Zoomer" title="" rel="zoom-position:inner; thumb-change:mouseover"><img src="<?php echo get_image('package',$res['media'],285,371,'R');?>" class="db" alt=""></a></span></div>
          <p class="clearfix"></p>
        </div>
        
        <div class="col-lg-7 col-md-7 col-sm-12">
          <p class="fs24 black mt10"><?php echo $res['title']?></p>
          <div class="clearfix"></div>
          
          <p class="mt20 bb2"></p>
          <div class="col-lg-6 col-md-5 col-sm-5 mt20 p0">
            <p class="fs14 lht-22 grey">Price : <span class="blue fs24 ml10"><?php echo  display_price($res['price']);?></span></p>
            
            <p class="clearfix"></p>
          </div>
    
        
          
        </div>
        <p class="clearfix"></p>
      </div>
      <p class="mt20 bb"></p>
      
      <div class="mt30">
        <p class="fs18 b blue">Description</p>
        <div class="mt5 lht-18"><?php echo $res['description'];?></div>
      </div>      
    </div>
  </div>
</div>
<?php 
$this->load->view("bottom_application");?>