<div style="margin-top:10px;">
 <?php
 $menu_array=lang('top_menu_list');
 $menu_array = $menu_array[$this->session->userdata('admin_id')];
 $top_menu_icon=lang('top_menu_icon');
 if(array_key_exists('Dashboard',$menu_array)) unset($menu_array['Dashboard']);
 $total_menu=count($menu_array);
 if($total_menu > 0){
	 foreach($menu_array as $key=>$value){
		 $w =  ($key =='Other Management') ? 95 : 30;
		 $cls =  ($key =='Other Management') ? 'other-list' : 'other-list2';
		 $icon = array_key_exists( $key, $top_menu_icon) ? $top_menu_icon[$key] : "";
		 echo '<ul style="float:left; width:'.$w.'%; padding:5px; margin:5px; background-color:#fff; color:#000; border:1px solid #d9d9d9; font-weight:bold; list-style:none;" class="'.$cls.'">';
		 $key1=str_replace(' ','',$key);
		 if(is_array($value)){
			 echo '<li id="'.$key1.'" style="color:#000" >'.$key.'';
			 echo ' <div>';
			 if($icon!=''){
				 echo '<div style="float:left;"><img src="'.base_url().'assets/sitepanel/image/'.$icon.'" alt="" width="43" height="43" /></div>';
			 }
			 echo '<ul style="height:125px; margin-top:5px; margin-left:10px;">';
			 foreach($value as $k=>$val){
				 echo '<li>'.anchor($val,$k).'</li>';
			 }
			 echo '</ul></div></li>';
		 }else{
			 $attr="class='top'";
			 echo '<li id="'.$key1.'">'.anchor($value,$key,$attr).'</li>';
		 }
		 echo '</ul>';
	 }
 }

	
?>
</div>