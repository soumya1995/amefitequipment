<?php $this->load->view('includes/header'); ?> 
<?php
$country_name=get_value_from_table("wl_country","country_name",array("id"=>$contID));
$heading_title="$heading_title of $country_name";
?> 
<div id="content">

<div class="breadcrumb"> <?php echo anchor('sitepanel/dashbord','Home'); ?>&raquo; 
<a href="<?php echo base_url();?>sitepanel/country">Countries</a>
&raquo;<?php echo $heading_title; ?> </div>
<div class="box">
	<div class="left"></div>
	<div class="right"></div>
	<div class="heading">
		<h1 style="background-image: url('<?php echo base_url(); ?>assets/admin/image/category.png');"><?php echo $heading_title; ?></h1>
		<div class="buttons" style="vertical-align:top; ">
			<?php echo anchor("sitepanel/city_by_country/add/".$contID,'<span>Add New City</span>','class="button" ' );?>
		</div>
	</div>
	<script type="text/javascript">function serialize_form() { return $('#srchform').serialize();   } </script> 
	<div class="content">
		
		 
		<?php 
		echo form_open("sitepanel/city_by_country/index/".$contID,'id="myform"'); 
		?>
        
        <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
		<table width="100%"  border="0" cellspacing="3" cellpadding="3" >
			<?php 
            if(error_message() !=''){
           	 echo error_message();
            }
            ?> 
                
        <tr>
		<td align="center" >Search(City) <input type="text" class="my_text" name="keyword" value="<?php echo $this->input->post('keyword');?>"  />&nbsp;
		<a  onclick="$('#myform').submit();" class="button"><span> GO </span></a>
		<input type="hidden" name="stchstatussrch" value="1">
		<?php if( $this->input->get_post('keyword')!='' )
					 { 
					    echo anchor(current_url(),'<span>View All</span>');
					 } ?>
		</td>
		</tr>
		</table>
		<?php echo form_close();?>
		<?php
		if( is_array($res) && !empty($res) )
		{
			echo form_open("sitepanel/city_by_country/change_status/".$contID,'id="myform"');?>
			<table class="list" width="100%" id="my_data">
			<thead>
			<tr>
				<td width="33" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
				<td width="204" class="left">City</td>
				<td width="141" class="right"><span class="left">Status</span></td>
				<td width="67" class="right">Action</td>
			</tr>
			</thead>
			<tbody>
			<?php 	
			foreach($res as $catKey=>$pageVal)
			{ 
				?> 
				<tr>
					<td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?=$pageVal['id'];?>" /></td>
					<td class="left"><?php echo $pageVal['city_name'];?></td>
					<td class="right"><?php echo ($pageVal['status']==1)? "Active":"In-active";?></td>
					<td align="right" >
						<?php echo anchor("sitepanel/city_by_country/edit/".$contID.'/'.$pageVal['id'].query_string(),'Edit'); ?>
					</td>
				</tr>
			<?php
			}		   
			?> 
			<tr><td colspan="7" align="right" height="30"><?php echo $page_links; ?></td></tr>     
			</tbody>
			<tr>
				<td height="35" colspan="7" align="left" style="padding:2px">
					<input name="Activate" type="submit"  value="Activate" class="button2" id="Activate" onclick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
					<input name="Deactivate" type="submit" class="button2" value="Deactivate" id="Deactivate"  onclick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
					<input name="Delete" type="submit" class="button2" id="Delete" value="Delete"  onclick="return validcheckstatus('arr_ids[]','Delete','Record','u_status_arr[]');"/>
				</td>
			</tr>
			</table>
			<?php
			echo form_close();
		}else
		{
			echo "<center><strong> No record(s) found !</strong></center>" ;
		}
		?> 
	</div>
</div>

</div>
<?php $this->load->view('includes/footer'); ?>