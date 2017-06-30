<?php $this->load->view('includes/header'); ?>
<?php

$values_posted_back=(is_array($this->input->post())) ? TRUE : FALSE;

?>  
 <div id="content">
  <div class="breadcrumb">
       <?php echo anchor('sitepanel/dashbord','Home'); ?>
        &raquo; <?php echo anchor('sitepanel/gym_packages'.($catresult['parent_id']==0 ? '' : '/index/'.$catresult['parent_id']),'Back To Listing'); ?> &raquo; <?php echo $heading_title; ?> </a>
        
      </div>
      
      <div class="box">
    <div class="heading">
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/gym_packages.png" alt="" /> <?php echo $heading_title; ?></h1>
      
     <div class="buttons"><?php echo anchor("sitepanel/gym_packages/",'<span>Cancel</span>','class="button" ' );?></div>
      
    </div>
    
    <div class="content">
       
	<?php echo validation_message(); echo error_message(); ?>  
    
	<?php echo form_open_multipart(current_url_query_string(),array('id'=>'catfrm','name'=>'catfrm'));?>  
		<div id="tab_pinfo">
			<table width="90%"  class="form"  cellpadding="3" cellspacing="3">
			<tr>
				<th colspan="2" align="center" > </th>
			</tr>
			<?php
			$default_params = array(
							'heading_element' => array(
													  'field_heading'=>"Gym Packages Title",
													  'field_name'=>"gym_packages_name",
													  'field_value'=>$catresult['gym_packages_name'],
													  'field_placeholder'=>"Your Title",
													  'exparams' => 'size="40"'
													),
							'url_element'  => array(
													  'field_heading'=>"Page URL",
													  'field_name'=>"friendly_url",
													  'field_value'=>$catresult['friendly_url'],			  
													  'field_placeholder'=>"Your Page URL",
													  'exparams' => 'size="40"',
												   )

						  );
			seo_edit_form_element($default_params);
			
			?>
			<?php /*?><tr class="trOdd">
				<td width="28%" height="26" align="right" >Image :</td>
				<td align="left">
					<input type="file" name="gym_packages_image" />
					<?php
					if($catresult['gym_packages_image']!='' && file_exists(UPLOAD_DIR."/gym_packages/".$catresult['gym_packages_image']))
					{ 
					?>
						 <a href="#"  onclick="$('#dialog').dialog({width:'auto',height:'auto'});">View</a>
					<?php if($this->deletePrvg===TRUE){?> | <input type="checkbox" name="cat_img_delete" value="Y" />Delete <?php } ?>
                        
					<?php	
					}
					?>
					<br />
                    <br />
					[ <?php echo $this->config->item('gym_packages.best.image.view');?> ]
					<div id="dialog" title="gym_packages Image" style="display:none;">
					<img src="<?php echo base_url().'uploaded_files/gym_packages/'.$catresult['gym_packages_image'];?>"  />						</div>
				  <?php echo form_error('gym_packages_image');?>
				</td>
			</tr>
			<tr class="trOdd">
				<td width="28%" height="26" align="right" >Alt :</td>
				<td align="left">
					<input type="text" name="gym_packages_alt" value="<?php echo set_value('gym_packages_alt',$catresult['gym_packages_alt']);?>" />
					<br />
				</td>
			</tr>
            <?php */?>
            <tr class="trOdd">
                <td width="28%" height="26" align="right" > Description :</td>
                <td>
               <textarea name="gym_packages_description" rows="5" cols="50" id="cat_desc" ><?php echo set_value('gym_packages_description',$catresult['gym_packages_description']);?></textarea><?php  echo display_ckeditor($ckeditor); ?>
                </td>
            </tr>
            
			<tr class="trOdd">
				<td align="left">&nbsp;</td>
				<td align="left">
					<input type="submit" name="sub" value="Update" class="button2" />
					<input type="hidden" name="action" value="editgym_packages" />
					<input type="hidden" name="gym_packages_id" id="pg_recid" value="<?php echo $catresult['gym_packages_id'];?>">
				</td>
			</tr>
			</table>
		</div>
	<?php echo form_close(); ?>
	</div>
</div>
<?php $this->load->view('includes/footer'); ?>