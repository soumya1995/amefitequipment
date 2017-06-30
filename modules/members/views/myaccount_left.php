<?php $page=$this->uri->segment(2);?>
<div>
    <p class="mt20 ttu fs20"><?php echo ucwords($mres['first_name']." ".$mres['last_name']);?>!</p>
    <p class="gray mt2 fs13">Last Login: <?php echo getDateFormat($mres['last_login_date'],7);?></p>
    <p class="mt10"><b>Email ID:</b> <?php echo $mres['user_name'];?><br class="hidden-sm"><b class="ml5 mr5 visible-sm-inline">/</b> <b>Mobile No.</b> <?php echo $mres['mobile_number'];?></p>
    
    <div class="t2r_a mt10"> 
    	<span class="hidden-xs mr4">Welcome, <b class="ttu fs13"><a href="<?php echo base_url();?>members/myaccount"><?php echo ucwords($mres['first_name']." ".$mres['last_name']);?></a></b> /</span> <a href="<?php echo base_url();?>users/logout" style="color:#bb0f0f; text-transform:none"><img src="<?php echo theme_url(); ?>images/lgt.png" class="mr3" alt="">Logout!</a>
    </div>
   <div class="acc_links"> 
    <a href="<?php echo base_url();?>members/edit_account" <?php if($page=="edit_account"){?>class="act"<?php }?> title="Edit Account"><b class="fa fa-user"></b> Edit Account</a> 
    <a href="<?php echo base_url();?>members/member_address_list" <?php if($page=="member_address_list"){?>class="act"<?php }?> title="My Addresses"> <b class="glyphicon glyphicon-envelope mr5"></b>My Addresses</a> 
    <a href="<?php echo base_url();?>members/wishlist" <?php if($page=="wishlist"){?>class="act"<?php }?> title="My Favorites"><b class="glyphicon glyphicon-heart mr5"></b>Wishlist</a> 
    <a href="<?php echo base_url();?>members/orders_history" <?php if($page=="orders_history"){?>class="act"<?php }?> title="Shipping history"><b class="glyphicon glyphicon-calendar mr5"></b>Shipping history</a> 
    <a href="<?php echo base_url();?>members/newsletter_subscription" <?php if($page=="newsletter_subscription"){?>class="act"<?php }?> title="Newsletter Subscription"><b class="fa fa-newspaper-o"></b> Newsletter Subscription</a> 
    <a href="<?php echo base_url();?>members/change_password" <?php if($page=="change_password"){?>class="act"<?php }?> title="Change Password"><b class="glyphicon glyphicon-cog mr5"></b>Change Password</a>
   </div>
</div>