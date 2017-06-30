<?php
$this->load->helper(array('string','text'));
$banners_array = array();
$sql = "SELECT * FROM wl_banners WHERE banner_image!='' AND status='1' AND banner_position = 'Right Panel'  ORDER BY  RAND() LIMIT 2";
$query = $this->db->query($sql);
if($query->num_rows() > 0){
	$result_banner = $query->result_array();
	foreach($result_banner as $val){
		if($val['banner_image']!='' && file_exists(UPLOAD_DIR."/banner/".$val['banner_image'])){
			array_push($banners_array,$val);
		}
	}
}

if(!empty($banners_array)){
	$p=1;
	echo '<p class="ac">';
	foreach($banners_array as $key=>$val){
		$ban_title="";
		$link_ban = ($val['banner_url']!='' ) ? $val['banner_url'] : "";
		if($link_ban!=''){
			$link_ban = !preg_match("~^http~",$link_ban) ? "http://".$link_ban : $link_ban;
		}
		if($link_ban!=''){
			?>
			<a href="<?php echo $link_ban;?>" target="_blank"><img src="<?php echo get_image('banner',$val['banner_image'],'230','470','R'); ?>" alt="<?php echo escape_chars($ban_title);?>" title="<?php echo escape_chars($ban_title);?>" class="mw_98" /></a>
			<?php
		}else{
			?>
			<img src="<?php echo get_image('banner',$val['banner_image'],'230','470','R'); ?>" alt="<?php echo escape_chars($ban_title);?>" title="<?php echo escape_chars($ban_title);?>" class="mw_98" />
			<?php
		}
		if($p == 1){
			echo '<br/>';
		}
		$p++;
	}
	echo '</p>';
}