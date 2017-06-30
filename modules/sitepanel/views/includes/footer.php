</div>
<div id="footer"><?php  echo $this->config->item("site_admin_name"); ?> &copy; <?php echo date('Y');?> All Rights Reserved.</div>
<?php 
if ($this->config->item('bottom.debug'))
{
?>

 <p class="mt5 mb5" align="center"><?php $this->output->enable_profiler(FALSE); ?><p>
  
<?php
 }  
?>
</body></html>
