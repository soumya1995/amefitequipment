<?php $this->load->view('includes/face_header'); ?>           
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="left" valign="top"> 
      <?php echo form_open('sitepanel/forgotten_password/');?>  
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="100%">
     
          <table width="100%" align="right" cellpadding="2"  cellspacing="2" >
            <tr>
              <td colspan="2" align="right" bgcolor="#F8F8F8"><img src="<?php echo base_url(); ?>assets/images/spacer.gif" width="1" height="2" alt="" /></td>
              </tr>
              <tr><td colspan="2" align="center"><span style=" color:#F00"><strong><?php echo $this->session->flashdata('message'); ?></strong></span></td></tr>
            <tr>
              <td width="42%" align="right" bgcolor="#F8F8F8">Enter Your Email ID <span class=" blue b ft-13"><span class="red">*</span></span> :</td>
              <td width="58%" align="left" bgcolor="#F8F8F8">
              <input name="email" type="text" id="textfield2" style="width:270px;" /><br /> <span style=" color:#F00"><?php echo form_error('email');?></span></td>
            </tr>
            <tr>
              <td  align="right" bgcolor="#F8F8F8"> Word Verification <b class="red">*</b>  :
                           
              </td>
              <td align="left" valign="middle" bgcolor="#F8F8F8"><p style="float:left;"><input type="text" name="verification_code" id="verification_code" class="input-bdr2" style="width:150px;"></p><p style="float:left;"><img src="<?php echo site_url('captcha/normal'); ?>" class="vam bdr" alt=""  id="captchaimage"/><a href="javascript:viod(0);" title="Change Verification Code"  ><img src="<?php echo theme_url(); ?>images/ref.png"  alt="Refresh"  onclick="document.getElementById('captchaimage').src='<?php echo site_url('captcha/normal'); ?>/<?php echo uniqid(time()); ?>'+Math.random(); document.getElementById('verification_code').focus();" class="ml10 vam"></a></p>
              <span style=" color:#F00;float:left;"><?php echo form_error('verification_code');?></span>
                </td>
            </tr>
            <tr>
              <td  align="right" bgcolor="#F8F8F8">&nbsp;</td>
              <td align="left" bgcolor="#F8F8F8" class="pb7">&nbsp;
               <input name="forgotme" type="submit"  value="Submit" /> 
              <input type="hidden" name="forgotme" value="yes" />
              </td>
            </tr>
          </table></td>
          
        </tr>
      </table>
      <?php echo form_close();?> 
      
      </td>
  </tr>
</table>

</body>
</html>
