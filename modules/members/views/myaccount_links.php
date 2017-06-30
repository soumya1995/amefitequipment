<?php $page=$this->uri->segment(2);?>
<p class="show-hide pb10 text-uppercase b mt10 bb2 text-center mob_only"><a href="javascript:void(0)"><img src="<?php echo theme_url(); ?>images/menu.png" alt="Account Navigation" class="vam"> Account Links</a></p>
      <ul class="emp_acc_link mob_hider">
        <li><a href="<?php echo base_url();?>members/myaccount" <?php if($page=="myaccount"){?>class="act"<?php }?> title="Dashboard">Dashboard</a></li>
        <li><a href="<?php echo base_url();?>members/edit_account" <?php if($page=="edit_account"){?>class="act"<?php }?> title="Manage Account">Edit Account</a></li>
        <li><a href="<?php echo base_url();?>members/orders_history" <?php if($page=="orders_history"){?>class="act"<?php }?> title="Shipping history">Shipping History</a></li>
        <li><a href="<?php echo base_url();?>members/wishlist" <?php if($page=="wishlist"){?>class="act"<?php }?> title="My Favorite">My Favorites</a></li>
        <li><a href="<?php echo base_url();?>members/change_password" <?php if($page=="change_password"){?>class="act"<?php }?> title="Change Password">Change Password</a></li>
        <li><a href="<?php echo base_url();?>users/logout" title="Logout">Logout</a></li>
      </ul>
<p class="cb"></p>
