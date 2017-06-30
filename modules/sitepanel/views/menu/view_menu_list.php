<?php $this->load->view('includes/header'); ?>  
  
  <div id="content">
  
  <div class="breadcrumb">
  
    <?php echo anchor('sitepanel/dashbord','Home'); 
	
		echo '<span class="pr2 fs14">»</span> '.$heading_title;
	  
    ?>
       
             
   </div>      
       
 <div class="box">
 
    <div class="heading">
    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
    </div>
   
  
      
     <div class="content">
    	
        <?php  echo error_message(); ?>
		<?php
		if(is_array($res) && ! empty($res))
		{
			
		?>
        
          
        
			<?php echo form_open("sitepanel/menu/",'id="data_form"');?>
            
          
           
			<table class="list" width="100%" id="my_data">
            
			<thead>
			  <tr>
				<td width="20" style="text-align: center;"></td>
				<td width="90" class="left">Title </td>
				<td width="94" class="left">Display Order</td>
				
			</tr>
			</thead>
			<tbody>
			<?php 	
			$i=0;
			foreach($res as $catKey=>$pageVal)
			{ 
				$i++;	
						
				$displayorder       = ($pageVal['sort_order']!='') ? $pageVal['sort_order']: "0";								
				
				
				
			?> 
				<tr>
					<td style="text-align: center;"><?php echo $i;?></td>
					<td class="left">
						<?php echo $pageVal['menu_title'];?>
						
					</td>
                    
					
					<td>
                     <input type="text" name="ord[<?php echo $pageVal['menu_id'];?>]" value="<?php echo $displayorder;?>" size="5" />
                    </td>
					
				</tr>
			<?php
			}		   
			?> 
			
			   
			</tbody>
			</table>
			<table class="list" width="100%">
			<tr>
				<td align="left" style="padding:2px" height="35">
					<?php
					if($this->orderPrvg===TRUE)
					{
					?>
					  <input name="update_order" type="submit"  value="Update Order" class="button2" />
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