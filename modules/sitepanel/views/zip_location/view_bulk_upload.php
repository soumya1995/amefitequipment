<?php $this->load->view('includes/header'); ?>  
  <div id="content">
  
  <div class="breadcrumb">
  
       <?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> </a>   
             
   </div>      
       
 <div class="box">
 
    <div class="heading">
    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
    </div>
      
     <div class="content">   
     
     <?php echo validation_message();?>
     <?php echo error_message(); ?>      
     
      
	 <?php echo form_open_multipart("sitepanel/zip_location/uploads_location",'id="data_form"');?>
     
	  <table class="list" width="100%" id="my_data">
     
        <tbody>
          
          <tr>
            <td width="57%" style="text-align: center;"><br />
              <br />
              <span style="color:#F00">*</span> Import Excel File:
              <input type="file" name="excel_file" id="excel_file" /><br /><br /> <br />
              <input type="submit" name="sub" value="Upload Excel File" class="button2" />
              <input type="hidden" name="action" value="excel_file" /> <br /> <br /> <br /> <br /><br />
              <br />
              <br />
              <br />
              <br />
              <br /></td>
            <td width="43%" style="text-align: center;"><a href="<?php echo base_url()?>assets/sample/sample_location.xls" style="color:#FF0000;">Download View Sample Location Excel File</a></td>
            
          </tr>
          
               
        </tbody>
    	
      </table>
	<?php echo form_close();?> 
	 
  </div>
</div>
<?php $this->load->view('includes/footer'); ?>