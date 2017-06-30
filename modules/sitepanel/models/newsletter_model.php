<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Newsletter_model extends MY_Model{

	public function __construct()
	{	
		parent::__construct();	
	}
	
	
	public function get_newsletter($offset=FALSE,$per_page=FALSE)
	{	
		$keyword               =  $this->db->escape_str(trim($this->input->get_post('keyword',TRUE)));
		$newsletter_groups_id  =  $this->input->get_post('newsletter_groups_id',TRUE);
				
		$where_condtion  = ( $keyword!='') ? "status != '2' 
		             AND (subscriber_name like '%$keyword%' OR subscriber_email like '%$keyword%')":"status != '2' ";
					 		
		$this->db->select("SQL_CALC_FOUND_ROWS *",FALSE);		
		$this->db->from("wl_newsletters");
		
		 if( $newsletter_groups_id!="" )
		 {
		    $this->db->join("wl_newsletter_group_subscriber","wl_newsletter_group_subscriber.subscriber_id=wl_newsletters.subscriber_id","left");
		  	$this->db->where("wl_newsletter_group_subscriber.newsletter_groups_id",$newsletter_groups_id);
		  	$this->db->group_by("wl_newsletter_group_subscriber.subscriber_id");
		 }
		 
		$this->db->where($where_condtion);
		
		$this->db->order_by("wl_newsletters.subscriber_id","desc");		
		
		$this->db->limit($offset,$per_page);
		
		$query=$this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
			
	}
	
	
	public function change_status()
	{
			$arr_ids = $_REQUEST['arr_ids'];
			
			if(is_array($arr_ids)){			
				$str_ids = implode(',', $arr_ids);
				
				if($this->input->post('Activate')=='Activate')
				{				
					$query = $this->db->query("UPDATE wl_newsletters SET user_status='1' WHERE subscriber_id IN ($str_ids)");
					$this->session->set_userdata(array('msg_type'=>'success'));	
					$this->session->set_flashdata('success', 'Information have been activated successfully.'); 				
				}
				
				if($this->input->post('Deactivate')=='Deactivate')
				{				
					$query = $this->db->query("UPDATE wl_newsletters SET user_status='0' WHERE subscriber_id IN ($str_ids)");
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success', 'Information have been de-activated successfully.'); 				
				}
				
				if($this->input->post('Delete')=='Delete')
				{				
					$query = $this->db->query("DELETE from wl_newsletters WHERE subscriber_id in ($str_ids)");			
					$query = $this->db->query("DELETE from wl_newsletter_group_subscriber WHERE subscriber_id IN ($str_ids)");	
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success', 'Information have been deleted successfully.'); 
				}
				
				
				/* Bind Subscriber in Groups */
				
				if($this->input->post('add_group')==1 && $this->input->post('group_id')!="")
				{
					
					foreach ($arr_ids as $id)
					{
						$cond=" AND newsletter_groups_id =".$this->input->post('group_id')." AND subscriber_id=".$id;
						
						if($this->check_subscriber($cond) ==0 )
						{
							
						      $this->db->insert('wl_newsletter_group_subscriber',
						               array("newsletter_groups_id"=>$this->input->post('group_id'),
							          "subscriber_id"=>$id,
									  'date_added'=>$this->config->item('config.date.time')));
						}
												
					}
					
					$this->session->set_userdata(array('msg_type'=>'success'));
			        $this->session->set_flashdata('success','Subscriber has been successfully added in group.');
				
					
				}
				
			 /* End  Bind Subscriber in Groups */
			 
			 
					
			/* Unbind Subscriber in Groups */
				
				if($this->input->post('add_group')==2 && $this->input->post('ugroup_id')!="")
				{
					foreach ($arr_ids as $id)
					{					
						$this->db->delete('wl_newsletter_group_subscriber',
						   array("newsletter_groups_id"=>$this->input->post('ugroup_id'),"subscriber_id"=>$id));	
						   
						  				
					}
					
					$this->session->set_userdata(array('msg_type'=>'success'));
			        $this->session->set_flashdata('success','Subscriber has been successfully removed from group.');
				}
				
				
			  /* End  Unbind Subscriber in Groups */
				
				
			}	
			
				
		}
		
		
	public function getemail_by_id($id_array)
	{	
		$id_array=explode(',',$id_array);	
			
		if(is_array($id_array))
		{	 
			$emailarray='';			
			foreach($id_array as $value)
			{			
				$query = $this->db->query("SELECT * FROM wl_newsletters WHERE subscriber_id='$value'");				
				foreach ($query->result() as $row)
				{
					$emailarray=$row->subscriber_email.','.$emailarray;				
				}				
			}
			return $emailarray;		
		}		
	}
	
	
	public function get_admin_email()
	{	 
		$query = $this->db->query("SELECT * FROM tbl_admin ");	
			
		if ($query->num_rows() > 0)
		{	
			
			return $query->row_array();		
		}	
	}
	
	public function checkRecords($cond)
	{
		$qry = $this->db->query("select subscriber_id from wl_newsletters where 1 $cond");
		$num=$qry->num_rows();
		$qry->free_result();
		return $num;
	}
	
	public function check_subscriber($cond)
	{
		$qry = $this->db->query("select subscriber_id from wl_newsletter_group_subscriber where 1 $cond");
		$num=$qry->num_rows();
		$qry->free_result();
		return $num;
	}
	
	public function get_group_email($subscriber_id="")
		{
			$this->db->select('wl_newsletter_groups.group_name');
			$this->db->from('wl_newsletter_group_subscriber');
			$this->db->where('subscriber_id',$subscriber_id);	
			 $this->db->join('wl_newsletter_groups',
							 'wl_newsletter_groups.newsletter_groups_id=wl_newsletter_group_subscriber.newsletter_groups_id','INNER');
			
			
			$query=$this->db->get();
			if ($query->num_rows() > 0)
			{
				$data=$query->result();
				$group_name=array();
				foreach ($data as $d)
				{
					array_push($group_name,$d->group_name);
				}
				
				$group_name=implode(", ",$group_name);
				return $group_name;
			}
		}
		
		
		public function get_record_by_id( $subscriber_id )
		{		
			$subscriber_id = (int) $subscriber_id;	    
			if($subscriber_id!='' && is_numeric($subscriber_id)){			
				$condtion = "subscriber_id =$subscriber_id";			
				$fetch_config = array(
								  'condition'=>$condtion,							 					 
								  'debug'=>FALSE,
								  'return_type'=>"object"							  
								  );			
				$result = $this->find('wl_newsletters',$fetch_config);
				return $result;		
			 }		
		}
		
		
}
// model end here