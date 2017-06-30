<?php $this->load->view("includes/face_header"); $order_id = (int) $this->uri->segment(4);?>
<?php echo form_open(); ?>
<table width="100%" align="center" cellpadding="0" cellspacing="0">
        
<tr><td colspan="2" align="left">

<?php echo validation_message();?>
 <?php echo error_message(); ?>
</td>
  </tr>
  <tr>
    <td  style="padding:10px;"><strong>Comment* : </strong></td>
    <td   style="padding:10px;">
      <label>
       <textarea name="comments" id="comments" style="width:300px;height:70px;" ><?php echo set_value('comments',$comments);?></textarea>
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
