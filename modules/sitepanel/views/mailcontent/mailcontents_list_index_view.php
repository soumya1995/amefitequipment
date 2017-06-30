<?php $this->load->view('includes/header'); ?>   
<div id="content">
  <div class="breadcrumb">
      <?php echo anchor('sitepanel/dashbord','Home'); ?>
        &raquo;  Mail Contents   </a>        
      </div>
      <div class="box">
    <div class="heading">
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">&nbsp;</div>
    </div>
    <div class="content">
          
       <?php  echo error_message(); ?>
		<?php echo form_open("sitepanel/mailcontents/",'id="pagingform" method="get" '); ?>
         <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
       <?php echo form_close();?>
  
  
    
    
      <?php
      error_message();
	  validation_message();
      ?>
                
     <?php	 
	 if( count($pagelist) > 0 ){ 
	 ?>
		<?php echo form_open("sitepanel/mailcontents/",'id="data_form"');?>
		<table class="list" width="100%" id="my_data">  
        <thead>
         
          <tr>
            <td width="420" class="left">Section</td>
			<td width="300"  align="center">Details</td>
			<td width="102" align="center">Action</td>
          </tr>
        </thead>
        <tbody>
          <?php		  
		    $srlno=0; 		
			foreach($pagelist as $catKey=>$pageVal){ 			  
		    $srlno++; 
		   ?> 
          <tr>
            <td class="left"><?php echo $pageVal['email_section'];?></td>
			<td align="center" valign="middle">            
              <a href="#"  onclick="$('#dialog_<?php echo $pageVal['id'];?>').dialog({ width: 650 });">view</a>              
			  <div id="dialog_<?php echo $pageVal['id'];?>" title="Mail Content" style="display:none;">
			    <?php echo $pageVal['email_content'];?>
               </div>  
            </td>
            <td align="center" valign="middle">
			 <?php
			 if($this->editPrvg===TRUE)
			 {
			 ?>
			  <?php echo anchor("sitepanel/mailcontents/edit/$pageVal[id]/".query_string(),'Edit'); ?>
			<?php
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
			<?php echo form_close(); ?>
 <?php 
  }else{
	  
    echo "<center><strong> No record(s) found !</strong></center>" ;
	
 }
?>        
      
  </div>
</div>
<?php $this->load->view('includes/footer'); ?>