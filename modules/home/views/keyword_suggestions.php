<ul>
<?php 
 if(is_array($result) && !empty($result)){
	foreach($result as $value){ 
	 ?>
     <li><a href="#" onclick='fill_products("<?php echo $value['product_name'];?>");'><?php echo $value['product_name'];?></a></li>
     <?php
	}
 }

?>
</ul>