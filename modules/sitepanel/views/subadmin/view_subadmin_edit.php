<?php $this->load->view('includes/header'); ?>  
<?php $admin_type = is_array($this->input->post()) ? $this->input->post('admin_type') : $result['admin_type'];?>
<div class="content">
    <div id="content">
  <div class="breadcrumb">
       <?php echo anchor('sitepanel/dashbord','Home'); ?>
        &raquo; <?php echo $heading_title; ?> </a>
        
      </div>
      
      <div class="box">
    <div class="heading">
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
      <div class="buttons">
	   <a href="javascript:void(0);" onclick="history.back();" class="button">Cancel</a>  
	</div>
      
    </div>
    <div class="content">
    	    
	<?php echo validation_message();?>
    <?php echo error_message(); ?>  
    
	<?php echo form_open("sitepanel/subadmin/edit/".$result['admin_id']);?>  
		<div id="tab_pinfo">
			<table width="90%"  class="form"  cellpadding="3" cellspacing="3">
			<tr>
				<th colspan="2" align="center" > </th>
			</tr>
			<tr class="trOdd">
				<td width="28%" height="26" align="right" ><span class="required">*</span> Group</td>
				<td width="72%" align="left">
				<select name="admin_type">
				  <option value="">Type</option>
				  <?php
				  foreach($this->config->item('admin_groups') as $key=>$val)
				  {
				  ?>
					<option value="<?php echo $key;?>" <?php echo $admin_type==$key ? 'selected="selected"' : '';?>><?php echo $val;?></option>
				  <?php
				  }
				  ?>
				 </select>
				</td>
			</tr>
			<tr class="trOdd">
				<td width="28%" height="26" align="right" ><span class="required">*</span> Email</td>
				<td width="72%" align="left"><input type="text" name="admin_email" size="40" value="<?php echo set_value('admin_email',$result['admin_email']);?>"></td>
			</tr>
			<tr class="trOdd">
				<td width="28%" height="26" align="right" ><span class="required">*</span> Username</td>
				<td width="72%" align="left"><input type="text" name="admin_username" size="40" value="<?php echo set_value('admin_username',$result['admin_username']);?>"></td>
			</tr>
			<tr class="trOdd">
				<td width="28%" height="26" align="right" ><span class="required">*</span> Password</td>
				<td width="72%" align="left"><input type="password" name="admin_password" size="40" value="<?php echo set_value('admin_password',$result['admin_password']);?>"></td>
			</tr>
        
			<tr class="trOdd">
				<td align="left">&nbsp;</td>
				<td align="left">
					<input type="hidden" name="admin_id" value="<?php echo $result['admin_id'];?>">
					<input type="submit" name="sub" value="Update" class="button2" />
					<input type="hidden" name="action" value="update" />
                </td>
			</tr>
			</table>
		</div>
	<?php echo form_close(); ?>
	</div>
</div>

<?php $this->load->view('includes/footer'); ?>