<?php $this->load->view('includes/header');?>
<div class="content">
	<div id="content">
		<div class="breadcrumb">
			<?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> </a>
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
				
				<?php echo form_open_multipart("sitepanel/$this->current_controller/edit/".$prodresult->admin_id);?>
				<div id="tab_pinfo">
					<table width="90%"  class="form"  cellpadding="3" cellspacing="3">
						<tr>
							<th colspan="2" align="center" > </th>
						</tr>
				<tr class="trOdd">
					<td width="38%" height="26" align="right" ><span class="required">*</span> Username:</td>
					<td width="62%" align="left"><input type="text" name="username" size="40" value="<?php echo set_value('username',$prodresult->admin_username);?>"></td>
				</tr>
				<tr class="trOdd">
					<td width="38%" height="26" align="right" ><span class="required">*</span> Password:</td>
					<td width="62%" align="left"><input type="text" name="password" size="40" value="<?php echo set_value('password',$prodresult->admin_password);?>"></td>
				</tr>
                
                <tr class="trOdd">
					<td width="38%" height="26" align="right" ><span class="required">*</span> Subadmin Name:</td>
					<td width="62%" align="left"><input type="text" name="subadminname" size="40" value="<?php echo set_value('subadminname',$prodresult->contact_person);?>"></td>
				</tr>
                
                <tr class="trOdd">
					<td width="38%" height="26" align="right" ><span class="required">*</span> Subadmin Email:</td>
					<td width="62%" align="left"><input type="text" name="subadminemail" size="40" value="<?php echo set_value('subadminemail',$prodresult->admin_email);?>"></td>
				</tr>
				
				<tr class="trOdd">
					<td height="26" align="right" valign="top">Allocate Section: </td>
					<td align="left">
						<div style="height:200px; overflow-y:scroll;">
							<?php
							if(is_array($section_res) && count($section_res) > 0)
							{
								foreach($section_res as $value)
								{
									?>
									<div><b><?php echo $value['section_title'];?></b></div>
									<?php
									$sub_section_res=get_section_data($this->admin_id,$this->admin_type,$value['id']);
									if(is_array($sub_section_res) && count($sub_section_res) > 0)
									{
										?>
										<div style="border:1px solid #f2f2f2;">
										<table width="65%" cellspacing="0" cellpadding="5" border="0">
											<?php
											foreach($sub_section_res as $val)
											{
												$secidarr = ($this->input->post())?$this->input->post('sec_id'):$allocated_secid_arr;
												?>
												<tr>
													<td width="1%"><input type="checkbox" name="sec_id[]" value="<?php echo $val['id'];?>" <?php echo (in_array($val['id'],$secidarr))?"checked":"";?>></td>
													<td width="95%" align="left"><?php echo $val['section_title'];?></td>
												</tr>
												<?php
											}
											?>
										
										</table>
										</div>
										<?php
									}
								}
							}
							?>
						</div>
					</td>
				</tr>					
				
				<tr class="trOdd">
					<td align="left">&nbsp;</td>
					<td align="left">
						<input type="submit" name="sub" value="Update" class="button2" />
						<input type="button" name="sub" value="Cancel" class="button2" onclick="window.location.href='<?php echo base_url();?>sitepanel/<?php echo $this->current_controller;?>';"/>
						<input type="hidden" name="action" value="editproduct" />
						<input type="hidden" name="id" value="<?php echo $prodresult->admin_id;?>">
					</td>
				</tr>
					</table>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
		
	</div>
</div>	
<?php $this->load->view('includes/footer'); ?>