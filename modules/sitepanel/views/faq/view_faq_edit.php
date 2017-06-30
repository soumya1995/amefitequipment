<?php $this->load->view('includes/header');?>
<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo anchor('sitepanel/faq','Back To Listing');?> &raquo; <?php echo $heading_title;?></div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url();?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title;?></h1>
   <div class="buttons">&nbsp;</div>
  </div>
  <div class="content">
   <?php echo validation_message();
   echo error_message();
   echo form_open_multipart(current_url_query_string());?>
   <table width="90%"  class="tableList" align="center" cellpadding="5" cellspacing="5">
    <tr><th colspan="2" align="center" > </th></tr>
    
    <?php
      $selcatID = ($this->input->post('category_id')!='') ? $this->input->post('category_id'): $res['faq_parent_id'];
      $selcatID = (int) $selcatID;
      ?>
      <tr class="trOdd">
       <td align="right" valign="top" ><span class="required">*</span> Category :</td>
       <td align="left">
        <select name="category_id" style="width:380px;"  size="10">
        <option value="">Select Category</option>
         <?php echo get_nested_dropdown_menu_faq(0,$selcatID);?>
        </select>
       </td>
      </tr>
    
    <tr class="trOdd">
     <td height="26">* <span class="left">Question</span>:</td>
     <td><input type="text" name="faq_question" style="width:525px;" value="<?php echo set_value('faq_question',$res['faq_question']);?>"></td>
    </tr>
    <tr class="trEven">
     <td width="197" height="26">* <span class="left">Answer</span>: </td>
     <td width="667" style="f"><textarea name="faq_answer" rows="10" cols="50" style="width:525px;"><?php echo set_value('faq_answer',$res['faq_answer']);?></textarea><?php /*echo display_ckeditor($ckeditor)*/;?></td>
    </tr>
    <tr class="trOdd">
     <td align="left">&nbsp;</td>
     <td align="left">
      <input type="submit" name="sub" value="Edit" class="button2" />
     </td>
    </tr>
   </table>
   <?php echo form_close();?>
  </div>
 </div>
</div>
<?php $this->load->view('includes/footer');?>