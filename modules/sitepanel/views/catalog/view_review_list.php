<?php $this->load->view('includes/header'); ?>  
<div class="content">
    <div id="content">
  <div class="breadcrumb">
    
    <?php echo anchor('sitepanel/dashbord','Home'); 
	
		
		echo '<span class="pr2 fs14">»</span> Review List ';
	 
    ?>
     
        
 </div>
  <div class="box">
    <div class="heading">
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
      
      
    </div>
    <div class="content">
    		 <?php 
			   if(error_message() !=''){
			      echo error_message();
			   }
			    ?>  
      <script type="text/javascript">function serialize_form() { return $('#pagingform').serialize();   } </script> 
         
        
		<?php 
		echo form_open('','id="search_form" method="get" '); ?>
        <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
		<table width="100%"  border="0" cellspacing="3" cellpadding="3" >
		   
           <tr>
			<td align="center" >Search [ Name/Email,Product Name ] 
				<input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />&nbsp;
                
				<a onclick="$('#search_form').submit();" class="button"><span> GO </span></a>
				
				<?php 
				if($this->input->get_post('keyword')!='' || $this->input->get_post('status')!='' )
				{ 
					echo anchor(base_url()."sitepanel/products/review",'<span>Clear Search</span>');
				} 
				?>
			</td>
		</tr>
		</table>
		<?php echo form_close();?>
        
      
		<?php	 
		if( is_array($res) && !empty($res) )
		{
			echo form_open("sitepanel/products/review/",'id="data_form"');
			
			?>
  
			<table class="list" width="100%" id="my_data">
			<thead>
			<tr>
				<td width="27" style="text-align: center;">
                <input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
				<td width="147"  class="left">Name/Email</td>
				<td width="119" class="left">Product Name</td>
				<!--<td width="142" class="center">Rate</td>-->
				<td width="397" class="left">Comment</td>
				<td width="71" class="center">Post Date.</td>
				<td width="59" class="center">Status</td>
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
                    <input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['review_id'];?>" /></td>
					<td class="left" valign="top"> 
					<?php echo $pageVal['poster_name'];?> <br/>                   
                    <?php echo $pageVal['email'];?>  
					</td>
					<td class="left" valign="top"> <?php echo $pageVal['product_name'];?> </td>
					<!--<td class="center" valign="top"><?php  echo rating_html($pageVal['rate'],5);?></td>-->
                    
					<td class="left" valign="top"><?php echo $pageVal['comment'];?></td>
					<td class="center" valign="top"><?php echo getDateFormat($pageVal['posted_date'],1);?></td>
					<td class="center" valign="top"><?php echo ($pageVal['status']==1)? "Active":"In-active";?></td>
				</tr>
			<?php
			}		   
			?> 
			<tr><td colspan="11" align="right" height="30"><?php echo $page_links; ?></td></tr>     
			</tbody>
			<tr>
				<td align="left" colspan="11" style="padding:2px" height="35">
					
					<input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onClick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
					<input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
					
					<input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/> 
					
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

<script type="text/javascript">		
	function onclickgroup(){
		if(validcheckstatus('arr_ids[]','set','record','u_status_arr[]')){			
			$('#data_form').submit();
		}
	}	
</script>

<?php $this->load->view('includes/footer'); ?>