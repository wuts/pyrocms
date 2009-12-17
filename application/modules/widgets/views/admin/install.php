<?php echo form_open('admin/widgets/install');?>
<!-- Header div -->
<div class="header">
	<h3>Install Widget</h3>
</div>
<table border="0" class="listTable">    
<thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#">Name</a></th>
		<th><a href="#">Author</a></th>
		<th><a href="#">License</a></th>
		<th><a href="#">Version</a></th>
		<th><a href="#">Description</a></th>
		<th class="last"></th>
	</tr>
</thead>
<tbody>
	<?php foreach($this->data->widgets as $widgets): foreach($widgets as $widget): ?>
	<tr>
		<td><input type="checkbox" name="action_to[]" value="<?php echo $widget->filename; ?>" /></td>
		<td><?php echo $widget->name; ?></td>
		<td><?php echo $widget->author; ?></td>
		<td><?php echo $widget->license; ?></td>
		<td><?php echo $widget->version; ?></td>
		<td><?php echo anchor('admin/widgets/details/' . $widget->filename,'View Description',array('rel' => 'modal')); ?></td>
	</tr>
	<?php endforeach; endforeach; ?>
</tbody>
<tfoot>
	<tr>
		<td colspan="6">
			<div class="inner"><? $this->load->view('admin/fragments/pagination'); ?></div>
		</td>
	</tr>
</tfoot>
</table>
<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save','cancel') )); ?>
<?php echo form_close(); ?>