<?php $this->load->view('includes/header'); ?>  

<div id="content">  
  <div class="breadcrumb">  
    <?php echo anchor('sitepanel/dashbord','Home'); ?>
     &raquo; <?php echo anchor('sitepanel/newsletter', 'Back To Listing');?> &raquo;  <?php echo $heading_title;?> 
    
   </div>      
       
 <div class="box"> 
    <div class="heading">    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>      
      <div class="buttons">&nbsp;</div>      
    </div>  
     <div class="content"> 
	  
	    <?php validation_message();?>
        <?php  error_message(); ?>
        <?php echo form_open_multipart('sitepanel/newsletter/import_newsletter/');?>
        <?php
         $atts = array(
           'width' => '650',
           'height' => '400',
           'scrollbars' => 'yes',
           'status' => 'yes',
           'resizable' => 'yes',
           'screenx' => '0',
           'screeny' => '0'
         );
        ?>

	<table width="90%"  class="tableList" align="center">
		<tr>
         <th colspan="3" align="center" > </th>
      </tr>
		<tr class="trOdd">
         <td height="26">* Newsletter XL File:</td>
         <td><input type="file" name="upload_file" id="upload_shipping" /></td>
         <td><?php echo anchor(base_url().'assets/sample/newsletter.xls', 'Download Newsletter Sample file', 'target="_blank"');?>
            </td>
      </tr>
		<tr class="trOdd">
			<td align="left">&nbsp;</td>
			<td align="left">
            <input type="submit" name="sub" value="Upload" class="button2" />
            <input type="hidden" name="action" value="import" />
         </td>
         <td align="left">&nbsp;</td>
      </tr>
	</table>
<?php echo form_close(); ?>
  </div>
</div>
<?php $this->load->view('includes/footer'); ?>