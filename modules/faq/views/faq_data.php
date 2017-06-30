<?php
if(is_array($res) && !empty($res) ){
	$counter=1+$this->input->get_post('offset');
	foreach($res as $val){
		?>        
        <div class="panel panel-default listpager">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $counter;?>"><?php echo $val['faq_question'];?></a>
                </h4>
            </div>
            <div id="collapse<?php echo $counter;?>" class="panel-collapse collapse">
                <div class="panel-body black"><?php echo nl2br($val['faq_answer']);?></div>
            </div>
        </div>            
		<?php
	$counter++;
	}
}?>