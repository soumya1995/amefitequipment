<?php $this->load->view('includes/header'); ?>
<div id="content">
 <div class="breadcrumb"> <?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> </a></div>
 <div class="box">
  <div class="heading"><h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1></div>
  <div class="content">
   <?php echo validation_message();
   echo error_message();?>
   <div style="clear:both"></div>
   <?php echo form_open_multipart('');?>
   <div id="tab_pinfo">
    <table width="90%"  class="form"  cellpadding="3" cellspacing="3">
     <tr><th colspan="2" align="right" ><span class="required">*Required Fields</span></th></tr>
     <tr><th colspan="2" align="center" > </th></tr>
     <tr class="trOdd">
      <td height="26" align="right" >Upload Excel Data<span class="required"> * </span>: </td>
      <td align="left"><input type="file" name="upload_file" size="60" /></td>
     </tr>
     <tr class="trOdd">
      <td align="left">&nbsp;</td>
      <td align="left">
       <input type="submit" name="sub" value="Save" class="button2" />
       <input type="hidden" name="action" value="add" />
      </td>
     </tr>
     <tr class="trOdd">
      <td align="center" colspan="2"><br/><br/>
       <input type="button" name="sub" value="Download Products Sample" style="background-color:#252424;color:#FFF;font-weight:bold" onclick="window.location.href='<?php echo base_url().'assets/sample/products.xls';//echo site_url('sitepanel/products/download_product_format');?>';"/>
       <input type="button" name="sub" value="Download Categories" style="background-color:#252424;color:#FFF;font-weight:bold" onclick="window.location.href='<?php echo site_url('sitepanel/products/download_cat_format');?>';"/>
       
       <input type="button" name="sub" value="Download Brand Sample" style="background-color:#252424;color:#FFF;font-weight:bold" onclick="window.location.href='<?php echo site_url('sitepanel/products/download_brand_format');?>';"/>
       
       <?php /*?><input type="button" name="sub" value="Download Weights" style="background-color:#252424;color:#FFF;font-weight:bold" onclick="window.location.href='<?php echo site_url('sitepanel/products/download_weight_format');?>';"/><?php */?>      
       <br/><br/>
       <strong>Note:</strong> Please download products to view the sample sheet as well as uploaded products, also download other sheets for id's reference.
      </td>
     </tr>
    </table>
   </div>
   <?php echo form_close(); ?>
  </div>
 </div> 
</div>
<?php $this->load->view('includes/footer'); ?>