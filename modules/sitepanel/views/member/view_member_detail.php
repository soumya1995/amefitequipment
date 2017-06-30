<?php $this->load->view('includes/face_header');?>
<table width="100%" border="0" cellspacing="4" cellpadding="0" class="grey">
 <tr valign="top" >
  <td colspan="4" align="right" >
   <table width="100%"  border="0" cellspacing="2" cellpadding="2">
    <tr align="left" bgcolor="#1588BB" class="white"><td colspan="7" bgcolor="#CCCCCC" ><strong> Personal Details : </strong></td></tr>
    <!-- <tr valign="top" >
     <td align="left" ><strong>Title : </strong></td>
     <td align="left" ><?php echo $mres['title'];?></td>
     <td align="left" >&nbsp;</td>
     <td align="left" >&nbsp;</td>
    </tr>-->
    <tr valign="top" >
     <td width="19%" align="left" ><strong>  Name : </strong></td>
     <td width="25%" align="left" ><?php echo ucwords($mres['first_name']." ".$mres['last_name']);?></td>
     <td width="21%" align="left" ><strong>Register Date : </strong></td>
     <td width="35%" align="left" > <?php echo $mres['account_created_date'];?></td>
    </tr>
    <tr valign="top" >
     <td align="left" ><strong>User Id : </strong></td>
     <td align="left" ><?php echo $mres['user_name'];?></td>
     <td align="left" ><strong>Password. :</strong></td>
     <td align="left" ><?php echo $this->safe_encrypt->decode($mres['password']);?></td>
    </tr>
    <?php if($mres['phone_number']){?>
    <tr valign="top" >
     <td align="left" ><strong>Phone: </strong></td>
     <td align="left" ><?php echo $mres['phone_number'];?></td>
     <td align="left" >&nbsp;</td>
     <td align="left" >&nbsp;</td>
    </tr>
    <?php }if($mres['mobile_number']){?>
    <tr valign="top" >
     <td align="left" ><strong>Mobile : </strong></td>
     <td align="left" ><?php echo $mres['mobile_number'];?></td>
     <td align="left" >&nbsp;</td>
     <td align="left" >&nbsp;</td>
    </tr>
    <?php }if($mres['fax_number']){?>
    <tr valign="top" >
     <td align="left" ><strong>Fax : </strong></td>
     <td align="left" ><?php echo $mres['fax_number'];?></td>
     <td align="left" >&nbsp;</td>
     <td align="left" >&nbsp;</td>
    </tr>
    <?php }?>
	 <tr valign="top" >
	 <?php
     if($mres['address']){?>
     <td align="left" ><strong>Address :</strong></td>
     <td align="left" ><?php echo $mres['address'];?></td>
     <?php
	 }if($mres['city']){?>
     <td align="left" ><strong>City : </strong></td>
     <td align="left" ><?php echo $mres['city'];?></td>     
     <?php
	 }?>
    </tr>
   
    <tr valign="top" >     
      <?php
     if($mres['state']){?>
     <td align="left" ><strong>State/Region :</strong></td>
     <td align="left" ><?php echo $mres['state'];?></td>
     <?php
	 } if($mres['country']){?>
	 <td align="left" ><strong>Country : </strong></td>
     <td align="left" ><?php echo $mres['country'];?></td>
     <?php
	 }?>
    </tr>
    <?php
	if($mres['customer_type']=='1' || $mres['customer_type']=='0'){
		$seller_arr=$this->config->item('seller_type');
		$gender=($mres['gender']=='M')?'Male':'Female';
		$ven_logo=get_image('logos',$mres['company_logo'],'60','60');
		$ven_docs=get_image('docs',$mres['licence_doc'],'60','60');
		?>
    <?php /*?><tr valign="top" >
      <td align="left" ><strong>Gender :</strong></td>
      <td align="left" ><?php echo $gender;?></td>
      <td align="left" ></td>
      <td align="left" ></td>
    </tr>
    <tr valign="top" >
      <td align="left" ><strong>Company Name :</strong></td>
      <td align="left" ><?php echo $mres['company_name'];?></td>
      <td align="left" ><strong>Alternative Email Id :</strong></td>
      <td align="left" ><?php echo $mres['alternative_email_id'];?></td>
    </tr>
    <tr valign="top" >
      <td align="left" ><strong>Upload Logo :</strong></td>
      <td align="left" ><img src="<?php echo $ven_logo;?>" width="60" height="60" class="fl mr10" alt=""></td>
      <td align="left" ><strong>Customer Support No. (If any) :</strong></td>
      <td align="left" ><?php echo $mres['phone_number'];?></td>
    </tr>
     <tr valign="top" >
      <td align="left" ><strong>Licence Copy :</strong></td>
      <td align="left" ><img src="<?php echo $ven_docs;?>" width="60" height="60" class="fl mr10" alt=""></td>
      <td align="left" ></td>
      <td align="left" ></td>
    </tr><?php */?>
   	<?php
	}?>
   <tr valign="top" >     
     <td align="left" ><strong>Status :</strong></td>
     <td align="left" ><?php echo ($mres['status']==1)?"Active":"In Active";?></td>
	 <td align="left" ></td>
     <td align="left" ></td>
    </tr>
		
    <tr><td colspan="4">&nbsp;</td></tr>
   </table>
  </td>
 </tr>
 <?php if($res_ship['name']){?>
 <tr align="left" valign="top" bgcolor="#1588BB" >
  <td height="28" colspan="2" align="center" valign="middle" bgcolor="#CCCCCC" ><strong> Delivery Information </strong></td>
  <td colspan="2" align="center" valign="middle" bgcolor="#CCCCCC" ><?php /*?><strong>Shipping Details </strong><?php */?></td>
 </tr>
 <tr valign="top" >
  <td width="19%" align="left" ><strong> Name : </strong></td>
  <td width="25%" align="left" ><?php echo ucwords($res_ship['name']);?></td>
  <?php /*?><td width="19%" align="left" ><strong> Name : </strong></td>
  <td width="35%" align="left" ><?php echo ucwords($res_bill['name']);?></td><?php */?>
 </tr>
 <tr valign="top" >
  <td align="left" ><strong>  Address : </strong></td>
  <td align="left" ><?php echo $res_ship['address'];?></td>
	<?php /*?><td align="left" ><strong> Address : </strong></td>
	<td align="left" ><?php echo $res_bill['address'];?></td><?php */?>
 </tr>
	<tr valign="top" >
	<td align="left" ><strong>Phone : </strong></td>
	<td align="left" ><?php echo $res_ship['phone'];?></td>
	<?php /*?><td align="left" ><strong>Phone : </strong></td>
	<td align="left" ><?php echo $res_bill['phone'];?></td><?php */?>
 </tr>
	
 <tr valign="top" >
	<td align="left" ><strong> Postal code : </strong></td>
	<td align="left" ><?php echo $res_ship['zipcode'];?></td>
	<?php /*?><td align="left" ><strong> Postal code : </strong></td>
	<td align="left" ><?php echo $res_bill['zipcode'];?></td><?php */?>
 </tr>
 <tr valign="top" >
	<td align="left" ><strong>Country  : </strong></td>
	<td align="left" ><?php echo ucwords($res_ship['country']);?></td>
	<?php /*?><td align="left" ><strong>Country  : </strong></td>
	<td align="left" ><?php echo ucwords($res_bill['country']);?></td><?php */?>
 </tr>
 <tr valign="top" >
	<td align="left" ><strong>State/Province  :</strong></td>
	<td align="left" ><?php echo ucwords($res_ship['state']);?></td>
	<?php /*?><td align="left" ><strong>State/Province  :</strong></td>
	<td align="left" ><?php echo ucwords($res_bill['state']);?></td><?php */?>
 </tr>
 <tr valign="top" >
	<td align="left" ><strong>City  : </strong></td>
	<td align="left" ><?php echo ucwords($res_ship['city']);?></td>
	<?php /*?><td align="left" ><strong>City  : </strong></td>
	<td align="left" ><?php echo ucwords($res_bill['city']);?></td><?php */?>
 </tr>
 <?php }?>
 <tr align="left" valign="top" ><td colspan="4" align="left">&nbsp;</td></tr>
 <tr align="left" valign="top" bgcolor="#FFFFFF" ><td colspan="4" ><span class="b white"><strong></strong></span></td></tr>
</table>
</body>
</html>