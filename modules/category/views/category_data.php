<?php
if(is_array($res) && !empty($res) ){
	$counter=0;
	foreach($res as $val){
		$total_subcategories = $val['total_subcategories'];
		  if($total_subcategories<=0){
			  $link_url = base_url().$val['friendly_url'];
			  //$link_url = base_url()."products/index/".$val['category_id'];
		  }else{
			  //$link_url = "javascript:void(0)";
			  $link_url = base_url().$val['friendly_url'];
		  }		
		?>
            <div class="categories-box listpager">
                <h2 class="fs15 ttu black"><a href="<?php echo $link_url;?>" class="u"><?php echo $val['category_name'];?></a></h2>
                <div class="fs16 black mt10 ml10"><?php echo substr(strip_tags($val['category_description']),0,120).'...';?><a href="<?php echo $link_url;?>">Read More >></a></div>
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
                             <a href="<?php echo $sub_link_url;?>"><?php echo $sub_category_name;?><?php if($total_sub_categories3>0){?> <span>(<?php echo $total_sub_categories3;?>)<?php }?></span></a>
                             <?php
					  }?>
                    
                    </p>
                <p class="clearfix"></p>
                <?php if($total_sub_categories2 >6 ){?><p class="mt2 text-right"><a href="<?php echo $link_url;?>">Show all</a></p><?php } ?>
                </div>
               	<?php
				}else{
			     $cond_products = array('status'=>'1','orderby'=>'rand()');
			     $cond_products['category_id']=$val['category_id'];
			     $category_products=$this->product_model->get_products(6,0,$cond_products);					     
			     $data['total_category_products'] = get_found_rows();//trace($category_products);
			     if( is_array($category_products) && !empty($category_products)){
				     $res=$category_products;
				   ?>
                 <div class="catelink">
                     <p class="list-link o-hid" style="min-height:37px;">
                     <?php
                      for($i=0; $i<count($res); $i++){
                             
                             $link_url_1=base_url().$res[$i]['friendly_url'];
                             ?>
                            <a href="<?php echo $link_url_1;?>" title="<?php echo $res[$i]['product_name'];?>"><?php echo char_limiter($res[$i]['product_name'],40);?></a>
                            <?php
                      }
                      ?>
                      <a href="<?php echo $link_url;?>">View All &raquo;</a>
                    </p>
                </div>
			     <?php
				 }
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
  