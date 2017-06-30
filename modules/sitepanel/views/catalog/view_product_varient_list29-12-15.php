<?php $this->load->view('includes/header');
 $atts_edit = array(
	   'width'      => '600',
	   'height'     => '460',
	   'scrollbars' => 'yes',
	   'status'     => 'yes',
	   'resizable'  => 'yes',
	   'screenx'    => '0',
	   'screeny'    => '0'
	   );

$service_type = (int) $this->uri->segment(4);
$product_id = (int) $this->uri->segment(5);
?>
<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo anchor('sitepanel/products/','Products'); ?> &raquo; <?php echo $heading_title; ?> </a></div>
 <div class="box">
  <div class="heading"><h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1><div class="buttons">
  
  <a href="javascript: void(0)" onclick="window.open('<?php echo base_url();?>sitepanel/products/addservice/<?php echo $service_type;?>/<?php echo $product_id.query_string();?>',
  'windowname1', 
  'width=600, height=460'); 
   return false;" class="button">Add Service</a>
</div>
   </div>
   
   <?php echo form_open("",'id="search_form" method="get" ');?>
    <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
    <table width="100%"  border="0" cellspacing="3" cellpadding="3" >
     <tr>
      <td align="center" >Search [ Warranty/Package Name ]
       <input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />&nbsp;
       
       <select name="type" id="type" style="width:120px;" onchange="this.form.submit();">
        <option value="">Select Type</option> 
        <option value="W" <?php if(set_value('type')=='W'){?> selected="selected" <?php } ?> >Warranty</option>
        <option value="P" <?php if(set_value('type')=='P'){?> selected="selected" <?php } ?>>Packages</option> 
       </select>
      
       <a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a>
       <?php
       if( $this->input->get_post('keyword')!='' || $this->input->get_post('status')!='' || $this->input->get_post('type')!='' ){
	       
		       echo anchor("sitepanel/products/services/".$service_type."/".$product_id,'<span>Clear Search</span>');
	       
       }?>
      </td>
		</tr>
		</table>

		<?php echo form_close();?>
     
  
  <div class="content">
   <?php
   if(error_message() !=''){
	   echo error_message();
   }
   $j=0;
   if( is_array($res) && !empty($res) )
   {
	   echo form_open(current_url_query_string(),'id="data_form"');
	   $product_res=get_db_single_row('wl_products','product_name,product_code,products_id',$Condwherw=' AND products_id="'.$this->uri->segment(5).'"');
	   
	   $service_type_arr=($this->config->item('service_type'));
	   $service=$service_type_arr[$service_type];
	   
	   ?>
	   <table width="100%">
	    <tr>
	     <td align="left"><strong>Product Name</strong> - <?php echo $product_res['product_name'];?><br/><strong>Product Code -</strong> <?php echo $product_res['product_code'];?><br/><strong>Service Type -</strong> <?php echo $service;?></td>
	     
	    </tr>
	   </table>
	   <table class="list" width="100%" id="my_data">
	    <thead>
	     <tr>
          <td width="4%" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
	      <td width="30%" align="center" class="center"><strong>Warranty/Package Name</strong></td>
	      <td width="26%" align="center" class="center"><strong>Price</strong></td>	
          <?php /*?><td width="26%" align="center" class="center"><strong>Stock</strong></td><?php */?>     
         <?php /*?> <td width="10%" align="center" class="center"><strong>Status</strong></td><?php */?>
          <td width="10%" align="center" class="center"><strong>Action</strong></td>
				
			 </tr>
			</thead>
			<tbody>
			 <?php
			 $i=1;
			 foreach($res as $catKey=>$pageVal){
				 
				// $wres=$this->weight_model->get_weight_by_id($pageVal['weight_id']);
				 ?>
				 <tr>
                  <td style="text-align: center;">                  
                  <input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['attribute_id'];?>"  <?php if($pageVal['default_status']=='1') {?>  disabled="disabled"   <?php } ?>   />           
                  </td>
				  <td align="center" class="center"><?php echo $pageVal['variant_name'];?></td>
				  <td align="center">				  
                    <span style="color: #b00;"><strong><?php echo display_price($pageVal['product_price']);?></strong></span>
				  </td>
                 <?php /*?> <td align="center" class="center"><?php echo $pageVal['quantity'];?></td><?php */?>
                  <?php /*?><td align="center"><?php echo ($pageVal['status']==1)? "Active":"In-active";?></td><?php */?>
				  <td align="center" class="center">
				  <?php echo anchor_popup('sitepanel/products/editservice/'.$pageVal['service_type'].'/'.$pageVal['product_id'].'/'.$pageVal['attribute_id'], 'Edit', $atts_edit);?> 
                  <br />
				  <?php 				  
				   if($pageVal['default_status']!='1') {
				  		echo anchor('sitepanel/products/delete_price_variant/'.$pageVal['service_type'].'/'.$pageVal['product_id'].'/'.$pageVal['attribute_id'], 'Delete', $atts_edit);
				   }
				  ?></td>
				 
				 </tr>
				 <?php
				 $j++;
			 }?>
			 <!--<tr><td colspan="6" align="right" height="30">&nbsp;</td></tr>-->
			</tbody>
		 </table>
         <?php /*?><table class="list" width="100%">
			 <tr>
			  <td align="left" colspan="11" style="padding:2px" height="35">
			   <?php if($this->activatePrvg===TRUE)?>
			   <input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onclick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
			   <?php if($this->deactivatePrvg===TRUE)?>
			   <input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onclick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
			
			  </td>
			 </tr>
			</table><?php */?>
         
		 <?php
		 echo form_close();
	 }else{
		 echo "<center><strong> No record(s) found !</strong></center>" ;
	 }?>
	</div>
 </div>
</div>
<script type="text/javascript">
function onclickgroup(){
	if(validcheckstatus('arr_ids[]','set','record','u_status_arr[]')){
		$('#data_form').submit();
	}
}
</script>

<?php $this->load->view('includes/footer');?>