<?php $this->load->view("top_application");?>
<script type="text/javascript">function serialize_form() { return $('#myform').serialize(); }</script>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<p class="col-lg-6 col-md-6 col-sm-6 p0 heading">Testimonials</p>

<p class="cb"></p>  
    
<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li class="active">Testimonials</li>
</ul>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont"><a href="<?php echo base_url();?>testimonials/post" class="pull-right btn-style pop1">Post Your Testimonial</a></p>
</div>
</div>
</div>

 <?php
    if(is_array($res) && !empty($res) ){
	    echo form_open("",'id="myform" method="post" ');?>
	    <input type="hidden" name="per_page" value="<?php echo $this->input->get_post('per_page');?>">
	    <input type="hidden" name="offset" value="0">
	    <?php echo form_close();?>
        <div id="my_data">
        	<div class=" floater" id="prodListingContainer">
            	<?php $data = array('res'=>$res);
				  $this->load->view('testimonials/testimonial_data',$data);
			    ?> 
            </div>
            <p class="clearfix"></p>
	     	<div class="ac mt25" id="loadingdiv"><img src="<?php echo theme_url(); ?>images/loader.gif" alt=""></div>
        </div>
        <?php
    }else{
	    ?>
	    <div class="ac b mt10"><strong>No record found !</strong></div>
	    <div style="height:150px;"></div>
	    <?php
    }?>
    
</div>
</div>
</div>
<script type="text/javascript">
  var page = 1;
  var triggeredPaging = 0;

  $(window).scroll(function (){
	var scrollTop = $( window ).scrollTop();
	var scrollBottom = (scrollTop + $( window ).height());
	//alert(scrollTop+scrollBottom);
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
<?php 
$this->load->view("bottom_application");?>