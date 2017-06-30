<?php $this->load->view("top_application");?>
<script type="text/javascript">function serialize_form() { return $('#myform').serialize(); }</script>
<!--Body-->
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<p class="heading">FAQ's</p>   
    
<ul class="breadcrumb">
<li><a href="index.htm">Home</a></li>
<li class="active">FAQ's</li>
</ul>
	<div class="clearfix"></div>
    <div class="row mt20">
        <?php 
		$this->load->model(array('faq_category/faq_category_model'));
		  $condtion_left = "AND status = '1' AND faq_category_id != '".$category_id."'";
		$condtion_array_left = array(
								'field' =>"*",
								'condition'=>$condtion_left,
								'limit'=>200,
								'offset'=>0,
								'debug'=>FALSE
								);
		$result_data_left  =  $this->faq_category_model->getfaq_category($condtion_array_left);
		if(is_array($result_data_left) && !empty($result_data_left)){
		  ?>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
            <div class="heading-bg">Category</div>
            <div>
          <ul class="links">
            <?php
				foreach($result_data_left as $data)
				{
					echo ' <li><a href="'.$data['friendly_url'].'" title="'.$data['faq_category_name'].'">'.char_limiter($data['faq_category_name'],25).'</a></li>';
				}
			?>
            </ul>
      
            </div>
        </div>
		<?php }?>
        
         <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
            <div class="panel-group" id="accordion">
                
                 <?php
    if(is_array($res) && !empty($res) ){
	    echo form_open("",'id="myform" method="post" ');?>
	    <input type="hidden" name="per_page" value="<?php echo $this->input->get_post('per_page');?>">
	    <input type="hidden" name="offset" value="0">
	    <?php echo form_close();?>
       <div id="my_data">
       		<div class="panel-group mt10 floater" id="prodListingContainer">
          <?php $data = array('res'=>$res);
				  $this->load->view('faq/faq_data',$data);
			    ?>   
         </div>
            <p class="clearfix"></p>
	     	<div class="ac mt25 dn" id="loadingdiv"><img src="<?php echo theme_url(); ?>images/loader.gif" alt=""></div>
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
</div>
</div>
</div>
<!--Body end-->
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
$this->load->view("bottom_application");