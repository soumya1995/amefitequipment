<?php $this->load->view('includes/header');?>
<div class="content">
 <div id="content">
  <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo anchor('sitepanel/package','Back To Listing'); ?> &raquo;  <?php echo $heading_title;?></div>
  <div class="box">
   <div class="heading">
    <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title;?></h1>
    <div class="buttons">
     <a href="javascript:void(0);" onclick="$('#form').submit();" class="button">Save</a>
     <?php echo anchor("sitepanel/package",'<span>Cancel</span>','class="button"');?>
    </div>
   </div>
   <div class="content">
    <div id="tabs" class="htabs">
     <a href="#tab-general">General</a>
     <a href="#tab-image">Image</a>
    </div>
    <?php echo validation_message();
    echo error_message();
    echo form_open_multipart(current_url_query_string(),array('id'=>'form'));?>

    <div id="tab-general">
     <table width="90%"  class="form"  cellpadding="3" cellspacing="3">
      <tr><th colspan="2" align="right"><span class="required">*Required Fields</span><br><span class="required">**Conditional Fields</span></th></tr>
      <tr><th colspan="2" align="center" > </th></tr>
            <tr class="trOdd">
             <td height="26" align="right" ><span class="required">*</span> Title:</td>
             <td align="left"><input type="text" name="title" size="40" value="<?php echo set_value('title',$res['title']);?>" /></td>
            </tr>
            
			<tr class="trOdd">
			 <td height="26" align="right" ><span class="required">*</span> Price:</td>
			 <td align="left"><input type="text" name="price" size="40" maxlength=8 value="<?php echo set_value('price',$res['price']);?>"> Maximum of 5 digits</td>
			</tr>
            
            <tr class="trOdd">
			 <td height="26" align="right" > Description:</td>
			 <td align="left"><textarea name="description" rows="5" cols="50" id="description"><?php echo $res['description'];?></textarea> <?php  echo display_ckeditor($ckeditor1);?></td>
			</tr>
			
			<tr class="trOdd">
			 <td align="left">&nbsp;</td>
			 <td align="left"><input type="hidden" name="package_id" value="<?php echo $res['package_id'];?>"></td>
			</tr>
		 </table>
		</div>
		<div id="tab-image">
		 <input type="hidden" name="product_exclude_images_ids" value="" id="product_exclude_images_ids" />
		 <table id="images" class="list">
		  <thead><tr><td class="left">Image</td></tr></thead>
		  <table id="images" class="form">
		   <?php
		   //trace($res_photo_media);
		   $j=0;
		   for($i=1;$i<=4;$i++){
			   $product_img  = @$res_photo_media[$j]['media'];
			   $product_path = "package/".$product_img;
			   $product_img_auto_id  = @$res_photo_media[$j]['id'];
			   ?>
			   <tr>
			    <td width="28%" align="right"><span class="required">**</span> Image <?php echo $i;?></td>
			    <td width="2%" height="26" align="center" >:</td>
			    <td align="left">
			     <input type="file" name="image<?php echo $i;?>" />
			     <?php
			     if( $product_img!='' && file_exists(UPLOAD_DIR."/".$product_path) ){
				     ?>
				     <a href="javascript:void(0);"  onclick="$('#dialog_<?php echo $j;?>').dialog({width:'auto'});">View</a>
				     <?php if($this->deletePrvg===TRUE){?> | <input type="checkbox" name="package_img_delete[<?php echo $product_img_auto_id;?>]" value="Y" />Delete <?php }
			     }?><br /><br />[ ( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 160X208 ) ]

			     <div id="dialog_<?php echo $j;?>" title="Product Image" style="display:none;"><img src="<?php echo base_url().'uploaded_files/'.$product_path;?>"  /> </div>
			     <input type="hidden" name="media_ids[]" value="<?php echo $product_img_auto_id;?>" />
			    </td>
			   </tr>
			   <?php
			   $j++;
		   }?>		  
		  </table>
		  <tfoot></tfoot>
		 </table>
		</div>
		<?php echo form_close();?>
	 </div>
	</div>
 </div>
</div>

<?php $this->load->view('includes/footer');?>