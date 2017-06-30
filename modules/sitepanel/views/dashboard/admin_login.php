<?php $this->load->view('includes/header'); ?>   
   <div class="content"> 
  
<div class="box" style="width: 325px; min-height: 500px; margin-top: 40px; margin-left: auto; margin-right: auto;">

   
  <div class="heading"> 
      <h1><img src='<?php echo base_url(); ?>assets/sitepanel/image/lockscreen.png'>Please enter your login details.</h1>
    </div>
  
    
  <div class="content" style="min-height: 150px;">
   
    
    <?php 
	 
	     $atts = array(
              'width'      => '650',
              'height'     => '400',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
	 
	 ?>
    <?php echo form_open('sitepanel/auth'); ?>
		
      
    <table style="width: 100%;">
      <tr>
        <td colspan="2" align="center"><?php  echo error_message();?></td>
      </tr>
       <tr>
         <td rowspan="4" style="text-align: center;"><img src="<?php echo base_url(); ?>assets/sitepanel/image/login.png" alt="Please enter your login details." /></td>
      </tr>
        
      <tr>
        <td width="80%">Username:<br />
          <input type="text" name="username" value="" style="margin-top: 4px;" />
          <?php echo form_error("username","<div style='color:red'>","</div>") ?>
          <br />
          <br />
          Password:<br />
          <input type="password" name="password" value="" style="margin-top: 4px;" />
                    <?php echo form_error("password","<div style='color:red'>","</div>") ?>
          </td>
      </tr>
        
      <tr>
        <td align="right">
	    <?php echo anchor_popup('sitepanel/forgotten_password/','Forgot Password?',$atts);?></td>
      </tr>
      <tr>
        <td align="left" >
          <input type="hidden" value="login" name="action"> 
          <input type="submit" name="sss" value="Login"  class="button2" />
                    
        </td>
      </tr>
        
    </table>
      
 <?php echo form_close(); ?>
    </div>
</div> 
<?php $this->load->view('includes/footer'); ?>