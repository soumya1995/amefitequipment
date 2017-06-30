<?php $this->load->view("includes/face_header"); ?>
<?php echo form_open(); ?>
<table width="100%" align="center" cellpadding="0" cellspacing="0" class="list">
        
<tr>
  <td colspan="4" align="left">
    
    <?php echo validation_message();?>
    <?php echo error_message(); ?></td>
  </tr>
  
   <tr>
     <td colspan="4" style="padding:10px;"><strong>Message Detail:</strong></td>
   </tr>
   <tr>
     <td width="82%" style="padding:10px;"><?php echo nl2br($message->message)?></td>
     <td width="18%" colspan="3" style="padding:10px;"><span style="float:right;"><?php echo getDateFormat($message->created_at,1)?></span></td>
   
  </tr>
  
 </table>
 <table width="100%" align="center" cellpadding="0" cellspacing="0" class="list">
  <?php 
  	if(!empty($rmessage))
	{
	  foreach($rmessage as $key=>$val)
	  {
			?>
  <tr>
    <td  width="72%"  style="padding:10px;">
    <div class="red b">
    <?php 
    	echo ($val->sender_id==0)?"Admin Reply":"";
    ?>
    </div>
    <?php echo $val->message_reply;?></td>
    <td width="18%"style="padding:10px;"><span style="float:right;"><?php echo getDateFormat($val->posted_date,1);?></span></td>
    <td width="10%" colspan="2" style="padding:10px;"><a href="<?php echo base_url();?>sitepanel/members/del_message/<?php echo $this->uri->segment(4);?>/<?php echo $val->id;?>" onclick="return confirm('Are you sure to delete this message');">Delete</a></td>
  </tr>
  <?php }}else
  {?>
  <tr>

    <td colspan="4" align="center" style="padding:10px;"><strong>No Reply found.</strong></td>
  </tr>
  <?php }?>
</table>
<?php echo form_close(); ?>
</body>
</html>
