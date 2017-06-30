<?php $this->load->view('includes/header');?>
<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo anchor('sitepanel/paymentinfo','Back To Listing');?> &raquo; <?php echo $heading_title;?></div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url();?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title;?></h1>
   <div class="buttons">&nbsp;</div>
  </div>
  <div class="content">
   <?php echo validation_message();
   echo error_message();
   echo form_open_multipart('sitepanel/paymentinfo/add/');?>
   <table width="90%"  class="tableList" align="center">
    <tr><th colspan="2" align="center" > </th></tr>
     <tr class="trOdd">
     <td height="26">* <span class="left">Payment Type</span>:</td>
     <td>
      <select name="ptype">
        <option value="">Select</option>
        <option value="2" <?php if($this->input->post('ptype')==2){ echo "Selected";}?> >Moneygram</option>
        <option value="3" <?php if($this->input->post('ptype')==3){ echo "Selected";}?>>Western Union</option>
      </select>
     </td>
    </tr>
    <tr class="trOdd">
     <td height="26">* <span class="left">First Name</span>:</td>
     <td><input type="text" name="first_name" style="width:525px;" value="<?php echo set_value('first_name');?>"></td>
    </tr>
    <tr class="trOdd">
     <td height="26">* <span class="left">Last Name</span>:</td>
     <td><input type="text" name="last_name" style="width:525px;" value="<?php echo set_value('last_name');?>"></td>
    </tr>
    <tr class="trOdd">
     <td height="26">* <span class="left">City</span>:</td>
     <td><input type="text" name="city" style="width:525px;" value="<?php echo set_value('city');?>"></td>
    </tr>
    <tr class="trOdd">
     <td height="26">* <span class="left">Country</span>:</td>
     <td><input type="text" name="country" style="width:525px;" value="<?php echo set_value('country');?>"></td>
    </tr>
    <tr class="trOdd">
     <td align="left">&nbsp;</td>
     <td align="left">
      <input type="submit" name="sub" value="Add" class="button2" />
      <input type="hidden" name="action" value="addnews" />
     </td>
    </tr>
   </table>
   <?php echo form_close();?>
  </div>
 </div>
</div> 
<?php $this->load->view('includes/footer');?>