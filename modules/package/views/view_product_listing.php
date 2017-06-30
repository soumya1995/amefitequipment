<?php $this->load->view("top_application");
$segment=3;
@$catid = (int) $cat_res['category_id'];
$condtion_array = array(
		'field' =>"*,( SELECT COUNT(category_id) FROM wl_categories AS b
		WHERE b.parent_id=a.category_id ) AS total_subcategories",
		'condition'=>"AND parent_id = '0' AND status='1' ",
		'limit'=>100,
		'order'=>'sort_order',
		'offset'=>0,
		'debug'=>FALSE
		);

$category_res  = $this->category_model->getcategory($condtion_array);
$total_cat_found	=  $this->category_model->total_rec_found;
$selected_category = (int) $this->uri->rsegment(3)?$this->uri->rsegment(3):$this->input->post('category_id');
?>
<script type="text/javascript">function serialize_form() { return $('#myform').serialize();   } </script>
<div class="container">
  <div class="inner-cont">
    <h1><?php echo $heading_title;?></h1>
    <?php
	if($catid){
		echo category_breadcrumbs($catid,$segment);
	}else{ echo navigation_breadcrumb($heading_title); }
	?>
    
    <div class="mt5">
    
      <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
      <div class="row">
      <?php
	   if(is_array($category_res) && !empty($category_res) ){?>
        <div class="category-d">
          <p class="products-text">Products</p>
          <div class="cate-sec-d">
            <ul class="cate">
            	<?php
				  foreach($category_res as $val){
					  $total_subcategories = $val['total_subcategories'];
					  /*if($total_subcategories<=0){
						  $link_url = base_url()."products/index/".$val['category_id'];					  
					  }else{
						  $link_url = "javascript:void(0)";
					  }*/
					  $link_url = base_url().$val['friendly_url'];
					  ?>
              			<li><a href="<?php echo $link_url;?>" title="Pressure"><?php echo $val['category_name'];?></a></li>
             		<?php
				  }?>
            </ul>
          </div>
          <p class="clearfix"></p>
          <?php
          if($total_cat_found > 10){?>
          	<p class="cate-sec-btn"><a href="category.htm">Show All Products</a></p>
		 <?php 
		 } ?>
        </div>
        	<?php
	   }?>
      </div>
    </div>
    <div class="col-lg-9 col-md-9 sol-sm-6 col-xs-12">
<?php
if(is_array($cat_res) && !empty($cat_res)){
   ?>
	   <div class="p10 border1 mb10 mt5 hidden-xs hidden-sm">
            <div class="thm1 fl mr15">
            <figure>
              <img src="<?php echo get_image('category',$cat_res["category_image"],'75','85');?>" width="75" height="85" alt=""> </figure>
            </div>
            <p class="gray"><?php echo $cat_res['category_description'];?></p>
            <div class="clearfix"></div>
		</div>
		<?php
}?>
      <div class="">
      <?php
       if(is_array($res) && !empty($res)){
        echo form_open("",'id="myform" method="post" ');?>
       <input type="hidden" name="offset" value="0">
       <input type="hidden" name="per_page" value="<?php echo $this->config->item('per_page');?>">
       <?php echo form_close();?>	   
        <div id="my_data">           
           <ul class="list floater" id="prodListingContainer">
           	<?php 
				$data = array('res'=>$res);
            	$this->load->view('products/product_data',$data);
			?>
            </ul>           
			<?php if($totalProduct > $record_per_page){?>
            <div class="ac pt10 pb10" id="loadingdiv"><img src="<?php echo theme_url(); ?>images/ajax-loader.gif" width="128" height="15" alt=""></div>
            <?php }?>    
       </div>
       <?php
   }else{
	   ?>
	   <div class="ac b mt10"><strong>No record found !</strong></div>
	   <div style="height:150px;"></div>
	   <?php
   }
   ?>      
      </div>
     
    </div>
    <p class="clearfix"></p>
      
      <div class="clearfix"></div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var page = 1;
  var triggeredPaging = 0;

  $(window).scroll(function (){
	var scrollTop = $( window ).scrollTop();
	var scrollBottom = (scrollTop + $( window ).height());
	// alert(scrollTop+scrollBottom);
	var containerTop = $('#prodListingContainer').offset().top;
	var containerHeight = $('#prodListingContainer').height();
	var containerBottom = Math.floor(containerTop + containerHeight);
	var scrollBuffer = 0;

	//  if($(window).scrollTop() + $(window).height() == $(document).height()) {
		
		if((containerBottom - scrollBuffer) <= scrollBottom) {
		  page = $('.listpager').length;
		  $(':hidden[name="offset"]').val(page);
		  var actual_count = <?php echo $totalProduct; ?>;		 
		  if(!triggeredPaging && page < actual_count){
			triggeredPaging=1;
			
			data_frm = serialize_form();
			$.ajax({
				  type: "POST",
				  url: "<?php echo base_url().$frm_url;?>",
				  data:data_frm,
				  error: function(res) {
					triggeredPaging = 0;
				  },
				  beforeSend: function(jqXHR, settings){
					$('#loadingdiv').show();
				  },
				  success: function(res) {
					$('#loadingdiv').hide();
					$("#prodListingContainer").append(res);
					triggeredPaging = 0;
					//console.log(res);
					
					$('.listpager').fadeTo(500, 0.5, function() {
					  $(this).fadeTo(100, 1.0);
					});
				  }
				});
		  }
		}
});
</script>
<?php $this->load->view("bottom_application");?>