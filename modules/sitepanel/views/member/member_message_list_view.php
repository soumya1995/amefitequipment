<?php $this->load->view('includes/header'); ?>

  <div id="content">
  <div class="breadcrumb">
     <?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo anchor('sitepanel/members','Members'); ?> &raquo; <?php echo $heading_title;?>        
      </div>
      
      <div class="box">
    <div class="heading">
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">&nbsp;</div>
    </div>
    <div class="content">
    
   
     <div class="required">                        
                <strong> Total Record(s) Found : <?php echo $total_rec; ?></strong>  
      </div>
                  
      <?php  
	  
	   echo form_open("sitepanel/members/messages/".$this->uri->segment(4),'id="search_form" method="get" ');    ?>
       <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
   
    <table width="100%"  border="0" align="center" cellspacing="3" cellpadding="3">
    <?php 
	 
	
                if(error_message() !=''){
               	   echo error_message();
                }
                ?> 
                
      <tr>
        <td width="52%" align="right" >
          <strong>Search </strong> [ Name,Email ]
          <input name="keyword" type="text" value="<?php echo trim($this->input->get_post('keyword'));?>" size="35"  />&nbsp;</td>
        <td width="9%" align="center" >
            <select name="status">
            
            <option value="">Status</option>
            <option value="1" <?php echo $this->input->get_post('status')==='1' ? 'selected="selected"' : '';?>>Active</option>
            <option value="0" <?php echo $this->input->get_post('status')==='0' ? 'selected="selected"' : '';?>>In-active</option>
            
            </select>
        </td>
        
        
        <td width="39%" align="left" ><a  onclick="$('#search_form').submit();" class="button"><span>GO </span></a>&nbsp;
        <?php
            if( $this->input->get_post('keyword')!='' || $this->input->get_post('status')!='' )
            {             
			   echo anchor("sitepanel/members/messages/".$this->uri->segment(4),'<span>Clear Search</span>');
            }
            ?></td>
	  </tr>
			</table>
        <?php   echo form_close();     ?>
    
    <?php  echo form_open("",'id="data_form"');?>         
  
    <table class="list" width="100%" id="my_data">
    <?php
	
		$atts = array(
		'width'      => '650',
		'height'     => '600',
		'scrollbars' => 'yes',
		'status'     => 'yes',
		'resizable'  => 'yes',
		'screenx'    => '0',
		'screeny'    => '0'
		);
		
		$atts1 = array(
						'width'      => '600',
						'height'     => '300',
						'scrollbars' => 'yes',
						'status'     => 'yes',
						'resizable'  => 'yes',
						'screenx'    => '0',
						'screeny'    => '0'
					 );	
	
    if(is_array($pagelist) && count($pagelist) > 0 )
    {
      ?>
      <thead>
        <tr>
          <td width="31" style="text-align: center;">
          <input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
          <td  class="left">Name</td>
          <td width="250 class="left">Email</td>
          <td width="150" align="right" >Post Date </td>
          <td width="70" class="center">Status</td>
          <td width="210" class="center">Action</td>
        </tr>
      </thead>
      <tbody>
      <?php
      
      foreach($pagelist as $catKey=>$pageVal)
      {
        ?>
        <tr>
          <td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['id'];?>" /></td>
          <td class="left"> <?php echo $pageVal['name'];
          	if($pageVal['phone_number']){
          		echo "<br /> Phone : ".$pageVal['phone_number'];
          	}      		
          ?>
           </td>
          <td class="left"><?php echo $pageVal['email'];?> </td>
          <td class="right"><?php echo getDateFormat($pageVal['created_at'],7);?></td>
          <td class="center"><?php echo ($pageVal['status']=='1')?"Active":"Inactive";?></td>
          <td class="center"> 
         <?php echo anchor_popup('sitepanel/members/view_reply/'.$pageVal['message_id'], 'View Reply Messages', $atts);?>  | 
		
		  <?php echo anchor_popup('sitepanel/members/send_reply/'.$pageVal['message_id'], 'Send Reply', $atts1);?></td>
        </tr>
        <?php
      }
      ?>
         <tr><td colspan="7" align="right" height="30"><?php echo $page_links; ?></td></tr>  
     <tr>
      		<td colspan="6" align="left" style="padding:5px">
            
            
      		<input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onClick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
      			<input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
                
   			<input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/></td>
   		</tr>
      </tbody>
    <?php
    }
    else{
      echo "<div class='ac b'> No record(s) found !</div>" ;
    }
    ?>
    </table>
    <?php echo form_close(); ?>
  </div>
</div>
<?php $this->load->view('includes/footer'); ?>