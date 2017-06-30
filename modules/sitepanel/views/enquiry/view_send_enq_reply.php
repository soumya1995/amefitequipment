<?php $this->load->view("includes/face_header"); ?>
<?php echo form_open('sitepanel/enquiry/send_reply/'.$this->uri->segment(4)); ?>
<table width="100%" align="center" cellpadding="0" cellspacing="0">
        
<tr><td colspan="2" align="left">

<?php echo validation_message();?>
 <?php echo error_message(); ?>
</td>
  </tr>
  <tr>
    <td  style="padding:10px;"><strong>Subject* : </strong></td>
    <td   style="padding:10px;">
      <label>
        <input type="text" name="subject" id="textfield"  value="<?php echo set_value('subject');?>" />
      </label>
   </td>
  </tr>
  <tr>
    <td style="padding:10px;"><strong>Message* : </strong></td>
    <td style="padding:10px;">
      <label>
        <textarea name="message" id="textarea" cols="45" rows="5"><?php echo set_value('message');?></textarea>
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
