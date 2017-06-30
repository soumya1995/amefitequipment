<?php
class Zip_location extends Admin_Controller
{

	public function __construct(){
	
			parent::__construct();
			
		    $this->config->set_item('menu_highlight','product management');	
			$this->load->model(array('zip_location_model')); 	
	
	}
	
	   public  function index()
	   {		 
			$pagesize               =  (int) $this->input->get_post('pagesize');
			
			$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
			
			$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
			
			$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
										
			$res_array              =  $this->zip_location_model->get_location($offset,$config['limit']);
			
			$config['total_rows']	= 	$this->zip_location_model->total_rec_found;	
			
			$data['page_links']     =  admin_pagination("$base_url",$config['total_rows'],$config['limit'],$offset);
			
			$data['heading_title']  =   'Manage Zip Location';
			
			$data['res']            =  $res_array; 
			
			
			if($this->input->post('status_action')!='')
			{
			
			$this->update_status('wl_zip_location','zip_location_id');
			
			}		
			
			$this->load->view('zip_location/view_list',$data);	
		      
			
		
	    }
		
		
		public function add()
		{				
			$data['heading_title'] = 'Add Zip Location';			
			$this->form_validation->set_rules('location_name','Location Name',"trim|required|max_length[50]|xss_clean|unique[wl_zip_location.location_name='".$this->db->escape_str($this->input->post('location_name'))."' AND status!='2']");
			
			$this->form_validation->set_rules('zip_code','Zip Code',"trim|required|max_length[50]|xss_clean");
			 
			if($this->form_validation->run()==TRUE)
			{
				
				$posted_data = array( 'location_name'		=>	$this->input->post('location_name',TRUE),
									  'zip_code'		=>	$this->input->post('zip_code',TRUE),
				                      'added_date'   	=>	$this->config->item('config.date.time')
				                      );
				
				$this->zip_location_model->safe_insert('wl_zip_location',$posted_data,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('success'));		
				redirect('sitepanel/zip_location', '');
			}
							   
			$this->load->view('zip_location/view_add',$data);		
	   
	   }
	   
	  
	   
	   public function edit()
	   {
		    $data['heading_title'] = 'Edit Zip Location';
			$Id = (int) $this->uri->segment(4);
			$rowdata=$this->zip_location_model->get_zip_location_by_id($Id);
			
		  if( is_object($rowdata) )
		  { 
				$this->form_validation->set_rules('location_name','Location Name',"trim|required|xss_clean|max_length[50]|unique[wl_zip_location.location_name='".$this->db->escape_str($this->input->post('location_name'))."' AND status!='2' AND zip_location_id!='".$Id."']");
				$this->form_validation->set_rules('zip_code','Zip Code',"trim|required|max_length[50]|xss_clean");
				
				if($this->form_validation->run()==TRUE)
				{
				
					$posted_data = array( 'location_name'	=>	$this->input->post('location_name',TRUE),
				                      	  'zip_code'	=>	$this->input->post('zip_code',TRUE),
				                      );
						
						$where = "zip_location_id = '".$rowdata->zip_location_id."'"; 						
						$this->zip_location_model->safe_update('wl_zip_location',$posted_data,$where,FALSE);	
						$this->session->set_userdata(array('msg_type'=>'success'));
						$this->session->set_flashdata('success',lang('successupdate'));		
						redirect('sitepanel/zip_location/'.query_string(), ''); 	
				
				}
								
			    $data['res']=$rowdata;
			    $this->load->view('zip_location/view_edit',$data);
				
		   }else{
			   
			  redirect('sitepanel/zip_location', ''); 	 
			   
		   }
		   
	   }
	   
	   
	/*---------Bulk Upload Location---------*/
	
	public function uploads_location()
	{
		$data['heading_title']	=	'Bulk Upload Location';
		if($this->input->post('action')=='excel_file')
		{
			$this->form_validation->set_rules('excel_file','Upload Excel File','required|file_allowed_type[xls]');
			
			if($this->form_validation->run()==TRUE)
			{
				require_once FCPATH.'apps/third_party/Excel/reader.php';
				$data = new Spreadsheet_Excel_Reader();
				$data->setOutputEncoding('CP1251');
				
				//$data->setUTFEncoder('');
				chmod($_FILES["excel_file"]["tmp_name"], 0777);
				$data->read($_FILES["excel_file"]["tmp_name"]);
				$worksheet=$data->sheets[0]['cells'];
				//trace($worksheet);exit;
				if(is_array($worksheet) && !empty($worksheet))
				{
					for($i=2;$i<=count($worksheet);$i++)
					{
						$location_name	=	(!isset($worksheet[$i][1])) ? '' : addslashes(trim($worksheet[$i][1]));
						$zip_code		=	(!isset($worksheet[$i][2])) ? '' : addslashes(trim($worksheet[$i][2]));
						
						
						$check_exist="SELECT * FROM wl_zip_location WHERE zip_code='".$zip_code."' AND location_name='".$location_name."' ";
						$query_num=$this->db->query($check_exist);
						if($query_num->num_rows == 0)
						{
							$data = array(
										'location_name'		=>	$location_name,
										'zip_code'			=>	$zip_code,
										'added_date' 		=>  date('Y-m-d h:i:s'),
										'status' 			=>  '1',
										'xls_type' 			=>  'Y',
									 );
							$locationId =  $this->zip_location_model->safe_insert('wl_zip_location',$data,FALSE);
						}
					}
					
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success',lang('success')); 
					redirect('sitepanel/zip_location/uploads_location', 'refresh');
					exit;
				}
				else
				{
					$this->form_validation->_error_array['image']='Uploading Failed.Please Try Again';	  
				}				
			}
		}
		$this->load->view('zip_location/view_bulk_upload',$data);
	}
	
	/*---------End Bulk Upload Location---------*/
	   

}
//controllet end