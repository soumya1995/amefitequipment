<?php $this->load->view("includes/face_header"); ?>
<?php echo form_open(); ?>
<table width="100%" align="center" cellpadding="0" cellspacing="0">
        
<tr><td colspan="2" align="left">

<?php echo validation_message();?>
 <?php echo error_message(); ?>
</td>
  </tr>
  <tr>
    <td  style="padding:10px;"><strong>Seller Commission* : </strong></td>
    <td   style="padding:10px;">
      <label>
       <input type="text" name="seller_commission" id="seller_commission"  value="<?php echo set_value('seller_commission');?>" />
      </label>
   </td>
  </tr>
 
  <tr>
    <td style="padding:10px;">&nbsp;</td>
    <td style="padding:10px;">
      <label>
        <input type="submit" name="button" id="button" value="Submit" />
      </label>
  </td>
  </tr>
</table>
<?php echo form_close(); ?>
</body>
</html>
