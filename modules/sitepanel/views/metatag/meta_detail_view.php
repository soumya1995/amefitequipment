<?php $this->load->view('admin/popup_header'); ?>
	<table width="100%"  border="0" cellspacing="5" cellpadding="5" class="list">
		 <thead>
		 <tr >
			<td width="15%" colspan="3" height="30"><?php echo $heading_title; ?></td>
		</tr>
		 </thead>
		<tr class="trOdd">
			<td width="15%">URL </td>
			<td width="3%">: </td>
			<td width="82%"><?php echo base_url().$metaresult->url;?> </td>
		</tr>
		<tr class="trOdd">
			<td width="15%">Title </td>
			<td width="3%">: </td>
			<td width="82%"><?php echo $metaresult->title;?> </td>
		</tr>
		<tr class="trEven">
			<td>Keyword</td>
			<td>: </td>
			<td><?php echo $metaresult->keyword;?> </td>
		</tr>
		<tr class="trOdd">
			<td>Description</td>
			<td>: </td>
			<td><?php echo $metaresult->description;?> </td>
		</tr>
	</table>
</body>
</html>