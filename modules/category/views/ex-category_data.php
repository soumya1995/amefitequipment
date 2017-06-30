<?php
if(is_array($res) && !empty($res) ){
	$counter=0;
	foreach($res as $val){
		$total_subcategories = $val['total_subcategories'];
		  if($total_subcategories<=0){
			  $link_url = base_url()."products/index/".$val['category_id'];
		  }else{
			  $link_url = "javascript:void(0)";
		  }		
		?>
            <div class="categories-box listpager">
                <p class="fs14 ttu black"><a href="<?php echo $link_url;?>" class="u"><?php echo $val['category_name'];?></a></p>
                <?php
				if($val['total_subcategories'] > 0){
				 $condtion_array2 = array(
				 'field' =>"*",
				 'condition'=>"AND parent_id = '".$val['category_id']."' AND status='1'",
				 'order'=>'sort_order',
				 'debug'=>FALSE
				 );
	
				 $condtion_array2['offset'] = 0;
				 $condtion_array2['limit'] = 5;
				 $res2 = $this->category_model->getcategory($condtion_array2);
				 $total_sub_categories2	=  $this->category_model->total_rec_found;
			?> 
                <div class="catelink">
                <p class="list-link o-hid" style="min-height:37px;">
				 <?php
                      foreach($res2 as $val2){
                          $sub_link_url = base_url().$val2['friendly_url'];
                          $sub_category_name = strlen($val2['category_name']) > 25 ? char_limiter($val2['category_name'],25,'') : $val2['category_name'];
						  
						   $condtion_array3 = array(
							 'field' =>"*",
							 'condition'=>"AND parent_id = '".$val2['category_id']."' AND status='1'",
							 'order'=>'sort_order',
							 'debug'=>FALSE
							 );
				
							 $condtion_array3['offset'] = 0;
							 $condtion_array3['limit'] = 100;
							 $res3 = $this->category_model->getcategory($condtion_array3);
							 $total_sub_categories3	=  $this->category_model->total_rec_found;
                          ?>
                             <a href="<?php echo $sub_link_url;?>"><?php echo $sub_category_name;?> <span>(<?php echo $total_sub_categories3;?>)</span></a>
                             <?php
					  }?>
                    
                    </p>
                <p class="clearfix"></p>
                <?php if($total_sub_categories2 >6 ){?><p class="mt2 text-right"><a href="<?php echo $link_url;?>">Show all</a></p><?php } ?>
                </div>
               	<?php
				}else{
					
					
					
					?>
                	<div class="catelink">
                		<p class="list-link o-hid" style="min-height:37px;"><strong>No sub-category found !</strong></p>
                        
                    </div>
                <?php
				}?>
            </div>
        
               
        <?php /*?> <li class="listpager">
          <div>
            <div class="pro_pcs">
              <figure><a href="<?php echo $link_url;?>" title="<?php echo $val['category_name'];?>"><img src="<?php echo $cateImage;?>" alt="<?php echo $val['category_alt'];?>"></a></figure>
            </div>
            <a href="<?php echo $link_url;?>" title="<?php echo $val['category_name'];?>" class="cat_title trans_eff"><?php echo char_limiter($val['category_name'],25);?></a> 
           </div>
        </li> <?php */?>         
		<?php
	}
}?>
  