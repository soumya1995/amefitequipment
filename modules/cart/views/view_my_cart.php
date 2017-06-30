<?php $this->load->view("top_application");
$curr_symbol = display_symbol();
?>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<h1 class="heading">Shopping Cart - <span class="blue fs15"><?php echo count($this->cart->contents());?> ITEMS</span></h1>   
    
<ul class="breadcrumb">
<li><a href="<?php echo base_url(); ?>">Home</a></li>
<li class="active">Shopping Cart</li>
</ul>

     <div>
      <div class="bdr mt10 shadow">
      <?php
      echo error_message();
      ?>
      <?php
         if($this->cart->total_items() > 0){
           if( $this->session->userdata('user_id') > 0 ){
               $redirect_page='cart/checkout';
           }else{
               $redirect_page='users/guest_login?ref=cart/checkout';
           }
           echo form_open('','name="cart_frm" id="cart_frm" ');?>
            <div class="cart-head">
                <p class="sn">S. No.</p>
                <p class="cart-product">Product Details</p>	
                <p class="cart-qty">Qty.</p>
                <p class="cart-total">Sub Total</p>   
                <p class="cb"></p>
            </div>
           <?php
			$i=1;
			$shipping_total = 0;
			$shipping_weight = 0;
			$total_tax=0;
			$sub_total=0;
                        $warranty_name = "";
                        $package_name = "";
			foreach($this->cart->contents() as $items){
			 
				$link_url=base_url().$items['friendly_url'];
				
				$amount=(($items['price']+$items['options']['warranty_price']+$items['options']['service_price']+$items['options']['package_price'])*$items['qty']);
				$sub_total+=$amount;
				$mt=($i=='1')?"":"mt5";	
				
				if(!empty($items['options']['service_type']) && !empty($items['options']['warranty_id'])){
			
					$woption["where"] = array('product_id'=>$items['pid'],'type_id'=>$items['options']['warranty_id'],'type'=>'W');
					$wres=$this->warranty_model->get_product_base_price($woption);
                                     
					$warranty_name = $wres['variant_name'];
					//$max_qty = $wres['quantity'];					
				}
				if(!empty($items['options']['service_type']) && !empty($items['options']['package_id'])){
			
					$poption["where"] = array('product_id'=>$items['pid'],'type_id'=>$items['options']['package_id'],'type'=>'P');
					$pres=$this->warranty_model->get_product_base_price($poption);
					$package_name = $pres['variant_name'];
					//$max_qty = $pres['quantity'];					
				}	
				$max_qty = $items['max_qty'];	
				?>  
            <div class="cart-list">
                <p class="sn"><?php echo $i;?>.</p>
                <div class="cart-product">
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 p0">
                <p class="thmb bdr"><span><a href="<?php echo $link_url;?>"><img src="<?php echo get_image('products',$items['img'],'65','85','R');?>" alt="<?php echo $items['origname'];?>" title="<?php echo $items['origname'];?>"></a></span></p>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-8 p0">
                <p class="black fs14"><a href="<?php echo $link_url;?>"><?php echo $items['origname'];?> (<?php echo $items['code'];?>) / <?php echo $items['options']['service_name'];?></a></p>
                               
				<?php 
				if($items['discount_price']!="0.00"){?>            
            	<p>Price:  <del class=" "><?php echo display_price($items['product_price']);?></del> <span class=" blue"><?php echo  display_price($items['discount_price']);?></span></p>
                
                </p>
				<?php
                }else{?>
                    <p>Price: <span class=" blue"><?php echo  display_price($items['product_price']);?></span></p>
                <?php 
                }?>
            
                <?php if(!empty($items['brand'])){?><p class="mt5"><strong>Brand:</strong> <?php echo $items['brand'];?></p><?php } ?>
          		<?php if(!empty($items['color'])){?><p class="mt2"><strong>Color:</strong> <?php echo $items['color'];?></p><?php } ?>
          		<?php if(!empty($items['size'])){?><p class="mt3"><strong>Size:</strong> <?php echo $items['size'];?></p><?php } ?>
                
                <?php if(!empty($items['options']['service_type']) &&  !empty($items['options']['warranty_id'])){?><p class="mt3"><strong>Warranty:</strong> <?php echo $warranty_name;?></p><?php } ?>
                <?php if(!empty($items['options']['service_type']) &&  !empty($items['options']['package_id'])){?><p class="mt3"><strong>Package:</strong> <?php echo $package_name;?></p><?php } ?>
                
                <p class="mt5"><a href="<?php echo base_url(); ?>cart/remove_item/<?php echo $items['rowid']; ?>" onclick="return confirm('Are you sure you want to remove this item?');"><img src="<?php echo theme_url(); ?>images/delete.png" alt=""></a></p>
                </div>
                <p class="clearfix"></p>
                </div>
                <p class="cart-qty"><span class="mob_only fs14 green">Qty.<br></span><a href="javascript:void(0)" onclick="decrease_quantity('qty_<?php echo $i;?>');"><img src="<?php echo theme_url(); ?>images/minus.png" alt="" class="vam"></a><input name="<?php echo $i; ?>[qty]" id="qty_<?php echo $i;?>" type="text" class="fs16 vam text-center" style="width:30px; border:none;" value="<?php echo $items['qty']; ?>" readonly="readonly"><a href="javascript:void(0)" onclick="increase_quantity('qty_<?php echo $i;?>','<?php echo $max_qty;?>');"><img src="<?php echo theme_url(); ?>images/plus.png" alt="" class="vam"></a></p>
                <p class="cart-total"><span class="mob_only fs14 green">Sub Total<br></span> <?php echo display_price($amount);?></p>	 
                <p class="cb"></p>
                <input type="hidden" name="<?php echo $i; ?>[rowid]" id='cart_rowid_<?php echo $i; ?>' value="<?php echo $items['rowid']; ?>" />
            </div>
           <?php
				$i++;
				//$cart_total      = $this->cart->total();
				/*$shipping_total  = array_key_exists('shipment_rate',$shipping_res) ?  $shipping_res['shipment_rate'] : '';	    
				$grand_total      = $cart_total+$shipping_total;*/
				
				//$shipping_weight+=$items['weight_name'];								
											
			}
			$this->session->set_userdata('sub_total',$sub_total);	
			$tax  = ($this->admin_info->tax > 0) ?  $this->admin_info->tax : '0';
			$total_tax = ($sub_total*$tax/100);
			$this->session->set_userdata('total_amount_payable',$sub_total);	
			?>     
        
       </div>
    </div>


	<div class="mt20">
    <p class="text-right fs14">Sub Total: <?php echo display_price($sub_total);?></p>
    <p class="text-right fs14 mt10">Tax (<?php echo display_price($this->admin_info->tax);?> % ): <?php echo display_price($total_tax);?></p>
    <?php /*?><p class="text-right fs14 mt10">Shipping Type: <select class="p4" style="width:120px;">
      <option>Select</option>
    </select></p> <?php */?>   
    <p class="text-right fs19 mt10 b">Amount Payable: <?php echo display_price($this->session->userdata('total_amount_payable')+$total_tax);?></p>
		
	<link href='https://www.freightcenter.com/myaccount/CSS/widget.css' rel='stylesheet' type='text/css' />
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
   <tr>
      <td>
         <div id='htmlPlaceholder'></div>
         <div id='FCfooter'>
            <div id='FCfooterLinks' style='margin-top: -45px; margin-right: 23px; position: relative; z-index: 100;' >

            </div>
         </div>
      </td>
   </tr>
</table>
<script id='widgetscript' src='https://www.freightcenter.com/myaccount/widget.js?WidgetId=10836' type='text/javascript'></script>
		
    <p class="bb2 mt15"></p>
    
		
		
    <div class="mt20">
    <p class="col-lg-8 col-md-8 col-sm-7 p0 mt18">
    	<input name="" type="button" class="btn-style" value="Continue Shopping" onClick="window.open('<?php echo base_url(); ?>category','_parent')"> 
        <input name="Update_Qty" type="submit" class="btn-style" value="Update Cart"></p>
    <p class="col-lg-4 col-md-4 col-sm-5 p0 mt20 text-right"> 
    <br class="mob_only">
    <?php  
		if($this->session->userdata('user_id')==''){?>  
    		<input name="GustCheckout" type="button" class="btn-style2" value="Quick Checkout" onclick="window.open('<?php echo base_url(); ?>users/guest_login?ref=cart/checkout','_parent')">
            <?php
		}?>
    <input name="Checkout" type="submit" class="btn-style2" value="Checkout" onclick="window.open('<?php echo base_url(); ?>cart/checkout','_parent')">
    
    </p>
    <p class="cb"></p>
    </div>
    </div>
	<?php
		echo form_close();	 
   }else{
	   ?>
	   <div class="mt10 p10 fs13 bg4 radius-5 shadow1" align="center"><strong>Your Basket is empty.</strong></div>
	   <div style="height:150px;"></div>
	   <?php
   }?>
</div>
</div>
</div>
<?php
echo form_open("cart",array("name"=>"cartFrm1","id"=>"cartFrm1"));
?>
<input type="hidden" id="uqty" name="qty" value="" />
<input type="hidden" id="urow_id" name="rowid" value="" />
<input type="hidden"  name="action" value="update" />
<?php
echo form_close();
?>
<script>
	function onclickupdate(row_id,qty_id){		
		$("#uqty").val($("#qty_"+qty_id).val());
		$("#urow_id").val(row_id);
		$("#cartFrm1").submit();
	}
	function chk_shipping(url){
		
		var shipping_method=$("#shipping_method").val();
		
		if(shipping_method==''){		
			$("#shp").html("Please select shipping type");
			$("#shipping_method").focus();
			return false;
		}
	}
</script>
<?php $this->load->view("bottom_application");?>