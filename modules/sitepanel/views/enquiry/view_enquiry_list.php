<?php $this->load->view('includes/header'); 
$block_path=$inq_type=='Wholesale' ? "enquiry/wholesale/" : "enquiry/";
?>  

 <div id="content">
  <div class="breadcrumb">
     <?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title;?>        
      </div>
      
      <div class="box">
    <div class="heading">
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">&nbsp;</div>
    </div>
    <div class="content">
     <?php  echo error_message(); ?>
        
		<?php echo form_open("",'id="search_form"');?>
        <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
		<table width="100%"  border="0" cellspacing="3" cellpadding="3" >
		 <?php 
                if(error_message() !=''){
               	   echo error_message();
                }
                ?> 
         <tr>
			<td align="center" ><strong>Search</strong> [  name,email ] 
			  <input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />&nbsp;			
			<a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a>			
			<?php
			if($this->input->get_post('keyword')!='')
			{ 
				echo anchor("sitepanel/enquiry/".$this->uri->rsegment(2),'<span>Clear Search</span>');
			} 
			?>
		   </td>
		</tr>
		</table>
		<?php echo form_close();?>
		<?php 
		if( is_array($res) && !empty($res) )
		{
		?>
			<?php echo form_open("",'id="data_form"');?>
          
			<table class="list" width="100%" id="my_data">
			<thead>
			<tr>
				<td width="22" style="text-align: center;"><?php if($this->deletePrvg===TRUE){?><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /><?php }?></td>
				<td width="188" class="left">User info</td>
				<td width="163" class="left"> Email</td>
				<td width="424" class="left">Comments</td>
			</tr>
			</thead>
			<tbody>
			<?php
			$atts = array(
										'width'      => '600',
										'height'     => '300',
										'scrollbars' => 'yes',
										'status'     => 'yes',
										'resizable'  => 'yes',
										'screenx'    => '0',
										'screeny'    => '0'
									 );
			
			foreach($res as $catKey=>$res)
			{
				$address_details=array();
			?> 
				<tr>
					<td style="text-align: center;" valign="top">
					<?php
					if($this->deletePrvg===TRUE)
					{
					?>
                    <input type="checkbox" name="arr_ids[]" value="<?php echo $res['id'];?>" />
					<?php
					}
					?>
					</td>
					<td class="left" valign="top">
					<?php echo ucwords($res['first_name']);?> <?php //echo ucwords($res['last_name']);?> <br>
					<?php 
					if($res['address']!="" && $res['address']!='0')
					{ 
						$address_details[]="<b>Address : </b>".nl2br($res['address']); 
					}
					
					if($res['country']!="" && $res['country']!='0')
					{ 
						$address_details[]="<b>Country : </b>".$res['country']; 
					}
					
					if($res['city']!="" && $res['city']!='0')
					{ 
						$address_details[]="<b>City : </b>".ucwords($res['city']); 
					}
					
					if($res['state']!="" && $res['state']!='0')
					{ 
						$address_details[]="<b>State : </b>".ucwords($res['state']); 
					}
					
					
					if($res['company_name']!="" && $res['company_name']!='0')
					{ 
						$address_details[]="<b>Company : </b>".ucwords($res['company_name']); 
					}
					if($res['phone_number']!="" && $res['phone_number']!='0')
					{ 
						$address_details[]="<b>Phone : </b>".$res['phone_number'];  
					}
					if($res['mobile_number']!="" && $res['mobile_number']!='0')
					{ 
						$address_details[]="<b>Mobile : </b>".$res['mobile_number'];  
					}
					
					if($res['fax_number']!="" && $res['fax_number']!='0')
					{ 
						$address_details[]="<b>Fax : </b>".$res['fax_number'];  
					}
					if(!empty($address_details))
					{
						echo implode("<br>",$address_details)."<br /><br />"; 
					}
					
					if(!empty($res['product_service']))
					{
						echo "<b>Product Enquiry : </b>".$res['product_service']; 
					}
					if($res['reply_status']=='Y')
					{
					  echo '<span class="b red">Replied</span>';
					}
					
					?>
					
					<?php echo anchor_popup('sitepanel/enquiry/send_reply/'.$res['id'], 'Send Reply', $atts);?>
					</td>
					<td class="left" valign="top"><?php echo $res['email'];?>
					<br/><b>Receive Date :</b><?php echo $res['receive_date'];?></td>
					<td class="left" valign="top"><?php echo strip_tags($res['message']); ?> </td>            
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