<?php $this->load->view('includes/header'); ?>

<div id="content">

<div class="breadcrumb">  
<?php echo anchor('sitepanel/dashbord','Home'); ?>&raquo;
<?php echo anchor('sitepanel/newsletter_group','Back To Listing'); ?> &raquo; <?php echo $heading_title; ?>
</div>      

<div class="box">

<div class="heading">

<h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>

<div class="buttons"> &nbsp; </div>

</div>

<div class="content">

<?php error_message();validation_message(); ?>

	<?php echo form_open(current_url_query_string());?>
    
		<table class="form">
			<tr>
				<td valign="top">Group Name <span class="required">*</span></td>
				<td>
			<input type="text" name="group_name" size="40"value="<?php echo set_value('group_name',$catresult->group_name);?>">
					<?php echo form_error('group_name');?>
				</td>
			</tr>
			<tr>
				<td align="left">&nbsp;</td>
				<td align="left"><input type="submit" name="sub" value="Edit" class="button2" /> 
				<input type="hidden" name="newsletter_groups_id" value="<?php echo $catresult->newsletter_groups_id;?>">
                
				</td>
			</tr>
		</table>
	<?php echo form_close(); ?></div>
</div>
<?php $this->load->view('includes/footer');