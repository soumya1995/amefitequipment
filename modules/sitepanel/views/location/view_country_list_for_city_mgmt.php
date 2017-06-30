<?php $this->load->view('includes/header'); ?> 
<div id="content">
 
<div class="breadcrumb"> <?php echo anchor('sitepanel/dashbord','Home'); ?>
 &raquo; <?php echo $heading_title; ?> </div>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('<?php echo base_url(); ?>assets/admin/image/category.png');">   <?php echo $heading_title; ?></h1>
	
  </div>
  <script type="text/javascript">function serialize_form() { return $('#myform').serialize();   } </script> 
  <div class="content">
  
     <?php 
	 echo form_open("sitepanel/country/",'id="myform"');?>
        <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3" >
				<?php 
                if(error_message() !=''){
               	   echo error_message();
                }
                ?> 
                <tr>
					<td align="center" >Search(country) <input type="text" class="my_text" name="keyword" value="<?php echo $this->input->post('keyword');?>"  />&nbsp;<input type="hidden" name="stchstatussrch" value="1">
					<a  onclick="$('#myform').submit();" class="button"><span> GO </span></a>
					
		<?php if( $this->input->get_post('keyword')!='' )
					 { 
					    echo anchor(current_url(),'<span>View All</span>');
					 } ?>
					</td>
				</tr>
			</table>
	 <?php echo form_close();?>	 
	 <?php 
	     if( is_array($pagelist) && !empty($pagelist) ) {
		 echo form_open("sitepanel/country/change_status/",'id="myform"');?>
	      <table class="list" width="100%" id="my_data">
     
        <thead>
          <tr>
            <td width="20" style="text-align: center;"><!--<input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" />-->Sn.</td>
            <td width="189" class="left">Country</td>
             <td width="164" class="left">State</td>
             <td width="72" class="right">Action</td>
          </tr>
        </thead>
		
        <tbody>
          <?php 
			$ctr=1;
			foreach($pagelist as $catKey=>$pageVal){ 	
			   
			   $imgjpggiftsuv=($pageVal['contID']<=114)?".gif":".jpg";
		   ?> 
          <tr>
            <td style="text-align: center;"><?php echo $ctr;?><!--<input type="checkbox" name="arr_ids[]" value="<?=$pageVal['id'];?>" />--></td>
            <td class="left">
			
			<?php echo $pageVal['country_name'];?> </td>
            <td class="left">
            
           <?php /*?> <a href="<?php echo base_url();?>sitepanel/state/<?php echo $pageVal['id'];?>"><strong>View State Listing</strong></a><?php */?>
         
         <a href="<?php echo base_url();?>sitepanel/city_by_country/index/<?php echo $pageVal['id'];?>"><strong>Manage City</strong></a>   
            </td>
            <td class="right"><?php echo ($pageVal['status']==1)? "Active":"In-active";?></td>
          </tr>
          <?php
		     $ctr++;
		   }		  
		  ?> 
          <tr><td colspan="7" align="right" height="30"><?php echo $page_links; ?></td></tr>     
        </tbody>
    	<tr>
				<td height="35" colspan="7" align="left" style="padding:2px">
					<!--<input name="Activate" type="submit"  value="Activate" class="button2" id="Activate" onclick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
					<input name="Deactivate" type="submit" class="button2" value="Deactivate" id="Deactivate"  onclick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
					<input name="Delete" type="submit" class="button2" id="Delete" value="Delete"  onclick="return validcheck('arr_ids[]','delete','Record');"/>-->
				</td>
			</tr>
      </table>
	<?php echo form_close();
	 }else{
	    echo "<center><strong> No record(s) found !</strong></center>" ;
	 }
	?> 
	 
  </div>
</div>

</div>
<?php $this->load->view('includes/footer'); ?>