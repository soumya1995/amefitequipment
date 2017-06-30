<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dmailer
{
	
	private $CI;
		
    public function __construct()
	{
		
		$this->CI =& get_instance();	
		$this->CI->load->library('email');		
		/*$config = array(
		'protocol' => 'smtp',
		'smtp_host' => 'ssl://smtp.googlemail.com',
		'smtp_port' => 465,
		'smtp_user' => 'weblink.dkm@gmail.com',
		'smtp_pass' => 'wlhr-1471',     
		 );	
		
	   	
	    $this->CI->email->initialize($config);    */
		
	 }
   
   
   public function mail_notify($mail_conf = array())
   {
	   
			/*
			 $mail_conf =  array(
			'subject'=>"hiiiiiii",
			'to_email'=>"sk@gmail.com",
			'from_email'=>"mk@gmail.com",
			'from_name'=>"mk maurya",
			'body_part'=>"hfdgfgdg gfdgf dgdfgdf gdfg",
			 print_r($mail_conf); exit();
			 			 			
			*/	
			   
		   if(is_array($mail_conf) && !empty($mail_conf) )
		   { 	   	 
				 					 
					$mail_to            = $mail_conf['to_email'];
					$mail_subject       = $mail_conf['subject']; 
					$from_email         = $mail_conf['from_email'];
					$from_name          = $mail_conf['from_name'];	
					$body               = $mail_conf['body_part'];				
					
					$cc                 = @$mail_conf['cc'];
					$bcc                = @$mail_conf['bcc'];
					$alternative_msg    = @$mail_conf['alternative_msg'];
					$debug              = @$mail_conf['debug'];
					
					$attachment = is_array(@$mail_conf['attachment']) ? @$mail_conf['attachment'] : (array)@$mail_conf['attachment'];
					 			
					$this->CI->email->set_newline("\r\n");
					$this->CI->email->set_mailtype('html');				  
					$this->CI->email->from($from_email, $from_name);
					$this->CI->email->reply_to($from_email, $from_name);
					$this->CI->email->to($mail_to);	
						
					if($cc!='')
					{
						$this->CI->email->cc($cc);
					}
					if($bcc!='')
					{
						$this->CI->email->bcc($bcc);
					}
					
					if($alternative_msg!='')
					{					
						$this->CI->email->set_alt_message($alternative_msg);					
					}
					
					if( is_array($attachment) && !empty($attachment))
					{
						foreach($attachment as $file)
						{
							if($file !='' && file_exists($file))
							{
								
								$this->CI->email->attach($file);
								
							}
						}
					
					}
					$this->CI->email->subject($mail_subject);				
					$this->CI->email->message($body);								
					$this->CI->email->send();				
					
					if($debug )
					{
						 $this->CI->email->print_debugger();
					}
					
					$this->CI->email->clear(TRUE);	
			  
			  }  
   
     } 
 


}
// END Form Email mailer  Class
/* End of file Dmailer.php */
/* Location: ./application/libraries/Dmailer.php */