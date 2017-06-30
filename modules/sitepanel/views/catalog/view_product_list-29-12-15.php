<?php $this->load->view('includes/header');?>
<div class="content">
 <div id="content">
  <div class="breadcrumb">
   <?php echo anchor('sitepanel/dashbord','Home');
   $segment=4;
   $catid = (int)$this->input->get_post('category_id');
   if($catid ){
	   echo admin_category_breadcrumbs($catid,$segment);
   }else{
	   echo '<span class="pr2 fs14">»</span> Products ';
   }
	$seg=$this->uri->rsegment(2);
   ?>
  </div>
  <div class="box">
   <div class="heading">
    <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a href="<?php echo base_url();?>sitepanel/products/add/<?php echo $this->input->get('category_id');?>" class="button">Add product</a></div>
   </div>
   <div class="content">
    <?php
    if(error_message() !=''){
	    echo error_message();
    }?>
    <script type="text/javascript">function serialize_form() { return $('#pagingform').serialize();   } </script>
    <?php echo form_open("",'id="search_form" method="get" ');?>
    <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
    <table width="100%"  border="0" cellspacing="3" cellpadding="3" >
     <tr>
      <td align="center" >Search [ Product Name, Model Number ]
       <input type="text" name="keyword2" value="<?php echo $this->input->get_post('keyword2');?>"  />&nbsp;
       <select name="status">
        <option value="">Status</option>
        <option value="1" <?php echo $this->input->get_post('status')==='1' ? 'selected="selected"' : '';?>>Active</option>
        <option value="0" <?php echo $this->input->get_post('status')==='0' ? 'selected="selected"' : '';?>>In-active</option>
       </select>
       <select name="search_prod_type" style="width:120px;" >
        <option value=""> Select</option>
        <option value="featured_product" <?php if($this->input->get_post('search_prod_type')=='featured_product') { ?> selected="selected" <?php  } ?>>Featured Product</option>
        <option value="hot_product" <?php if($this->input->get_post('search_prod_type')=='hot_product') { ?> selected="selected" <?php  } ?>>Hot Selling</option>		
       </select>
       <input type="hidden" name="category_id" value="<?php echo $this->input->get_post('category_id');?>"  />
       <input type="hidden" name="brand_id" value="<?php echo $this->input->get_post('brand_id');?>"  />
       <a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a>
       <?php
       if( $this->input->get_post('keyword2')!='' || $this->input->get_post('status')!='' || $this->input->get_post('category_id')!='' || $this->input->get_post('brand_id')!='' ){
	       if($this->input->get_post('category_id')!=''){
		       $search_category=$this->input->get_post('category_id');
		       //echo anchor("sitepanel/products?category_id=".$search_category,'<span>Clear Search</span>');
	       }else{
		       echo anchor("sitepanel/products/$seg",'<span>Clear Search</span>');
	       }
       }?>
      </td>
		</tr>
		</table>

		<?php echo form_close();?>
		<div class="required"> <?php echo $category_result_found; ?></div>
		<?php
		if( is_array($res) && !empty($res) ){
			echo form_open(current_url_query_string(),'id="data_form"'); 
			?>
			<table class="list" width="100%" id="my_data">
			 <thead>
			  <tr>
			   <td width="2%" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
			   <td width="26%"  class="left">Product Name</td>
			   <td width="11%" class="left">Product Code</td>
			   <td width="14%" class="right">Product Price</td>		
			   <td width="8%" class="left">Product Image</td>
			   <td width="7%" class="left">Details</td>
			   <td width="8%" class="center">Review</td>
			   <td width="6%" class="center">Status</td>
			   <td width="26%" class="center">Action/Services</td>
			  </tr>
			 </thead>
			 <tbody>
			  <?php
			  $atts = array(
				'width'      => '740',
				'height'     => '600',
				'scrollbars' => 'yes',
				'status'     => 'yes',
				'resizable'  => 'yes',
				'screenx'    => '0',
				'screeny'    => '0'
				);
			  $atts_edit = array(
			  'width'      => '525',
			  'height'     => '375',
			  'scrollbars' => 'no',
			  'status'     => 'no',
			  'resizable'  => 'no',
			  'screenx'    => '0',
			  'screeny'    => '0'
			  );
			  foreach($res as $catKey=>$pageVal){
				  
				  //trace($stock_res);				  
				  ?>
				  <tr>
				   <td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['products_id'];?>" /></td>
				   <td class="left" valign="top">
				    <?php echo $pageVal['product_name'];
				    $product_set_in = array();
				    if($pageVal['featured_product']!="" && $pageVal['featured_product']!='0')
				    $product_set_in[]="<b>Featured  Product: </b> Yes";
				    if($pageVal['new_arrival']!="" && $pageVal['new_arrival']!='0')
				    $product_set_in[]="<b>New Arrival : </b> Yes";
				    if($pageVal['hot_product']!="" && $pageVal['hot_product']!='0')
				    $product_set_in[]="<b>Hot Product : </b> Yes";
					if($pageVal['offered_product']!="" && $pageVal['offered_product']!='0')
				    $product_set_in[]="<b>Offer Product : </b> Yes";
				    if(!empty($product_set_in))
				    {
					    echo "<br /><br />";
					    echo implode("<br>",$product_set_in)."<br />";
				    }?>
				    <div id="dialog_<?php echo $pageVal['products_id'];?>" title="Description" style="display:none;"><?php echo $pageVal['products_description'];?></div>
					
				   </td>
				   <td class="left" valign="top">
				   <?php echo $pageVal['product_code'];?></td>
				   <td align="right" valign="top">
                   <p>
                   <strong>Buyer Price:</strong>
                    <?php 
					if($pageVal['buyer_product_discounted_price']>0){?>
				    	<span style="text-decoration: line-through;"><?php echo display_price($pageVal['buyer_product_price']);?></span><br>
				    	<span style="color: #b00;"><?php echo display_price($pageVal['buyer_product_discounted_price']);?></span>
				    <?php }else{?>
				    	<span><?php echo display_price($pageVal['buyer_product_price']);?></span>
				    <?php 
					}?>
                   </p> 
                   
                   <p>
                   <strong>Wholesaler Price:</strong>
                    <?php 
					if($pageVal['wholesaler_product_discounted_price']>0){?>
				    	<span style="text-decoration: line-through;"><?php echo display_price($pageVal['wholesaler_product_price']);?></span><br>
				    	<span style="color: #b00;"><?php echo display_price($pageVal['wholesaler_product_discounted_price']);?></span>
				    <?php }else{?>
				    	<span><?php echo display_price($pageVal['wholesaler_product_price']);?></span>
				    <?php 
					}?>
                   </p>                   				   
				   </td>
				   <td align="center" valign="top"><img src="<?php echo get_image('products',$pageVal['media'],70,90,'AR');?>" /></td>
				   <td class="left" valign="top">
				    <p><a href="#"  onclick="$('#dialog_<?php echo $pageVal['products_id'];?>').dialog( {width: 650} );">View Details</a></p>
                    <p class="red b">Stock: <?php echo $pageVal['product_stock'];?></p>
                    <p class="red "><em>Low Stock: <?php echo $pageVal['low_stock'];?></em></p>
				   </td>
				   <td class="center" valign="top"><a href="<?php echo base_url().'sitepanel/products/review/'.$pageVal['products_id'];?>">View Review(<?php echo $pageVal['review_count'];?>)</a></td>
				   <td class="center" valign="top">
				   <?php echo ($pageVal['product_status']==1)? "Active":"In-active";?>					
				   </td>
				   <td align="center" valign="top">
				    <?php 
					$service_type_arr=($this->config->item('service_type'));
					
					if($this->editPrvg===TRUE)?>
                    	<p><?php echo anchor("sitepanel/products/edit/$pageVal[products_id]/".query_string(),'Edit');?></p>                        
                        <p>
							<?php
							if(!empty($service_type_arr)){
				   
					  			foreach($service_type_arr as $key=>$serviceVal){ 
							 		echo anchor("sitepanel/products/services/$key/$pageVal[products_id]/".query_string(),'Manage '.$serviceVal.'');?><br />
                                    <?php
								}
							}?>                            
                        </p>
                       
                         <p><?php echo anchor_popup('sitepanel/products/related/'.$pageVal['products_id'], 'Add Related Products', $atts);?><br />
				    	 <?php echo anchor_popup('sitepanel/products/view_related/'.$pageVal['products_id'], 'View Related Products', $atts);?></p>
				   </td>
				  </tr>
				  <?php
			  }?>
			 </tbody>
			</table>
			<?php if($page_links!=''){?>
			<table class="list" width="100%">
			 <tr><td align="right" height="30"><?php echo $page_links; ?></td></tr>
			</table>
			<?php }?>
			<table class="list" width="100%">
			 <tr>
			  <td align="left" colspan="11" style="padding:2px" height="35">
			   <?php if($this->activatePrvg===TRUE)?>
			   <input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onclick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
			   <?php if($this->deactivatePrvg===TRUE)?>
			   <input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onclick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>


			   <?php if($this->deletePrvg===TRUE)?>
			   <input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onclick="return validcheckstatus('arr_ids[]','delete','Record');"/>
			   <?php if($this->featuredPrvg === TRUE){
				   echo form_dropdown("set_as",$this->config->item('product_set_as_config'),$this->input->post('set_as'),'style="width:120px;" onchange="return onclickgroup()"');
				   echo form_dropdown("unset_as",$this->config->item('product_unset_as_config'),$this->input->post('unset_as'),'style="width:120px;" onchange="return onclickgroup()"');
			   }?>
			  </td>
			 </tr>
			</table>
			<?php
			echo form_close();
		}else{
			echo "<center><strong> No record(s) found !</strong></center>" ;
		}?>
	 </div>
	</div>
 </div>	 
</div>
<script type="text/javascript">
function onclickgroup(){
	if(validcheckstatus('arr_ids[]','set','record','u_status_arr[]')){
		$('#data_form').submit();
	}
}
</script>
<?php $this->load->view('includes/footer');?>