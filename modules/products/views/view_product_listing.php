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
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<h1 class="heading"><?php echo $heading_title;?></h1>   
    
<?php
	if($catid){
		echo category_breadcrumbs($catid,$segment);
	}else{ echo navigation_breadcrumb($heading_title); }
	?>
<?php
   if($catid && $cat_res['category_description']){
	   ?> 
		<div class="mt10 fs12 lht-16 p10" style="border:#eee 1px solid; background:#fbfbfb;"><?php echo $cat_res['category_description'];?></div>
        <?php
   }?>

<div class="mt10">
<?php echo form_open("",'id="myform1" method="post" ');?>
      <input name="new_arrival" id="new_arrival" type="hidden" value="<?php echo $this->input->get_post('new_arrival');?>" />
      <input name="featured_product" id="featured_product" type="hidden" value="<?php echo $this->input->get_post('featured_product');?>" />
      <input name="hot_product" id="hot_product" type="hidden" value="<?php echo $this->input->get_post('hot_product');?>" />
      <input name="offered_product" id="offered_product" type="hidden" value="<?php echo $this->input->get_post('offered_product');?>" />
      <input name="keyword2" id="keyword2" type="hidden" value="<?php echo $this->input->get_post('keyword2');?>" />
      <input name="category_id" id="category_id" type="hidden" value="<?php echo $this->input->get_post('category_id');?>" />
      
      <p class="col-lg-6 col-md-6 col-sm-6 mt15">Showing <strong id="pg">1 - <?php echo $totalProduct; ?></strong> of <strong><?php echo $totalProduct; ?></strong> results</p>
     
      <p class="col-lg-6 col-md-6 col-sm-6 mt10 text-right"> 
          <select name="order_by_price" id="order_by_price" class="p4" style=""> <!--onchange="this.form.submit();"-->
            <option value="">Select</option>
            <option value="ASC" <?php if($this->input->get_post('order_by_price')=='ASC'){?> selected="selected" <?php } ?>>Price Low to High</option>
            <option value="DESC" <?php if($this->input->get_post('order_by_price')=='DESC'){?> selected="selected" <?php } ?>>Price High to Low</option>     
          </select>
          <input name="action" type="submit" value="GO" class="button-style" style="padding:5px;">
      </p>
      <p class="clearfix"></p>
      <?php echo form_close();?>
</div>

	<div class="mt20">
    	
      <?php
	   if(is_array($res) && !empty($res)){
			echo form_open("",'id="myform" method="post" ');?>
		   <input type="hidden" name="offset" value="0">
		   <input type="hidden" name="per_page" value="<?php echo $this->config->item('per_page');?>">
		   <?php echo form_close();?>	   
			<div id="my_data">           
			   <div class="list floater" id="prodListingContainer">
				<?php 
					$data = array('res'=>$res);
					$this->load->view('products/product_data',$data);
				?>
				
    
    </div>           
				<?php if($totalProduct > $record_per_page){?>
				<div class="text-center mt20" id="loadingdiv"><img src="<?php echo theme_url(); ?>images/loader.gif" alt=""></div>
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
    <p class="clearfix"></p>    
    </div>        
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