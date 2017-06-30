<?php $this->load->view('includes/header'); ?> 
  <div id="content">
  <div class="breadcrumb">
      <?php echo anchor('sitepanel/dashbord','Home'); ?>
 &raquo; <?php echo anchor('sitepanel/mailcontents','Back To Listing'); ?> &raquo;  <?php echo $heading_title; ?>
      </div>
      <div class="box">
    <div class="heading">
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">&nbsp;</div>
    </div>
    <div class="content">
      
     <?php
      error_message();
	  validation_message();
      ?>
       <?php echo form_open(current_url_query_string());?>  

	<table width="90%"  class="tableList" align="center">
		<tr>
			<th colspan="2" align="center" > </th>
		</tr>
		<tr class="trOdd" valign="top">
		  <td height="26" colspan="2" style="color:#F00"><strong>* Please do not change the variables enclosed with { } .</strong></td>
	  </tr>
		<tr class="trOdd" valign="top">
			<td height="26">Section :</td>
			<td><strong><?php echo $pageresult->email_section;?></strong></td>
		</tr>
		<tr class="trEven" valign="top">
			<td width="187" height="26">Mail Subject : </td>
			<td width="648" style="f">
			<input type="text" name="email_subject" value="<?php echo set_value('email_subject',$pageresult->email_subject);?>" style="width:450px;">
			<?php
			echo display_ckeditor($ckeditor); ?>
			</td>
		</tr>
		<tr class="trOdd" valign="top">
			<td width="187" height="26">Mail Contents : </td>
			<td width="648" style="f">
			<textarea name="email_content" rows="5" cols="50" id="mail_content" ><?php echo set_value('email_content',$pageresult->email_content);?></textarea>
			<?php
			echo display_ckeditor($ckeditor); ?>
			</td>
		</tr>
		<tr class="trEven">
			<td align="left">&nbsp;</td>
			<td align="left">
			<input type="submit" name="sub" value="Update" class="button2" />            
			<input type="hidden" name="id" value="<?php echo $pageresult->id;?>" />
			</td>
		</tr>
	</table>
<?php echo form_close(); ?>
  </div>
</div>
<?php $this->load->view('includes/footer'); ?>