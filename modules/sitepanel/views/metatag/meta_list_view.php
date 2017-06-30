<?php $this->load->view('includes/header');?>
<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> </a></div>
 <div class="box">
  <div class="heading"><h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1></div>
  <div class="content">
   <?php
   validation_message();
   error_message();
   echo form_open("sitepanel/meta/",'id="form" method="get" ');?>
   <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
   <table width="100%"  border="0" cellspacing="3" cellpadding="3" >
    <tr><td align="center" >Search [ URL ] <input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />&nbsp; <a  onclick="$('#form').submit();" class="button"><span> GO </span></a> <?php if($this->input->get_post('keyword')!=''){ echo anchor("sitepanel/meta/",'<span>Clear Search</span>'); }?></td></tr>
   </table>
   <?php echo form_close();
   if( is_array($pagelist) && !empty($pagelist) ) {
	   echo form_open("sitepanel/meta/",'id="myform"');?>
	   <table class="list" width="100%" id="my_data">
	    <thead>
	     <tr>
	      <td width="369" class="left">URL</td>
	      <td width="629" align="left" class="left">Meta Details</td>
	      <td width="125" class="right">Action</td>
	     </tr>
	    </thead>
	    <tbody>
	     <?php
	     foreach($pagelist as $catKey=>$pageVal){
		     ?>
		     <tr>
		      <td class="left"><?php echo base_url().$pageVal['page_url'];?></td>
		      <td align="left" class="left">
		       <p> <strong> Title  : </strong> <?php echo $pageVal['meta_title'];?> </p>
		       <p> <strong> Keyword  : </strong> <?php echo$pageVal['meta_keyword'];?> </p>
		       <p> <strong> Description   : </strong> <?php echo $pageVal['meta_description'];?></p>
		      </td>
		      <td class="right">
		       <?php
		       if($this->editPrvg===TRUE){
			       echo anchor("sitepanel/meta/edit/$pageVal[meta_id]/".query_string(),'Edit');
		       }?>
		      </td>
		     </tr>
		     <?php
	     }?>
	    </tbody>
	   </table>
	   <?php
	   if($page_links!=''){
		   ?>
		   <table class="list" width="100%">
		    <tr><td align="right" height="30"><?php echo $page_links; ?></td></tr>
		   </table>
		   <?php
	   }?>
	  </table>
	  <?php echo form_close();
  }else{
	  echo "<center><strong> No record(s) found !</strong></center>" ;
  }?>
 </div>
</div>
<?php $this->load->view('includes/footer');?>