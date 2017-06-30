<?php $this->load->view('includes/header');?>
<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo $heading_title;?></a></div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title;?></h1>
   <div class="buttons">  <?php echo anchor("sitepanel/weight/add/",'<span>Add Weight</span>','class="button" ' );?></div>
  </div>
  <div class="content">
   <?php echo validation_message();
   echo error_message();
   echo form_open("sitepanel/weight/",'id="search_form" method="get" ');?>
   <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
   <table width="100%"  border="0" cellspacing="3" cellpadding="3">
    <tr>
     <td align="center" >Search [ Weight Name] <input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />&nbsp;<a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a><?php if($this->input->get_post('keyword')!=''){ echo anchor("sitepanel/weight/",'<span>Clear Search</span>'); }?></td>
    </tr>
   </table>
   <?php echo form_close();
   if( is_array($res) && !empty($res) ){
	   echo form_open("sitepanel/weight/",'id="data_form"');?>
	   <table class="list" width="100%" id="my_data">
	    <thead>
	     <tr>
	      <td width="5%" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
	      <td width="60%" class="left">Weight Name</td>
	      <!-- <td width="15%" align="center">Image</td>-->
	      <td width="10%" class="center">Status</td>
	      <td width="10%" class="center">Action</td>
	     </tr>
	    </thead>
	    <tbody>
	     <?php
	     $j=1;
	     foreach($res as $catKey=>$pageVal){
		     ?>
		     <tr>
		      <td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['weight_id'];?>" /></td>
		      <td class="left">
			  <?php echo $pageVal['weight_name'];?> <?php echo $this->config->item('weight_unight');?>              
              </td>
		      <?php /*<td align="center">
		       <?php
		       $image_path = "weight/".$pageVal['weight_image'];
		       if($pageVal['weight_image']!=''){
			       ?>
			       <a href="#"  onclick="$('#dialog_<?php echo $j;?>').dialog({width:'auto'});">View Image </a>
			       <div id="dialog_<?php echo $j;?>" title="Banner Image" style="display:none;"><img src="<?php echo base_url().'uploaded_files/'.$image_path;?>"  /> </div>
			       <?php
		       }else{echo 'No Image';}?>
		      </td>*/?>
		      <td class="center"><?php echo ($pageVal['status']==1)?"Active":"In-active";?></td>
		      <td class="center"><?php echo anchor("sitepanel/weight/edit/$pageVal[weight_id]/".query_string(),'Edit'); ?></td>
		     </tr>
		     <?php
		     $j++;
	     }?>
	     <tr><td colspan="7" align="right" height="30"><?php echo $page_links; ?></td></tr>
	    </tbody>
	    <tr>
	     <td align="left" colspan="7" style="padding:2px" height="35">
	      <input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onClick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
	      <input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
	      <input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/>
          <?php 
		  if($this->input->get_post('category_id')!=""){
			   ?>
			   <input type="hidden" name="category_id" id="category_id" value="<?php echo $this->input->get_post('category_id');?>" />
			   <input name="status_action" type="submit"  value="Set Left" class="button2" id="Category" onClick="return validcheckstatus('arr_ids[]','Category','Record','u_status_arr[]');"/>
			   
			   &nbsp;
			   <input name="status_action" type="submit"  value="Unset Left" class="button2" id="Category" onClick="return validcheckstatus('arr_ids[]','Category','Record','u_status_arr[]');"/>
			   <?php
		 }?>
	     </td>
	    </tr>
	   </table>
	   <?php
	   echo form_close();
   }else{
	   echo "<center><strong> No record(s) found !</strong></center>" ;
   }?>
  </div>
 </div> 
</div>
<?php $this->load->view('includes/footer');?>