<?php
$this->load->helper(array('string','text'));
$banner_left_array = array();
$sql = "SELECT * FROM wl_banners WHERE banner_image!='' AND status='1' AND banner_position = 'Home Page'  ORDER BY  RAND() LIMIT 3";
$query = $this->db->query($sql);
if($query->num_rows() > 0){
	$result_banner = $query->result_array();
	foreach($result_banner as $val){
		if($val['banner_image']!='' && file_exists(UPLOAD_DIR."/banner/".$val['banner_image'])){
			array_push($banner_left_array,$val);
		}
	}
}

if(!empty($banner_left_array)){
	?>
	<?php
	$p=1;
	foreach($banner_left_array as $key=>$val){
		$ban_title="";
		$link_ban = ($val['banner_url']!='' ) ? $val['banner_url'] : "";
		if($link_ban!=''){
			$link_ban = !preg_match("~^http~",$link_ban) ? "http://".$link_ban : $link_ban;
		}
		$css="";
		if($p > 1){
			$css="mt25";
		}
		if($link_ban!=''){
			?>
			<div class="<?php echo $css;?>"><a href="<?php echo $link_ban;?>" target="_blank"><img src="<?php echo get_image('banner',$val['banner_image'],'286','448','R'); ?>" alt="<?php echo escape_chars($ban_title);?>" title="<?php echo escape_chars($ban_title);?>"  class="db" /></a></div>
			<?php
		}else{
			?>
			<div  class="<?php echo $css;?>"><img src="<?php echo get_image('banner',$val['banner_image'],'286','448','R'); ?>" alt="<?php echo escape_chars($ban_title);?>" title="<?php echo escape_chars($ban_title);?>" class="db" /></div>
			<?php
		}
		$p++;
	}?>
	
	<?php
}