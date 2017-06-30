<?php $this->load->view('top_application'); ?>
<div class="content">    <!--Left-->
 <div class="content-left">
  <!--Categories-->
  <?php $this->load->view("category/category_left_view");?>
  <!--Categories-->
 </div>
 <div class="content-right">
  <!--Text-->
  <div>
   <p class="fr"><a href="<?php echo base_url(); ?>testimonials/post" class="btn-bg">Post Testimonials</a></p>
   <h1><?php echo $res[0]['poster_name'];?></h1>
   <?php $parent_page_url=base_url().'testimonials'; echo navigation_breadcrumb($res[0]['poster_name'], "Testimonials", $parent_page_url);?>
   <div class="lh20px gray1">
    <div class="mt30">
     <!--Starts-->
     <div class="testi-row">
      <p  class="quote-icon fl"></p>
      <p class="quote-drop"></p>
      <div class="fs16 lh30px geor i">
       <span class="ml70"></span><b><?php echo ucfirst($res[0]['testimonial_title']);?></b>
       <div class="bg-testi"><?php echo $res[0]['testimonial_description'];?></div>
      </div>
      <div class="cb"></div>
     </div>
     <p class="mt10 geor fs16 mr10 mt15 i ar"><?php echo ucwords($res[0]['poster_name']);?></p>
     <p class="ar mr20 fs11 mt5"><?php echo getDateFormat($res[0]['posted_date'],1);?></p>
     <!--Ends--> 
    </div>
   </div>
  </div>
 </div>
 <div class="cb"></div>
 <?php $this->load->view("pages/newsletter");?>
 <div class="cb"></div>
</div>
<?php $this->load->view("bottom_application");?> 