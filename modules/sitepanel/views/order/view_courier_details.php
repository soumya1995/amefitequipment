<?php $this->load->view('includes/face_header');
echo validation_message();
echo error_message();
echo form_open("sitepanel/orders/courierdetails/".$this->uri->segment(4),'id="myform"');?>
<table width="300" align="left" cellpadding="1" cellspacing="1" class="list" style="margin-top:10px;">
 <thead>
  <tr><td colspan="4" height="30"><?php echo $heading_title; ?>	</td></tr>
 </thead>
 <tr><td colspan="4" align="center"><font color="#FF0000"><strong><?php echo $this->session->flashdata('message');?></strong> </font> </td></tr>
 <tr class="trOdd">
  <td width="38%" height="26" align="right" ><span class="required">*</span> Courier Company Name:</td>
  <td width="62%" align="left"><input type="text" name="courier_company_name" size="30" value="<?php echo set_value('courier_company_name',$res['courier_company_name']);?>"></td>
 </tr>
 <tr class="trOdd">
  <td width="45%" height="26" align="right" ><span class="required">*</span> Airway Bill Number:</td>
  <td width="55%" align="left"><input type="text" name="bill_number" size="30" value="<?php echo set_value('bill_number',$res['bill_number']);?>"></td>
 </tr>
 <tr class="trOdd">
  <td align="left">&nbsp;</td>
  <td align="left">
   <input type="submit" name="sub" value="Update" class="button2" />
   <input type="hidden" name="action" value="edit" />
   <input type="hidden" name="order_id" value="<?php echo $this->uri->segment(4);?>">
  </td>
 </tr>
</table>
<?php echo form_close();?>
</body>
</html>