<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pages_model extends MY_Model
{
	
	public  function get_cms_page($page=array())
	{		
		if( is_array($page) && !empty($page) )
		{			
			$result =  $this->db->get_where('wl_cms_pages',$page)->row_array();

			if( is_array($result) && !empty($result) )
			{
				return $result;
			}
			
		}	
			
	}
	
	
	public function get_all_cms_page($offset='0',$limit='10')
	{
		
		$keyword = $this->db->escape_str(trim($this->input->get_post('keyword')));
		
		$condtion = ($keyword!='') ? "status !='2' AND page_name LIKE '%".$keyword."%'" :
		"status !='2' ";
		
		$fetch_config = array(
							  'condition'=>$condtion,
							  'order'=>"page_name ASC",
							  'limit'=>$limit,
							  'start'=>$offset,							 
							  'debug'=>FALSE,
							  'return_type'=>"array"							  
							  );		
		$result = $this->findAll('wl_cms_pages',$fetch_config);
		return $result;	
	
	}

	// Add newsletter service..........................
	  	
	public function add_newsletter_member()
	{
		  $subscribe_me = $this->security->xss_clean($this->input->post('subscribe_me'));
		  $subscribe_me = $subscribe_me == '' && ($subscribe_me != 'Y' && $subscribe_me !='N') ? 'Y' : $subscribe_me;

		  $subscriber_name = $this->security->xss_clean($this->input->post('subscriber_name'));
		  $subscriber_name = $subscriber_name=='' ? null : $subscriber_name;

		  $subscriber_email = $this->security->xss_clean($this->input->post('subscriber_email'));

		  	
		  if($subscribe_me === 'Y')
		  {
		  
			  $query = $this->db->query("SELECT * FROM wl_newsletters  WHERE subscriber_email='".$subscriber_email."' ");
			  if ($query->num_rows() > 0)
			  {
			  
				  $row = $query->row_array();
				  if($row['status']==1)
				  {
					  $error_type = "error";
					  $error_msg = $this->config->item('newsletter_already_subscribed');
				  
				  }
				  else
				  {
				  
					  $where = "subscriber_email = '".$row['subscriber_email']."'"; 						
					  $this->safe_update('wl_newsletters',array('status'=>'1'),$where,FALSE);

					  $error_type = "success";
					  $error_msg = $this->config->item('newsletter_subscribed');
				  }
			  }
			  else
			  {
				 $data =  array('status'=>'1',
							   'subscriber_name'=>$subscriber_name,
							   'subscriber_email'=>$subscriber_email
							  );
				 $this->pages_model->safe_insert('wl_newsletters',$data); 	

				 $error_type = "success";
				 $error_msg = $this->config->item('newsletter_subscribed');
			  
			  }
		  
		  }
		  elseif($subscribe_me === 'N')
		  {
		  
			  $query = $this->db->query("SELECT * FROM wl_newsletters  WHERE subscriber_email='".$subscriber_email."' ");
			  if ($query->num_rows() > 0)
			  {
			  
				  $row = $query->row_array();
				  
				  if($row['status']==1)
				  {
				  
					  $where = "subscriber_email = '".$row['subscriber_email']."'"; 						
					  $this->safe_update('wl_newsletters',array('status'=>'0'),$where,FALSE);	

					  $error_type = "success";
					  $error_msg = $this->config->item('newsletter_unsubscribed');
				  
				  }
				  else
				  {
				  
					$error_type = "error";
					$error_msg = $this->config->item('newsletter_already_unsubscribed');
					
				  
				  }
			  
			  }
			  else
			  {
			  
				  $error_type = "error";
				  $error_msg = $this->config->item('newsletter_not_subscribe');
			 }
		  
		  }
		  
		  return array('error_type'=>$error_type,'error_msg'=>$error_msg);
	
	}
	
	public function get_products_enquiries($limit = '10', $offset = '0', $param = array()) {
		$keyword   = $this->db->escape_str(trim($this->input->get_post('keyword',TRUE)));
    $status = @$param['status'];
    $productid = @$param['productid'];
    $orderby = @$param['orderby'];
    $type = @$param['type'];
    $where = @$param['where'];
    $customers_id = @$param['customers_id'];
    $sellers_id = @$param['sellers_id'];

    if($keyword!=''){
	    $this->db->where("CONCAT_WS(' ',first_name,last_name) LIKE '%".$keyword."%' OR  email LIKE '%".$keyword."%'  OR  product_service LIKE '".$keyword."%' OR  phone_number LIKE '".$keyword."%' ");			
    }
    if ($customers_id != '') {
      $this->db->where("customers_id ", "$customers_id");
    }
    if ($sellers_id != '') {
      $this->db->where("sellers_id ", "$sellers_id");
    }
    if ($type != '') {
      $this->db->where("type  ", "$type");
    }
    if ($status != '') {
      $this->db->where("status", "$status");
    }
    if ($where != '') {
      $this->db->where($where);
    }
    if ($orderby != '') {
      $this->db->order_by($orderby);
    } else {
      $this->db->order_by('id ', 'desc');
    }
    if ($limit > 0) {
      if (applyFilter('NUMERIC_WT_ZERO', $offset) == -1) {
        $offset = 0;
      }
      $this->db->limit($limit, $offset);
    }
    $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
    $this->db->from('wl_enquiry');
    $q = $this->db->get();
    //echo_sql();
    $result = $q->result_array();
    return $result;
  }
  
  public function update_reply_status($rid) {

    $id = (int) $rid;

    if ($id != '' && is_numeric($id)) {

      $data = array('reply_status' => 'Y', 'reply' => $this->input->post('message'));

      $where = "id = '" . $id . "'";

      $this->safe_update('wl_enquiry', $data, $where, FALSE);
    }
  }
	
	
	
		
}