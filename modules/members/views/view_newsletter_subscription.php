<?php $this->load->view("top_application");
echo navigation_breadcrumb("Newsletter Subscription");?>
<div class="container mid_area">
  <div class="container acc_container">
  <div class="row">
    <div class="col-xs-3 pull-left">
      <?php $this->load->view("members/myaccount_left");?>
    </div>
    <!-- left ends -->
    
    <div class="col-xs-12 col-md-9 acc_right">
      <div>
        <h1>Newsletter Subscription</h1>               
		<?php validation_message();echo error_message();?>  
        <p class="cb"></p>
        <div class="app_container inr_addresses">
          <div class="row hidden-xs b ttu gray fs14">
            <div class="col-xs-5" >Name/Email</div>
            <div class="col-xs-5 text-center"> Action </div>
          </div>
          <!-- row 1 -->
          <?php
		  $condtion = " AND subscriber_email ='".$mres['user_name']."' AND status!='2'";
		  $nres = get_db_single_row('wl_newsletters',"subscriber_email,subscriber_name,status",$condtion);		 	 
		  ?>
          <div class="row fs13">
           <?php echo form_open('members/newsletter');?>
          <input name="subscriber_name" id="name" autocomplete="off" type="hidden" placeholder="Name *" class="p8 w100 radius-3" value="<?php echo $nres["subscriber_name"];?>">
         <input name="subscriber_email" id="email" autocomplete="off" type="hidden" placeholder="Email ID *" class="p8 w100 radius-3" value="<?php echo $nres["subscriber_email"];?>" >
                     
            <div class="col-xs-5">
              <p class="fs16 mb5 ttu b"><?php echo ucwords($mres['first_name']." ".$mres['last_name']);?> </p>
              <p><?php echo $mres['user_name'];?></p>
            </div>
            <div class="col-xs-5 text-center black ttu fs14"> 
            <?php
			if($nres['status']=='0'){?>            
            	<input name="subscribe" type="submit" value="Subscribe" class="btn4 ml10" onclick="document.getElementById('saction').value='Y'">
            <?php
			}else{?>
            	<input name="unsubscribe" type="submit" value="Unsubscribe" class="btn4 ml10" onclick="document.getElementById('saction').value='N'">
            <?php
			}?>
            </div>
            <input name="subscribe_me" type="hidden" id="saction" value="" />
            <?php echo form_close();?>
          </div>
        
        </div>
       
      </div>
    </div>
    <!-- right ends --> 
    <p class="clearfix cb"></p>
  </div>
  <p class="clearfix"></p>
</div>
</div>
<?php $this->load->view("bottom_application");?>