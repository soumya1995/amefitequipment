<?php $this->load->view('includes/face_header'); ?>
<table width="100%" border="0" cellspacing="4" cellpadding="0" class="grey">
                <tr valign="top" >
                  <td colspan="4" align="right" >
		
				  <table width="100%"  border="0" cellspacing="2" cellpadding="2">
                    <tr align="left" bgcolor="#1588BB" class="white">
                  <td colspan="7" bgcolor="#CCCCCC" ><strong> Personal Details : </strong></td>
                 </tr>
                    <tr valign="top" >
                      <td align="left" ><strong>Title : </strong></td>
                      <td align="left" ><?php echo $mres['title'];?></td>
                      <td align="left" >&nbsp;</td>
                      <td align="left" >&nbsp;</td>
                    </tr>
                    <tr valign="top" >
                      <td width="19%" align="left" ><strong>  Name : </strong></td>
                      <td width="25%" align="left" >
					  <?php echo $mres['first_name'];?> <?php echo $mres['last_name'];?>
                     </td>
                      <td width="21%" align="left" ><strong>Register Date : </strong></td>
                      <td width="35%" align="left" > <?php echo $mres['account_created_date'];?>
					</td>
                    </tr>
                    <tr valign="top" >
                      <td align="left" ><strong>User Id : </strong></td>
                      <td align="left" ><?php echo $mres['user_name'];?></td>
                      <td align="left" ><strong>Password. :</strong></td>
                      <td align="left" ><?php echo $this->safe_encrypt->decode($mres['password']);?></td>
                    </tr>
                   
                  
                    <tr>
                      <td colspan="4">&nbsp;</td>
                    </tr>
                  </table>
				
				  </td>
                </tr>
                <tr align="left" valign="top" bgcolor="#1588BB" >
                  <td height="28" colspan="2" align="center" valign="middle" bgcolor="#CCCCCC" >
				  <strong> Billing Address </strong></td>
                  <td colspan="2" align="center" valign="middle" bgcolor="#CCCCCC" >
				  <strong>Shipping Details </strong></td>
           </tr>
                <tr valign="top" >
                  <td width="19%" align="left" ><strong> Name : </strong></td>
                  <td width="25%" align="left" ><?php echo $res_bill['name'];?></td>
                  <td width="19%" align="left" ><strong> Name : </strong></td>
                  <td width="35%" align="left" ><?php echo $res_ship['name'];?></td>
                </tr>
                <tr valign="top" >
                  <td align="left" ><strong>  Address : </strong></td>
                  <td align="left" ><?php echo $res_bill['address'];?></td>
                  <td align="left" ><strong> Address : </strong></td>
                  <td align="left" ><?php echo $res_ship['address'];?></td>
                </tr>
                <tr valign="top" >
                  <td align="left" ><strong>Phone : </strong></td>
                  <td align="left" ><?php echo $res_bill['phone'];?></td>
                  <td align="left" ><strong>Phone : </strong></td>
                  <td align="left" ><?php echo $res_ship['phone'];?></td>
                </tr>
              
                <tr valign="top" >
                  <td align="left" ><strong> Postal code : </strong></td>
                  <td align="left" ><?php echo $res_bill['zipcode'];?></td>
                  <td align="left" ><strong> Postal code : </strong></td>
                  <td align="left" ><?php echo $res_ship['zipcode'];?></td>
                </tr>
                <tr valign="top" >
                  <td align="left" ><strong>Country  : </strong></td>
                  <td align="left" ><?php echo $res_bill['country'];?></td>
                  <td align="left" ><strong>Country  : </strong></td>
                  <td align="left" ><?php echo $res_ship['country'];?></td>
                </tr>
                <tr valign="top" >
                  <td align="left" ><strong>State/Province  :</strong></td>
                  <td align="left" ><?php echo $res_bill['state'];?></td>
                  <td align="left" ><strong>State/Province  :</strong></td>
                  <td align="left" ><?php echo $res_ship['state'];?></td>
                </tr>
                <tr valign="top" >
                  <td align="left" ><strong>City  : </strong></td>
                  <td align="left" ><?php echo $res_bill['city'];?></td>
                  <td align="left" ><strong>City  : </strong></td>
                  <td align="left" ><?php echo $res_ship['city'];?></td>
                </tr>
                <tr align="left" valign="top" >
                  <td colspan="4" align="left">&nbsp;</td>
  </tr>
                <tr align="left" valign="top" bgcolor="#FFFFFF" >
                  <td colspan="4" ><span class="b white"><strong> 


 </strong></span></td>
  </tr>
</table>
</body>
</html>