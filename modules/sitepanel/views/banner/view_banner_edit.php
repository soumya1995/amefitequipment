<?php
$curr_sec_val=$this->input->post('section') ? $this->input->post('section') :  $res->banner_page;
$curr_position_val=$this->input->post('banner_position') ? $this->input->post('banner_position') :  $res->banner_position;
?>
<?php $this->load->view('includes/header'); ?>  
 <div id="content">
  
  <div class="breadcrumb">
  
      <?php echo anchor('sitepanel/dashbord','Home'); ?>
 &raquo; <?php echo anchor('sitepanel/banners','Back To Listing'); ?> &raquo;  <?php echo $heading_title; ?> 
             
   </div>      
       
 <div class="box">
 
    <div class="heading">
    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
      <div class="buttons">&nbsp;</div>
      
    </div>
   
<div class="content">       
<?php echo validation_message('');?>
<?php echo error_message(); ?> 
<?php echo form_open_multipart(current_url_query_string());?>    
<table width="90%"  class="form"  cellpadding="3" cellspacing="3">
<tr>
	<th colspan="2" align="center" > </th>
</tr>
<!--<tr class="trOdd">
	<td width="28%" height="26" align="right" ><span class="required">*</span> Section:</td>
	<td width="72%" align="left">
		<select name="section" onchange="change_ban_postions(this.value);">
			<option value="">Select Section</option>
			<?php 
			foreach ($this->config->item('bannersections')  as $key=>$val)
			{
				$sel = ($curr_sec_val==$key ) ? "selected" : "";
				?> 
				<option value="<?php echo $key;?>" <?php echo $sel;?> ><?php echo $val ;?></option> 
			<?php 
			} 
			?>  
		</select>
	</td>
</tr>-->
<tr class="trOdd">
	<td width="28%" height="26" align="right" ><span class="required">*</span> Banner Position:</td>
	<td width="72%" align="left">
    	<div id="ban_postion">
                
                <?php echo banner_postion_drop_down('banner_position',set_value('banner_postion',$res->banner_position),set_value('section',$res->banner_page));?>
					                    </div>
		
	</td>
</tr>
<tr class="trOdd">
<td width="28%" height="26" align="right" ><span class="required">*</span> Banner Image:</td>
	<td align="left">
		<input type="file" name="image1" id="image1" />                 
		<?php
		 $j=1;
		 $product_path = "banner/".$res->banner_image;
		?>
         <a href="#"  onclick="$('#dialog_<?php echo $j;?>').dialog({width:'auto'});">View</a>
         <div id="dialog_<?php echo $j;?>" title="Banner Image" style="display:none;">
         <img src="<?php echo base_url().'uploaded_files/'.$product_path;?>"  /> </div>
        
		<br />
	</td>
</tr>
 <tr class="trOdd">
				<td width="28%" height="26" align="right" ><span class="required"></span> Banner Url:</td>
				<td align="left">
					<input type="text" name="banner_url" style="width:210px;"  value="<?php echo set_value('banner_url',$res->banner_url);?>" />
					<br />
				</td>
			</tr>
<tr class="trOdd">
	<td align="left">&nbsp;</td>
	<td align="left">
		<input type="submit" name="sub" value="Update Banner" class="button2" />
		<input type="hidden" name="action" value="addbanner" />
	</td>
</tr>
</table>    
</div>
</div>
<script type="text/javascript">
function change_ban_postions(){
	var section = $('[name="section"]').val();
	if(section != '' && section != 'undefined')
	{
		$.ajax({
				  type: "POST",
				  url: "<?php echo base_url();?>sitepanel/banners/ajx_ban_postions",
				  data: { banner_section : section }
				}).done(function( data ) {
				  $('#ban_postion').html(data);
				});
		
		
	}
	return false;
	
}
</script>
<?php $this->load->view('includes/footer'); ?>