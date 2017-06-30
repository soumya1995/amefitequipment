<?php $this->load->view('admin/popup_header'); ?>
<table width="100%"  border="0" cellspacing="5" cellpadding="5" class="list">
<thead>
<tr >
	<td colspan="3" height="30"><?php echo $heading_title; ?></td>
</tr>
</thead>
<tr class="trOdd">
	<td> Add Date </td>
	<td>:</td>
	<td><?php echo $res->recive_date;?></td>
</tr>
<tr class="trOdd">
	<td width="19%">Product Name </td>
	<td width="3%">: </td>
	<td width="78%"><?php echo $res->product_name;?> </td>
</tr>
<tr class="trEven">
	<td>Product Code</td>
	<td>: </td>
	<td><?php echo $res->product_code;?> </td>
</tr>

<tr class="trOdd">
	<td>Category</td>
	<td>:</td>
	<td>
	<?php
	if (is_array($categoryProducts) && !empty ($categoryProducts) )
	{
		$categoryAvailable=array();
		foreach($categoryProducts as $key=>$val)
		{
			array_push($categoryAvailable,$val['cat_name']);
		}
		echo implode(" &laquo; ",$categoryAvailable);
	}else{
		echo "-";
	}
	?>
	</td>
</tr>


<tr class="trOdd">
	<td>Price</td>
	<td>: </td>
	<td><?php echo display_price($res->pprice);?> </td>
</tr>
<?php if($res->discount_price !='0.00'){ ?>
<tr class="trOdd">
	<td>Discounted Price</td>
	<td>: </td>
	<td><?php echo display_price($res->discount_price);?> </td>
</tr>
<?php } ?>
<tr class="trOdd">
	<td>Description</td>
	<td>: </td>
	<td><?php echo $res->description;?> </td>
</tr>
<!--<tr class="trOdd">
	<td>Category Status</td>
	<td>: </td>
	<td><?php echo ($res->cat_status==1)? "Active":"In-active";?> </td>
</tr>
<tr class="trOdd">
	<td>Status</td>
	<td>: </td>
	<td><?php echo ($res->status==1)? "Active":"In-active";?> </td>
</tr>-->
</table>
</body>
</html>