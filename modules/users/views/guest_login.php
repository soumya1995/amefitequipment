<?php  $this->load->view("top_application");
$ref=$this->input->get_post('ref');
?>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<h1 class="heading">Quick Checkout</h1>   
    
<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li class="active">Quick Checkout</li>
</ul>

	<div class="col-lg-7 p0 mt15">
	<div>    
         
        
        <div class="p15">
	<div class="p2">
   <div class="login-form">
    <?php echo error_message();
    $user_login=set_value('user_login');
    echo form_open('users/guest_login');?>
    <input type="hidden" name="action" value="Add" />
    <input type="hidden" name="ref" value="<?php echo $ref;?>" />
        <p class="fs16">Enter Your Email Address</p>
        <p class="mt10">
          <input name="user_name" id="email" type="text" class="p7 w95" value="<?php if(get_cookie('userName')!=""){ echo get_cookie('userName'); }else{ echo set_value('user_name'); }?>"><?php echo form_error('user_name');?>
        </p>
        <p class="mt15 fs16">          
          <input name="user_login" type="radio" value="guest" class="fl" style="margin-right:10px" <?php if($user_login=="" || $user_login=="guest"){?>checked="checked"<?php }?> onClick="$('.password_cont').slideUp('fast')"> Continue as guest
          </p>
        <p class="ml20 fs13 pale">(No password or registration required)</p>
        <p class="mt15 fs16">          
          <input name="user_login" type="radio" value="member" class="fl" style="margin-right:10px" <?php if($user_login=="member"){?>checked="checked"<?php }?> onClick="$('.password_cont').slideDown('fast')"> I have a <strong><?php echo $this->config->item('site_name');?> </strong> account
          </p>
        <p class="ml20 fs13 red">(Sign in to your account for a faster checkout)</p>
        <div class="password_cont dn">
          <p class="mt15 b">
            <label for="password">Password :</label>
          </p>
          <p class="mt3">
            <input name="password" id="password" type="password" class="p7 w95" value="<?php if(get_cookie('pwd')!=""){ echo get_cookie('pwd'); }?>"><?php echo form_error('password');?>
          </p>
          <p class="red mt10 fr fs12"><a href="<?php echo base_url();?>users/forgotten_password" class="uu forgot">Forgot Password?</a></p>
          <p class="mt10 fs12">
            <label>
              <input name="remember" type="checkbox" value="Y" class="fl mr5 mt3" <?php if(get_cookie('userName')!=""){?>checked="checked"<?php }?>> Remember Me!</label></label>
          </p>
        </div>
        <p class="mt15">
          <input name="submit" type="submit" class="btn btn-md btn-danger radius-3" value="Continue &gt;" />
        </p>
        <?php echo form_close();?>
      </div>
	</div>
    
    
      </div>
      
      <!-- slide 2 -->
      
      <!--<div class=" mt10">
        <p class="black p10 fs16 bdr" style="background:#eee;">2. Make Payment</p>
      </div>-->
      
      <!-- slide 2 --> 
      
    </div>
    </div>
    
    
    <p class="col-lg-1"></p>
    
    
    <div class="col-lg-4 p0 pt20">
    <br class="mob_only">
     <div>
        <p class="b ml5 ttu pink fs14">Your Cart Items</p>
         <?php $this->load->view("cart/cart_right_view");?>

      </div>
    </div>
    
    
    <p class="clearfix"></p>

</div>
</div>
</div>
<?php $this->load->view("bottom_application");?>