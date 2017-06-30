<?php $this->load->view('includes/header'); ?>
<style>
.content input[type="password"], .my_text {
    border: 1px solid #666666;
    padding: 4px !important;
    width: 250px;
}
</style>
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
				
				<?php echo form_open_multipart("sitepanel/$this->current_controller/add");?>
				<div id="tab_pinfo">
					<table width="90%"  class="form"  cellpadding="3" cellspacing="3">
						<tr>
							<th colspan="2" align="center" > </th>
						</tr>
						
						<tr class="trOdd">
								<td height="26" align="right" >Username<span class="required"> * </span>: </td>
								<td align="left"><input type="text" name="username" size="60" value="<?php echo set_value('username');?>" /></td>
						</tr>
						<tr class="trOdd">
								<td height="26" align="right" >Password<span class="required"> * </span>: </td>
								<td align="left"><input type="password" name="password" size="60" value="<?php echo set_value('password');?>" /></td>
						</tr>
						<tr class="trOdd">
								<td height="26" align="right" >Confirm Password<span class="required"> * </span>: </td>
								<td align="left"><input type="password" name="cpassword" size="60" value="<?php echo set_value('cpassword');?>" /></td>
						</tr>
						<tr class="trOdd">
					<td width="38%" height="26" align="right" ><span class="required">*</span> Subadmin Name:</td>
					<td width="62%" align="left"><input type="text" name="subadminname" size="40" value="<?php echo set_value('subadminname');?>"></td>
				</tr>
                
                <tr class="trOdd">
					<td width="38%" height="26" align="right" ><span class="required">*</span> Subadmin Email:</td>
					<td width="62%" align="left"><input type="text" name="subadminemail" size="40" value="<?php echo set_value('subadminemail');?>"></td>
				</tr>
						<tr class="trOdd">
								<td height="26" align="right" valign="top">Allocate Section: </td>
								<td align="left">
									<div style="height:400px; overflow:auto;">
										<?php						
										
										$posted_arr=($this->input->post())?$this->input->post('sec_id'):array();
										if(@is_array($section_res) && @count($section_res) > 0)
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
															?>
															<tr>
																<td width="1%"><input type="checkbox" name="sec_id[]" value="<?php echo $val['id'];?>" <?php echo (@in_array($val['id'],$posted_arr))?"checked":"";?>></td>
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
								<input type="hidden" name="action" value="addcategory" />
								<input type="submit" name="sub" value="Add" class="button2" />
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