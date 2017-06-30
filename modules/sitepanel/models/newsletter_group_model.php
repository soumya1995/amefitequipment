<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Newsletter_group_model extends MY_Model
{
	
	public function __construct()
	{
		parent::__construct();
		
	}

	// Get All Records
	public function getallrecord($offset=FALSE,$per_page=FALSE)
	{
		$keyword    = $this->db->escape_str(trim($this->input->get_post('keyword',TRUE)));
		
		$condition="status !='2'";
		
		if($keyword!='') $condition .="AND group_name like '%".$keyword."%'";
		$fetch_config = array(
								'condition'=>$condition,
							  	'order'=>"newsletter_groups_id DESC",
							  	'limit'=>$per_page,
							  	'start'=>$offset,							 
							  	'debug'=>FALSE,
							  	'return_type'=>"array"
							);					  
			
		$result = $this->findAll('wl_newsletter_groups',$fetch_config);
		return $result;
	}

	
	public function get_records_by_id( $newsletter_groups_id )
	{
		$newsletter_groups_id = (int) $newsletter_groups_id;
		if($newsletter_groups_id!='' && is_numeric($newsletter_groups_id)){
			$condtion = "newsletter_groups_id =$newsletter_groups_id";
			$fetch_config = array(
							  'condition'=>$condtion,							 					 
							  'debug'=>FALSE,
							  'return_type'=>"object"							  
							  );
			$result = $this->find('wl_newsletter_groups',$fetch_config);
			return $result;
		}
	}
	
	public function change_status()
	{
		$arr_ids = $this->input->post('arr_ids');
		if( is_array($arr_ids) ){
			$str_ids = implode(',', $arr_ids);
			if($this->input->post('Activate')=='Activate'){				
				$data = array('status'=>'1');
				$where = "newsletter_groups_id IN ($str_ids)";
				$this->safe_update('wl_newsletter_groups',$data,$where,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('activate'));
					
			}
			if($this->input->post('Deactivate')=='Deactivate')
			{							
				$data = array('status'=>'0');
				$where = "newsletter_groups_id IN ($str_ids)";
				$this->safe_update('wl_newsletter_groups',$data,$where,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('deactivate'));
			}
				
			if($this->input->post('Delete')=='Delete')
			{	
					$this->db->where("newsletter_groups_id IN ($str_ids)");
					$this->db->delete('wl_newsletter_group_subscriber');
								
					$this->db->where("newsletter_groups_id IN ($str_ids)");
					$this->db->delete('wl_newsletter_groups');
					
					
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success',lang('deleted'));
					
			}
		}

	}


	public function checkRecord($cond)
	{
		$qry = $this->db->query("SELECT newsletter_groups_id from wl_newsletter_groups where 1 $cond");
		$num=$qry->num_rows();
		$qry->free_result();
		return $num;
	}
	
	public function count_records($newsletter_groups_id="",$cond='')
	{
		$this->db->where('newsletter_groups_id',$newsletter_groups_id);
		if($cond!="")$this->db->where($cond);
		$this->db->from('wl_newsletter_group_subscriber');
		return $this->db->count_all_results();
		
	}
	
	
	
	public function group_drop_down($name,$selval,$extra="",$mess="")
	{								
		$this->db->select('newsletter_groups_id,group_name');
		$query=$this->db->get('wl_newsletter_groups');		
		$arr=array(''=>"$mess Group"); 
		   
		if($query->num_rows() > 0)
		{
			$res=$query->result();		      
		      foreach($res as $val)
			  {
		        	$cid=$val->newsletter_groups_id;
		        	$arr[$cid]=$val->group_name;
		      }
		}
		
		return form_dropdown($name,$arr,$selval,$extra);
	}
	
	

	public function get_group_email($newsletter_groups_id="")
	{
	    $this->db->select('wl_newsletters.subscriber_email');
        $this->db->from('wl_newsletters');
		$this->db->where('wl_newsletter_group_subscriber.newsletter_groups_id',$newsletter_groups_id);	
		$this->db->join('wl_newsletter_group_subscriber',
		 'wl_newsletters.subscriber_id=wl_newsletter_group_subscriber.subscriber_id','INNER');	
		 		
		$query=$this->db->get();
		
		if ( $query->num_rows() > 0 )
		{			
			$data=$query->result();
			
			$subscriber_email=array();
			
			foreach ($data as $d)
			{
				array_push($subscriber_email,$d->subscriber_email);
			}
			
			$user_email=implode(",",$subscriber_email);
			
			return $subscriber_email;
		}
		
	}
	
	 
}
// model end here