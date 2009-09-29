<?php echo form_open('admin/widgets/manage');?>
<p>Widgets can be uploaded using your FTP program. When you've finished uploading your widget, simply click the activate button and PyroCMS will automaticly install the widget.</p>
<table border="0" class="listTable">    
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#">Name</a></th>
		<th><a href="#">Area</a></th>
		<th><a href="#">Activated</a></th>
		<th class="last"></th>
	</tr>
  </thead>
  <tbody>
	<?php if (!empty($this->data->widgets)): ?>
		<?php foreach ($this->data->widgets as $widget): ?>
		<tr>
			<td><input type="checkbox" name="action_to[]" value="<?php echo $widget->id;?>" /></td>
			<td><?php echo ucfirst(str_replace("_"," ",$widget->name)); ?></td>
			<td><?php echo ucfirst(str_replace("_"," ",$widget->area)); ?></td>
			<td><?php if($widget->active === 'true'){echo 'Yes';}else{echo 'No';} ?></td>
			<td>
				<?php if($widget->active !== 'true') {echo anchor('admin/widgets/activate/' . $widget->id, 'Activate') . ' | ';} ?>
				<?php echo anchor('admin/widgets/deactivate/' . $widget->id, 'Deactivate') . ' | '; ?>
				<?php echo anchor('admin/widgets/delete/' . $widget->id, 'Delete', array('class'=>'confirm')); ?>
	        </td>
		</tr>
		<?php endforeach; ?>		
	<?php else: ?>
		<tr>
			<td colspan="5">No widgets have been installed yet !</td>
		</tr>
	<?php endif; ?>
	</tbody>
	<tfoot>
	  	<tr>
	  		<td colspan="6">
	  			<div class="inner"><? $this->load->view('admin/fragments/pagination'); ?></div>
	  		</td>
	  	</tr>
	  </tfoot>
</table>
<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?php echo form_close(); ?>