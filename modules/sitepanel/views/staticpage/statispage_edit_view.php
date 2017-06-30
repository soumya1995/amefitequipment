<?php $this->load->view('includes/header'); ?> 
   
 <div id="content">
  
  <div class="breadcrumb">
  
       <?php echo anchor('sitepanel/dashbord','Home'); ?>
 &raquo; <?php echo anchor('sitepanel/staticpages','Back To Listing'); ?> &raquo;  <?php echo $heading_title; ?>
             
   </div>      
       
 <div class="box">
 
    <div class="heading">
    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
      <div class="buttons">&nbsp;</div>
      
    </div>
   
     <script type="text/javascript">function serialize_form() { return $('#pagingform').serialize(); } </script> 
      
     <div class="content">
      <?php  echo error_message(); ?>
     
   <?php echo form_open(current_url_query_string());?>  

	<table width="90%"  class="tableList" align="center">
		<tr>
			<th colspan="2" align="center" > </th>
		</tr>
		<tr class="trOdd">
			<td height="26">Page :</td>
			<td><strong><?php echo $pageresult['page_name'];?></strong></td>
		</tr>
	<?php if($pageresult['page_short_description']!=''){	 ?>
		<tr class="trOdd">
			<td height="26">* Heading :</td>
			<td>
       <textarea name="page_short_description" rows="1" cols="80"><?php echo $pageresult['page_short_description'];?></textarea></td>
		</tr>
	 <?php
	 }
	 ?>	
		<tr class="trEven">
			<td width="187" height="26">Description : </td>
			<td width="648" style="f">
			<textarea name="page_description" rows="5" cols="50" id="page_desc" ><?php echo $pageresult['page_description'];?></textarea>
			<?php
			echo display_ckeditor($ckeditor); ?>
			</td>
		</tr>
		<tr class="trEven">
			<td align="left">&nbsp;</td>
			<td align="left">
			<input type="submit" name="sub" value="Update" class="button2" />
			<input type="hidden" name="id" value="<?php echo $pageresult['page_id'];?>" />
			
			</td>
		</tr>
	</table>
<?php echo form_close(); ?>
  </div>
</div>
<?php $this->load->view('includes/footer'); ?>