<?php $this->load->view('includes/header'); ?> 
<?php
//$rwstate=(array)get_db_single_row("wl_state","region_name,country_id",array("id"=>$stateID));

?> 
<div id="content">

<div class="breadcrumb"> <?php echo anchor('sitepanel/dashbord','Home'); ?>&raquo;<a href="<?php echo base_url();?>sitepanel/country">Manage Country</a>&raquo;<a href="<?php echo base_url();?>sitepanel/state/index/<?php echo $contID;?>">Manage State</a>
 &raquo;<?php echo $heading_title; ?> </div>
<div class="box">
	<div class="left"></div>
	<div class="right"></div>
	<div class="heading">
		<h1 style="background-image: url('<?php echo base_url(); ?>assets/admin/image/category.png');"><?php echo $heading_title; ?></h1>
		<div class="buttons" style="vertical-align:top; ">
			<?php echo anchor("sitepanel/city/add/".$stateID."/".$contID,'<span>Add New City</span>','class="button" ' );?>
		</div>
	</div>
	<script type="text/javascript">function serialize_form() { return $('#srchform').serialize();   } </script> 
	<div class="content">
		<div class="required">                        
                <strong> Total Record(s) Found : <?php echo $total_rec; ?></strong>  
         </div>
		 
		<?php 
		echo form_open("",'id="myform"'); 
		?>
		<table width="100%"  border="0" cellspacing="3" cellpadding="3" >
			<?php 
            if(error_message() !=''){
           	 echo error_message();
            }
            ?> 
                
        <tr>
		<td align="center" >
        <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
        Search(City) <input type="text" name="keyword" value="<?php echo $this->input->post('keyword');?>"  />&nbsp;
		<a  onclick="$('#myform').submit();" class="button"><span> GO </span></a>
		<input type="hidden" name="stchstatussrch" value="1">
				<?php if($this->input->get_post('keyword')!=''){ echo anchor("sitepanel/city/index/".$stateID."/".$contID,'<span>Clear Search</span>'); }?></td>
		</tr>
		</table>
		<?php echo form_close();?>
		<?php
		if( is_array($res) && !empty($res) )
		{ 
			echo form_open("sitepanel/city/change_status/".$stateID."/".$contID.query_string(),'id="data_form"');?>
			<table class="list" width="100%" id="my_data">
			<thead>
			<tr>
				<td width="33" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
				<td width="204" class="left">City</td>
				<!--<td width="141" class="left">Location/Zip Code</td>-->
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
					<td class="left">
					<?php 
					echo $pageVal['city_name']; 
					/*if($pageVal['is_fetaured']!="" && $pageVal['is_fetaured']!='0')
				    echo "<br /><b>Top Destinations  : </b> Yes";*/
					?>
                    </td>
					<!--<td class="left"><a href="<?php echo base_url();?>sitepanel/zip_location/index/<?php echo $contID;?>/<?php echo $pageVal['id'];?>"><strong>Location/Zip Code</strong></a></td>-->
					<td class="right"><?php echo ($pageVal['status']==1)? "Active":"In-active";?></td>
					<td align="right" >
						<?php echo anchor("sitepanel/city/edit/".$stateID."/".$contID."/".$pageVal['id'].query_string(),'Edit'); ?>
					</td>
				</tr>
			<?php
			}		   
			?> 
			<tr><td colspan="8" align="right" height="30"><?php echo $page_links; ?></td></tr>     
			</tbody>
			<tr>
				<td height="35" colspan="8" align="left" style="padding:2px">
					<input name="Activate" type="submit"  value="Activate" class="button2" id="Activate" onclick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
					<input name="Deactivate" type="submit" class="button2" value="Deactivate" id="Deactivate"  onclick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
					<input name="Delete" type="submit" class="button2" id="Delete" value="Delete"  onclick="return validcheck('arr_ids[]','delete','Record');"/>
                    
                    <?php /*if($this->featuredPrvg === TRUE){
					   echo form_dropdown("set_as",$this->config->item('city_set_as_config'),$this->input->post('set_as'),'style="width:120px;" onchange="return onclickgroup()"');
					   echo form_dropdown("unset_as",$this->config->item('city_unset_as_config'),$this->input->post('unset_as'),'style="width:120px;" onchange="return onclickgroup()"');
				   }*/?>
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
<script type="text/javascript">
function onclickgroup(){
	if(validcheckstatus('arr_ids[]','set','record','u_status_arr[]')){
		$('#data_form').submit();
	}
}
</script>
<?php $this->load->view('includes/footer'); ?>