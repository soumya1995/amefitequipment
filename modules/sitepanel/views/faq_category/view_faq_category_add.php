<?php $this->load->view('includes/header');?>
<div class="content">
 <div id="content">
  <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo anchor('sitepanel/faq_category'.($parent_id==0 ? '' : '/index/'.$parent_id),'Back To Listing'); ?> &raquo; <?php echo $heading_title; ?> </a></div>
  <div class="box">
   <div class="heading">
    <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/faq_category.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><?php echo anchor("sitepanel/faq_category/",'<span>Cancel</span>','class="button" ' );?></div>
   </div>
   <div class="content">
   <div style="width:90%;">
   <?php
   	echo validation_message();
    echo error_message();
   ?>
   </div>
    <?php 
    echo form_open_multipart("sitepanel/faq_category/add/".$parent_id);?>
    <div id="tab_pinfo">
     <table width="90%"  class="form"  cellpadding="3" cellspacing="3">
      <tr><th colspan="2" align="center" > </th></tr>
      <?php
      $default_params = array(
				'heading_element' => array(
				'field_heading'=>"Category Title",
				'field_name'=>"faq_category_name",
				'field_placeholder'=>"Your Category Title",
				'exparams' => 'size="40"'
				),
				'url_element'  => array(
				'field_heading'=>"Page URL",
				'field_name'=>"friendly_url",
				'field_placeholder'=>"Your Page URL",
				'exparams' => 'size="40"',
				'pre_seo_url' =>'',
				'pre_url_tag'=>FALSE
				)
			);

			if(is_array($parentData))
			{
			  $pre_seo_url  = base_url().$parentData['friendly_url']."/";
			  $default_params['url_element']['pre_seo_url'] = $pre_seo_url;
			  $default_params['url_element']['pre_url_tag'] = TRUE;
			  $default_params['url_element']['exparams'] = 'size="30"';
			}

			seo_add_form_element($default_params);
			?>

			<?php /*?><tr class="trOdd">
			 <td width="28%" height="26" align="right" >Image :</td>
			 <td align="left"><input type="file" name="faq_category_image" /><br /><br />[ <?php echo $this->config->item('faq_category.best.image.view');?> ]</td>
			</tr>
			<tr class="trOdd">
			 <td width="28%" height="26" align="right" >Alt :</td>
			 <td align="left"><input type="text" name="faq_category_alt" value="<?php echo set_value('faq_category_alt');?>" /><br /></td>
			</tr>
            <?php */?>
			<tr class="trOdd" style="display:none; visibility:hidden;">
			 <td height="26" align="right"> Description :</td>
			 <td><textarea name="faq_category_description" rows="5" cols="50" id="cat_desc" ><?php echo $this->input->post('faq_category_description');?></textarea> <?php  echo display_ckeditor($ckeditor); ?></td>
			</tr>

			<tr class="trOdd">
			 <td align="left">&nbsp;</td>
			 <td align="left">
			  <input type="submit" name="sub" value="Add" class="button2" />
			  <input type="hidden" name="action" value="addfaq_category" />
			  <?php
			  if(is_array($parentData)){
				  ?>
				  <input type="hidden" name="parent_id" value="<?php echo $parentData['faq_category_id'];?>" />
				  <?php
			  }?>
			 </td>
			</tr>
		 </table>
		</div>
		<?php echo form_close(); ?>
	 </div>
	</div>
 </div>
</div>
<?php $this->load->view('includes/footer');?>