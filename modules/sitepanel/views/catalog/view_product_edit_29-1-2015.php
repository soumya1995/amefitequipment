<?php $this->load->view('includes/header');?>
<div class="content">
 <div id="content">
  <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo anchor('sitepanel/products','Back To Listing'); ?> &raquo;  <?php echo $heading_title;?></div>
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
    echo form_open_multipart(current_url_query_string(),array('id'=>'form'));?>

    <div id="tab-general">
     <table width="90%"  class="form"  cellpadding="3" cellspacing="3">
      <tr><th colspan="2" align="right"><span class="required">*Required Fields</span><br><span class="required">**Conditional Fields</span></th></tr>
      <tr><th colspan="2" align="center" > </th></tr>
      <tr class="trOdd">
       <td height="26" align="right" valign="top" ><span class="required">*</span> Category:</td>
       <td align="left"><select name="category_id" style="width:350px;"  size="8"><?php echo get_nested_dropdown_menu(0,$res['category_id']);?></select></td>
      </tr>
    <?php
			$default_params = array(
							'heading_element' => array(
													  'field_heading'=>$heading_title." Name",
													  'field_name'=>"product_name",
													  'field_value'=>$res['product_name'],
													  'field_placeholder'=>"Your Product Name",
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
               <td width="23%" align="right" ><span class="required">*</span> Product Code :</td>
               <td width="74%" align="left"><input type="text" name="product_code" size="70" value="<?php echo set_value('product_code',$res['product_code']);?>"></td>
          </tr>
      
          <tr class="trOdd">
			 <td height="26" align="right"><span class="required">*</span> Weight:</td>
			 <td align="left">
             	<input type="text" name="product_weight" style="width:100px;" value="<?php echo set_value('product_weight',$res['product_weight']);?>"> <?php echo $this->config->item('weight_unit');?>
             </td>
			</tr>
            
            <tr class="trOdd">
			 <td height="26" align="right"><span class="required">*</span> Width:</td>
			 <td align="left">
             	<input type="text" name="product_width" style="width:100px;" value="<?php echo set_value('product_width',$res['product_width']);?>"> <?php echo $this->config->item('width_unit');?>
             </td>
			</tr>
            
            <tr class="trOdd">
			 <td height="26" align="right"><span class="required">*</span> Height:</td>
			 <td align="left">
             	<input type="text" name="product_height" style="width:100px;" value="<?php echo set_value('product_height',$res['product_height']);?>"> <?php echo $this->config->item('width_unit');?>
             </td>
			</tr>
            
            <tr class="trOdd">
			 <td height="26" align="right"><span class="required">*</span> Length:</td>
			 <td align="left">
             	<input type="text" name="product_length" style="width:100px;" value="<?php echo set_value('product_length',$res['product_length']);?>"> <?php echo $this->config->item('length_unit');?>
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
                    <option value="<?php echo $val["brand_name"];?>" <?php if($val['brand_name']==$res['product_brand']){?> selected="selected" <?php } ?>><?php echo $val["brand_name"];?></option>
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
             	<input type="text" name="product_color" style="width:100px;" value="<?php echo set_value('product_color',$res['product_color']);?>"> 
             </td>
			</tr>
            <tr class="trOdd">
			 <td height="26" align="right">Size:</td>
			 <td align="left">
             	<input type="text" name="product_size" style="width:100px;" value="<?php echo set_value('product_size',$res['product_size']);?>"> 
             </td>
			</tr> 
            
            <tr class="trOdd">
			 <td height="26" align="right"><span class="required">*</span>Stock:</td>
			 <td align="left">
             	<input type="text" name="product_stock" style="width:100px;" value="<?php echo set_value('product_stock',$res['product_stock']);?>"> 
             </td>
			</tr> 
            
            <tr class="trOdd">
			 <td height="26" align="right"><span class="required">*</span>Low Stock:</td>
			 <td align="left">
             	<input type="text" name="low_stock" style="width:100px;" value="<?php echo set_value('low_stock',$res['low_stock']);?>"> 
             </td>
			</tr> 
           
            
			<tr class="trOdd">
			 <td height="26" align="right"><span class="required">*</span> Price <span style="color:red;">[For Buyer]</span>:</td>
			 <td align="left"><input type="text" name="buyer_product_price" size="40" maxlength="8" value="<?php echo set_value('buyer_product_price',$res['buyer_product_price']);?>"> Maximum of 5 digits</td>
			</tr>
			
            <tr class="trOdd">
			 <td height="26" align="right"><span class="required">**</span> Discounted price <span style="color:red;">[For Buyer]</span>:</td>
			 <td align="left"><input type="text" name="buyer_product_discounted_price" size="40" maxlength="8" value="<?php echo set_value('buyer_product_discounted_price',$res['buyer_product_discounted_price']);?>"> Maximum of 5 digits</td>
			</tr> 
            
            <tr class="trOdd">
			 <td height="26" align="right"><span class="required">*</span> Price <span style="color:red;">[For Wholesaler]</span>:</td>
			 <td align="left"><input type="text" name="wholesaler_product_price" size="40" maxlength="8" value="<?php echo set_value('wholesaler_product_price',$res['wholesaler_product_price']);?>"> Maximum of 5 digits</td>
			</tr>
			
            <tr class="trOdd">
			 <td height="26" align="right"><span class="required">**</span> Discounted price <span style="color:red;">[For Wholesaler]</span>:</td>
			 <td align="left"><input type="text" name="wholesaler_product_discounted_price" size="40" maxlength="8" value="<?php echo set_value('wholesaler_product_discounted_price',$res['wholesaler_product_discounted_price']);?>"> Maximum of 5 digits</td>
			</tr>
            
            <tr class="trOdd">
               <td width="23%" align="right" >Coming Soon :</td>
               <td width="74%" align="left"><input type="text" name="product_coming_soon" size="70" value="<?php echo set_value('product_coming_soon',$res['product_coming_soon']);?>"></td>
          </tr>
            
            <tr class="trOdd">
			 <td height="26" align="right">Duration for delivery:</td>
			 <td align="left"><textarea name="delivery_time" id="delivery_time" style="width:230px;height:50px;"><?php echo set_value('delivery_time',$res['delivery_time']);?></textarea></td>
			</tr>	          
            
            <tr class="trOdd">
			 <td align="right" >Description :</td>
			 <td align="left"><textarea name="products_description" rows="5" cols="50" id="description"><?php echo set_value('products_description',$res['products_description']);?></textarea><?php echo display_ckeditor($ckeditor1);?></td>
			</tr>
			
			<tr class="trOdd">
			 <td align="left">&nbsp;</td>
			 <td align="left"><input type="hidden" name="products_id" value="<?php echo $res['products_id'];?>"></td>
			</tr>
		 </table>
		</div>
		<div id="tab-image">
		 <input type="hidden" name="product_exclude_images_ids" value="" id="product_exclude_images_ids" />
		 <table id="images" class="list">
		  <thead><tr><td class="left">Image</td></tr></thead>
		  <table id="images" class="form">
		   <?php
		   //trace($res_photo_media);
		   $j=0;
		   for($i=1;$i<=$this->config->item('total_product_images');$i++){
			   $product_img  = @$res_photo_media[$j]['media'];
			   $product_path = "products/".$product_img;
			   $product_img_auto_id  = @$res_photo_media[$j]['id'];
			   ?>
			   <tr>
			    <td width="28%" align="right"><span class="required">**</span> Image <?php echo $i;?></td>
			    <td width="2%" height="26" align="center" >:</td>
			    <td align="left">
			     <input type="file" name="product_images<?php echo $i;?>" />
			     <?php
			     if( $product_img!='' && file_exists(UPLOAD_DIR."/".$product_path) ){
				     ?>
				     <a href="javascript:void(0);"  onclick="$('#dialog_<?php echo $j;?>').dialog({width:'auto'});">View</a>
				     <?php if($this->deletePrvg===TRUE){?> | <input type="checkbox" name="product_img_delete[<?php echo $product_img_auto_id;?>]" value="Y" />Delete <?php }
			     }?><br /><br />[ <?php echo $this->config->item('product.best.image.view');?> ]

			     <div id="dialog_<?php echo $j;?>" title="Product Image" style="display:none;"><img src="<?php echo base_url().'uploaded_files/'.$product_path;?>"  /> </div>
			     <input type="hidden" name="media_ids[]" value="<?php echo $product_img_auto_id;?>" />
			    </td>
			   </tr>
			   <?php
			   $j++;
		   }?>
		   <tr class="trOdd">
			  <td height="26" align="right" >Alt Tag Text</td>
			  <td height="26" align="center" >:</td>
			  <td align="left"><input type="text" name="product_alt" size="40" value="<?php echo set_value('product_alt',$res['product_alt']);?>"></td>
			 </tr>
		  </table>
		  <tfoot></tfoot>
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
//-->
$('#product_exclude_images_ids').val('');
function delete_product_images(img_id)
{
	//alert($('#product_exclude_images_ids').val());
	img_id = img_id.toString();
	exclude_ids1 = $('#product_exclude_images_ids').val();
	exclude_ids1_arr = exclude_ids1=='' ? Array() : exclude_ids1.split(',');

	if($.inArray(img_id,exclude_ids1_arr)==-1){
		exclude_ids1_arr.push(img_id);
	}

	exclude_ids1 =  exclude_ids1_arr.join(',');

	$('#product_exclude_images_ids').val(exclude_ids1);
	$('#product_image'+img_id).remove();
	$('#del_img_link_'+img_id).remove();

	alert($('#product_exclude_images_ids').val());
}

</script>
<?php $default_date = date('Y-m-d',strtotime(date('Y-m-d',time())));?>
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
<?php $this->load->view('includes/footer');?>