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
   echo form_open_multipart("sitepanel/paymentinfo/edit/".$rwdata->id);?>
   <table width="90%"  class="tableList" align="center" cellpadding="5" cellspacing="5">
    <tr><th colspan="2" align="center" > </th></tr>
    
    <tr class="trOdd">
     <td height="26">* <span class="left">Title</span>:</td>
     <td><input type="text" name="ptitle" style="width:525px;" value="<?php echo set_value('ptitle',$rwdata->ptitle);?>" readonly="readonly"></td>
    </tr>
    
   <?php if($rwdata->ptype==1){ ?> 
    <tr class="trOdd">
     <td height="26">* <span class="left">Account Holder Name</span>:</td>
     <td><input type="text" name="ac_holder_name" style="width:525px;" value="<?php echo set_value('ac_holder_name',$rwdata->ac_holder_name);?>"></td>
    </tr>
    <tr class="trOdd">
     <td height="26">* <span class="left">Account No.</span>:</td>
     <td><input type="text" name="ac_no" style="width:525px;" value="<?php echo set_value('ac_no',$rwdata->ac_no);?>"></td>
    </tr>
    <tr class="trOdd">
     <td height="26">* <span class="left">Bank Name</span>:</td>
     <td><input type="text" name="bank_name" style="width:525px;" value="<?php echo set_value('bank_name',$rwdata->bank_name);?>"></td>
    </tr>
    <?php /*<tr class="trOdd">
     <td height="26">* <span class="left">Bank Address</span>:</td>
     <td><input type="text" name="bank_address" style="width:525px;" value="<?php echo set_value('bank_address',$rwdata->bank_address);?>"></td>
    </tr>*/?>
    <tr class="trOdd">
     <td height="26">* <span class="left">Swift Code</span>:</td>
     <td><input type="text" name="ifc_code" style="width:525px;" value="<?php echo set_value('ifc_code',$rwdata->ifc_code);?>"></td>
    </tr>
    <tr class="trOdd">
     <td height="26">* <span class="left">City</span>:</td>
     <td><input type="text" name="city" style="width:525px;" value="<?php echo set_value('city',$rwdata->city);?>"></td>
    </tr>
    <tr class="trOdd">
     <td height="26">* <span class="left">Country</span>:</td>
     <td><input type="text" name="country" style="width:525px;" value="<?php echo set_value('country',$rwdata->country);?>"></td>
    </tr>
   <?php }elseif($rwdata->ptype!=4){ ?>
   <tr class="trOdd">
     <td height="26">* <span class="left">First Name</span>:</td>
     <td><input type="text" name="first_name" style="width:525px;" value="<?php echo set_value('first_name',$rwdata->first_name);?>"></td>
    </tr>
    <tr class="trOdd">
     <td height="26">* <span class="left">Last Name</span>:</td>
     <td><input type="text" name="last_name" style="width:525px;" value="<?php echo set_value('last_name',$rwdata->last_name);?>"></td>
    </tr>
    <tr class="trOdd">
     <td height="26">* <span class="left">City</span>:</td>
     <td><input type="text" name="city" style="width:525px;" value="<?php echo set_value('city',$rwdata->city);?>"></td>
    </tr>
    <tr class="trOdd">
     <td height="26">* <span class="left">Country</span>:</td>
     <td><input type="text" name="country" style="width:525px;" value="<?php echo set_value('country',$rwdata->country);?>"></td>
    </tr>
   <?php } ?>  
    <tr class="trOdd">
     <td align="left">&nbsp;</td>
     <td align="left">
      <input type="submit" name="sub" value="Edit" class="button2" />
      <input type="hidden" name="action" value="Add">
      <input type="hidden" name="ptype" value="<?php echo $rwdata->ptype;?>">
     </td>
    </tr>
   </table>
   <?php echo form_close();?>
  </div>
 </div>
</div>
<?php $this->load->view('includes/footer');?>