<?php $this->load->view('includes/header');?>
<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo $heading_title;?></div>      
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
   <div class="buttons">&nbsp;</div>
  </div>
  <div class="content">  
   <?php echo validation_message();
   echo form_open('sitepanel/setting/change/');?>
   <table width="60%"  class="tableList" align="center" border="0">
    <tr><th colspan="3" align="center"><?php  echo error_message(); echo '<div style="clear:both;">&nbsp;</div>';?> </th></tr>
    <tr class="trOdd">
     <td width="20%" height="26"> Old Password</td>
     <td width="5%" height="26">:</td>
     <td width="75%"><input type="password" name="old_pass" id="old_pass" style="width:325px;" value=''></td>
    </tr>
    <tr class="trEven">
     <td height="26"> New Password</td>
     <td align="center">:</td>
     <td><input type="password" name="new_pass" style="width:325px;" value=''></td>
    </tr>
    <tr class="trOdd">
     <td height="26"> Confirm Password</td>
     <td align="center">:</td>
     <td><input type="password" name="confirm_password" style="width:325px;" value="" /></td>
    </tr>
    <tr class="trOdd">
     <td height="26">&nbsp;</td>
     <td>&nbsp;</td>
     <td><input type="submit" class="button2" value="Update Info"  /></td>
    </tr>
   </table>
   <?php echo form_close();?>
  </div>
 </div> 
</div>
<?php $this->load->view('includes/footer');?>