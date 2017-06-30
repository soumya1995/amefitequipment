<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
* The global dbquery CI helpers 

*/

if ( ! function_exists('custom_result_set'))
{	
	function custom_result_set($sql)
	{	
		$ci = CI();
		$query=$ci->db->query($sql);
				
		if( $query->num_rows() > 0 )
		{			
			return $query->result_array();
			
		}	
	}
	
}

/*

 $condtion = "WHERE  page_id='16' AND status='1'"  String  format ;   
 $condtion = array('page_id'=>'16','status'=>'1')  Array format;

*/

if ( ! function_exists('get_db_single_row'))
{
	function get_db_single_row($tablename,$fields="*",$condition="1")
	{
		$ci = CI();
		
		$cond = 'WHERE 1';
				
		if( is_array($condition) && !empty($condition) ) 
		{
			foreach($condition as $key=>$value)
			{
				
			  $cond .=" AND $key='".$value."'";  
			  
			}
			
		}else
		{
			  $cond  .= $condition; 
		}
											   
		$query=$ci->db->query("SELECT $fields FROM $tablename $cond");
		$row_founds = $query->num_rows();
				
		if( $row_founds > 1)
		{			
			   echo $message = "Query returns multiple result set please check : ";
			   echo_sql();			   
			
		}elseif($row_founds > 0 )
		{
			return $query->row_array();
		}
		
	}
	
}


/*

$condtion = "WHERE  page_id='16' AND status='1'"  String  format ;   
$condtion = array('page_id'=>'16','status'=>'1')  Array format;

*/


if ( ! function_exists('get_db_field_value'))
{
  function get_db_field_value($tbl_name,$field,$condition)
  {    
	  $ci = CI();
      $cond="WHERE 1";
	  	  
    if( count($condition) > 0 && is_array($condition))
    {			  
      foreach($condition as $key=>$value)
      {		  		  		  
        $cond .=" AND $key='".$value."'";				  		
      }
	  	  
	}else
	{
		 $cond .= $condition; 		
	}
	
      $query=$ci->db->query("SELECT $field FROM $tbl_name $cond");
	  	                 
      if($query->num_rows() > 0)
      {	
	  	  
        $res=$query->row();	 
        return $res->$field;		 
		
      }	   
   }
}


/*


*/
 
if ( !function_exists('count_record') )
{	
	function count_record ($table,$condition="")
    {
		$ci = CI();	
			
		if($table!="" && $condition!="")
		{			
			  $ci->db->from($table);
			  $ci->db->where($condition);	        
			  $num = $ci->db->count_all_results();	
			  		
		 }else
		 {		 		
			 $num = $ci->db->count_all($table);	
		}
				
		return $num;	
    } 
}


/*



*/

if ( !function_exists('get_found_rows') )
{
	function get_found_rows()
	{
		$ci = CI();
		$query=$ci->db->query('SELECT FOUND_ROWS() AS total');
		$row=$query->row();
		return $row->total;
	}
}

/*



*/

if ( !function_exists('get_auto_increment') )
{
	function get_auto_increment($tablename)
	{
		$ci = CI();
		$query	=	$ci->db->query("SHOW TABLE STATUS LIKE '$tablename'");
		if($query->num_rows()==1)
		{
			$row=$query->row();
			
			return $inc=$row->Auto_increment;
		}
	}
}

/*




*/
if ( ! function_exists('echo_sql'))
{
	function echo_sql()
	{
		$ci = CI();
		echo"<font color='#ff0000' style='font-size:16px;font-family:verdana'><br />";
		echo wordwrap($ci->db->last_query(),60,"<br />\n",TRUE);		
		echo"<br />\n </font>";
	}
}

if ( ! function_exists('get_db_multiple_row'))
{
	function get_db_multiple_row($tablename,$fld=FALSE,$Condwherw=FALSE)
	{
		$CI = CI();	
		$fld=($fld!='')?$fld:"*";	
		$Condwherw=($Condwherw!='')?$Condwherw:" 1 ";
		
		$selquery="SELECT $fld
		           FROM $tablename
				   WHERE $Condwherw";
		$query=$CI->db->query($selquery);
		
		if($query->num_rows() > 0){
			
		  	return $query->result_array();
			
		}
	}
} 