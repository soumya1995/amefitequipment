<?php $this->load->view('includes/header'); ?>  
 
  <div id="content">
  
  <div class="breadcrumb">
  
       <?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> </a> 
         
   </div> 
        
 <div class="box">
    <div class="heading">
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"> <?php echo anchor("sitepanel/paymentinfo/add/",'<span>Add Payment Info.</span>','class="button" ' );?></div>    
    </div>
	<div class="content">
		    <?php 
                if(error_message() !=''){
               	   echo error_message();
                }
                ?> 	
		<?php
	
		 $j=0;
		if( is_array($res) && !empty($res) )
		{
			echo form_open("sitepanel/paymentinfo/",'id="myform"');
			?>
			<table class="list" width="100%" id="my_data">
			<thead>
			<tr>
				<td width="20" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
				<td width="145" class="left">Title</td>
				<td width="298" class="left">Info</td>
				<td width="82" class="right">Status</td>
				<td width="65" class="right">Action</td>
			</tr>
			</thead>
			<tbody>
<?php 	
		foreach($res as $catKey=>$pageVal)
		{ 
		?> 
			<tr>
				<td style="text-align: center;">
					<input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['id'];?>" />
                   
				</td>
				<td class="left" valign="top"><?php echo $pageVal['ptitle'];?></td>
				<td class="left">
                <table width="100%" border="0">
                  <?php if($pageVal['ptype']==1){ ?>  
                    <tr>
                    	<td width="50%">A/C Holder Name</td>
                        <td width="50%"><?php echo $pageVal['ac_holder_name'];?></td>
                    </tr>
                    <tr>
                    	<td width="50%">A/C No.</td>
                        <td width="50%"><?php echo $pageVal['ac_no'];?></td>
                    </tr>
                    <tr>
                    	<td width="50%">Bank Name</td>
                        <td width="50%"><?php echo $pageVal['bank_name'];?></td>
                    </tr>
                    <?php /*<tr>
                    	<td width="50%">Bank Address</td>
                        <td width="50%"><?php echo $pageVal['bank_address'];?></td>
                    </tr>*/?>
                    <tr>
                    	<td width="50%">Swift Code</td>
                        <td width="50%"><?php echo $pageVal['ifc_code'];?></td>
                    </tr>
                    <tr>
                    	<td width="50%">City</td>
                        <td width="50%"><?php echo $pageVal['city'];?></td>
                    </tr>
                    <tr>
                    	<td width="50%">Country</td>
                        <td width="50%"><?php echo $pageVal['country'];?></td>
                    </tr>
                 <?php }elseif($pageVal['ptype']!='4'){ ?>  
                   <tr>
                    	<td width="50%">First Name</td>
                        <td width="50%"><?php echo $pageVal['first_name'];?></td>
                    </tr>
                    <tr>
                    	<td width="50%">Last Name</td>
                        <td width="50%"><?php echo $pageVal['last_name'];?></td>
                    </tr>
                    <tr>
                    	<td width="50%">City</td>
                        <td width="50%"><?php echo $pageVal['city'];?></td>
                    </tr>
                    <tr>
                    	<td width="50%">Country</td>
                        <td width="50%"><?php echo $pageVal['country'];?></td>
                    </tr>
                 <?php } ?> 
                </table>
                </td>
                <td align="center" valign="top"><?php echo ($pageVal['status']==1)?'Active':'In-active';?></td>
				<td align="center" valign="top">
                 <?php echo anchor("sitepanel/paymentinfo/edit/$pageVal[id]/".query_string(),'Edit');?></td>
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
				  <input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onClick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
			
				<input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
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