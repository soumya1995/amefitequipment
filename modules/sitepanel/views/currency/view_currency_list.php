<?php $this->load->view('includes/header'); ?>  
 
  <div id="content">
  
  <div class="breadcrumb">
  
       <?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> </a>   
             
   </div>      
       
 <div class="box">
 
    <div class="heading">
    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
      <div class="buttons"> <?php echo anchor("sitepanel/currency/add/",'<span>Add Currency</span>','class="button" ' );?> </div>
      
    </div>
   
    
	<div class="content">
		    <?php 
                if(error_message() !=''){
               	   echo error_message();
                }
                ?> 	
                
		<?php echo form_open("sitepanel/currency/",'id="form" method="get" '); ?>
        
         <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
          
		<table width="100%"  border="0" cellspacing="3" cellpadding="3" >
		<tr>
			<td align="center" >Search [ currency title ]
				<input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />&nbsp;
				<a  onclick="$('#form').submit();" class="button"><span> GO </span></a>
			
				<?php 
				if($this->input->get_post('keyword')!=''){ 
					echo anchor("sitepanel/currency/",'<span>Clear Search</span>');
				} 
				?>
			</td>
		</tr>
		</table>
		<?php echo form_close();?>
		<?php
	
		 $j=0;
		if( is_array($res) && !empty($res) )
		{
			echo form_open("sitepanel/currency/",'id="myform"');
			?>
			<table class="list" width="100%" id="my_data">
			<thead>
			<tr>
				<td width="20" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
				<td width="145" class="left">Currency Title</td>
				<td width="145" class="left">Code</td>
                <td width="202" class="left">Image</td>
				<td width="202" class="left">Symbol</td>
                <td width="202" class="left">Value</td>
				<td width="134" class="right">Status</td>
				<td width="148" class="right">Action</td>
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
                <?php if($pageVal['is_default']!='Y'){?>
					<input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['currency_id'];?>" />
                    <?php }?>
				</td>
				<td class="left"><?php echo $pageVal['title'];?></td>
				<td class="left"><?php echo $pageVal['code'];?></td>
				<td align="center"><?php $product_path = "currency/".$pageVal['curr_image'];?>
                 <img src="<?php echo base_url().'uploaded_files/'.$product_path;?>"  width="10%" height="10%"/>
				</td>
                 <td align="center"><?php echo $pageVal['symbol_left'];?></td>
                 <td align="center"><?php echo round($pageVal['value'],2);?></td>
            	<td class="right"><?php echo ($pageVal['status']==1)? "Active":"In-active";?></td>
				<td align="center" >  
				 <?php if($pageVal['is_default']!='Y'){?>
					<?php echo anchor("sitepanel/currency/edit/$pageVal[currency_id]/".query_string(),'Edit'); ?>			
				 
				<?php }else{?>	
                <strong>Base Currency</strong>
				
				<?php }?>
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
<?php $this->load->view('includes/footer'); ?>