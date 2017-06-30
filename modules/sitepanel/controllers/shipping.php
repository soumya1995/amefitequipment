<?php
class Shipping extends Admin_Controller
{

	public function __construct(){
	
			parent::__construct();
			
		    $this->config->set_item('menu_highlight','orders management');	
			$this->load->model(array('shipping_model')); 	
	
	}
	
	
	   public  function index()
	   {		 
			
			
			$pagesize               =  (int) $this->input->get_post('pagesize');
			
			$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
			
			$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
			
			$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
										
			$res_array              =  $this->shipping_model->get_shipping($offset,$config['limit']);
			
			$config['total_rows']	= $this->shipping_model->total_rec_found;	
			
			$data['page_links']     =  admin_pagination("$base_url",$config['total_rows'],$config['limit'],$offset);
			
			$data['heading_title']  =   'Manage Shipping';
			
			$data['res']            =  $res_array; 
			
			
			if($this->input->post('status_action')!='')
			{
			
			$this->update_status('wl_shipping','shipping_id');
			
			}		
			
			$this->load->view('shipping/view_shipping_list',$data);	
		      
			
		
	    }
		
		
		public function add_shipping()
		{				
			$data['heading_title'] = 'Add Shipping';			
			$this->form_validation->set_rules('shipping_type','Shipping Method','trim|required|max_length[50]|xss_clean');
			$this->form_validation->set_rules('shipment_rate','Shipping Rate','trim|required|is_valid_amount|xss_clean');
			
			if($this->form_validation->run()==TRUE)
			{
			
				
				$posted_data = array( 'shipping_type'=>$this->input->post('shipping_type',TRUE),
				                      'shipment_rate'=>$this->input->post('shipment_rate',TRUE),					
				                      'added_date'   =>$this->config->item('config.date.time')
				                      );
				
				$this->shipping_model->safe_insert('wl_shipping',$posted_data,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('success'));		
				redirect('sitepanel/shipping', '');
			
			
			}
							   
			$this->load->view('shipping/view_shipping_add',$data);		
	   
	   }
	   
	  
	   
	   public function edit()
	   {
	   
		  
		    $data['heading_title'] = 'Edit Shipping';
			$Id = (int) $this->uri->segment(4);
			$rowdata=$this->shipping_model->get_shipping_by_id($Id);
			
		  if( is_object($rowdata) )
		  { 
		
	
				
				$this->form_validation->set_rules('shipping_type','Shipping Method','trim|required|max_length[50]|xss_clean');
			   $this->form_validation->set_rules('shipment_rate','Shipping Rate','trim|required|is_valid_amount|xss_clean');
				
				if($this->form_validation->run()==TRUE)
				{
				
							$posted_data = array( 'shipping_type'=>$this->input->post('shipping_type',TRUE),
				                      'shipment_rate'=>$this->input->post('shipment_rate',TRUE)
				                      );
						
						$where = "shipping_id = '".$rowdata->shipping_id."'"; 						
						$this->shipping_model->safe_update('wl_shipping',$posted_data,$where,FALSE);	
						$this->session->set_userdata(array('msg_type'=>'success'));
						$this->session->set_flashdata('success',lang('successupdate'));		
						redirect('sitepanel/shipping/'.query_string(), ''); 	
				
				}
								
			    $data['res']=$rowdata;
			    $this->load->view('shipping/view_shipping_edit',$data);
				
		   }else{
			   
			  redirect('sitepanel/shipping', ''); 	 
			   
		   }
		   
	   }

}
//controllet end