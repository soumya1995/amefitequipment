<?php $this->load->view('includes/header');
$pcatID =($this->uri->segment(4) > 0)? $this->uri->segment(4):"0";
$pcatID = (int) $pcatID;

$values_posted_back=(is_array($this->input->post())) ? TRUE : FALSE;
$availability_till_date = $this->input->post('availability_till_date');
?>

<div class="content">
 <div id="content">
  <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo anchor('sitepanel/products','Back To Listing');?> &raquo; <?php echo $heading_title;?></div>
  <div class="box">
   <div class="heading">
    <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title;?></h1>
    <div class="buttons">
     <a href="javascript:void(0);" onclick="$('#form').submit();" class="button">Save</a>
     <?php echo anchor("sitepanel/products",'<span>Cancel</span>','class="button"');?>
    </div>
   </div>
   <div class="content">
    <div id="tabs" class="htabs">
     <a href="#tab-general">General</a>
     <a href="#tab-image">Image</a>
    </div>
    <?php echo validation_message();
    echo error_message();
    echo form_open_multipart('sitepanel/products/add/',array('id'=>'form'));?>

    <div id="tab-general">
     <table width="100%"  class="form"  cellpadding="3" cellspacing="3">
      <tr><th colspan="3" align="right"><span class="required">*Required Fields</span><br><span class="required">**Conditional Fields</span></th></tr>
      <tr><th colspan="3" align="center" > </th></tr>
      <?php
      $selcatID = ($this->input->post('category_id')!='') ? $this->input->post('category_id'): $pcatID;
      $selcatID = (int) $selcatID;
      ?>
      <tr class="trOdd">
       <td align="right" valign="top" ><span class="required">*</span> Category :</td>
       <td align="left">
        <select name="category_id" style="width:380px;"  size="10">
         <?php echo get_nested_dropdown_menu(0,$selcatID);?>
        </select>
       </td>
      </tr>
      
      <?php
			$default_params = array(
								'heading_element' => array(
														  'field_heading'=>"Name",
														  'field_name'=>"product_name",
														  'field_placeholder'=>"Your Product Name",
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
			
			seo_add_form_element($default_params);
			?>
			
			<?php /*?><!--
			<tr class="trOdd">
       <td width="23%" align="right" ><span class="required">*</span> Product Name :</td>
       <td width="74%" align="left"><input type="text" name="product_name" size="70" value="<?php echo set_value('product_name');?>"></td>
      </tr>
      -->   <?php */?> 
      
      		<tr class="trOdd">
               <td width="23%" align="right" ><span class="required">*</span> Product Code :</td>
               <td width="74%" align="left"><input type="text" name="product_code" size="40" value="<?php echo set_value('product_code');?>"></td>
              </tr> 	
            
       		<tr class="trOdd">
			 <td height="26" align="right"><span class="required">*</span> Weight:</td>
			 <td align="left">
             	<input type="text" name="product_weight" style="width:100px;" value="<?php echo set_value('product_weight');?>"> <?php echo $this->config->item('weight_unit');?>
             </td>
			</tr>
            
            <tr class="trOdd">
			 <td height="26" align="right"><span class="required">*</span> Width:</td>
			 <td align="left">
             	<input type="text" name="product_width" style="width:100px;" value="<?php echo set_value('product_width');?>"> <?php echo $this->config->item('width_unit');?>
             </td>
			</tr>
            
            <tr class="trOdd">
			 <td height="26" align="right"><span class="required">*</span> Height:</td>
			 <td align="left">
             	<input type="text" name="product_height" style="width:100px;" value="<?php echo set_value('product_height');?>"> <?php echo $this->config->item('width_unit');?>
             </td>
			</tr>
            
            <tr class="trOdd">
			 <td height="26" align="right"><span class="required">*</span> Length:</td>
			 <td align="left">
             	<input type="text" name="product_length" style="width:100px;" value="<?php echo set_value('product_length');?>"> <?php echo $this->config->item('length_unit');?>
             </td>
			</tr> 
            
            <?php
			if( is_array($brand_res) && !empty($brand_res) ){?> 
            <tr class="trOdd">
			 <td height="26" align="right">Brand:</td>
			 <td align="left">
                <select name="product_brand" id="product_brand" style="width:200px;" style="border:none;">
                <option value="">Select Brand</option>
                <?php
                foreach($brand_res as $val){				
                    //$brandImage=get_image('brand',$val["brand_image"],'307','99');
                    ?>
                    <option value="<?php echo $val["brand_name"];?>" <?php if(set_value('product_brand')==$val['brand_name']){?> selected="selected" <?php } ?>><?php echo $val["brand_name"];?></option>
                    <?php
                }?>
                </select>
             </td>
			</tr>
            <?php
			}?>
            <tr class="trOdd">
			 <td height="26" align="right">Color:</td>
			 <td align="left">
             	<input type="text" name="product_color" style="width:100px;" value="<?php echo set_value('product_color');?>"> 
             </td>
			</tr>
            <tr class="trOdd">
			 <td height="26" align="right">Size:</td>
			 <td align="left">
             	<input type="text" name="product_size" style="width:100px;" value="<?php echo set_value('product_Size');?>"> 
             </td>
			</tr>
            
             <tr class="trOdd">
			 <td height="26" align="right"><span class="required">*</span>Stock:</td>
			 <td align="left">
             	<input type="text" name="product_stock" style="width:100px;" value="<?php echo set_value('product_stock');?>"> 
             </td>
			</tr> 
            
            <tr class="trOdd">
			 <td height="26" align="right"><span class="required">*</span>Low Stock:</td>
			 <td align="left">
             	<input type="text" name="low_stock" style="width:100px;" value="<?php echo set_value('low_stock');?>"> 
             </td>
			</tr>  
            
			<tr class="trOdd">
			 <td height="26" align="right"><span class="required">*</span> Price <span style="color:red;">[For Buyer]</span>:</td>
			 <td align="left"><input type="text" name="buyer_product_price" size="40" maxlength="8" value="<?php echo set_value('buyer_product_price');?>"> Maximum of 5 digits</td>
			</tr>
			
            <tr class="trOdd">
			 <td height="26" align="right"><span class="required">**</span> Discounted price <span style="color:red;">[For Buyer]</span>:</td>
			 <td align="left"><input type="text" name="buyer_product_discounted_price" size="40" maxlength="8" value="<?php echo set_value('buyer_product_discounted_price');?>"> Maximum of 5 digits</td>
			</tr> 
            
            <tr class="trOdd">
			 <td height="26" align="right"><span class="required">*</span> Price <span style="color:red;">[For Wholesaler]</span>:</td>
			 <td align="left"><input type="text" name="wholesaler_product_price" size="40" maxlength="8" value="<?php echo set_value('wholesaler_product_price');?>"> Maximum of 5 digits</td>
			</tr>
			
            <tr class="trOdd">
			 <td height="26" align="right"><span class="required">**</span> Discounted price <span style="color:red;">[For Wholesaler]</span>:</td>
			 <td align="left"><input type="text" name="wholesaler_product_discounted_price" size="40" maxlength="8" value="<?php echo set_value('wholesaler_product_discounted_price');?>"> Maximum of 5 digits</td>
			</tr>
             <tr class="trOdd">
			 <td height="26" align="right"><span class="required">**</span> Services :</td>
			 <td align="left">
                             <?php 
                            $service_type_arr=($this->config->item('service_type'));
                            $i=0;
                            $serv = array();
                                if($this->input->post("service"))
                                {
                                    $service = $this->input->post("service");
                                    foreach($service as $val)
                                    {
                                        $serv[$val] = $val;
                                    }
                                }
                                
                             $price = $this->input->post("price");
                             foreach($service_type_arr as $key=>$val){
                             $checked = (isset($serv[$key]))?"checked='checked'":"";
                             ?>
                             <input type="checkbox" name="service[]" class="serv" <?php echo $checked;?> value="<?php echo $key?>"><?php echo $val;?>&nbsp; &nbsp;<div class="servin" style="display:none;"><input class="spring_test" type="text" style="witdh:350px;" value="<?php echo $price[$i];?>" name="price[]" ></div></div><br>
                             <?php $i++;}?>
                              </td>
			</tr>
            
            <tr class="trOdd">
               <td width="23%" align="right" >Coming Soon :</td>
               <td width="74%" align="left"><input type="text" name="product_coming_soon" size="70" value="<?php echo set_value('product_coming_soon');?>"></td>
          </tr>
            
            <tr class="trOdd">
			 <td height="26" align="right">Duration for delivery:</td>
			 <td align="left"><textarea name="delivery_time" id="delivery_time" style="width:230px;height:50px;"><?php echo set_value('delivery_time');?></textarea></td>
			</tr>	          
            
            <tr class="trOdd">
			 <td align="right" >Description :</td>
			 <td align="left"><textarea name="products_description" rows="5" cols="50" id="description"><?php echo set_value('products_description');?></textarea><?php echo display_ckeditor($ckeditor1);?></td>
			</tr>
			
			<tr class="trOdd">
			 <td align="left">&nbsp;</td>
			 <td align="left">&nbsp;</td>
			 <td align="left">
			  <input type="hidden" name="action" value="addnews" />
			  <input type="hidden" name="pcatID" value="<?php echo $pcatID;?>" />
			 </td>
			</tr>
     </table>
    </div>
    <div id="tab-image">
     <table id="images" class="form">
      <?php for($i=1;$i<=$this->config->item('total_product_images');$i++){?>
      <tr>
       <td width="28%" align="right" ><span class="required">**</span>Image <?php echo $i;?></td>
       <td width="2%" height="26" align="center" >:</td>
       <td align="left"><input type="file" name="product_images<?php echo $i;?>" /><br />[ <?php echo $this->config->item('product.best.image.view');?> ] </td>
      </tr>
      <?php }?>
      <tr class="trOdd">
			 <td height="26" align="right" >Alt Tag Text</td>
			 <td height="26" align="center" >:</td>
			 <td align="left"><input type="text" name="product_alt" size="40" value="<?php echo set_value('product_alt');?>"></td>
			</tr>
            
            <tr class="trOdd">
			  <td height="26" align="right" >Watermark Logo Type</td>
			  <td height="26" align="center" >:</td>
			  <td align="left">
              	<input name="logo_type" value="logo"<?php echo ($this->input->post('logo_type')=="logo") ? '  checked="checked"': ' checked="checked"';?> type="radio" /> Company Logo
                &nbsp;
                <input name="logo_type" value="number"<?php echo ($this->input->post('logo_type')=="number") ? '  checked="checked"': '';?> type="radio" /> Company No.
              </td>
			 </tr>
     </table>
    </div>
    <?php echo form_close();?>
   </div>
  </div>
 </div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs();
$('#languages a').tabs();
$('#vtab-option a').tabs();
//--></script>
<?php
$default_date = date('Y-m-d',strtotime(date('Y-m-d',time())));
$selected_date = $availability_till_date=='' ? $default_date : $availability_till_date;
?>
<script type="text/javascript">
$(document).ready(function(){

  $('.start_date,.end_date').live('click',function(e){
		e.preventDefault();
		cls = $(this).hasClass('start_date') ? 'start_date1' : 'end_date1';
		$('.'+cls+':eq(0)').focus();
	});
	$( ".end_date1").live('focus',function(){
		$(this).datepicker({
			showOn: "focus",
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			defaultDate: 'y',
			buttonText:'',
			minDate:'<?php echo $default_date;?>' ,
			maxDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())."+365 days"));?>',
			yearRange: "c-100:c+100",
			buttonImageOnly: true,
			onSelect: function(dateText, inst) {
				$('.end_date1').val(dateText);
			}
		});
	});
});


</script>
 <script type="application/javascript">
$(document).ready(function(){
$('.spring_test').bind('keyup blur',function(){
	curr_obj = $(this);
	curr_val = curr_obj.val();
	//alert(curr_val);
	curr_obj.val(curr_val.replace(/[^0-9\.]/g, ''));
});
});
</script>
<?php $this->load->view('includes/footer');?>