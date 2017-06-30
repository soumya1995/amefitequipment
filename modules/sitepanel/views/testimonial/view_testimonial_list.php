<?php $this->load->view('includes/header'); ?>  
  
  <div id="content">
  
  <div class="breadcrumb">
  
       <?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> </a>   
             
   </div>      
       
 <div class="box">
 
    <div class="heading">
    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
        <div class="buttons"><?php echo anchor("sitepanel/testimonial/post","<span>Post Testimonial</span>",'class="button" ' );?></div>
      
    </div>
   
    
      
     <div class="content">
    	
	
		<?php echo form_open("sitepanel/testimonial/",'id="search_form" method="get" '); ?>
        
		<table width="100%"  border="0" cellspacing="3" cellpadding="3" >
		  <?php 
			   if(error_message() !='')
			   {	
			      echo error_message();
				  
			   }
			   ?>  
          <tr>
			<td align="center" >Search [  name] 
            
				<input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />&nbsp;				
                
			  <a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a>
				
				<?php 
				if($this->input->get_post('keyword')!='')
				{ 
				echo anchor("sitepanel/testimonial/",'<span>Clear Search</span>');
				} 
				?>
			</td>
		</tr>        
		</table>
		<?php echo form_close();?>
        
		<?php
		if(is_array($res) && ! empty($res))
		{
			
		?>
        
			<?php echo form_open("sitepanel/testimonial/",'id="data_form"');?>
            
           <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
           
			<table class="list" width="100%" id="my_data">
            
			<thead>
			  <tr>
				<td width="4%" style="text-align: center;">
                                
                <input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" />
                
                </td>
				<td width="27%" class="left">Poster </td>
				<!--td width="278" class="left">Title</td-->
				<td width="55%" class="left">Description</td>
				<td width="7%" class="right">Status</td>
				<td width="7%" class="right">Action</td>
			  </tr>
			</thead>
			<tbody>
			<?php 	
			foreach($res as $catKey=>$pageVal)
			{ 
				
				
			?> 
				<tr>
					<td style="text-align: center;">
						<input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['testimonial_id'];?>" />
					</td>
					<td class="left" valign="top">
						Name : <?php echo ucwords($pageVal['poster_name']);?>
                        <?php if($pageVal['email']!='')
						{
							
                           echo "<br />Email : ".$pageVal['email'];
                           
						
						}
						?>
					</td>
                    
					<!--td align="left"><?php echo $pageVal['testimonial_title'];?></td-->
					<td><?php echo $pageVal['testimonial_description'];?></td>
					<td class="right"><?php echo ($pageVal['status']==1)? "Active":"In-active";?></td>
					<td class="right">
					  <?php
					  if($this->editPrvg===TRUE)
					  {
					  ?>
						<?php echo anchor("sitepanel/testimonial/edit/$pageVal[testimonial_id]/".query_string(),'Edit'); ?>
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
				<td align="left"  style="padding:2px" height="35">
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
					?>
					<?php
					if($this->deletePrvg===TRUE)
					{
					?>
                    <input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onclick="return validcheckstatus('arr_ids[]','delete','Record');"/>
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
<?php $this->load->view('includes/footer'); ?>