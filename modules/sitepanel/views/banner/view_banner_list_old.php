<?php $this->load->view('includes/header'); ?>  
 
  <div id="content">
  
  <div class="breadcrumb">
  
       <?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> </a>   
             
   </div>      
       
 <div class="box">
 
    <div class="heading">
    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
      <div class="buttons"> <?php echo anchor("sitepanel/banners/add/",'<span>Add Banner</span>','class="button" ' );?> </div>
      
    </div>
   
    
	<div class="content">
		    <?php 
                if(error_message() !=''){
               	   echo error_message();
                }
                ?> 	
                
		<?php echo form_open("sitepanel/banners/",'id="form" method="get" '); ?>
        
         <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
          
		<table width="100%"  border="0" cellspacing="3" cellpadding="3" >
		<tr>
			<td align="center" >Search [ Banner Position ]
				<input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />&nbsp;
				<a  onclick="$('#form').submit();" class="button"><span> GO </span></a>
			
				<?php 
				if($this->input->get_post('keyword')!=''){ 
					echo anchor("sitepanel/banners/",'<span>Clear Search</span>');
				} 
				?>
			</td>
		</tr>
		</table>
		<?php echo form_close();?>
		<?php
		$pagesection = $this->config->item('bannersections'); 
		 $j=0;
		if( is_array($res) && !empty($res) )
		{
			echo form_open("sitepanel/banners/",'id="myform"');
			?>
			<table class="list" width="100%" id="my_data">
			<thead>
			<tr>
				<td width="20" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
				<td width="145" class="left">Banner Position</td>
				<!--<td width="145" class="left">Section</td>-->
				<td width="202" class="center">Banner Picture</td>
				<td width="134" class="center">Status</td>
				<td width="148" class="center">Action</td>
			</tr>
			</thead>
			<tbody>
			<?php 	
			$atts = array(
											'width'      => '740',
											'height'     => '600',
											'scrollbars' => 'yes',
											'status'     => 'yes',
											'resizable'  => 'yes',
											'screenx'    => '0',
											'screeny'    => '0'
									 );
		foreach($res as $catKey=>$pageVal)
		{ 
		?> 
			<tr>
				<td style="text-align: center;">
					<input type="checkbox" name="arr_ids[]" value="<?=$pageVal['banner_id'];?>" />
				</td>
				<td class="left"><?php echo $pageVal['banner_position'];?></td>
				<!--<td class="left"><?php echo (array_key_exists($pageVal['banner_page'],$pagesection) ? $pagesection[$pageVal['banner_page']] : "-");?></td>-->
				<td align="center">
                
         <?php
		 $j=1;
		 $product_path = "banner/".$pageVal['banner_image'];
		?>
         <a href="#"  onclick="$('#dialog_<?php echo $pageVal['banner_id'];?>').dialog({width:'auto'});">View Banner </a>
         <div id="dialog_<?php echo $pageVal['banner_id'];?>" title="Banner Image" style="display:none;">
         <img src="<?php echo base_url().'uploaded_files/'.$product_path;?>"  /> </div>					
				</td>
				<td class="center"><?php echo ($pageVal['status']==1)? "Active":"In-active";?></td>
				<td align="center" >  
				  <?php
				  if($this->editPrvg===TRUE)
				  {
				  ?>
					<?php echo anchor("sitepanel/banners/edit/$pageVal[banner_id]/".query_string(),'Edit'); ?>						  <?php
				  }
				  ?>
					
				</td>
			</tr>
		<?php
		$j++;
		}		   
		?> 
		</tbody>
		</table>
		<?php
		if($page_links!='')
		{
		?>
		  <table class="list" width="100%">
		  <tr><td align="right" height="30"><?php echo $page_links; ?></td></tr>     
		  </table>
		<?php
		}
		?>
		<table class="list" width="100%">
		<tr>
			<td align="left" style="padding:2px" height="35">
				<?php
				if($this->activatePrvg===TRUE)
				{
				?>
				  <input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onClick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
				<?php
				}
				if($this->deactivatePrvg===TRUE)
				{
				?>
				<input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
				<?php
				}
				if($this->deletePrvg===TRUE)
				{
				?>
				  <input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/>
				<?php
				}
				?>
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
<?php $this->load->view('includes/footer'); ?>