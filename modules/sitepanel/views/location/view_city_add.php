<?php $this->load->view('includes/header'); ?> 
<div id="content">
 
<div class="breadcrumb"> <?php echo anchor('sitepanel/dashbord','Home'); ?>&raquo; <?php echo anchor('sitepanel/city/index/'.$stateID.'/'.$contID,'Back To Listing'); ?> &raquo;  <?php echo $heading_title; ?> </div>
<div class="box">
	<div class="left"></div>
	<div class="right"></div>
	<div class="heading"><h1 style="background-image: url('<?php echo base_url(); ?>assets/admin/image/category.png');">   <?php echo $heading_title; ?></h1></div>
	<div class="content">
	    
		<?php echo validation_message();?>
        <?php echo error_message(); ?> 
         
		<?php echo form_open('sitepanel/city/add/'.$stateID.'/'.$contID);?>  
		<div id="tab_pinfo">
			<table width="90%"  class="form"  cellpadding="3" cellspacing="3">
			<tr>
				<th colspan="2" align="right" >
					<span class="required">*Required Fields</span><br>
				 </th>
			</tr>
			<tr>
				<th colspan="2" align="center" > </th>
			</tr>
			<tr class="trOdd">
				<td width="28%" height="26" align="right" ><span class="required">*</span> City:</td>
				<td width="72%" align="left"><input type="text" name="city" size="40" value="<?php $this->input->post('city');?>"></td>
			</tr>
			<tr class="trOdd">
				<td align="left">&nbsp;</td>
				<td align="left">
					<input type="submit" name="sub" value="Add" class="button2" />
					<input type="hidden" name="action" value="addtestimonial" />
				</td>
			</tr>
			</table>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>

</div>
<?php $this->load->view('includes/footer'); ?>