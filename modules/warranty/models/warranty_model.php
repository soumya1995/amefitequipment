<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Warranty_model extends MY_Model
 {


	 public function get_warranty($limit='10',$offset='0',$param=array()){

		$status			    =   @$param['status'];		
		$warrantyid			=   @$param['warrantyid'];
		$orderby			=	@$param['orderby'];
		$where			    =	@$param['where'];			
		$keyword			=   trim($this->input->get_post('keyword2',TRUE));
		$keyword			=   $this->db->escape_str($keyword);
		
		if($where!=''){
			$this->db->where($where);

		}		
		if($warrantyid!=''){
			$this->db->where("wlw.warranty_id  ","$warrantyid");
		}		
		if($status!=''){
			$this->db->where("wlw.status","$status");
		}		
		if($keyword!=''){
			$this->db->where("(wlw.title LIKE '%".$keyword."%')");
		}
		if($orderby!=''){
			$this->db->order_by($orderby);

		}else{
			$this->db->order_by('wlw.title ','ASC');
		}

	  	$this->db->group_by("wlw.warranty_id");
	  	if($limit!=""){
			$this->db->limit($limit,$offset);		
		}		
		$this->db->select("SQL_CALC_FOUND_ROWS wlw.*, wlw.status as product_status, wlwm.media,wlwm.media_type, wlwm.is_default",FALSE);
		$this->db->from('wl_warranty as wlw');		
		$this->db->join('wl_media AS wlwm','wlw.warranty_id=wlwm.products_id','left');
		
		$q=$this->db->get();
		//echo_sql();
		$result = $q->result_array();
		$result = ($limit=='1') ? @$result[0]: $result;
		return $result;

	}

	public function get_warranty_media($limit='4',$offset='0',$param=array())
    {
		 $default			    =   @$param['default'];
		 $productid			    =   @$param['productid'];
		 $media_type			=   @$param['media_type'];
		 $product_type			=   @$param['product_type'];
		 $where  =   @$param['where'];
		 if( is_array($param) && !empty($param) )
		 {
			$this->db->select('SQL_CALC_FOUND_ROWS *',FALSE);
			if($limit)
			$this->db->limit($limit,$offset);
			$this->db->from('wl_media');
			$this->db->where('products_id',$productid);

			if($default!='')
			{
				$this->db->where('is_default',$default);
			}
			if($media_type!='')
			{
				$this->db->where('media_type',$media_type);
			}
			if($product_type!='')
			{
				$this->db->where('product_type',$product_type);
			}
						
			if($where!=''){			
				$this->db->where($where);			
			}
			
			$this->db->order_by('id ASC');
			
			$q=$this->db->get();
			//echo_sql();
			$result = $q->result_array();
			//$result = @($limit=='1') ? $result[0]: $result;
			return $result;

		 }

	}
	
	

	public function get_product_base_price($param=array()){

		  $where			    =   @$param['where'];
		  $this->db->select('*',FALSE);
		  $this->db->from('wl_product_attributes');
		  if($where!=''){
			  $this->db->where($where);
		  }
		  $q=$this->db->get();
		  $result = $q->row_array();
		  //echo $this->db->last_query();
		  return $result;
	}

	public function get_product_brand($brand_id,$param=array())
    {
		 $brand_id  = (int) $brand_id;

		if($brand_id > 0)
		{

		  $where			    =   @$param['where'];

		  if($where!='')
		  {
			  $this->db->where($where);
		  }


		  $this->db->select('*',FALSE);

		  $this->db->from('wl_brands');

		  $this->db->where(array('brand_id ='=>$brand_id,'status !='=>'2'));




		  $q=$this->db->get();
		  $result = $q->row_array();
		  return $result;
		}
	}



	public function related_warranty_added($productId,$limit='NULL',$start='NULL')
	{
		$res_data =  array();
		$condtion = ($productId!='') ? "status ='1' AND product_id = '$productId' ":"status ='1'";
		$fetch_config = array(
													'condition'=>$condtion,
													'order'=>"id DESC",
													'limit'=>$limit,
													'start'=>$start,
													'debug'=>FALSE,
													'return_type'=>"array"
												 );
		$result = $this->findAll('wl_warranty_related',$fetch_config);
		if( is_array($result) && !empty($result) )
		{
			foreach ($result as $val )
			{
				$res_data[$val['id']] =$val['related_id'];
			}
		}
		return $res_data;
	}

	public function update_viewed($id,$counter=0)
	{
	  $id = (int) $id;
	  if($id>0)
	  {
		  $posted_data = array(
					'warranty_viewed'=>($counter+1)
				 );

		  $where = "warranty_id = '".$id."'";
		  $this->category_model->safe_update('wl_warranty',$posted_data,$where,FALSE);
	  }

	}



	public function get_related_warranty($productId)
	{
		$condtion = (!empty($productId)) ? "status !='2'  AND warranty_id NOT IN(".implode(",",$productId). ")" :"status !='2'";

		$fetch_config = array(
													'condition'=>$condtion,
													'order'=>"warranty_id DESC",
													'limit'=>'NULL',
													'start'=>'NULL',
													'debug'=>FALSE,
													'return_type'=>"array"
												 );
		$result = $this->findAll('wl_warranty',$fetch_config);
		return $result;
	}


	public function related_warranty($productId,$start='NULL',$limit='NULL')
	{
		$res_data =  array();
		$condtion = ($productId!='') ? "status ='1' AND product_id = '$productId' ":"status ='1'";
		$fetch_config = array(
		'condition'=>$condtion,
		'order'=>"RAND()",
		'limit'=>$limit,
		'start'=>$start,
		'debug'=>FALSE,
		'return_type'=>"array"
		);
		
		$result = $this->findAll('wl_warranty_related',$fetch_config);
		if( is_array($result) && !empty($result) )
		{
			foreach ($result as $val )
			{
				$res_data[$val['id']] = $this->get_warranty(1,0, array('productid'=>$val['related_id']));
			}
		}
		$res_data = array_filter($res_data);
		return $res_data;
	}


	public function get_related_colors($colorId,$limit='NULL',$start='NULL')
	{
		$condtion = (!empty($colorId)) ? "status !='2'  AND color_id NOT IN(".implode(",",$colorId). ")" :"status !='2'";

		$fetch_config = array(
													'condition'=>$condtion,
													'order'=>"color_id DESC",
													'limit'=>'NULL',
													'start'=>'NULL',
													'debug'=>FALSE,
													'return_type'=>"array"
												 );
		$result = $this->findAll('wl_colors',$fetch_config);
		return $result;
	}

	public function related_colors($param=array())
	{
	  $res_data =  array();

	  $where			=	@$param['where'];
	  $limit			=   @$param['limit'];
	  $offset			=	@$param['offset'];

	  if($limit>0)
	  {
		$this->db->limit($limit,$offset);
	  }
	  if($where!='')
	  {
		$this->db->where($where);
	  }
	  $this->db->select('SQL_CALC_FOUND_ROWS wlc.color_name,wlc.status as color_status',FALSE);
	  $this->db->from('wl_colors as wlc');
	  $this->db->where('wlc.status !=','2');
	  //$this->db->join('wl_product_attributes AS wlpatt','wlc.color_id=wlpatt.color_id');
	  $q=$this->db->get();
	  $result = $q->result_array();

	  if( is_array($result) && !empty($result) )
	  {
		  foreach ($result as $val )
		  {
			$res_data[$val['attribute_id']] = $val;
		  }
	  }

	  $res_data = array_filter($res_data);
	  return $res_data;
	}

	public function get_related_sizes($sizeId,$limit='NULL',$start='NULL')
	{
		$condtion = (!empty($sizeId)) ? "status !='2'  AND size_id NOT IN(".implode(",",$sizeId). ")" :"status !='2'";

		$fetch_config = array(
													'condition'=>$condtion,
													'order'=>"size_id DESC",
													'limit'=>'NULL',
													'start'=>'NULL',
													'debug'=>FALSE,
													'return_type'=>"array"
												 );
		$result = $this->findAll('wl_sizes',$fetch_config);
		return $result;
	}

	public function related_sizes($param=array())
	{
	  $res_data =  array();

	  $where			=	@$param['where'];
	  $limit			=   @$param['limit'];
	  $offset			=	@$param['offset'];

	  if($limit>0)
	  {
		$this->db->limit($limit,$offset);
	  }
	  if($where!='')
	  {
		$this->db->where($where);
	  }
	  $this->db->select('SQL_CALC_FOUND_ROWS wls.size_name,wls.status as size_status',FALSE);
	  $this->db->from('wl_sizes as wls');
	  $this->db->where('wls.status !=','2');
	  //$this->db->join('wl_product_attributes AS wlpatt','wls.size_id=wlpatt.size_id');
	  $q=$this->db->get();
	  $result = $q->result_array();

	  if( is_array($result) && !empty($result) )
	  {
		  foreach ($result as $val )
		  {
			$res_data[$val['attribute_id']] = $val;
		  }
	  }

	  $res_data = array_filter($res_data);
	  return $res_data;
	}


	public function get_shipping_methods()
	{
		$condtion = "status =1";
		$fetch_config = array(
													'condition'=>$condtion,
													'order'=>"shipping_id DESC",
													'debug'=>FALSE,
													'return_type'=>"array"
													);
		$result = $this->findAll('wl_shipping',$fetch_config);
		return $result;
	}

	public function get_product_colors($id)
	{
		$id = (int) $id;
		if($id>0)
		{

			$this->db->select('wc.color_id, wc.color_name, wc.color_code');
			$this->db->from('wl_product_colors as wpc');
			$this->db->join('wl_colors as wc','wc.color_id=wpc.color_id','left');
			$this->db->join('wl_product_stock as wps','wps.product_color=wpc.color_id','left');
			$this->db->where('wpc.product_id',$id)->group_by('wc.color_id')->order_by('wps.product_quantity desc');
			$q=$this->db->get();
			return $result = $q->result_array();

		}
	}

	public function get_product_sizes($id)
	{
		$id = (int) $id;
		if($id>0)
		{

			$this->db->select('ws.size_id, ws.size_name');
			$this->db->from('wl_product_sizes as wps');
			$this->db->join('wl_sizes as ws','ws.size_id=wps.size_id');
			$this->db->join('wl_product_stock as wpst','wpst.product_size=ws.size_id');
			$this->db->where('wps.product_id',$id)->group_by('wpst.product_size')->order_by('wpst.product_quantity desc');
			$q=$this->db->get();
			return $result = $q->result_array();

		}
	}
	
	public function get_product_categories()
	{
		
		$this->db->select('wc.category_id, wc.category_name');
		$this->db->from('wl_categories as wc');
		$this->db->join('wl_warranty as wp','wp.category_id=wc.category_id');
		$this->db->where('wp.status !=','2');
		$this->db->where('wc.status !=','2');
		$this->db->order_by('wc.category_name asc');
		$this->db->group_by('wp.category_id');
		$q=$this->db->get();
		return $result = $q->result_array();
		
	}
	
	/*---------Manage Product Stock -------------*/
	
	public function product_id_stock_list($product_id)
	{
		$query="SELECT * FROM wl_product_stock WHERE product_id='".$product_id."'  ORDER BY product_size ASC";
		$db_query=$this->db->query($query);
		if($db_query->num_rows() > 0)
		{
			$res=$db_query->result_array();
			return $res;
		}
		else
		{
			return false;
		}
		
	}
	 
	/*---------End  Product Stock -------------*/ 
	
	/*---------Manage Product Combo -------------*/
	
	public function product_id_combo($product_id)
	{
		$query="SELECT * FROM wl_product_combo WHERE ref_pid='".$product_id."' AND status='1'  ORDER BY pid ASC";
		$db_query=$this->db->query($query);
		if($db_query->num_rows() > 0)
		{
			$res=$db_query->result_array();
			return $res;
		}
		else
		{
			return false;
		}
		
	}
	 
	/*---------End  Product Combo -------------*/ 
	
	
	public function product_out_stock_list($limit='10',$offset='0',$param=array())
	{
		$category_id		=   @$param['category_id'];
		$brand_id			=   @$param['brand_id'];
		$status			    =   @$param['status'];			
		$where			    =	@$param['where'];
		$orderby			=	@$param['orderby'];		
		$keyword			=   trim($this->input->get_post('keyword2',TRUE));	
		$keyword			=   $this->db->escape_str($keyword);
		
		
		if($keyword!='')
		{
			$this->db->where("(wlp.product_name LIKE '%".$keyword."%' OR wlp.product_code LIKE '%".$keyword."%' )");
		}
		
		if($orderby!='')
		{		
			//$this->db->order_by($orderby);
			
		}
		else
		{
			//$this->db->order_by('wlp.warranty_id ','desc');
		}
	
	    //$this->db->group_by("wlp.warranty_id"); 	
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS wlp.*,stock.product_quantity,wlp.status as product_status,wlpatt.*,wlpm.media,wlpm.media_type,wlpm.is_default',FALSE);
		$this->db->from('wl_warranty as wlp');
		$this->db->where('wlp.status !=','2');
		
		$cond="stock.product_id IN(SELECT IF(sum(product_quantity) = '0', product_id,'' ) as pid FROM `wl_product_stock` WHERE 1 group by product_id )";
		$this->db->where($cond);
		
		//$this->db->where(array('wlpatt.color_id ='=>'0','wlpatt.size_id ='=>'0'));
		$this->db->join('wl_product_attributes AS wlpatt','wlp.warranty_id=wlpatt.product_id');
		#--------------------------------------------------------------------------------------#
		
		//exit;
		
		$this->db->join('wl_product_stock AS stock',"wlp.warranty_id=stock.product_id",'left');
		
		#-------------------------------------------------------------------------------------#
		$this->db->join('wl_warranty_media AS wlpm','wlp.warranty_id=wlpm.warranty_id','left');
		//$this->db->where('stock.product_quantity',0);		
	
		$this->db->group_by('stock.product_id'); 
		
		$q=$this->db->get();
       //echo_sql();
		$result = $q->result_array();	
		$result = ($limit=='1') ? @$result[0]: $result;	
		return $result;
			
	}
	 
	/*---------End  Product Stock -------------*/ 
  
  	
	
	public function product_in_stock_list($limit='10',$offset='0',$param=array())
	{
		$category_id		=   @$param['category_id'];
		$brand_id			=   @$param['brand_id'];
		$status			    =   @$param['status'];			
		$where			    =	@$param['where'];
		$orderby			=	@$param['orderby'];		
		$keyword			=   trim($this->input->get_post('keyword2',TRUE));	
		$keyword			=   $this->db->escape_str($keyword);
		
		
		if($keyword!='')
		{
			$this->db->where("(wlp.product_name LIKE '%".$keyword."%' OR wlp.product_code LIKE '%".$keyword."%' )");
		}
		
		if($status!='')
		{
			$this->db->where("wlp.status","$status");
		}
		$search_prod_type=$this->input->get_post('search_prod_type',TRUE);
		
		if($search_prod_type=='new_arrival')
		{
			$this->db->where("wlp.new_arrival",'1');
		}
		if($search_prod_type=='new_arrival')
		{
			$this->db->where("wlp.new_arrival",'1');
		}
		if($search_prod_type=='hot_product')
		{
			$this->db->where("wlp.hot_product",'1');
		}
		
		
		if($orderby!='')
		{		
			//$this->db->order_by($orderby);
			
		}
		else
		{
			//$this->db->order_by('wlp.warranty_id ','desc');
		}
	
	   $this->db->group_by("wlp.warranty_id"); 	
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS wlp.*,stock.product_quantity,wlp.status as product_status,wlpatt.*,wlpm.media,wlpm.media_type,wlpm.is_default',FALSE);
		$this->db->from('wl_warranty as wlp');
		$this->db->where('wlp.status !=','2');
		
			$cond="stock.product_id IN(SELECT 
	IF(sum(product_quantity)> '0', product_id,'' ) as pid
	 FROM `wl_product_stock` WHERE 1 group by product_id 
)";
$this->db->where($cond);
		
		//$this->db->where(array('wlpatt.color_id ='=>'0','wlpatt.size_id ='=>'0'));
		$this->db->join('wl_product_attributes AS wlpatt','wlp.warranty_id=wlpatt.product_id');
		#--------------------------------------------------------------------------------------#
		
		//exit;
		
		$this->db->join('wl_product_stock AS stock',"wlp.warranty_id=stock.product_id",'left');
		
		#-------------------------------------------------------------------------------------#
		$this->db->join('wl_warranty_media AS wlpm','wlp.warranty_id=wlpm.warranty_id','left');
		//$this->db->where('stock.product_quantity',0);
		
	
		//$this->db->group_by('stock.product_id'); 
		
		$q=$this->db->get();
       //echo_sql();
		$result = $q->result_array();	
		$result = ($limit=='1') ? @$result[0]: $result;	
		return $result;
			
	}
/*---------Color media-------------*/
	
	public function get_color_image($opts=array())
	{
		$status_flag=FALSE;
		$keyword = $this->db->escape_str($this->input->post('keyword'));
		$status = $this->db->escape_str($this->input->post('status'));
		
		if($status!=='' && in_array($status,array('1','0')))
		{
			$opts['condition']= "color_status ='".$status."' AND warranty_id='".$this->uri->segment(4)."' ";
			$status_flag=TRUE;
		}
		if( ! $status_flag && (!array_key_exists('condition',$opts) || $opts['condition']==''))
		{
			$opts['condition']= "color_status !='2' ";
		}
		if($keyword!='')
		{
			$opts['condition'].= "AND (color_id ".$keyword.")";
		}
		
		$opts['condition'].= "AND warranty_id='".$this->uri->segment(4)."' AND color_id!=0";
		
		if(!array_key_exists('order',$opts) || $opts['order']=='')
		{
			$opts['order']= "id DESC ";
		}
		$fetch_config = array(
								'condition'=>$opts['condition'],
								'order'=>$opts['order'],
								'debug'=>FALSE,
								'return_type'=>"array"							  
							);	
		if(array_key_exists('limit',$opts) && applyFilter('NUMERIC_GT_ZERO',$opts['limit'])>0){
			$fetch_config['limit']=$opts['limit'];
		}	
		if(array_key_exists('offset',$opts) && applyFilter('NUMERIC_WT_ZERO',$opts['offset'])!=-1){
			$fetch_config['start']=$opts['offset'];
		}		
		$result = $this->findAll('wl_warranty_media',$fetch_config);
		return $result;	
	}
	
	// Add news information ...................
	public function add_color_image()
	{  		
			$color_id= $this->input->post('color_id');
			$this->load->library('upload');									
			$data_upload_sugg = $this->upload->my_upload('media',"warranty");
		$defalut_image = 'Y';	
		if( is_array($data_upload_sugg)  && !empty($data_upload_sugg) )
		{ 
			$add_data = array(
			'warranty_id'=>$this->input->post('product_id'),
			'media_type'=>'photo',
			'is_default'=>$defalut_image,									
			'media'=>$data_upload_sugg['upload_data']['file_name'],
			'media_date_added' => $this->config->item('config.date.time'),
			'color_id'=>$this->input->post('color_id')
			);															
			$this->product_model->safe_insert('wl_warranty_media', $add_data ,FALSE );
		
		
		
		return TRUE;
		}
		else
		{
			$this->delete_in("wl_warranty_media","id = $color_id",FALSE);
			return FALSE;
		}	
	}
	
	public function update_color_img($rowdata)
	{  
		 $where =  "id = '".$rowdata->id."'";
		
		$data = array(
						'color_id'  	=> $this->input->post('color_id'),
						'warranty_id'  	=> $this->input->post('product_id')
					 );
					 
				
		$banId =  $this->safe_update('wl_warranty_media',$data,$where,FALSE);
		
		$this->load->library('upload');
		$data =  $this->upload->my_upload('media','warranty');
		
		if( is_array($data)  && !empty($data) )
		{ 
			$this->safe_update('wl_warranty_media',
													array(
													'media'=>$data['upload_data']['file_name']
													),
													"id = $rowdata->id ",
													FALSE
												);
			unlink(UPLOAD_DIR.'/product/'.$rowdata->media);
			return FALSE;
		}
	}
	
	public function get_product_by_id($id)
	{
		$id = (int) $id;
		if($id>0)
		{
			
			$this->db->select('*');
			$this->db->from('wl_product_colors');
			$this->db->where('product_id',$id);
			$q=$this->db->get();
			return $result = $q->result_array();
			
		}
	}
	
	
	// Get help center by id.....
	public function get_color_by_id($id){
		
		$id = (int) $id;
	    
		if($id!='' && is_numeric($id)){
			
			$condtion = "color_status !='2' AND id=$id";
			
			$fetch_config = array(
							  'condition'=>$condtion,							 					 
							  'debug'=>FALSE,
							  'return_type'=>"object"							  
							  );
			
			$result = $this->find('wl_warranty_media ',$fetch_config);
			return $result;		
		
		 }
	}
	
	public function change_color_status()
	{
	   $arr_ids = $_REQUEST['arr_ids'];
		if(is_array($arr_ids)){
		
			$str_ids = implode(',', $arr_ids);
			
			if($this->input->post('Activate')=='Activate')
			{
				$query = $this->db->query("UPDATE wl_warranty_media   
				                           SET color_status='1' 
										   WHERE id in ($str_ids)");
										   
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('activate') ); 
			}
			
			if($this->input->post('Deactivate')=='Deactivate')
			{
				$query = $this->db->query("UPDATE wl_warranty_media  
				                           SET color_status='0' 
										   WHERE id in ($str_ids)");
										   
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('deactivate') ); 
				
			}
			
			if($this->input->post('Delete')=='Delete')
			{
				$query = $this->db->query("DELETE FROM wl_warranty_media 
				                           WHERE id in ($str_ids)");
										   
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('deleted')); 
			}
		}
	}
	
	/*---------End Color media-------------*/
	
	public function get_review($limit='10',$offset='0',$param=array())
	{
		$status			    =   @$param['status'];
		$rev_status			=   @$param['rev_status'];
		$productid			=   @$param['productid'];
		$rev_type			=   @$param['rev_type'];
		$orderby			=	@$param['orderby'];
		$where			    =	@$param['where'];
		
		$join			    =	@$param['join'];
		$keyword			=   trim($this->input->get_post('keyword',TRUE));
		$keyword			=   $this->db->escape_str($keyword);

		$return_type = !array_key_exists('return_type',$param) ? "result_array"     : $param['return_type'];

		if($productid!='')
		{
			$this->db->where("prd.warranty_id  ","$productid");
		}
		
		if($rev_type!='')
		{
			$this->db->where("rev.rev_type  ","$rev_type");
		}

		if($rev_status!='')
		{
			$this->db->where("rev.status","$rev_status");
		}
		
		if($status!='')
		{
			$this->db->where("prd.status","$status");
		}


		if($keyword!='')
		{
			$this->db->where("(prd.product_name LIKE '%".$keyword."%' OR rev.poster_name LIKE '%".$keyword."%' OR rev.email LIKE '%".$keyword."%' )");
		}

		if($where!='')
		{
			$this->db->where($where,"",FALSE);
		}

		if($orderby!='')
		{
			$this->db->order_by($orderby);

		}
		else
		{
			$this->db->order_by('rev.review_id ','desc');
		}

		if($limit)
		$this->db->limit($limit,$offset);

		$this->db->select('SQL_CALC_FOUND_ROWS rev.*,prd.product_name',FALSE);
		$this->db->from('wl_review as rev');
		//$this->db->where('rev.status !=2');
		$this->db->join('wl_warranty AS prd','rev.prod_id=prd.warranty_id','left');
		if(is_array($join)){
			$this->db->join($join["tableName"],$join["cond"],$join["type"]);
		}
		$q=$this->db->get();
		//echo_sql();
		
		
		$result =  ($return_type!='')  ? $q->$return_type()  :  $q->result_array() ;
		return $result;

	}

}