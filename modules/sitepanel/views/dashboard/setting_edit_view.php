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
   echo error_message();
   echo form_open('sitepanel/setting/edit/');?>
   <table width="60%"  class="tableList" align="center" border="0">
    <tr><th colspan="2" align="center" > </th></tr>
    <tr class="trOdd">
     <td align="left" width="26%">Mail Us </td>
     <td align="center" width="2%">:</td>
     <td align="left" width="72%"><input type="text" name="admin_email" style="width:325px;" value="<?php echo set_value('admin_email',$admin_info->admin_email);?>"<?php echo  $this->admin_log_data['admin_type']!=1 ? ' readonly="readonly"' : '';?> /></td>
    </tr>
    <tr class="trOdd">
     <td align="left">Call Us</td>
     <td align="center">:</td>
     <td align="left"><input type="text" name="phone" style="width:325px;" value="<?php echo set_value('phone',$admin_info->phone);?>"<?php echo  $this->admin_log_data['admin_type']!=1 ? ' readonly="readonly"' : '';?> /></td>
    </tr>    
    <?php if($this->admin_log_data['admin_type']==1){?>
    
    <?php /*?><tr class="trOdd">
     <td align="left">Timings</td>
     <td align="center">:</td>
     <td align="left"><input type="text" name="timings" style="width:325px;" value="<?php echo set_value('timings',$admin_info->timings);?>"<?php echo  $this->admin_log_data['admin_type']!=1 ? ' readonly="readonly"' : '';?> /></td>
    </tr><?php */?>
    
    <tr class="trOdd">
     <td align="left"> Address</td>
     <td align="center">:</td>
     <td align="left"><textarea name="address" cols="55" rows="6" style="width:325px;"><?php echo set_value('address',$admin_info->address);?></textarea></td>
    </tr>
    <tr class="trOdd">
     <td align="left">City</td>
     <td align="center">:</td>
     <td align="left"><input type="text" name="city" style="width:325px;" value="<?php echo set_value('city',$admin_info->city);?>"<?php echo  $this->admin_log_data['admin_type']!=1 ? ' readonly="readonly"' : '';?> /></td>
    </tr>
    <tr class="trOdd">
     <td align="left">State</td>
     <td align="center">:</td>
     <td align="left"><input type="text" name="state" style="width:325px;" value="<?php echo set_value('state',$admin_info->state);?>"<?php echo  $this->admin_log_data['admin_type']!=1 ? ' readonly="readonly"' : '';?> /></td>
    </tr>
    <tr class="trOdd">
     <td align="left">Zipcode</td>
     <td align="center">:</td>
     <td align="left"><input type="text" name="zipcode" style="width:325px;" value="<?php echo set_value('zipcode',$admin_info->zipcode);?>"<?php echo  $this->admin_log_data['admin_type']!=1 ? ' readonly="readonly"' : '';?> /></td>
    </tr>
    <tr class="trOdd">
     <td align="left">Country</td>
     <td align="center">:</td>
     <td align="left"><input type="text" name="country" style="width:325px;" value="<?php echo set_value('country',$admin_info->country);?>"<?php echo  $this->admin_log_data['admin_type']!=1 ? ' readonly="readonly"' : '';?> /></td>
    </tr>
    <?php }?>
    
    <tr class="trOdd">
     <td align="left">Tax(%)</td>
     <td align="center">:</td>
     <td align="left"><input type="text" name="tax" style="width:325px;" maxlength="5" value="<?php echo set_value('tax',$admin_info->tax);?>"<?php echo  $this->admin_log_data['admin_type']!=1 ? ' readonly="readonly"' : '';?> /></td>
    </tr>
        
    <tr class="trOdd">
     <td height="26">&nbsp;</td>
     <td height="26">&nbsp;</td>
     <td><input type="submit" class="button2" value="Update Info"  /></td>
    </tr>
   </table>
   <?php echo form_close();?>
  </div>
 </div> 
</div>
<?php $this->load->view('includes/footer');?>