<?php echo form_open('admin/widgets/delete');?>
<p>Widgets can be uploaded using your FTP program. When you've finished uploading your widget, simply click the activate button and PyroCMS will automaticly install the widget.</p>
<table border="0" class="listTable">    
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#">Name</a></th>
		<th><a href="#">Title</a></th>
		<th><a href="#">Area</a></th>
		<th><a href="#">Actions</a></th>
		<th class="last"></th>
	</tr>
  </thead>
  <tbody>
	<?php if (!empty($this->data->widgets_data)): ?>
		<?php foreach ($this->data->widgets_data as $widget): ?>
		<tr>
			<td><input type="checkbox" name="action_to[]" value="<?php echo $widget->id;?>" /></td>
			<td><?php echo ucfirst(str_replace("_"," ",$widget->name)); ?></td>
			<td><?php $body = unserialize($widget->body); echo $body['title']; ?></td>
			<td><?php if($widget->area){echo ucfirst(str_replace("_"," ",$widget->area));}else{echo "None";} ?></td>
			<td>
				<?php echo anchor('admin/widgets/details/' . $widget->id, 'Details',array('rel' => 'modal')) . ' | '; ?>
				<?php if(!$widget->area) {echo anchor('admin/widgets/activate/' . $widget->id, 'Activate') . ' | ';} ?>
				<?php if($widget->area) {echo anchor('admin/widgets/deactivate/' . $widget->id, 'Deactivate') . ' | ';} ?>
				<?php echo anchor('admin/widgets/edit/' . $widget->id, 'Edit'). ' | '; ?>
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