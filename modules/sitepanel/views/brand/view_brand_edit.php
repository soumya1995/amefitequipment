<?php $this->load->view('includes/header');?>
<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo anchor('sitepanel/brand','Back To Listing');?> &raquo; <?php echo $heading_title;?></div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
   <div class="buttons">&nbsp;</div>
  </div>
  <div class="content">
   <?php echo validation_message();
   echo error_message();
   echo form_open_multipart(current_url_query_string());?>
   <table width="90%"  class="tableList" align="center">
    <tr><th colspan="2" align="center" > </th></tr>
    <tr class="trOdd">
     <td width="253" height="26"> Brand Name : <span class="required">*</span></td>
     <td width="597"><input type="text" name="brand_name" size="40" value="<?php echo set_value('brand_name',$edit_result['brand_name']);?>"></td>
    </tr>
    <tr class="trOdd">
     <td align="left">Brand Image</td>
     <td align="left"><input type="file" name="brand_image" /><?php if($edit_result['brand_image']!='' && file_exists(UPLOAD_DIR."/brand/".$edit_result['brand_image'])){?><a href="javascript:void(0);"  onclick="$('#dialog').dialog({width:'auto'});">View</a><?php if($this->deletePrvg===TRUE){?> | <input type="checkbox" name="brand_img_delete" value="Y" />Delete <?php } }?><br /><br />[ <?php echo $this->config->item('brand.best.image.view');?> ] <div id="dialog" title="Brand Image" style="display:none;"> <img src="<?php echo base_url().'uploaded_files/brand/'.$edit_result['brand_image'];?>"  /> </div></td>
    </tr>
    <tr class="trOdd">
     <td align="left">&nbsp;</td>
     <td align="left">
      <input type="submit" name="sub" value="Update" class="button2" />
			<input type="hidden" name="id" value="<?php echo $edit_result['brand_id'];?>" />
			<input type="hidden" name="action" value="add" />
		 </td>
		</tr> 
	 </table>
	 <?php echo form_close();?>
	</div>
 </div>	
</div>
<?php $this->load->view('includes/footer');?>