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
  
  
   <?php echo form_open('sitepanel/newsletter/send_mail/');?>  

	<table width="98%"  class="tableList" align="center">
		<tr>
			<th colspan="2" align="center" > </th>
		</tr>
		<tr class="trOdd">
			<td height="26"> To:</td>
			<td><?php echo $this->input->post("sendto") ?></td>
		</tr>
		<tr class="trEven">
			<td height="26">Subject:</td>
			<td><?php echo $this->input->post("subject") ?></td>
		</tr>
		<tr class="trEven">
		 <td height="26">Message:</td>
			<td><?php echo $this->input->post("message") ?>
			</td>
		</tr>
		<tr class="trOdd">
			<td align="left">&nbsp;</td>
			<td align="left">
			<input type="submit" name="submit" value="Send Mail" class="button2" />
			<input type="hidden" name="arr_ids" value="<?php echo $this->input->post("arr_ids");?>">
			<input type="hidden" name="subject" value="<?php echo $this->input->post("subject");?>">
			<input type="hidden" name="message" value="<?php echo set_value('message',$this->input->post("message"));?>">
			
			<input type="hidden" name="sendto" value="<?php echo $this->input->post("sendto");?>">
			<input type="hidden" name="action" value="preview" />
			</td>
		</tr>
	</table>
<?php echo form_close(); ?>
  </div>
</div>
<?php $this->load->view('includes/footer'); ?>