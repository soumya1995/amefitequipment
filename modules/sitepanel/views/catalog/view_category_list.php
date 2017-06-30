<?php $this->load->view('includes/header');?>
<div id="content">
 <div class="breadcrumb">
  <?php echo anchor('sitepanel/dashbord','Home');
  $segment=4;
  $catid    = (int) $this->uri->segment(4,0);
  if($catid ){
	  echo admin_category_breadcrumbs($catid,$segment);
  }else{
	  echo '<span class="pr2 fs14">»</span> Category';
  }?>
 </div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
   <div class="buttons"><?php echo anchor("sitepanel/category/add/$parent_id","<span>Add $heading_title</span>",'class="button" ' );?></div>
  </div>
  
  <div class="content">
   <?php
   echo error_message();
   echo form_open("sitepanel/category/index/$parent_id",'id="search_form" method="get" ');
   ?>
   <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
   <table width="100%"  border="0" cellspacing="3" cellpadding="3" >
    <tr>
     <td align="center" >Search [ category name ]
      <input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />&nbsp;
      <select name="status">
       <option value="">Status</option>
       <option value="1" <?php echo $this->input->get_post('status')==='1' ? 'selected="selected"' : '';?>>Active</option>
       <option value="0" <?php echo $this->input->get_post('status')==='0' ? 'selected="selected"' : '';?>>In-active</option>
      </select>
      <a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a>
      
      <?php
      if( $this->input->get_post('keyword')!='' || $this->input->get_post('status')!='' ){
	      $parentid = (int) $this->input->get_post('parent_id');
	      if($parentid > 0 ){
		      echo anchor("sitepanel/category/index/$parentid",'<span>Clear Search</span>');
	      }else{
		      echo anchor("sitepanel/category/",'<span>Clear Search</span>');
	      }
      }?>
      <input type="hidden" name="parent_id" value="<?php echo $parent_id;?>"  />
     </td>
    </tr>
   </table>
   <?php echo form_close();
   
   if(is_array($res) && ! empty($res)){
	   echo form_open("sitepanel/category/",'id="data_form"');?>
	   <table class="list" width="100%" id="my_data">
	    <thead>
	     <tr>
	      <td width="5%" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
	      <td width="45%" class="left">Name </td>
	      <?php /*?><td width="15%" align="center">Image</td><?php */?>
	      <td width="10%" class="center">Display Order</td>
	      <td width="10%" align="center" >Status</td>
	      <td width="15%" align="center">Action</td>
	     </tr>
	    </thead>
	    <tbody>
	     <?php
	     foreach($res as $catKey=>$pageVal){
		     $imgdisplay=FALSE;
		     $displayorder       = ($pageVal['sort_order']!='') ? $pageVal['sort_order']: "0";
		     $total_subcategory  =  $pageVal['total_subcategories'];
		     $condtion_product   =  "AND category_id='".$pageVal['category_id']."'";
		     $total_products     =  count_products($condtion_product);
			 
			 $w='109'; 
			 $h='109';
			 $t='AR';			 
			 $img_arr= pathinfo($pageVal['category_image']);
			 if(!empty($pageVal['category_image'])){
			 			
				 if($img_arr['extension'] == 'png' || $img_arr['extension'] == 'gif'){
					
					$w='109'; 
					$h='109';
					$t='C';
				 }
			 }
		     ?>
		     <tr>
		      <td style="text-align: center;">
		       <input type="checkbox" name="arr_ids[]" value="<?php echo  $pageVal['category_id'];?>" <?php if($pageVal['is_fixed']=='1') {?> disabled="disabled" <?php } ?>/>
		       <input type="hidden" name="category_count" value="Y" />
		       <input type="hidden" name="product_count" value="Y" />
		      </td>
		      <td class="left">
		       <?php echo $pageVal['category_name'];
		       $category_set_in = array();
		       if($pageVal['is_fetaured']!="" && $pageVal['is_fetaured']!='0'){
			       $category_set_in[]="<b class='red'>Featured  : </b> Yes";
		       }			   
			   if($pageVal['is_new']!="" && $pageVal['is_new']!='0'){
			       $category_set_in[]="<b class='red'>New  : </b> Yes";
		       }
			   if($pageVal['is_hot']!="" && $pageVal['is_hot']!='0'){
			       $category_set_in[]="<b class='red'>Hot  : </b> Yes";
		       }
			   
		       if(!empty($category_set_in)){
			       echo "<br /><br />".implode("<br>",$category_set_in);
		       }
		       if($total_subcategory>0){
			       echo "<br><br>".anchor("sitepanel/category/index/".$pageVal['category_id'],'Subcategory ['. $total_subcategory.']','class="refSection" ' );
		       }elseif($total_products>0){
			       echo "<br><br>".anchor("sitepanel/products?category_id=".$pageVal['category_id'],'Products ['. $total_products.']','class="refSection" ' );
		       }else{
			       echo "<br><br>".anchor("sitepanel/category/index/".$pageVal['category_id'],'Subcategory ['. $total_subcategory.']','class="refSection" ')." | ".anchor("sitepanel/products?category_id=".$pageVal['category_id'],'Products ['. $total_products.']','class="refSection" ');
		       }?>
		      </td>
		      <?php /*?><td align="center"><img src="<?php echo get_image('category',$pageVal['category_image'],$w,$h,$t);?>" /></td><?php */?>
		      <td align="center"><?php if($pageVal['is_fixed']=='1'){ echo $displayorder; }else{?><input type="text" name="ord[<?php echo $pageVal['category_id'];?>]" value="<?php echo $displayorder;?>" size="5"  /><?php }?></td>
		      <td align="center"><?php echo ($pageVal['status']==1)? "Active":"In-active";?></td>
		      <td align="center" >
						<?php
						if($this->editPrvg===TRUE)
						{
						 echo anchor("sitepanel/category/edit/$pageVal[category_id]/".query_string(),'Edit');
						 echo "&nbsp;";
						}
						?>
						<?php
						if($pageVal['is_fixed']=='1')
						{
						  echo '<span class="red line-through">Delete</span>';
						}
						else
						{
							if($this->deletePrvg===TRUE)
							{
							  echo '  '.anchor("sitepanel/category/delete/$pageVal[category_id]/".query_string(),'Delete','onclick = \'return confirm("Are you sure to delete this category");\'');
							}
						}						
						?>

					</td>
				</tr>
			<?php
			}
			?>
			</tbody>
			</table>
			<?php
			if($page_links!='')
			{
			?>
			  <table class="list" width="100%">
			  <tr><td align="right" height="30"><?php echo $page_links; ?></td></tr>
			  </table>
			<?php
			}
			?>
			<table class="list" width="100%">
			<tr>
				<td align="left" style="padding:2px" height="35">
					<?php
					if($this->activatePrvg===TRUE)
					{
					?>
					  <input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onClick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
					<?php
					}
					if($this->deactivatePrvg===TRUE)
					{
					?>
					<input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
					<?php
					}
					if($this->orderPrvg===TRUE)
					{
					?>
					  <input name="update_order" type="submit"  value="Update Order" class="button2" />
					<?php
					}
					if($this->featuredPrvg === TRUE)
					{
					?>
					<?php
					if($pageVal['parent_id']==0){
					 echo form_dropdown("set_as",$this->config->item('category_set_as_config'),$this->input->post('set_as'),'style="width:115px; margin-top:5px;" onchange="return onclickgroup()"'); ?>

                    <?php echo form_dropdown("unset_as",$this->config->item('category_unset_as_config'),$this->input->post('unset_as'),'style="width:125px; margin-top:5px;" onchange="return onclickgroup()"'); ?>
                    <?php
                  }
					}
					?>
                </td>
			</tr>
			</table>
			<?php
			echo form_close();
		}else{
			echo "<center><strong> No record(s) found !</strong></center>" ;
		}
		?>
	</div>

</div>
<script type="text/javascript">
	function onclickgroup(){
		if(validcheckstatus('arr_ids[]','set','record','u_status_arr[]')){
			$('#data_form').submit();
		}
	}
</script>
<?php $this->load->view('includes/footer'); ?>