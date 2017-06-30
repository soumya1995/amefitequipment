<?php $this->load->view('includes/header');?>

<div id="content">
 <?php  echo error_message(); ?>
 <div style="display: inline-block; width: 100%; margin-bottom: 15px; clear: both;">
  <div style="float: left; width: 75%;">
   <div style="background: #666464; color: #FFF; border-bottom: 1px solid #303030; padding: 5px; font-size: 14px; font-weight: bold;">Easy Navigation</div>
   <div style="background:#f8f8f8; border: 1px solid #d9d9d9; padding: 8px; float:left"><?php $this->load->view('dashboard/admin_welcome_view');?></div>
  </div>
  <div style="float: right; width: 24%;">
   <div style="background: #666464; color: #FFF; border-bottom: 1px solid #303030;">
    <div style="width: 100%; display: inline-block;">
     <div style="float: left; font-size: 14px; font-weight: bold; padding: 7px 0px 0px 5px; line-height: 12px;">Statistics</div>
     <div style="float: right; font-size: 12px; padding: 2px 2px 0px 0px;"> </div>
    </div>
   </div>
   <div style="background:#f8f8f8; border: 1px solid #d9d9d9; padding: 10px; height: 49%;">
    <div id="report" style=" margin: auto;">
    <?php if($this->session->userdata('admin_id')==1){?>
     <table width="100%" border="0" cellspacing="5" cellpadding="3">
      <tr>
       <td>Total Categories : <?php echo $total_categories;?></td>
       <td><a href="<?php echo base_url();?>sitepanel/category">View</a></td>
      </tr>

      <tr>
       <td>Total Products : <?php echo $total_products;?></td>
       <td><a href="<?php echo base_url();?>sitepanel/products">View</a></td>
      </tr>
      
      <tr>
       <td>Total Orders : <?php echo  $total_orders;?></td>
       <td><a href="<?php echo base_url();?>sitepanel/orders/">View</a></td>
      </tr>
      <tr>
       <td>Total Newsletter<br/>Subscribers : <?php echo $total_newsletter_members;?></td>
       <td><a href="<?php echo base_url();?>sitepanel/newsletter">View</a></td>
      </tr>
      <tr>
       <td>Total Enquiries : <?php echo  $total_enquiries; ?></td>
       <td><a href="<?php echo base_url();?>sitepanel/enquiry">View </a></td>
      </tr>
      
      <tr>
       <td>Total Feedbacks : <?php echo  $total_feedbacks; ?></td>
       <td><a href="<?php echo base_url();?>sitepanel/enquiry/feedback">View </a></td>
      </tr>

      <tr>
       <td>Total FAQs : <?php echo  $total_faqs; ?></td>
       <td><a href="<?php echo base_url();?>sitepanel/faq">View </a></td>
      </tr>

      
      <tr>
       <td>Total Banners : <?php echo  $total_banners; ?></td>
       <td><a href="<?php echo base_url();?>sitepanel/banners">View </a></td>
      </tr>
      

     </table>
     <?php }?>
     
     
     <?php if($this->session->userdata('admin_id')==2){?>
     <table width="100%" border="0" cellspacing="5" cellpadding="3">
      <tr>
       <td>Total Newsletter<br/>Subscribers : <?php echo $total_newsletter_members;?></td>
       <td><a href="<?php echo base_url();?>sitepanel/newsletter">View</a></td>
      </tr>


     </table>
     <?php }?>
     
     
     <?php if($this->session->userdata('admin_id')==3){?>
     <table width="100%" border="0" cellspacing="5" cellpadding="3">
      <tr>
       <td>Total Products : <?php echo $total_products;?></td>
       <td><a href="<?php echo base_url();?>sitepanel/products">View</a></td>
      </tr>
     </table>
     <?php }?>
     
     <div style="margin-top:141px;">&nbsp;</div>
    </div>
   </div>
  </div>
 </div>
 <div></div>
</div>

<?php $this->load->view('includes/footer');?>