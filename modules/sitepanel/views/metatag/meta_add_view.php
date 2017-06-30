<?php $this->load->view('includes/header'); ?>  
 <div id="content">
  
  <div class="breadcrumb">
  
      <?php echo anchor('sitepanel/dashbord','Home'); ?>
 &raquo; <?php echo anchor('sitepanel/meta','Back To Listing'); ?> &raquo;  <?php echo $heading_title; ?>
             
   </div>      
       
 <div class="box">
 
    <div class="heading">
    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
      <div class="buttons">&nbsp; </div>
      
    </div>
          
     <div class="content">
             
        <?php 
        validation_message();
        error_message();
        ?>

       <?php echo form_open('sitepanel/meta/add/');?>  

	<table width="90%"  class="tableList" align="center">
		<tr>
			<th colspan="2" align="center" > </th>
		</tr>
		<tr class="trOdd">
			<td height="26"> URL : <span class="required">*</span></td>
			<td><input type="text" value="<?php echo base_url();?>"  readonly="readonly" size="38"/>
			<input type="text" name="page_url" size="40" value="<?php echo set_value('page_url');?>"></td>
		</tr>
		<tr class="trEven">
			<td width="197" height="26">Title : <span class="required">*</span></td>
			<td width="667" style="f">
			<textarea name="meta_title" rows="5" cols="80" id="title" ><?php echo set_value('meta_title');?></textarea>
			</td>
		</tr>
		<tr class="trEven">
			<td width="197" height="26">Keywords : <span class="required">*</span></td>
			<td width="667" style="f">
			<textarea name="meta_keyword" rows="5" cols="80" id="keyword" ><?php echo set_value('meta_keyword');?></textarea>
			</td>
		</tr>
		<tr class="trEven">
			<td width="197" height="26">Description : <span class="required">*</span></td>
			<td width="667" style="f">
			<textarea name="meta_description" rows="5" cols="80" id="description" ><?php echo set_value('meta_description');?></textarea>
			</td>
		</tr>
		<tr class="trOdd">
			<td align="left">&nbsp;</td>
			<td align="left">
			<input type="submit" name="sub" value="Add" class="button2" />
			<input type="hidden" name="action" value="addmeta" />
			</td>
		</tr>
	</table>
<?php echo form_close(); ?>
  </div>
</div>
<?php $this->load->view('includes/footer'); ?>