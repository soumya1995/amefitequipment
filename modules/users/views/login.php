<?php $this->load->view("top_application");
$ref=$this->input->get_post('ref');?>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<h1 class="heading">Login</h1> 
<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li class="active">Login</li>
</ul>
	<div class="loginbox">
    <p class="fs16 text-uppercase text-center p15" style="border-bottom:#ddd 1px dashed;">Sign in to <br class="mob_only"><span class="blue"><?php echo $this->config->item('site_name');?></span></p>
    
    <div class="login-form">
    <?php echo error_message();?><p class="cb"></p>
    <form id="loginform" name="loginform" action="<?php echo base_url();?>users/login/" method="post">
	   	<input type="hidden" name="action" value="Login" />
	  	<input type="hidden" name="ref" value="<?php echo $ref;?>" />
        <p class="blue">Email ID</p>
        <p><input type="text" name="user_name" id="email" class="bgW bdr p8 w100" placeholder="username or email" value="<?php if(get_cookie('userName')!=""){ echo get_cookie('userName'); }?>"><?php echo form_error('user_name');?>   </p>
        <p class="blue mt10">Password</p>
        <p><input name="password" id="password" type="password" class="bgW bdr p8 w100" placeholder="Password *"  value="<?php if(get_cookie('pwd')!=""){ echo get_cookie('pwd'); }?>"><?php echo form_error('password');?></p>
        <p class="mt10"><label><input name="remember" type="checkbox" value="Y" <?php if(get_cookie('userName')!=""){?>checked="checked"<?php }?> class="" style="margin-right:5px"> Keep Me Logged In</label></p>
        <p class="fs11 mt3">(if this is a private computer)</p>
        <p class="mt20"><input name="submit" type="submit" class="button-style fs14 w100" value="Login"></p>
        <p class="blue fs11 ttu uu mt10"><a href="<?php echo base_url();?>users/forgotten_password" class="pop1">Forgot Password?</a></p>
    </form>
    </div>
    
    <div class="login-txt">
    <p class="fs20 weight300 mb10">Register now for <span class="blue">FREE</span></p>
    <?php echo $content['page_description'];?>
    <p class="mt18"><input name="button" type="button" class="btn-style ttu fs14 w100" value="Yes please, register now!" onclick="window.open('<?php echo base_url();?>users/register/','_parent');"></p>
    </div>
    
    <p class="cb"></p>
    </div>
    
    
</div>
</div>
</div>
<?php $this->load->view("bottom_application");?>