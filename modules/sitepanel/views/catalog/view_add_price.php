<?php $this->load->view('includes/face_header');  
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/developers/js/common.js"></script>
<?php
echo validation_message();
echo error_message();
$type = $this->uri->segment(4);
echo form_open("sitepanel/products/addservice/".$this->uri->segment(4)."/".$this->uri->segment(5).query_string(),'id="myform"');?>
<div>
<table width="300" align="left" cellpadding="1" cellspacing="1" class="list" style="margin-top:10px;">
 <thead>
  <tr><td colspan="4" height="30"><?php echo $heading_title; ?>	</td></tr>
 </thead>
 <tr><td colspan="4" align="center"><font color="#FF0000"><strong><?php echo $this->session->flashdata('message');?></strong> </font> </td></tr>
 

 </table> 
</div>
<div id="pattr1" <?php if($type == 'W'){?> style="display:block;" <?php }else{ ?> style="display:none;" <?php } ?> > 
 <table width="300" align="left" cellpadding="1" cellspacing="1" class="list">
     <tr class="trOdd">
      <td width="38%" height="26" align="right" ><span class="required">*</span> Warranty:</td>
      <td width="62%" align="left">
      <select name="pattr_id1" id="pattr_id1" style="padding:3px;" class="" onchange="return put_type_id(this.value);">
        <option value="">Select Warranty</option> 
        <?php
          foreach($warranty as $val){
             
              ?>
              <option value="<?php echo $val['warranty_id'];?>" <?php if(set_value('type_id')==$val['warranty_id']){?> selected="selected" <?php } ?>><?php echo $val['title']." ".display_price($val['price']);?></option>
              <?php
          }?>
      </select>  
      </td>
     </tr>
  </table>  
</div> 
<div  id="pattr2" <?php if($type == 'P'){?> style="display:block;" <?php }else{ ?> style="display:none;" <?php } ?>>
 <table width="300" align="left" cellpadding="1" cellspacing="1" class="list">
     <tr class="trOdd">
      <td width="38%" height="26" align="right" ><span class="required">*</span> Package:</td>
      <td width="62%" align="left">
      <select name="pattr_id2" id="pattr_id2" style="padding:3px;" class="" onchange="return put_type_id(this.value);">
        <option value="">Select Package</option> 
        <?php
          foreach($package as $val){
             
              ?>
              <option value="<?php echo $val['package_id'];?>" <?php if(set_value('type_id')==$val['package_id']){?> selected="selected" <?php } ?>><?php echo $val['title']." ".display_price($val['price']);?></option>
              <?php
          }?>
      </select>  
      </td>
     </tr>     
  </table> 
</div>
<div> 
 <table width="300" align="left" cellpadding="1" cellspacing="1" class="list">
 <?php /*?><tr class="trOdd">
  <td width="38%" height="26" align="right" ><span class="required">*</span> Stock:</td>
  <td width="62%" align="left"><input type="text" name="quantity" size="20" maxlength=8 value="<?php echo set_value('quantity');?>"> Maximum of 5 digits</td>
 </tr><?php */?>

 <tr class="trOdd">
  <td align="left" width="38%" height="26" align="right">&nbsp;</td>
  <td align="left" width="62%" align="left">   
   <input type="hidden" name="action" value="add" />
    <input type="hidden" name="type" value="<?php echo $type;?>" />
   <input type="hidden" name="type_id" id="type_id" value="">    
   <input type="submit" name="sub" value="Add" class="button2" />  
  </td>
 </tr>
</table>
</div>
<?php echo form_close();?>
</body>
</html>