<?php
class Paymentinfo extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('paymentinfo_model'));
		$this->config->set_item('menu_highlight','other management');
	}

	public  function index()
	{


		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		
		$res_array              =  $this->paymentinfo_model->getpaymentinfo($offset,$config['limit']);
		$config['total_rows']	=  $this->paymentinfo_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Payment Info.';
		$data['res']            =  $res_array;
		if( $this->input->post('status_action')!='')
		{
			   $this->update_status('wl_payment_info','id');
		}
		

		$this->load->view('paymentinfo/view_paymentinfo_list',$data);
	}
	
	public function edit(){
		
		$data['heading_title']="Edit Info.";
		$id=(int)$this->uri->segment(4);
		$rwdata=$this->paymentinfo_model->get_paymentinfo_by_id($id);
		if(is_object($rwdata)){
			 if($this->input->post('action')=='Add'){
				
				$this->form_validation->set_rules('ptitle','Title',"trim|required|max_length[100]|xss_clean");
				
				if($this->input->post('ptype')==1){ 
				 
				 $this->form_validation->set_rules('ac_holder_name','Account Holder Name',"trim|required|max_length[100]|xss_clean");
				 $this->form_validation->set_rules('ac_no','Account No.',"trim|required|max_length[100]|xss_clean");
				 $this->form_validation->set_rules('bank_name','Bank Name',"trim|required|max_length[100]|xss_clean");
				 //$this->form_validation->set_rules('bank_address','Bank Address',"trim|required|max_length[100]|xss_clean");
				 $this->form_validation->set_rules('ifc_code','Swift Code',"trim|required|max_length[100]|xss_clean");
				 $this->form_validation->set_rules('city','City',"trim|required|max_length[100]|xss_clean");
					$this->form_validation->set_rules('country','Country',"trim|required|max_length[100]|xss_clean");
				}
				if($this->input->post('ptype')==2 || $this->input->post('ptype')==3){
					$this->form_validation->set_rules('first_name','First Name',"trim|required|max_length[100]|xss_clean");
					$this->form_validation->set_rules('last_name','Last Name',"trim|required|max_length[100]|xss_clean");
					$this->form_validation->set_rules('city','City',"trim|required|max_length[100]|xss_clean");
					$this->form_validation->set_rules('country','Country',"trim|required|max_length[100]|xss_clean");
				
				}
					if($this->form_validation->run()===TRUE)
					{
				    if($this->input->post('ptype')==1){	
						$posted_data = array(
						'ptitle'          => $this->input->post('ptitle'),
						'ac_holder_name'  => $this->input->post('ac_holder_name'),
						'ac_no'           => $this->input->post('ac_no'),
						'ifc_code'        => $this->input->post('ifc_code'),
						'bank_name'       => $this->input->post('bank_name'),
						'city'        => $this->input->post('city'),
						'country'       => $this->input->post('country')
						//'bank_address'    => $this->input->post('bank_address')
						);
					}
					if($this->input->post('ptype')==2 || $this->input->post('ptype')==3){
						$posted_data = array(
						'ptitle'          => $this->input->post('ptitle'),
						'first_name'  => $this->input->post('first_name'),
						'last_name'           => $this->input->post('last_name'),
						'city'        => $this->input->post('city'),
						'country'       => $this->input->post('country')
						);
					}if($this->input->post('ptype')==4){
						$posted_data = array(
						'ptitle'          => $this->input->post('ptitle')
						);
					}
					$where = "id = '".$rwdata->id."'";
					//trace($_POST);
					//trace($posted_data);
					//die();
					$this->paymentinfo_model->safe_update('wl_payment_info',$posted_data,$where,FALSE);
					
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success',lang('successupdate'));
					redirect('sitepanel/paymentinfo', '');
					}
				}
			
			 $data['rwdata']=$rwdata;  
			 
			$this->load->view('paymentinfo/view_paymentinfo_edit',$data);   
		}else{
		  
		  redirect("sitepanel/paymentinfo");	
			
		}
	}
	
	public function add()
		{			
			$data['heading_title'] = 'Payment Info.';			
	        $this->form_validation->set_rules('ptype','Payment Type','trim|required|xss_clean');
			$this->form_validation->set_rules('first_name','First Name','trim|required|required|xss_clean|max_length[100]');
			$this->form_validation->set_rules('last_name','Last Name','trim|required|required|xss_clean|max_length[100]');
			$this->form_validation->set_rules('city','City','trim|required|required|xss_clean|max_length[100]');
			$this->form_validation->set_rules('country','Country','trim|required|required|xss_clean|max_length[100]');
			
			if($this->form_validation->run()==TRUE)
			{
			     $ptitle=($this->input->post('ptype')==2)?'Moneygram':'Western Union';
			      $posted_data = array(
					'ptype'   =>$this->input->post('ptype',TRUE),
					'ptitle'  =>$ptitle,
					'first_name'   =>$this->input->post('first_name',TRUE),
					'last_name'   =>$this->input->post('last_name',TRUE),
					'city'   =>$this->input->post('city',TRUE),
					'country'   =>$this->input->post('country',TRUE)
				 );
				 				
			    $this->paymentinfo_model->safe_insert('wl_payment_info',$posted_data,FALSE);					 
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('success'));			
				redirect('sitepanel/paymentinfo', '');
				
			
			}
			
			$this->load->view('paymentinfo/view_paymentinfo_add',$data);				
	   
	   }
	
}
// End of controller