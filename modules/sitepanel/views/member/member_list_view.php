<?php $this->load->view('includes/header'); ?>
<?php error_reporting(E_ALL); ?>
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
    
   
     <div class="required">                        
                <strong> Total Record(s) Found : <?php echo $total_rec; ?></strong>  
         </div>
                  
      <?php   echo form_open("",'id="search_form" method="get" ');    ?>
       <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
   
    <table width="100%"  border="0" align="center" cellspacing="3" cellpadding="3">
    <?php 
	 
	
                if(error_message() !=''){
               	   echo error_message();
                }
                ?> 
      <tr><td width="52%" align="right"><strong>Search </strong> [ name, username ] <input name="keyword" type="text" value="<?php echo trim($this->input->get_post('keyword'));?>" size="35"  />&nbsp;</td>
      <td width="9%" align="center" >
            <select name="status">
            
            <option value="">Status</option>
            <option value="1" <?php echo $this->input->get_post('status')==='1' ? 'selected="selected"' : '';?>>Active</option>
            <option value="0" <?php echo $this->input->get_post('status')==='0' ? 'selected="selected"' : '';?>>In-active</option>
            
            </select>
        </td>
        
        
        <td width="39%" align="left" ><a  onclick="$('#search_form').submit();" class="button"><span>GO </span></a>&nbsp;
        <?php
            if( $this->input->get_post('keyword')!='' || $this->input->get_post('status')!='' )
            { 
			
				if($type=='seller'){            
			   		echo anchor("sitepanel/members/seller",'<span>Clear Search</span>');
				}else{
					echo anchor("sitepanel/members/",'<span>Clear Search</span>');
				}
            }
            ?></td>
	  </tr>
			</table>
        <?php   echo form_close();     ?>
    
	<?php
	if( count($pagelist) > 0 )
    {
      ?>
	  <?php  echo form_open("",'id="data_form"');?>         
  
	  <table class="list" width="100%" id="my_data">
	  <?php

		  $atts = array(
							'width'      => '650',
							'height'     => '600',
							'scrollbars' => 'yes',
							'status'     => 'yes',
							'resizable'  => 'yes',
							'screenx'    => '0',
							'screeny'    => '0'
						);
	  ?>	
      <thead>
        <tr>
          <td width="31" style="text-align: center;">
          <input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
          <td width="372"  class="left">Name</td>
          <td width="149" class="left">Username</td>
          <td width="116" class="left">Password</td>
          <td width="163" align="right" >Reg. Date </td>
          <td width="255" class="center">Status</td>  
        </tr>
      </thead>
      <tbody>
      <?php
      
      foreach($pagelist as $catKey=>$pageVal)
      {
        ?>
        <tr>
          <td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['customers_id'];?>" /></td>
          <td class="left">
				<?php echo $pageVal['name'];?>             
				<br /> 
				<?php echo anchor_popup('sitepanel/members/details/'.$pageVal['customers_id'], 'View Details', $atts);?>
               	<?php echo anchor_popup('sitepanel/members/send_mail/'.$pageVal['customers_id'], 'Send Mail', $atts);?>
               	<?php /*?>| <a href="<?php echo base_url()?>sitepanel/members/messages/<?php echo $pageVal['customers_id']?>">Messages List</a> <?php */?>
				<?php
					if($pageVal["customer_type"]==1){
						$count_products=count_record('wl_products',"vendor_id = '".$pageVal['customers_id']."' ");
						?> | <a href="<?php echo base_url("sitepanel/products?vendor_id=$pageVal[customers_id]") ?>">Products [<span class="red b"><?php echo $count_products?></span>]</a>
						<?php 
					}
				?>
          </td>
          <td class="left"><?php echo $pageVal['user_name'];?></td>
          <td class="left"><?php echo $this->safe_encrypt->decode($pageVal['password']);?></td>
          <td class="right"><?php echo getDateFormat($pageVal['account_created_date'],7);?></td>
          <td class="center">
		  <?php 
		  echo ($pageVal['status']=='1')?"Active":"Inactive";
		  echo "<br />";				
		  if($pageVal['is_verified']=='0'){
			
				echo anchor('sitepanel/members/verify/'.$pageVal['customers_id'].'/'.$pageVal["customer_type"], 'Verify', '');
		  }
		  echo "<br />";
		  if($pageVal["customer_type"]==0){
			  echo anchor('sitepanel/members/customer_type/'.$pageVal['customers_id'].'/1', 'Set As Wholesaler', '');
		  }
		  if($pageVal["customer_type"]==1){
			  echo anchor('sitepanel/members/customer_type/'.$pageVal['customers_id'].'/0', 'Set As Buyer', '');
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
      		<td align="left" style="padding:5px">
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
      </tbody>
	  </table>
	  <?php echo form_close(); ?>
    <?php
    }
    else{
      echo "<div class='ac b'> No record(s) found !</div>" ;
    }
    ?>
 </div>
</div>
<?php $this->load->view('includes/footer'); ?>