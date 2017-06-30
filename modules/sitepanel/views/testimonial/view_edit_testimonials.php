<?php $this->load->view('includes/header');?>
<div class="content">
 <div id="content">
  <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo $heading_title;?></a></div>
  <div class="box">
   <div class="heading">
    <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title;?></h1>
    <div class="buttons"><?php echo anchor("sitepanel/testimonial",'<span>Cancel</span>','class="button"');?></div>
   </div>
   <div class="content">
    <?php $res=$res[0]; echo validation_message();
    error_message();
    echo form_open_multipart("sitepanel/testimonial/edit/".$res['testimonial_id']);?>
    <div id="tab_pinfo">
     <table width="90%"  class="form"  cellpadding="3" cellspacing="3">
      <tr><th colspan="2" align="center" > </th></tr>
     <?php /*?> <tr class="trOdd">
       <td height="26" align="right" >Title: </td>
       <td align="left"><input type="text" name="testimonial_title" style="width:400px;" value="<?php echo set_value('testimonial_title',$res['testimonial_title']);?>" /></td>
      </tr><?php */?>
      <?php
			$default_params = array(
							'heading_element' => array(
														'field_heading'=>"Name",
														'field_name'=>"poster_name",
														'field_value'=>$res['poster_name'],
														'field_placeholder'=>"",
														 'exparams' => 'size="40"'
													),
							'url_element'  => array(
													  'field_heading'=>"Page URL",
													  'field_name'=>"friendly_url",
													  'field_value'=>$res['friendly_url'],			  
													  'field_placeholder'=>"Your Page URL",
													  'exparams' => 'size="40"',
												   )

						  );
			seo_edit_form_element($default_params);
			
			?>
      <tr class="trOdd">
       <td height="26" align="right"><span class="required">*</span> Email : </td>
       <td><input type="text" name="email" style="width:400px;" value="<?php echo set_value('email',$res['email']);?>" /></td>
      </tr>
      <tr class="trOdd">
       <td height="26" align="right"> <span class="required">*</span> Comment:</td>
       <td><textarea name="testimonial_description" rows="5" style="width:400px;" id="testimonial_description"><?php echo set_value('testimonial_description',$res['testimonial_description']);?></textarea><?php /*echo display_ckeditor($ckeditor);*/?></td>
      </tr>
      <tr class="trOdd">
       <td align="left">&nbsp;</td>
       <td align="left"><input type="submit" name="sub" value="Post" class="button2" /></td>
      </tr>
     </table>
    </div>
    <?php echo form_close();?>
   </div>
  </div>
 </div>  
</div>
<?php $this->load->view('includes/footer');?>