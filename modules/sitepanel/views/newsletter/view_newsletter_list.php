<?php $this->load->view('includes/header'); ?>  

<div id="content">
  
  <div class="breadcrumb">
  
      <?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> 
             
   </div>      
       
 <div class="box">
 
    <div class="heading">
    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
      <div class="buttons"> <?php echo anchor("sitepanel/newsletter/add/",'<span>Add Newsletter Subscriber</span>','class="button" ' ); ?></div>
      
    </div>
      
     <div class="content">     
	
  
  <?php error_message(); ?>
     <?php echo form_open("sitepanel/newsletter/",'id="search_form" method="get" ');?>
      <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
      
			<table width="100%"  border="0" cellspacing="3" cellpadding="3" >
				<tr>
					<td align="center" >Search [email, name ]
				<input type="text" name="keyword" value="<?php echo set_value('keyword',$this->input->get_post('keyword'));?>"  />&nbsp;					
					
						<?php 
							//echo $this->newsletter_group_model->group_drop_down('newsletter_groups_id',$this->input->get_post('newsletter_groups_id'),'',"Select");
						?>
						<a onclick="$('#search_form').submit();" class="button"><span> GO </span></a>
						<?php 
							if($this->input->get_post('keyword')!='' || $this->input->get_post('newsletter_groups_id')!=""){ 
					    		echo anchor("sitepanel/newsletter/",'<span>View All</span>');
					   	} 
					   ?>
					</td>
				</tr>
			</table>
		<?php 
			echo form_close();
     		if( count($pagelist) > 0 ){ 
     		 	echo form_open("sitepanel/newsletter/change_status/",'id="data_form"');
     		 	?>
			  <table class="list" width="100%" id="my_data">     
		        <thead>
		          <tr>
		            <td width="20" style="text-align: center;">
                    
                    <input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" />
                    
		            	<input type="hidden" name="add_group" id="add_group" value="" />
					 	<input type="hidden" name="keyword"  value="<?php echo set_value('keyword',$this->input->post('keyword'));?>" />
					 	<input type="hidden" name="ngroup_id" value="<?php echo $this->input->post('ngroup_id')?>" />
		            </td>
		            <td width="180" class="left">Name</td>
						<td class="left">Email</td>
						<td width="63" class="left" align="right">Status</td>
						<td width="63" class="left" align="right">Action</td>
		          </tr>
		        </thead>				
		        <tbody>
		        <?php 		
					foreach($pagelist as $catKey=>$pageVal)
					{
						$group_name=$this->newsletter_model->get_group_email($pageVal['subscriber_id']);
						
				  	 	?> 
		          	<tr>
		            	<td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['subscriber_id'];?>" /></td>
		            	<td class="left"><?php echo $pageVal['subscriber_name'];?></td>
							<td style="line-height:20px">
								<?php echo $pageVal['subscriber_email'];?>
                                
                                <?php 
								/*if($group_name!='')
								{
								  echo '<div class="required  b">Groups : '.$group_name.'</div>';
								}*/
								?>
							</td>	
							<td class="left"><?php echo ($pageVal['status']==1)?"Active":"In-active";?></td>
							<td class="right">
							  <?php
							  if($this->editPrvg===TRUE)
							  {
							  ?>
							  [ <?php echo anchor("sitepanel/newsletter/edit/$pageVal[subscriber_id]/".query_string(),'Edit ');?> ]
							  <?php
							  }
							  ?>
							</td>
		          	</tr>
                    
		         	<?php
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
							if($this->newslettermailPrvg)
							{
							?>
							  <input name="Send" type="submit"  value="Send Email" class="button2" id="Activate" onClick="return validcheckstatus('arr_ids[]','Send Email','Record','u_status_arr[]');"/>
                            <?php
							}
							if($this->deletePrvg===TRUE)
							{
							?>
							<input name="Delete" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/>
							<?php
							}
							
							if($this->featuredPrvg===TRUE)
							{
							?>
							<?php 
								//echo $this->newsletter_group_model->group_drop_down('group_id',$this->input->post('group_id'),'style="width:150px;" class="button2" onchange="return onclickgroup(1)"',"Select");
								
								//echo $this->newsletter_group_model->group_drop_down('ugroup_id',$this->input->post('ugroup_id'),'style="width:150px;" class="button2"  onchange="return onclickgroup(2)"',"Unselect");
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
<script type="text/javascript">	
	$('#add_group').val(0);
	function onclickgroup(v){
		if(validcheckstatus('arr_ids[]','Group','Record','u_status_arr[]')){
			$('#add_group').val(v);
			$('#data_form').submit();
		}
	}	
</script>
<?php $this->load->view('includes/footer');