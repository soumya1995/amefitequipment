<?php $this->load->view('includes/header'); ?>  
  <div id="content">
  
  <div class="breadcrumb">
  
       <?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> </a>   
             
   </div>      
       
 <div class="box">
 
    <div class="heading">
    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
      <div class="buttons">  <?php echo anchor("sitepanel/shipping/add_shipping/",'<span>Add Shipping</span>','class="button" ' );?></div>
      
    </div>
      
     <div class="content">   
     
     <?php echo validation_message();?>
     <?php echo error_message(); ?>
     
      <?php 
	
	       echo form_open("sitepanel/shipping/",'id="search_form" method="get" ');?>
             <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3" >
				<tr>
					<td align="center" >Search [ Shipping Method ] <input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />&nbsp;
					<a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a>
					
					 <?php if($this->input->get_post('keyword')!='')
					   {
						    
					     echo anchor("sitepanel/shipping/",'<span>Clear Search</span>');
						
					   }
					   ?>
					</td>
				</tr>
			</table>
            
	 <?php echo form_close();?>	
     
      
	 <?php 
	   if( is_array($res) && !empty($res) )
	  {
	 
	    echo form_open("sitepanel/shipping/",'id="data_form"');?>
     
	  <table class="list" width="100%" id="my_data">
     
        <thead>
          <tr>
            <td width="21" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
            <td width="405" class="left">Shipping Method</td>
			<td width="343" align="left" class="left">Shipping Rate</td>
            <td width="73" class="right">Status</td>
            <td width="92" class="right">Action</td>
          </tr>
        </thead>
		
        <tbody>
          <?php 
			foreach($res as $catKey=>$pageVal){
				
		   ?> 
          <tr>
            <td style="text-align: center;">
            <input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['shipping_id'];?>" /></td>
            <td class="left"><?php echo $pageVal['shipping_type'];?></td>
			 <td align="left" class="left">
			 <?php //echo display_price($pageVal['shipment_rate']); 
			  echo $pageVal['shipment_rate']; ?> </td>      
            <td class="right"><?php echo ($pageVal['status']==1)?"Active":"In-active";?></td>
            <td class="right">
			  <?php
			  if($this->editPrvg===TRUE)
			  {
			  ?>
				<?php echo anchor("sitepanel/shipping/edit/$pageVal[shipping_id]/".query_string(),'Edit'); ?>
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
				<input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/>
				<?php
				}
				?>
			</td>
	</tr>
      </table>
	<?php echo form_close();
	 }else{
	    echo "<center><strong> No record(s) found !</strong></center>" ;
	 }
	?> 
	 
  </div>
</div>
<?php $this->load->view('includes/footer'); ?>