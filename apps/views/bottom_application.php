<?php $this->load->view('project_footer');
if ($this->config->item('bottom.debug')){
	?>
	<p class="mt5 mb5" align="center"><?php $this->output->enable_profiler($this->config->item('bottom.debug')); ?><p>
	<?php
}?>
<script type="text/javascript">var Page='home';</script> 
<script type="text/javascript" src="<?php echo resource_url();?>Scripts/script.int.dg.js"></script>

</body>
</html>