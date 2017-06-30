<?php $this->load->view("top_application");

$segment=3; 

$cat_name=$heading_title;

if($cat_id){

	$cat_name=ucwords($parentres['category_name']);

}



$condtion_array = array(

		'field' =>"*,( SELECT COUNT(category_id) FROM wl_categories AS b

		WHERE b.parent_id=a.category_id ) AS total_subcategories",

		'condition'=>"AND parent_id = '0' AND status='1' ",

		'limit'=>100,

		'order'=>'sort_order',

		'offset'=>0,

		'debug'=>FALSE

		);



$cat_res  = $this->category_model->getcategory($condtion_array);

$total_cat_found	=  $this->category_model->total_rec_found;

$selected_category = $this->uri->rsegment(3);

?>

<script type="text/javascript">function serialize_form() { return $('#myform').serialize(); }</script>

<div class="container pt10 minmax"> 

<div class="row">

<div class="inner-cont">

<h1 class="heading"><?php echo $heading_title;?></h1> 

<?php

if($cat_id){ echo category_breadcrumbs($cat_id,$segment); }else{ 

	echo navigation_breadcrumb($heading_title);

}

?>

<?php
echo error_message();
echo '<div class="cb"></div>';
   if(($cat_id) && ($parentres['category_description']!="")){

	   ?> 

			<div class="mt10 fs18 lht-16 p10" style="border:#eee 1px solid; background:#fbfbfb;"><?php echo $parentres['category_description'];?></div>

		<?php

}
if($heading_title=='Categories'){
?>
				<div class="mt10 fs18 lht-16 p10" style="border:#eee 1px solid; background:#fbfbfb;">At AME Fitness Equipment, we have a wide range of commercial gym equipment that helps you achieve total body workout in a safe way. We have a wide range of gym equipment like cardio, strength equipment, free weights, commercial flooring and many more. You can avail all these types of equipment from us at a competitive market price. We are celebrated Commercial Gym Equipment Online Shop in the USA that provides all types of gym equipment. We are a one-stop shop that caters to all the fitness equipment needs of its clients. The high quality of sports equipment offered by us has made us one of the leading Commercial Sports Equipment online shops in the USA. We also deal in Used Commercial Gym Equipment in the USA, which are available in the best condition.  To offer products to all our clients we also offer Remanufactured Commercial Gym Equipment in the USA. </div>
<?php } 	
	?>



	<div class="mt20">

    	 <?php

  	if(is_array($res) && !empty($res) ){

	   echo form_open("",'id="myform" method="post" ');?>

	   <input type="hidden" name="per_page" value="<?php echo $this->input->get_post('per_page');?>">

	   <input type="hidden" name="offset" value="0">

	   <?php echo form_close();?>

       <div  id="my_data">        

				<div class="floater" id="prodListingContainer">

				<?php 

                    $data = array('res'=>$res);

                    $this->load->view('category/category_data',$data);

                ?>

                </div>             

            

		<div class="clearfix cb"></div> 

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

	   }?>

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

<?php $this->load->view("bottom_application");?>