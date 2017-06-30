<?php $this->load->view('includes/header'); ?>  
<div id="content">

<div class="breadcrumb"> <?php echo anchor('sitepanel/dashbord','Home'); ?>
&raquo;<a href="<?php echo base_url();?>sitepanel/country">Manage Country</a>
 &raquo;<?php echo $heading_title; ?> </div>
<div class="box">
	<div class="left"></div>
	<div class="right"></div>
	<div class="heading">
		<h1 style="background-image: url('<?php echo base_url(); ?>assets/admin/image/category.png');"><?php echo $heading_title; ?></h1>
		<div class="buttons" style="vertical-align:top; ">
			<?php echo anchor("sitepanel/state/add/".$contID,'<span>Add New State</span>','class="button" ' );?>
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
        
        Search(State) <input type="text" name="keyword" value="<?php echo $this->input->post('keyword');?>"  />&nbsp;
		<a  onclick="$('#myform').submit();" class="button"><span> GO </span></a>
		<input type="hidden" name="stchstatussrch" value="1"><?php if($this->input->get_post('keyword')!=''){ echo anchor("sitepanel/state/index/".$contID,'<span>Clear Search</span>'); }?></td>
		</tr>
		</table>
		<?php echo form_close();?>
		<?php
		if( is_array($res) && !empty($res) )  
		{ 
			echo form_open("sitepanel/state/change_status/".$contID,'id="myform"');?>
			<table class="list" width="100%" id="my_data">
			<thead>
			<tr>
				<td width="23" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
				<td width="145" class="left">State</td>
				<td width="128" class="left">City</td>
				<td width="74" class="right"><span class="left">Status</span></td>
				<td width="71" class="right">Action</td>
			</tr>
			</thead>
			<tbody>
			<?php 	
			foreach($res as $catKey=>$pageVal)
			{ 
				?> 
				<tr>
					<td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?=$pageVal['id'];?>" /></td>
					<td class="left"><?php echo $pageVal['region_name'];?></td>
					<td>
                   <a href="<?php echo base_url();?>sitepanel/city/index/<?php echo $pageVal['id']."/".$contID;?>"><strong>Manage Cities</strong></a>
                    </td>
					<td class="right"><?php echo ($pageVal['status']==1)? "Active":"Inactive";?></td>
					<td align="center" >
						<?php echo anchor("sitepanel/state/edit/".$contID.'/'.$pageVal['id'].query_string(),'Edit'); ?>
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
					<input name="Delete" type="submit" class="button2" id="Delete" value="Delete"  onclick="return validcheck('arr_ids[]','delete','Record');"/>
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