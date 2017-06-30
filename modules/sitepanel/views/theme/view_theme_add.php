<?php $this->load->view('includes/header'); ?>  

<div id="content">
  
  <div class="breadcrumb">
  
    <?php echo anchor('sitepanel/dashbord','Home'); ?>
 &raquo; <?php echo anchor('sitepanel/theme','Back To Listing'); ?> &raquo;  <?php echo $heading_title; ?>
             
   </div>      
       
 <div class="box">
 
    <div class="heading">
    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
      <div class="buttons">&nbsp;</div>
      
    </div>
   
  
     <div class="content">
   
       
	    <?php echo validation_message();?>
        <?php echo error_message(); ?>
     
          
     
       <?php echo form_open_multipart('sitepanel/theme/add/');?>  

	<table width="90%"  class="tableList" align="center">
		<tr>
			<th colspan="2" align="center" > </th>
		</tr>
		<?php /*<tr class="trOdd">
			<td width="253" height="26"> Theme Name : <span class="required">*</span></td>
			<td width="597"><input type="text" name="theme_name" size="40" value="<?php echo set_value('theme_name');?>"></td>
		</tr>
		<?php */
		$default_params = array(
		'heading_element' => array(
		'field_heading'=>"Theme Name",
		'field_name'=>"theme_name",
		'field_placeholder'=>"",
		'exparams' => 'size="40"'
		),
		'url_element'  => array(
		'field_heading'=>"Page URL",
		'field_name'=>"friendly_url",
		'field_placeholder'=>"Your Page URL",
		'exparams' => 'size="40"',
		'pre_seo_url' =>'',
		'pre_url_tag'=>FALSE
		)
		);
		seo_add_form_element($default_params);?>
		
		<tr class="trOdd">
			<td align="left">&nbsp;</td>
			<td align="left">
			<input type="submit" name="sub" value="Add" class="button2" />
			<input type="hidden" name="action" value="add" />
			</td>
		</tr>
	</table>
<?php echo form_close(); ?>
  </div>
</div>
<?php $this->load->view('includes/footer'); ?>