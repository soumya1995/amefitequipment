<?php $this->load->view('includes/header');?>
<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo $heading_title;?></a></div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url();?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title;?></h1>
   <div class="buttons"> <?php echo anchor("sitepanel/faq/add/",'<span>Add FAQ</span>','class="button" ' );?></div>
  </div>
  <script type="text/javascript">function serialize_form() { return $('#pagingform').serialize(); } </script>
  <div class="content">
   <?php echo form_open("sitepanel/faq/",'id="search_form" method="get"');?>
   <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?></div>
   <table width="100%"  border="0" cellspacing="3" cellpadding="3">
    <?php if(error_message() !='') echo error_message();?>
    <tr><td align="center" >Search (<span class="left">Question</span>) <input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>" /> &nbsp; <a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a> &nbsp; <?php if( $this->input->get_post('keyword')!='' ) echo anchor("sitepanel/faq/",'<span>View All</span>');?></td></tr>
   </table>
   <?php echo form_close();
   if( is_array($pagelist) && !empty($pagelist)){
	   echo form_open("sitepanel/faq/",'id="data_form" ');?>
	   <table class="list" width="100%" id="my_data">
	    <thead>
	     <tr>
	      <td width="21" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
	      <td width="405" class="left">Question/Answer</td>
	      <td width="73" align="left">Order </td>
	      <td width="73" class="right">Status</td>
	      <td width="92" class="right">Action</td>
	     </tr>
	    </thead>
	    <tbody>
	     <?php
	     foreach($res as $catKey=>$pageVal){
		     ?>
		     <tr>
		      <td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['faq_id'];?>" /></td>
		      <td class="left">
		       <strong> Question -</strong> <?php echo $pageVal['faq_question'];?>
		       <br /> <strong> Answer -</strong> <a href="#"  onclick="$('#dialog_<?php echo $pageVal['faq_id'];?>').dialog( {width: 650} );">view</a>
		       <div id="dialog_<?php echo $pageVal['faq_id'];?>" title="Answer" style="display:none;"> <?php echo $pageVal['faq_answer'];?></div>
		      </td>
		      <td class="right"><input type="text" name="ord[<?php echo $pageVal['faq_id'];?>]" value="<?php echo $pageVal['sort_order'];?>" size="5" /></td>
		      <td class="right"><?php echo ($pageVal['status']==1)?"Active":"In-active";?></td>
		      <td class="right"><?php if($this->editPrvg===TRUE) echo anchor("sitepanel/faq/edit/$pageVal[faq_id]/".query_string(),'Edit');?></td>
		     </tr>
		     <?php
	     }?>
	    </tbody>
	   </table>
	   <?php
	   if($page_links!=''){
		   ?>
		   <table class="list" width="100%">
		    <tr><td align="right" height="30"><?php echo $page_links;?></td></tr>
		   </table>
		   <?php
	   }?>
	   <table class="list" width="100%">
	    <tr>
	     <td align="left" style="padding:2px" height="35">
	      <?php
	      if($this->activatePrvg===TRUE){
		      ?>
		      <input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onClick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
		      <?php
	      }
	      if($this->deactivatePrvg===TRUE){
		      ?>
		      <input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
		      <?php
	      }
	      if($this->orderPrvg===TRUE){
		      ?>
		      <input name="update_order" type="submit"  value="Update Order" class="button2" />
		      <?php
	      }
	      if($this->deletePrvg===TRUE){
		      ?>
		      <input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/>
		      <?php
	      }?>
	     </td>
	    </tr>
	   </table>
	   <?php echo form_close();
   }else{
	   echo "<center><strong> No record(s) found !</strong></center>";
   }?>
  </div>
 </div> 
</div>
<?php $this->load->view('includes/footer');?>