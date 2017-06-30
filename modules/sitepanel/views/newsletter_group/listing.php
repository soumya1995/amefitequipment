<?php $this->load->view('includes/header'); ?>
    
 <div id="content">
  
  <div class="breadcrumb">
  
      <?php
		echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title;
		$pagesize=$this->input->post('pagesize');
	?>
             
   </div>      
       
 <div class="box">
 
    <div class="heading">
    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
     <div class="buttons" style="vertical-align: top;"><?php 
				echo anchor("sitepanel/newsletter_group/send_mail/",'<span>Send Mail</span>','class="button" ' );
				echo anchor("sitepanel/newsletter_group/add/",'<span>Add Newsletter Group </span>','class="button" ' );
			?>
		</div>
      
    </div>   
    
  
     <div class="content">
              
		<?php
			echo error_message();
			echo form_open("sitepanel/newsletter_group",'id="search_form" method="get" ');?>
				<table width="400" border="0" align="center" cellspacing="3" cellpadding="3">
					<tr>
                    <td align="center"> Search [ Group name ]  
                      <input type="text" name="keyword" value="<?php echo set_value('keyword',$this->input->get_post('keyword'));?>" />&nbsp; 
						<a onclick="$('#search_form').submit();" class="button"><span> GO </span></a> 
                        
						<?php if($this->input->get_post('keyword')!='')
						{
							echo anchor("sitepanel/newsletter_group/",'<span>Clear Search</span>');
						} 
						?>
						</td>
					</tr>
				</table>
				<?php 
				echo form_close();			
			 if( is_array($res) && !empty($res) )
			 {
				echo form_open("sitepanel/newsletter_group/change_status/",'id="data_form"');?>
				<input type="hidden" name="keyword" value="<?php echo set_value('keyword',$this->input->post('keyword'));?>">
				<table class="list" width="100%" id="my_data"><thead>
					<tr>
						<td width="20" style="text-align: center;">
							<?php if($this->deletePrvg===TRUE){?><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /><?php } ?>
						</td>
						<td width="300" class="left">Group Name</td>
                        <td width="83" class="right">Action</td>
					</tr>
					</thead>
					<tbody>
					<?php
						$css='';$sl=0;
						foreach($res as $catKey=>$pageVal)
						{
							$css = ($css=='trEven')?'trOdd':'trEven';
							$sl++;
							?>
							<tr class="<?php echo $css;?>">
								<td style="text-align: center;"><?php if($this->deletePrvg===TRUE){?><input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['newsletter_groups_id'];?>" /><?php } ?></td>
								<td class="left" valign="top"><strong><?php echo $pageVal['group_name']; ?></strong>&nbsp;
									(<span class="red b">
									<?php 
										echo $this->newsletter_group_model->count_records($pageVal['newsletter_groups_id']);
									?></span>)
								</td>
								<!--<td class="right"><?php echo ($pageVal['status']==1)?"Active":"Inactive";?></td>
								--><td class="right">
									<?php
									if($this->editPrvg===TRUE)
									{
									?>
									  [<?php  echo anchor("sitepanel/newsletter_group/edit/$pageVal[newsletter_groups_id]/".query_string(),'Edit');?>]
									<?php
									}
									?>
								</td>
							</tr>
						<?php }	?>
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
							<tr><td align="left"  style="padding: 2px" height="35">
								<?php
								if($this->deletePrvg===TRUE)
								{
								?>
								<input name="Delete" type="submit" class="button2" id="Delete" 	value="Delete"
									onClick="return validcheckstatus('arr_ids[]','delete','Record');" />
								<?php
								}
								?>
								</td>
							</tr>
						  </table>
				<?php
				echo form_close();
			}else{					
				echo "<center><strong> No record(s) found !</strong></center>" ;
			}
			?>
		</div>
</div>
<?php $this->load->view('includes/footer');