<?php 
$this->load->view("top_application");
$this->load->model(array('weight/weight_model','prices/price_model'));

$thumbc['width']=400;
$thumbc['height']=313;
$thumbc['source_path']=UPLOAD_DIR.'/products/';	
//$discounted_price = $res['product_discounted_price']>0 && $res['product_discounted_price']!=null ? TRUE : FALSE;	
$stock_res=get_weight_attr($res["products_id"]);	
?>
<script type="text/javascript" src="<?php echo resource_url();?>zoom/magiczoomplus.js"></script>
<div class="container">
  <div class="inner-cont">
    <?php echo category_breadcrumbs($res['category_id'],'',$res['product_name']); ?>
    
    <div class="mt5 mb20">
    <div class="pc_box">
    <div class="rel o-hid shadow1 dtl-main-sec">
      <div class="product-dtl-img"> <a href="<?php echo img_url();?>products/<?php echo $res['media']?>" class="MagicZoomPlus" id="Zoomer" title="" rel="zoom-position:inner; thumb-change:mouseover"><img src="<?php echo get_image('products',$res['media'],400,313,'R');?>" class="db" alt=""></a> </div>
    </div>
    <div class="ac o-hid rel mt15" style="height:59px;"> <a href="javascript:void(0)" class="prev5 trans_eff fl mt16"><img src="<?php echo theme_url(); ?>images/arl.png" class="db" alt=""></a> <a href="javascript:void(0)" class="next5 trans_eff fr mt16"><img src="<?php echo theme_url(); ?>images/arr.png" class="db" alt=""></a>
      <div class="fl rel ml5 o-hid scroll-width">
        <div class="scroll_3">
          <ul class="myulx">
             <?php
			   $ix=0;
			   foreach($media_res as $v){
				   $thumbc['org_image']=$v['media'];
				   Image_thumb($thumbc,'R');
				   $cache_file="thumb_".$thumbc['width']."_".$thumbc['height']."_".$thumbc['org_image'];
				   $catch_img_url=thumb_cache_url().$cache_file;
				   ?>
					<li class="fl">
              			<div class="ds_thm"><a href="<?php echo img_url();?>products/<?php echo $v['media'];?>" rel="zoom-id:Zoomer" rev="<?php echo $catch_img_url;?>"><img src="<?php echo get_image('products',$v['media'],75,59,'R');?>"  alt="<?php echo $res['product_alt'];?>" ></a></div></li>    
				<?php
			 }?>
                        
          </ul>
          <div class="cb"></div>
        </div>
      </div>
    </div>
    <div class="cb pb5"></div>
  </div>
  <?php echo form_open('cart/add_to_cart/'.$res['products_id'],array('name'=>'cartfrm','id'=>'cartfrm'));?>
  <div class="dtl_right">
    <h1><?php echo $res['product_name'];?></h1>
    <p class="mt4 gray ttu">Model Number : <b><?php echo $res['product_code'];?></b></p>
    <?php
    if(!empty($res['product_barcode'])){?>
    	<p class="mt4"><img src="<?php echo get_image('barcodes',$res['product_barcode'],161,60,'R');?>" alt="" height="60"></p>
        <?php
	}
	if(@$stock_res['qty'] > 0 || !empty($stock_res)){
	?>
      <div class="dtl_color_cont">
        <p class="stock"><img src="<?php echo theme_url(); ?>images/in-stock.png" width="67" height="67" alt=""></p>
          <div class="col-xs-12 col-sm-8">
          <p class="fs16 blues">Weight</p>
          <div class="dtl_size mt15 ml2 d_c_tag2">        
            <select name="weight_id" id="weight_id" style="width:235px;padding:3px;" class="vam p5" onchange="return weight_amount(this.value,'<?php echo $res['products_id'];?>');">
                  <option value="">Select Weight</option> 
                  <?php
                  foreach($weights as $val){
                     
                     $sel=($res['weight_id']==$val['weight_id']?'selected="selected"':''); 
                      ?>
                      <option value="<?php echo $val['weight_id'];?>" <?php echo $sel;?>><?php echo $val['variant_name'];?></option>
                      <?php
                  }?>
              </select> <?php echo $this->config->item('weight_unight');?>
          </div>
          </div>
          <div class="clearfix"></div>
      </div>
    	<?php
	}?>
    <div class="pdf_color_cont">
    <div class="bg-gray1 b black  p8"><div class="sec1">Sl. No.</div>
    <div class="sec2">PDF Name</div>
    <div class="sec3 ac">Download</div>
    <div class="cb clearfix"></div></div>
     <?php
	 if(!empty($res['product_pdf1'])){
		 ?>     
		<div class="bgW mt5 bb p2">
			<div class="sec1 ac">1</div>
			<div class="sec2">PDF Name</div>
			<div class="sec3 ac"><a href="<?php echo base_url();?>products/download_pdf/1/<?php echo $res["products_id"];?>" class="btn3s"><img src="<?php echo theme_url(); ?>images/pdf.png" width="20" alt="" class=" vam"><span class="hidden-xs">Download</span></a></div>
			<div class="cb clearfix"></div>
		</div>
    	<?php
	 }?>
     <?php
	 if(!empty($res['product_pdf2'])){
		 ?>     
		<div class="bgW mt5 bb p2">
			<div class="sec1 ac">2</div>
			<div class="sec2">PDF Name</div>
			<div class="sec3 ac"><a href="<?php echo base_url();?>products/download_pdf/2/<?php echo $res["products_id"];?>" class="btn3s"><img src="<?php echo theme_url(); ?>images/pdf.png" width="20" alt="" class=" vam"><span class="hidden-xs">Download</span></a></div>
			<div class="cb clearfix"></div>
		</div>
    	<?php
	 }?>
     <?php
	 if(!empty($res['product_pdf3'])){
		 ?>     
		<div class="bgW mt5 bb p2">
			<div class="sec1 ac">3</div>
			<div class="sec2">PDF Name</div>
			<div class="sec3 ac"><a href="<?php echo base_url();?>products/download_pdf/3/<?php echo $res["products_id"];?>" class="btn3s"><img src="<?php echo theme_url(); ?>images/pdf.png" width="20" alt="" class=" vam"><span class="hidden-xs">Download</span></a></div>
			<div class="cb clearfix"></div>
		</div>
    	<?php
	 }?>
    
    </div>
      <p class="clearfix"></p>
      <p class="fs24 mt15 mb25" id="show_hide_price">Price: <span class="black"><?php echo display_price($res["product_price"]);?></span> </p>
      <div id="price"></div>
      <p class="clearfix"></p>
    	<input name="action" type="submit" class="btn-lg btn-primary trans_eff vam" value="Add to Cart Now!" style="cursor:pointer" />
    	<input name="action" type="button" class="btn-lg btn-warning trans_eff vam" value="Add to Favorite" style="cursor:pointer" onclick="window.location.href=('<?php echo base_url();?>cart/add_to_wishlist/<?php echo $res['products_id'];?>')">
    <div class="clearfix"></div>
  	<p class="mt20"><?php echo $res['delivery_time'];?></p>
     </div>
     <?php echo form_close();?>
  <div class="clearfix"></div>
  <hr class="mt5 mb30">
  <div class="details">
    <h2 class="mb15">Product Description</h2>
    <div class="cms_area">
      <?php echo $res['products_description'];?>
    </div>
  </div>
    <p class="clearfix"></p>
      
      <div class="clearfix"></div>
    </div>
  </div>
</div> 
<script>
/*$(document).ready(function(){
	$('#weight_id').val(<?php echo $res["weight_id"];?>);
	weight_amount('<?php echo $res["weight_id"];?>', '<?php echo $res["products_id"];?>');	
});*/

function weight_amount(weightId,productId){
		
	$.ajax({'url':'<?php echo base_url('products/show_weight_amount/');?>',
	
			type: "POST",
			dataType: "html",
			"data":{"weightId":weightId,"productId":productId},
			"success":function(data){
				$("#action").show();
				if(data==""){
					$("#action").hide();
				}
				$("#price").html(data);	
				$("#show_hide_price").hide();
			}
	});
}
</script>                                 
<?php $this->load->view("bottom_application");?>