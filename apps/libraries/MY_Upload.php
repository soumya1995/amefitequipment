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


class MY_Upload extends CI_Upload
{
	private $CI;
	
	public  function __construct()
	{
		parent::__construct();
		$this->CI =& get_instance();
		

		
	}
	
	/**
	* Verify that the filetype is allowed
	* using file extension instead of mime
	*
	* @access      public
	* @return      bool
	*/    
	function is_allowed_filetype()
	{
		if (count($this->allowed_types) == 0 OR ! is_array($this->allowed_types))
		{
			$this->set_error('upload_no_file_types');
			return FALSE;
		}
	
		foreach ($this->allowed_types as $val)
		{
			if ("." . strtolower($val) == strtolower($this->file_ext))
			{
				return true;
			}      
		}
		return FALSE;
	}
        
     

	function my_upload($filed,$path)
	{
		$CI =$this->CI;	
		
		$CI->load->library('upload');	 
		$config['upload_path'] = UPLOAD_DIR.'/'.$path.'/';
		$config['allowed_types'] = file_ext($_FILES[$filed]['name']);
		$config['max_size']  = '0';
		$config['max_width']  = '0';
		$config['max_height']  = '0';
		$config['remove_spaces'] = TRUE;
		$CI->upload->initialize($config);
		if ( ! $CI->upload->do_upload($filed))
		{
			$error = array('error' =>$CI->upload->display_errors());
		}
		else
		{
			$data = array('upload_data' => $CI->upload->data($filed));
			return $data;
		
		}
	}

	function multipe_upload($path,$filname,$file_num)
	{
		$CI =$this->CI;		 
		$CI->load->library('upload');
		$uploadedFiles = array();
		$config['upload_path'] = UPLOAD_DIR.'/'.$path.'/';	
		$config['remove_spaces'] = TRUE;
		for($i = 1; $i <= $file_num; $i++)
		{
			
			if( array_key_exists($filname.$i,$_FILES) && $_FILES[$filname.$i]['name']!="" )
			{
				$config['allowed_types'] = file_ext($_FILES[$filname.$i]['name']);
				$CI->upload->initialize($config);
				$upload = $CI->upload->do_upload($filname.$i);
				/* File failed to upload - continue */
				if($upload === FALSE)
				{ 
					$uploadedFiles[$i]='';
					$error[$i] = array('error' =>$CI->upload->display_errors());
				}
				else
				{
					/* Get the data about the file */
					$data = $CI->upload->data($filname.$i);
					$uploadedFiles[$i] = $data;
				}
			}
			
		}
		
		return $uploadedFiles; 
	}
	
	// --------------------------------------------------------------------

	/**
	 * Prep Filename
	 *
	 * Prevents possible script execution from Apache's handling of files multiple extensions
	 * http://httpd.apache.org/docs/1.3/mod/mod_mime.html#multipleext
	 *
	 * @param	string
	 * @return	string
	 */
	protected function _prep_filename($filename)
	{
		if (strpos($filename, '.') === FALSE OR $this->allowed_types == '*')
		{
			return $filename;
		}

		$parts		= explode('.', $filename);
		$ext		= array_pop($parts);
		$filename	= array_shift($parts);

		foreach ($parts as $part)
		{
			if ( ! in_array(strtolower($part), $this->allowed_types) OR $this->mimes_types(strtolower($part)) === FALSE)
			{
				$filename .= '.'.$part.'_';
			}
			else
			{
				$filename .= '.'.$part;
			}
		}

		$filename .= random_string('alnum',4).'.'.$ext;

		return $filename;
	}
	
	public function clean_file_name($filename)
	{
		$bad = array(
						"(",
						")",
						"<!--",
						"-->",
						"'",
						"<",
						">",
						'"',
						'&',
						'$',
						'=',
						';',
						'?',
						'/',
						"%20",
						"%22",
						"%3c",		// <
						"%253c",	// <
						"%3e",		// >
						"%0e",		// >
						"%28",		// (
						"%29",		// )
						"%2528",	// (
						"%26",		// &
						"%24",		// $
						"%3f",		// ?
						"%3b",		// ;
						"%3d"		// =
					);

		$filename = str_replace($bad, '', $filename);

		return stripslashes($filename);
	} 

}


?>