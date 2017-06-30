<?php $this->load->view('includes/header'); ?>
<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> </a></div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
   <div class="buttons"> <?php echo anchor("sitepanel/banners/add/",'<span>Add Banner</span>','class="button" ' );?> </div>
  </div>
  <div class="content">
   <?php
   if(error_message() !=''){echo error_message();}
   echo form_open("sitepanel/banners/",'id="form" method="get" ');
   ?>
   <table width="100%"  border="0" cellspacing="3" cellpadding="3" >
    <tr>
     <td align="center" >Search [ Banner Position ]
      <?php
      $this->load->helper('array');
     // echo form_dropdown('banner_position',banner_type_array(),$this->input->get_post('banner_position'),'class="w98"');
      ?>
       <?php echo banner_postion_drop_down('banner_position',$this->input->post('banner_position'),$this->input->post('section'));?>
      &nbsp;<a  onclick="$('#form').submit();" class="button"><span> GO </span></a>
      <?php
      if($this->input->get_post('banner_position')!=''){
	      echo anchor("sitepanel/banners/",'<span>Clear Search</span>');
      }?>
     </td>
     <td align="right" width="200">
      <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
     </td>
    </tr>
   </table>
   <?php echo form_close();
   $j=0;
   if( is_array($res) && !empty($res) ){
	   echo form_open("sitepanel/banners/",'id="myform"');
	   ?>
	   <table class="list" width="100%" id="my_data">
	    <thead>
	     <tr>
	      <td width="3%" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
	      <td  class="left" width="25%">User Details</td>
	      <td width="12%" class="left">Banner Position</td>
	      <td width="15%" class="left">URL</td>
	      <td width="17%" class="center">Banner Image</td>
	      <td width="16%" class="center">Posted Date</td>
	      <td width="6%" class="center">Status</td>
	      <td width="6%" class="center">Action</td>
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
			 $j=1;
			 foreach($res as $catKey=>$pageVal){
				 ?>
				 <tr>
				  <td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?=$pageVal['banner_id'];?>" /></td>
				  <td class="left">
				   <?php
				   if($pageVal["type"]==1){
					   echo 'Name: '.ucwords($pageVal['first_name']);?><br />
					   <?php if(!empty($pageVal['company_name'])){ echo 'Company: '.$pageVal['company_name'].'<br />'; }?>
					   Email: <?php echo $pageVal['email'];?><br />
					   Mobile: <?php echo $pageVal['mobile_number'];?><br />
					   <?php if(!empty($pageVal['phone_number'])){ echo 'Phone: '.$pageVal['phone_number'].'<br />'; }?>
					   <a href="javascript:void(0);" class="b" onclick="$('#dialog_<?php echo $pageVal['banner_id'];?>').dialog({ width: 650 });">View</a>
					   <div id="dialog_<?php echo $pageVal['banner_id'];?>" title="Description" style="display:none;">
					    <?php echo $pageVal['description'];?>
					    <div class="cb"></div>
					   </div>
					   <?php if($pageVal['address']){ echo $pageVal['address'];?><? }
				   }else{
					   echo "Admin";
				   }?>
				  </td>
				  <td class="left"><?php echo $pageVal['banner_position'];?></td>
				  <td class="left"><?php echo $pageVal['banner_url'];?></td>
				  <td align="center">
				   <?php $product_path = "banner/".$pageVal['banner_image'];?>
				   <a href="javascript:void(0);"  onclick="$('#dialog_<?php echo $j;?>').dialog({width:'auto'});">
				   <img src="<?php echo get_image('banner',$pageVal['banner_image'],100,100)?>" /></a>
				   <div id="dialog_<?php echo $j;?>" title="Banner Image" style="display:none;"><img src="<?php echo base_url().'uploaded_files/'.$product_path;?>"  /></div>
				  </td>
				  <td class="right"><p><?php echo getDateFormat($pageVal["banner_added_date"],7,"-")?></p></td>
				  <td class="center"><?php echo ($pageVal['status']==1)? "Active":"In-active";?></td>
				  <td align="center" ><?php echo anchor("sitepanel/banners/edit/$pageVal[banner_id]/".query_string(),'Edit');?></td>
				 </tr>
				 <?php
				 $j++;
			 }?>
			 <tr><td colspan="8" align="right" height="30"><?php echo $page_links;?></td></tr>
			</tbody>
			<tr>
			 <td align="left" colspan="8" style="padding:2px" height="35">
			  <input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onClick="return validcheckstatus('arr_ids[]','Activate_Banner','Record','u_status_arr[]');"/>
			  <input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
			  <input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/>
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
<?php $this->load->view('includes/footer'); ?>