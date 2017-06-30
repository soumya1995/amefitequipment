<?php $this->load->view('includes/header');?>
<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo anchor('sitepanel/header_images','Back To Listing');?> &raquo; <?php echo $heading_title;?></div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
   <div class="buttons">&nbsp;</div>
  </div>
  <div class="content">
   <?php echo validation_message('');
   echo error_message();
   echo form_open_multipart(current_url_query_string());?>
   <table width="90%"  class="form"  cellpadding="3" cellspacing="3">
    <tr><th colspan="2" align="center" > </th></tr>
    <tr class="trOdd">
     <td width="28%" height="26" align="right" ><span class="required">*</span> Header Image:</td>
     <td align="left">
      <input type="file" name="image1" id="image1" />
      <?php
      $j=1;
      $product_path = "header_images/".$res->header_image;
      ?>
      <a href="javascript:void(0);" onclick="$('#dialog_<?php echo $j;?>').dialog({width: '1200',overflow:'auto'});">View Header Image </a>
      <div id="dialog_<?php echo $j;?>" title="Header Image" style="display:none;"><img src="<?php echo base_url().'uploaded_files/'.$product_path;?>"  /> </div><br />Best view image size width : 1600 pixels and height : 566 pixels fixed.
     </td>
    </tr>
    
    <tr class="trOdd">
     <td width="28%" height="26" align="right" >Url:</td>
     <td align="left">
      <input type="text" name="header_url" id="header_url" value="<?php echo $res->header_url;?>" style="width:300px;" />      
     </td>
    </tr>
    
    <tr class="trOdd">
     <td align="left">&nbsp;</td>
     <td align="left">
      <input type="submit" name="sub" value="Update" class="button2" />
      <input type="hidden" name="action" value="add" />
     </td>
    </tr>
   </table>
  </div>
 </div>
</div> 
<?php $this->load->view('includes/footer');?>