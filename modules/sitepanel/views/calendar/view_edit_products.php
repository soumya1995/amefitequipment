<?php $this->load->view("includes/face_header"); $order_id = (int) $this->uri->segment(4);?>
<?php echo form_open(); ?>
<table width="100%" align="center" cellpadding="0" cellspacing="0">
        
<tr><td colspan="2" align="left">

<?php echo validation_message();?>
 <?php echo error_message(); ?>
</td>
  </tr>
  <tr>
    <td  style="padding:10px;"><strong>Product Name* : </strong></td>
    <td   style="padding:10px;">
      <label>
       <textarea name="product" id="product" style="width:300px;height:15px;" ><?php echo set_value('product',$product);?></textarea>
      </label>
   </td>
  </tr>
	
   <tr>
    <td  style="padding:10px;"><strong>Item Count* : </strong></td>
    <td   style="padding:10px;">
      <label>
       <input name="count" id="count" type="number" min="1"><?php echo set_value('count',$count);?>
      </label>
   </td>
  </tr>
	
  <tr>
    <td  style="padding:10px;"><strong>Condition* : </strong></td>
    <td   style="padding:10px;">
      <select name="condition" id="condition">
		  <option value="new">New</option> 
		  <option value="refurbished">Refurbished</option>  
		  <option value="remanufactured">Remanufactured</option>  
		  <?php echo set_value('condition',$condition);?>
	  </select>
   </td>
  </tr>
	
  <tr>
    <td  style="padding:10px;"><strong>Frame Color* : </strong></td>
    <td   style="padding:10px;">
      <select name="frame" id="frame">
		  <option value="red">Red</option> 
		  <option value="blue">Blue</option>  
		  <option value="platinum">Platinum</option>
		  <?php echo set_value('frame',$frame);?>
	  </select>
   </td>
  </tr>
	
  <tr>
    <td  style="padding:10px;"><strong>Pad Color* : </strong></td>
    <td   style="padding:10px;">
      <select name="pad" id="pad">
		  <option value="red">Red</option>
		  <option value="blue">Blue</option>
		  <option value="platinum">Platinum</option>
		  <?php echo set_value('pad',$pad);?>
	  </select>
   </td>
  </tr>
	
   <tr>
    <td  style="padding:10px;"><strong>Brand Name* : </strong></td>
    <td   style="padding:10px;">
      <select name="brand" id="brand">
		  <option value="cybex">Cybex</option>
		  <option value="lifefitness">Life Fitness</option>
		  <option value="hammerstrength">Hammer Strength</option>
		  <option value="stairmaster">Stair Master</option>
		  <option value="freemotion">Free Motion</option>
		  <option value="nautilus">Nautilus</option>
		  <option value="precor">Precor</option>
		  <option value="startrac">Star Trac</option>
		  <option value="technogym">Techno Gym</option>
		  <option value="schwinn">Schwinn</option>
		  <?php echo set_value('brand',$brand);?>
	  </select>
   </td>
  </tr>
 
  <tr>
    <td style="padding:10px;">&nbsp;</td>
    <td style="padding:10px;">
      <label>
        <input type="submit" name="button" id="button" value="Add/Edit" />
      </label>
  </td>
  </tr>
</table>
<?php echo form_close(); ?>
</body>
</html>
