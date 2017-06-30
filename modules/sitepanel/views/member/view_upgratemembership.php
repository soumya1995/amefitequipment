<?php $this->load->view('includes/face_header'); ?>
<table width="100%" border="0" cellspacing="4" cellpadding="0" class="grey">
    <tr valign="top" >
    	 <td>
     <?php echo form_open_multipart("sitepanel/members/upgratemembership/".$memID);
	      echo validation_message();
	 ?>    
          <table width="100%"  border="0" cellspacing="2" cellpadding="2">
				<tr align="left" bgcolor="#1588BB" class="white">
					<td colspan="2" bgcolor="#CCCCCC" ><strong> Add/Upgrate Membership : </strong></td>
				</tr>
				<tr valign="top" >
					<td width="19%" align="left" ><strong>  Membership Type : </strong></td>
					<td width="25%" align="left" >
                    <select name="memship">
                       <option value="">Select Membership</option>
                  <?php if(is_array($rwmemsp) && count($rwmemsp) > 0 ){
					     foreach($rwmemsp as $memspVal){
					   ?>
                        <option value="<?php echo $memspVal['memship_id'];?>" <?php if($this->input->post('memship')==$memspVal['memship_id']){ echo "Selected";}?>><?php echo $memspVal['memship_type'];?></option> 
                  <?php }
				  }
				   ?>     
                    </select>
                    </td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" name="submit1" value="Add">
                    <input type="hidden" name="action" value="Add">
                    </td>
				</tr>
			</table>
       <?php echo form_close();?>     
        </td>
    </tr>
</table>
</body>
</html>    