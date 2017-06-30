<?php $this->load->view('includes/header');?>
<div id="content">
 <div class="breadcrumb">
  <?php echo anchor('sitepanel/dashbord','Home');
  $segment=4;
  $catid    = (int) $this->uri->segment(4,0);
  if($catid ){
	  echo admin_gym_packages_breadcrumbs($catid,$segment);
  }else{
	  echo '<span class="pr2 fs14">»</span> '.$heading_title;
  }?>
 </div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/gym_packages.png" alt="" /> <?php echo $heading_title; ?></h1>
   <div class="buttons"><?php echo anchor("sitepanel/gym_packages/add/$parent_id","<span>Add $heading_title</span>",'class="button" ' );?></div>
  </div>
  
  <div class="content">
   <?php
   echo error_message();
   echo form_open("sitepanel/gym_packages/index/$parent_id",'id="search_form" method="get" ');
   ?>
   <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
   <table width="100%"  border="0" cellspacing="3" cellpadding="3" >
    <tr>
     <td align="center" >Search [ Gym Packages name ]
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
		      echo anchor("sitepanel/gym_packages/index/$parentid",'<span>Clear Search</span>');
	      }else{
		      echo anchor("sitepanel/gym_packages/",'<span>Clear Search</span>');
	      }
      }?>
      <input type="hidden" name="parent_id" value="<?php echo $parent_id;?>"  />
     </td>
    </tr>
   </table>
   <?php echo form_close();
   
   if(is_array($res) && ! empty($res)){
	   echo form_open("sitepanel/gym_packages/",'id="data_form"');?>
	   <table class="list" width="100%" id="my_data">
	    <thead>
	     <tr>
	      <td width="5%" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
	      <td width="45%" class="left">Name </td>
	      <?php /*?><td width="15%" align="center">Image</td>
	      <td width="10%" class="center">Display Order</td><?php */?>
	      <td width="10%" align="center" >Status</td>
	      <td width="15%" align="center">Action</td>
	     </tr>
	    </thead>
	    <tbody>
	     <?php
	     foreach($res as $catKey=>$pageVal){
		     ?>
		     <tr>
		      <td style="text-align: center;">
		       <input type="checkbox" name="arr_ids[]" value="<?php echo  $pageVal['gym_packages_id'];?>" <?php if($pageVal['is_fixed']=='1') {?> disabled="disabled" <?php } ?>/>
		      </td>
		      <td class="left">
		       <?php echo $pageVal['gym_packages_name'];
		       $gym_packages_set_in = array();
		       if($pageVal['is_fetaured']!="" && $pageVal['is_fetaured']!='0'){
			       $gym_packages_set_in[]="<b class='red'>Featured  : </b> Yes";
		       }			   
			   if($pageVal['is_new']!="" && $pageVal['is_new']!='0'){
			       $gym_packages_set_in[]="<b class='red'>New  : </b> Yes";
		       }
			   if($pageVal['is_hot']!="" && $pageVal['is_hot']!='0'){
			       $gym_packages_set_in[]="<b class='red'>Hot  : </b> Yes";
		       }
			   
		       if(!empty($gym_packages_set_in)){
			       echo "<br /><br />".implode("<br>",$gym_packages_set_in);
		       }
			   ?>
		      </td>
		      <?php /*?><td align="center"><img src="<?php echo get_image('gym_packages',$pageVal['gym_packages_image'],$w,$h,$t);?>" /></td>
		      <td align="center"><?php if($pageVal['is_fixed']=='1'){ echo $displayorder; }else{?><input type="text" name="ord[<?php echo $pageVal['gym_packages_id'];?>]" value="<?php echo $displayorder;?>" size="5"  /><?php }?></td><?php */?>
		      <td align="center"><?php echo ($pageVal['status']==1)? "Active":"In-active";?></td>
		      <td align="center" >
						<?php
						if($this->editPrvg===TRUE)
						{
						 echo anchor("sitepanel/gym_packages/edit/$pageVal[gym_packages_id]/".query_string(),'Edit');
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
							  echo '  '.anchor("sitepanel/gym_packages/delete/$pageVal[gym_packages_id]/".query_string(),'Delete','onclick = \'return confirm("Are you sure to delete this gym_packages");\'');
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
					  <input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onclick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
					<?php
					}
					if($this->deactivatePrvg===TRUE)
					{
					?>
					<input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onclick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
					<?php
					}
					if($this->orderPrvg===TRUE)
					{
						/*
					?>
					  <input name="update_order" type="submit"  value="Update Order" class="button2" />
					<?php
					*/
					}
					if($this->featuredPrvg === TRUE)
					{
					?>
					<?php
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
<?php $this->load->view('includes/footer'); ?>.