<?php
class Message_model extends MY_Model{

	public $table="";
	public $table_relate="";

	function __construct(){
		parent::__construct();
		$this->table='wl_messages';
		$this->table_relate='wl_message_details';
	}

	public function get_records($offset=FALSE,$per_page=FALSE,$cond="",$order="M.id DESC"){
		$order=($order=="")?'M.id DESC':$order;
		$opts=array(
						'condition'=>$cond,
						'debug'=>FALSE,
						'return_type'=>"object",
						'limit'=>$per_page,
						'orderby'=>$order,
						'groupby'=>"M.id",
						'offset'=>$offset,
						'fromcond'=>$this->table.' as M',
						'selectcond'=>'SQL_CALC_FOUND_ROWS M.*,MD.message_id,MD.user_id,MD.type,MD.message_status',
						'joins'=>array(array('tblname'=>$this->table_relate.' as MD','jclause'=>'MD.message_id=M.id','join_type'=>'INNER'))	
		);

		return $this->myCustomJoin($opts);
	}

	public function get_record_by_id($cond=""){
		$condtion = $cond;
		$fetch_config = array( 'condition'=>$condtion, 'debug'=>FALSE, 'return_type'=>"object" );
		$result = $this->find($this->table,$fetch_config);
		return $result;
	}

	public function get_reply_message($offset=FALSE,$per_page=false,$cond="",$order="id DESC"){
		$condition =$cond;
		 
		$fetch_config = array(
	            'condition'=>$condition,
					'order'=>$order,
					'limit'=>$per_page,
					'start'=>$offset,							 
					'debug'=>FALSE,
					'return_type'=>"object");
		$result = $this->findAll($this->table_relate,$fetch_config);
		return $result;
	}
	
	public function count_message($cond=""){
		$q=$this->db->query("SELECT count(M.id) FROM ($this->table as M) INNER JOIN $this->table_relate as MD ON `MD`.`message_id`=`M`.`id` WHERE $cond GROUP BY `M`.`id` ");
		return $q->num_rows();
	}

}