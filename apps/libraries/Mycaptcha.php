<?php
/**
 * CI-CMS Upload class overwrite
 * This file is part of CI-CMS
 * @package   CI-CMS
 * @copyright 2008 Hery.serasera.org
 * @license   http://www.gnu.org/licenses/gpl.html
 * @version   $Id$
 */

if (!defined('BASEPATH'))
{
	
    exit('No direct script access allowed');
}



class Mycaptcha {   
   public $word = '';
   public $ci = ''; 
			
			public function __construct() { 
			$CI = & get_instance(); 
			$CI->load->helper('captcha'); 
			$this->ci = $CI; 
			
			} 
			
   
		public function createWord() { 
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
		$word = ''; 
		for ($a = 0; $a <= 5; $a++) { 
		$b = rand(0, strlen($chars) - 1);
		$word .= $chars[$b]; 
		} 
		$this->word = $word; 
		return $this; 
		}
	
	 
		public function createCaptcha() { 
		
			
		$cap = array('img_path' => './assets/captcha/',
					'img_url' => base_url().'assets/captcha/',
					'font_path' => './assets/captcha/texb.ttf',
					'img_width' => '100',
					'img_height' => '30',
					'expiration' => 3600 ); 
				 
		$captchaOutput = create_captcha($cap); 
		$this->ci->session->set_userdata(array('word'=>$captchaOutput['word'], 'image' => $captchaOutput['time'].'.jpg')); 
		return $captchaOutput;
		} 
 
	public function deleteImage() {
		 
		if(isset($this->ci->session->userdata['image']))
		{ 
		$lastImage = FCPATH . "assets/captcha/" . $this->ci->session->userdata['image']; 
			if(file_exists($lastImage))
			{ 
			unlink($lastImage); 
			} 
		} 
		return $this; 
		}
   
   } 
 

?>