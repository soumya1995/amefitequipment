<?php $this->load->view('includes/header'); ?>  

<div id="content">  
  <div class="breadcrumb">  
 <?php echo anchor('sitepanel/dashbord','Home'); ?>
 &raquo; <?php echo anchor('sitepanel/newsletter','Back To Listing'); ?> &raquo;  <?php echo $heading_title; ?>
             
</div> 
 <div class="box">
 
    <div class="heading">
    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
      <div class="buttons"> &nbsp; </div>
      
    </div> 
      
     <div class="content">
  
    <?php error_message();validation_message(); ?>
     
     
 <?php echo form_open('sitepanel/newsletter_group/send_mail/');?>  

	<table width="90%"  class="tableList" align="center">
		<tr>
			<th colspan="2" align="center" > </th>
		</tr>
		<tr class="trOdd">
			<td height="26">To Group<span class="red">*</span>:</td>
			<td><?php 
				echo $this->newsletter_group_model->group_drop_down('group_id',$this->input->post('group_id'),'style="width:510px;" ',"Select");?></td>
		</tr>
		<tr class="trEven">
			<td height="26">Subject<span class="red">*</span>:</td>
			<td><input type="text" name="subject" style="width:500px;"  value="<?php echo set_value('subject');?>"></td>
		</tr>
		<tr class="trEven">
			<td width="197" height="26">Message : </td>
			<td width="667" style="f">
			<textarea name="message" rows="5" cols="50" id="message" ><?php echo set_value('message');?></textarea>
			<?php  echo display_ckeditor($ckeditor); ?>
			</td>
		</tr>
		<tr class="trOdd">
			<td align="left">&nbsp;</td>
			<td align="left">
			<input type="submit" name="sub" value="Send Email" class="button2" />
			<input type="hidden" name="Send" value="Send Email">
			<input type="hidden" name="action" value="addnews" />
			</td>
		</tr>
	</table>
<?php echo form_close(); ?>
  </div>
</div>
<?php $this->load->view('includes/footer'); ?>