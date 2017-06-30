<?php $this->load->view('includes/header');?>

<div class="content">
 <div id="content">
  <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo anchor('sitepanel/package','Back To Listing');?> &raquo; <?php echo $heading_title;?></div>
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
    echo form_open_multipart('sitepanel/package/add/',array('id'=>'form'));?>

    <div id="tab-general">
     <table width="100%"  class="form"  cellpadding="3" cellspacing="3">
      <tr><th colspan="3" align="right"><span class="required">*Required Fields</span><br><span class="required">**Conditional Fields</span></th></tr>
      <tr><th colspan="3" align="center" > </th></tr>
         <tr class="trOdd">
           <td width="23%" align="right" ><span class="required">*</span> Title :</td>
           <td width="74%" align="left"><input type="text" name="title" size="70" value="<?php echo set_value('title');?>"></td>
          </tr>     
            
			<tr class="trOdd">
			 <td height="26" align="right" ><span class="required">*</span> Price:</td>
			 <td align="left"><input type="text" name="price" size="40" maxlength="8" value="<?php echo set_value('price');?>"> Maximum of 5 digits</td>
			</tr>
			
            <tr class="trOdd">
			 <td align="right" >Description :</td>
			 <td align="left"><textarea name="description" rows="5" cols="50" id="description"><?php echo set_value('description');?></textarea><?php echo display_ckeditor($ckeditor1);?></td>
			</tr>
			
			<tr class="trOdd">
			 <td align="left">&nbsp;</td>
			 <td align="left">&nbsp;</td>
			 <td align="left">
			  <input type="hidden" name="action" value="add" />
			 </td>
			</tr>
     </table>
    </div>
    <div id="tab-image">
     <table id="images" class="form">
      <?php for($i=1;$i<=4;$i++){?>
      <tr>
       <td width="28%" align="right" ><span class="required">**</span>Image <?php echo $i;?></td>
       <td width="2%" height="26" align="center" >:</td>
       <td align="left"><input type="file" name="image<?php echo $i;?>" /><br />[ ( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 160X208 ) ] </td>
      </tr>
      <?php }?>      
     </table>
    </div>
    <?php echo form_close();?>
   </div>
  </div>
 </div>
</div>

<?php $this->load->view('includes/footer');?>