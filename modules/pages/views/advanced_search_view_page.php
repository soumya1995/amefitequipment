<?php $this->load->view("top_application");?>
<div class="content"> 
 <!--Text-->
 <div>
  <h1>Advanced Search</h1>
  <?php echo navigation_breadcrumb("Advanced Search");?>
  <div class="lh20px form-style gray1"> 
   <!--Starts-->
   <?php echo form_open('products/search',array('name'=>"frm11",'method'=>'post'));?>
   <div class="input-left">
    <p class="mt10"><label for="category">Category <b class="red">*</b>  </label></p>
    <p class="mt5">
     <select name="category_id" id="category_id" class="w98">
      <option value="">Select Category</option>
      <?php echo get_root_level_categories_dropdown(0);?>
     </select>
    </p>
   </div>
   
   <div class="input-right">
    <p class="mt10"><label for="keyword">Keyword <b class="red">*</b></label> </p>
    <p class="mt5"><input name="keyword2" id="keyword" type="text" class="w95"></p> 
   </div>
   <div class="cb"></div>
   <p class="mt10"><input type="submit" name="submit" value="Search" class="btn-bg" /></p>
   <?php echo form_open();?>
   <!--Ends-->
  </div>
 </div>
 <div class="cb"></div>
 <?php $this->load->view("pages/newsletter");?>
 <div class="cb"></div>
</div>
<?php $this->load->view("bottom_application");?>