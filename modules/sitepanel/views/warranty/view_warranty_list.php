<?php $this->load->view('includes/header');?>
<div class="content">
 <div id="content">
  <div class="breadcrumb">
   <?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title;?>
  </div>
  <div class="box">
   <div class="heading">
    <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a href="<?php echo base_url();?>sitepanel/warranty/add/" class="button">Add warranty</a></div>
   </div>
   <div class="content">
    <?php
    if(error_message() !=''){
	    echo error_message();
    }?>
    <script type="text/javascript">function serialize_form() { return $('#pagingform').serialize();   } </script>
    <?php echo form_open("",'id="search_form" method="get" ');?>
    <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
    <table width="100%"  border="0" cellspacing="3" cellpadding="3" >
     <tr>
      <td align="center" >Search [ Title ]
       <input type="text" name="keyword2" value="<?php echo $this->input->get_post('keyword2');?>"  />&nbsp;
       <select name="status">
        <option value="">Status</option>
        <option value="1" <?php echo $this->input->get_post('status')==='1' ? 'selected="selected"' : '';?>>Active</option>
        <option value="0" <?php echo $this->input->get_post('status')==='0' ? 'selected="selected"' : '';?>>In-active</option>
       </select>       
       <a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a>
       <?php
       if( $this->input->get_post('keyword2')!='' || $this->input->get_post('status')!=''){	      
		       echo anchor("sitepanel/warranty/",'<span>Clear Search</span>');	      
       }?>
      </td>
		</tr>
		</table>

		<?php echo form_close();?>
		<div class="required"> <?php echo $warranty_result_found; ?></div>
		<?php
		if( is_array($res) && !empty($res) ){
			echo form_open(current_url_query_string(),'id="data_form"'); 
			?>
			<table class="list" width="100%" id="my_data">
			 <thead>
			  <tr>
			   <td width="2%" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
			   <td width="35%"  class="left">Title</td>
			   <td width="14%" class="center">Price</td>		
			   <td width="9%" class="center">Image</td>
			   <td width="12%" class="center">Details</td>
			   <td width="5%" class="center">Status</td>
			   <td width="12%" class="center">Action</td>
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
			  $atts_edit = array(
			  'width'      => '525',
			  'height'     => '375',
			  'scrollbars' => 'no',
			  'status'     => 'no',
			  'resizable'  => 'no',
			  'screenx'    => '0',
			  'screeny'    => '0'
			  );
			 
			  foreach($res as $catKey=>$pageVal){
				  			  
				  ?>
				  <tr>
				   <td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['warranty_id'];?>" /></td>
				   <td class="left" valign="top"><?php echo $pageVal['title'];?></td>	
                   <td class="center" valign="top"><?php echo display_price($pageVal['price']);?></td>			   
				   <td align="center" valign="top"><img src="<?php echo get_image('warranty',$pageVal['media'],50,50,'AR');?>" /></td>
				   <td class="center" valign="top">
				    <a href="#"  onclick="$('#dialog_<?php echo $pageVal['warranty_id'];?>').dialog( {width: 650} );">View Details</a>
                    <div id="dialog_<?php echo $pageVal['warranty_id'];?>" title="Description" style="display:none;"><?php echo $pageVal['description'];?></div>
				   </td> 
				   <td class="center" valign="top">
				   <?php echo ($pageVal['status']==1)? "Active":"In-active";?>					
				   </td>
				   <td align="center" valign="top">
				    <?php if($this->editPrvg===TRUE)?><p><?php echo anchor("sitepanel/warranty/edit/$pageVal[warranty_id]/".query_string(),'Edit');?></p>
				   </td>
				  </tr>
				  <?php
			  }?>
			 </tbody>
			</table>
			<?php if($page_links!=''){?>
			<table class="list" width="100%">
			 <tr><td align="right" height="30"><?php echo $page_links; ?></td></tr>
			</table>
			<?php }?>
			<table class="list" width="100%">
			 <tr>
			  <td align="left" colspan="11" style="padding:2px" height="35">
			   <?php if($this->activatePrvg===TRUE)?>
			   <input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onclick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
			   <?php if($this->deactivatePrvg===TRUE)?>
			   <input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onclick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>


			   <?php if($this->deletePrvg===TRUE)?>
			   <input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onclick="return validcheckstatus('arr_ids[]','delete','Record');"/>			   
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
</div>
<script type="text/javascript">
function onclickgroup(){
	if(validcheckstatus('arr_ids[]','set','record','u_status_arr[]')){
		$('#data_form').submit();
	}
}
</script>
<?php $this->load->view('includes/footer');?>