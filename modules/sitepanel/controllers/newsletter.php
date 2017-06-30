<?php
class Newsletter extends Admin_Controller
{
			
   public function __construct()
   {  
		parent::__construct();		  
		$this->load->model(array('newsletter_model','newsletter_group_model')); 
		$this->config->set_item('menu_highlight','newsletter');	 
		
   }
	
	public function index($page = null)
	{	

			$pagesize                =  (int) $this->input->get_post('pagesize');
			
			$config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
			
			$offset                  =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
			 
			$base_url                =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		 
									
			$page_array             = $this->newsletter_model->get_newsletter($config['limit'],$offset);	
			
			$config['total_rows']   =  get_found_rows();
			
			$data['page_links']     =  admin_pagination("$base_url",$config['total_rows'],$config['limit'],$offset);
			
			$data['heading_title'] = 'Newsletter Subscriber List';
			
			$data['pagelist'] = $page_array;

			
			$this->load->view('newsletter/view_newsletter_list',$data);
	}
	
	public function add()
	{
		
	   $data['heading_title'] = 'Add Newsletter Member';
	   
		
		$this->form_validation->set_rules('subscriber_name','Name','trim|required|alpha|xss_clean|max_length[32]');
		
		$this->form_validation->set_rules('subscriber_email','Email','trim|required|valid_email|xss_clean|callback_check_record');
		
		
		if($this->form_validation->run()==TRUE)
		{							
			 
			  $posted_data = array(
					'subscriber_name'=>$this->input->post('subscriber_name',TRUE),
					'subscriber_email'=>$this->input->post('subscriber_email',TRUE),
					'subscribe_date'=>$this->config->item('config.date.time')
				 );
				 
				 				
			 $this->newsletter_model->safe_insert('wl_newsletters',$posted_data,FALSE);					
			 $this->session->set_userdata(array('msg_type'=>'success'));
			 $this->session->set_flashdata('success',lang('success'));
			 redirect("sitepanel/newsletter/", '');
			 
		 }
		 
		 $this->load->view('newsletter/newsletter_add',$data);	  
	}	   
	
	
	   
    public function edit()
    {	  
	 
	    $data['heading_title'] = 'Edit newsletter';
	   
		$id = (int) $this->uri->segment(4);	
		
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
		
		$rowdata = $this->newsletter_model->get_record_by_id($id);			
		
	
		
		if( is_object($rowdata) && !empty($rowdata) ) 
		{
		  
		   $this->form_validation->set_rules('subscriber_name','Name','trim|required|alpha|xss_clean|max_length[32]');
		
		    $this->form_validation->set_rules('subscriber_email','Email','trim|required|valid_email|xss_clean|callback_check_record');
		
			
			if($this->form_validation->run()==TRUE)
			{	
				
				$posted_data = array(
				'subscriber_name'=>$this->input->post('subscriber_name',TRUE),
				'subscriber_email'=>$this->input->post('subscriber_email',TRUE)
				);
				
				$where = "subscriber_id = '".$rowdata->subscriber_id."'"; 						
				$this->newsletter_model->safe_update('wl_newsletters',$posted_data,$where,FALSE);	
				
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('successupdate'));
				
				redirect('sitepanel/newsletter/'.query_string(), '');
			}
					
		}else
		{
			redirect('sitepanel/newsletter', '');
			
		}		
		
	   $data['catresult']=$rowdata;
	   $this->load->view('newsletter/newsletter_edit',$data);
	}
	
	
	
	public function change_status()
	{	
		
		$data['heading_title'] = 'Send Email';
		
		$str_ids = $this->input->post('arr_ids');
		
		if($this->input->post('Send')!='Send Email')
		{
			$this->newsletter_model->change_status();
			
			redirect('sitepanel/newsletter', ''); 
			
			
		}else
		{				
			
			$data['ckeditor']      =  set_ck_config(array('textarea_id'=>'message'));
			$this->preview();
			$arr_ids = $this->input->post('arr_ids');			  
			$str_ids =  is_array($arr_ids) ? implode(',', $arr_ids) : $arr_ids;			
			$rowdata=$this->newsletter_model->getemail_by_id($str_ids);
			$data['newsresult']=$rowdata;
			$data['ids']=$str_ids;
			$this->load->view('newsletter/view_newsletter_send',$data);
		}		
	}
	
	public function preview()
	{
	   
	        if($this->input->post('action')=='preview')
			{
				$this->form_validation->set_rules('sendto','TO','trim|required');
				$this->form_validation->set_rules('subject','Subject','trim|required');
				$this->form_validation->set_rules('message','Message','trim|required|exclude_text[<br />]');
				
				if($this->form_validation->run()=== TRUE)
				{	
				   
					 	echo form_open("sitepanel/newsletter/send_mail",array("name"=>"sendmailfrm","id"=>"sendmailfrm"));
					 	echo form_hidden("subject",$this->input->post("subject"));
					 	echo form_hidden("message",$this->input->post("message"));
					 	echo form_hidden("sendto",$this->input->post("sendto"));
						echo form_hidden("arr_ids",$this->input->post("arr_ids"));
					 	echo form_close();
					  echo '<script type="text/javascript">document.sendmailfrm.submit();</script>';
					
				}
					
				
		   }		
				
	}
	
	public function send_mail(){
		
		 if($this->input->post() && $this->input->post('sendto')!=""){
					if($this->input->post("submit")!="" ){
							 	$subject = $this->input->post('subject');
					  		$message = $this->input->post('message');
								$mail_to = explode(",",$this->input->post('sendto'));
					 		  $this->load->library('email');
								$config['mailtype']="html";
								$this->email->initialize($config);
					
								$rwadmin=$this->newsletter_model->get_admin_email();
								$this->email->from($rwadmin['admin_email'], $this->config->item('site_name'));
							
							if( is_array($mail_to) && !empty($mail_to))
							{
								foreach($mail_to as $to)
								{
									if($to!='')
									{
										$this->email->to($to);							
										$this->email->subject($subject);
										$this->email->message($message);							
										$this->email->send();
										//$this->email->print_debugger();
									}					
								}
							}
							$this->session->set_userdata(array('msg_type'=>'success'));
							$this->session->set_flashdata('success','Email has been sent successfully.');
							redirect('sitepanel/newsletter', '');
					}
					$data["heading_title"]="Newsletter Preview";
			 		$this->load->view('newsletter/view_newsletter_preview',$data);
			}else{
				redirect("sitepanel/newsletter")	;
			}	
		
		
	}
	
	
	public function check_record()
	{	   
        	$subscriber_email  = $this->db->escape_str($this->input->post('subscriber_email'));
			
        	 $id     = $this->input->post('subscriber_id');
			
        	$cond=" AND  subscriber_email ='".$subscriber_email."' AND status!='2'";
			
        	if(strlen($id)) $cond .=" AND subscriber_id!='".$id."' ";  
			              
	       if($this->newsletter_model->checkRecords($cond)>0)
		   {
	        	$this->form_validation->set_message('check_record','Record already exists...');
	        	return FALSE;
	      }else
		  {
			  return TRUE;
			  
		  }
		  
    }	

		
	

	
	public function news_temp_footer_links()
	{
		
		 $condtion = "status !='2'";
		 $footer_lins = "";
		 $sql = "SELECT product_id,product_name
		          FROM wl_products
				  WHERE status !='2' 
				  ORDER BY product_id DESC
				  LIMIT 0,20";		
		  $qrs = $this->db->query($sql);
		  
		  if($qrs->num_rows() > 0 ) 
		  {
			  
			  foreach ($qrs->result_array() as $val ) 
			  {
				  
			  $product_links = base_url()."products/".$val['product_id']."/".$val['product_name'];
			  
			  $footer_lins .='<a href="'.$product_links.'" style="font:12px Arial, Helvetica, sans-serif; color:#000; text-decoration:none; padding:5px 5px;">'.$val['product_name'].'</a> | ';
			  
			  }
			  
			
		  }
	   return $footer_lins;  
	}
	
	public function mail_selected_products($prodIDs=array())
	{
		 $var = "";
	  if( is_array($prodIDs) && !empty($prodIDs)  ) {		  
		 
		  foreach ($prodIDs as $val ) {
			  
			   $res =  $this->db->get_where('wl_products',
							array('product_id'=>$val))->row();
			    if ( is_object($res) ) {
					
					$product_links = base_url()."products/".$val."/".$res->product_name;
					$product_img   = base_url()."uploaded_files/product/".$res->small_pic;
	
				$var .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" background:#cce8f3; border:2px solid #bbbbbb; padding:10px;">				
					<tr>
					<td width="26%"><img src="'.$product_img.'" alt="" width="132" height="123" /></td>
					<td width="74%" valign="top"><p style="color: #065997; font-weight:bold;">'.$res->product_name.'</p><p>'.$res->description.'</p>
					<p><a href="'.$product_links.'" style="font:12px Arial, Helvetica, sans-serif; color:#9a0b00; font-weight:bold; text-decoration: underline;">View Details</a></p>
					</td>					
					</tr>				
				</table></br>' ;
            
				}

		  }
	  }
		
      return $var;
   
	}
	
	
	public function mail_data($post){	 
			 
		 if( is_array($post) && !empty($post) ) {
					 
		 $arr_prodid    = array_key_exists('prod',$post) ? $post['prod'] : array();		
		 $template      = $post['news_latter_temp'];
		 $templet_url   = base_url()."assets/newslatter_templates/".$template."/images/";
		 $product_lists = $this->mail_selected_products($arr_prodid);
		 $footer_links  = $this->news_temp_footer_links();
		 $body = read_file(FCROOT."application/views/user_mail/news_templates.html");	 			 
		 $body			=	str_replace('{message}',$post['message'],$body);
		 $body			=	str_replace('{url}',base_url(),$body);
		 $body			=	str_replace('{temleate_url}',$templet_url,$body);
		 $body			=	str_replace('{product_content}',$product_lists,$body);
		 $body			=	str_replace('{product_links}',$footer_links,$body);
		
		 }
		
	    return $body;
	
	}

    public function import_newsletter(){
       $data['heading_title'] = 'Import Newsletter Data';
       $this->form_validation->set_rules('upload_file', 'File', 'file_required||file_allowed_type[xls]');

       if($this->form_validation->run() == TRUE){
          if(!empty($_FILES) && $_FILES['upload_file']['name'] != ''){
			
			set_time_limit (1200) ;
			ini_set('upload_max_filesize','128M');
			ini_set('memory_limit', '-1');
			ini_set('post_max_size', '128M'); 
			
             require_once FCPATH.'apps/third_party/Excel/reader.php';
             $data = new Spreadsheet_Excel_Reader();
             $data->setOutputEncoding('CP1251');

             //$data->setUTFEncoder('');
             chmod($_FILES["upload_file"]["tmp_name"], 0777);
             $data->read($_FILES["upload_file"]["tmp_name"]);
             $worksheet = $data->sheets[0]['cells'];

             if(is_array($worksheet) && count($worksheet) > 0){
                $total = count($worksheet);
                for($i = 2; $i <= $total; $i++){
					
                   $subscriber_email = trim($worksheet[$i][1]);
                   $subscriber_email = $this->db->escape_str($subscriber_email);
                   $is_user_exist = count_record("wl_newsletters", "subscriber_email ='".$subscriber_email."'");
				   
                   if(($is_user_exist == 0) && ($subscriber_email != '')){
					
						$subscriber_name	=	$this->db->escape_str(htmlentities(trim($worksheet[$i][2])));
			  
					  $posted_data = array(
								'subscriber_name'=>ucwords($subscriber_name),
								'subscriber_email'=>strtolower($subscriber_email),
								'status'=>'0',
								'subscribe_date'=>$this->config->item('config.date.time')
				 		);
			 			$this->newsletter_model->safe_insert('wl_newsletters',$posted_data,false);
                   }
                }
             }
          }
		  
          $this->session->set_userdata(array('msg_type' => 'success'));
          $this->session->set_flashdata('success', 'Newsletter data successfully added.');
          redirect('sitepanel/newsletter/import_newsletter', '');
       }

       $this->load->view('newsletter/newsletter_data', $data);
    }
}
// End of controller