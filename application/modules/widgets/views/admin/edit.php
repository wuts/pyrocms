<?php echo form_open('admin/widgets/edit/' . $this->uri->segment(4));?>
	<div class="fieldset fieldsetBlock active tabs">
		<p>Here you can edit the data of an existing widget. You can also view more information about the selected widget by clicking the "Widget Details" tab.</p>
		<!-- Header div -->
		<div class="header">
			<h3>Edit Widget</h3>
		</div>
		<!-- Tabs div -->
		<div class="tabs">
			<ul class="clear-box">
				<li><a href="#fieldset1"><span>Edit Widget</span></a></li>
				<li><a href="#fieldset2"><span>Widget Details</span></a></li>
			</ul>
			<!-- Edit widget fieldset -->
			<fieldset id="fieldset1">
				<?php foreach($this->data->widgets as $widget): ?>
					
				<?php foreach($widget as $key => $value): ?>
					
					<?php if($key == 'body'): $json_array = json_decode($value,TRUE); ?>
						
					<?php foreach($json_array as $json_key => $json_value): ?>
					<div class="field">
						<label for="<?php echo $json_key; ?>"><?php echo ucfirst(str_replace('_',' ',$json_key)); ?></label>
						<input type="text" id="<?php echo $json_key; ?>" name="" value="<?php echo $json_value; ?>" />
					</div>
					<?php endforeach; ?>
						
					<?php else: if($key != 'name'): ?>						
					<div class="field"> 
						<label for="<?php echo $key; ?>"><?php echo ucfirst(str_replace('_',' ',$key)); ?></label>
						<input type="text" id="<?php echo $key; ?>" name="" value="<?php echo $value; ?>" />
					</div>					
					<?php endif; endif; ?>
				
				<?php endforeach; ?>
					
				<?php endforeach; ?>
			</fieldset>
			<!-- Widget details fieldset -->
			<fieldset id="fieldset2">
				<?php foreach($this->data->widgets_info as $widget_info): ?>
					<p><strong><?php echo $widget_info->name; ?>, by <?php echo $widget_info->author; ?></strong></p>
					<p><?php echo $widget_info->desc; ?> The widget is licensed under the <?php echo $widget_info->license; ?> license.</p>
				<?php endforeach; ?>
			</fieldset>
		</div>
	</div>
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save','cancel') )); ?>
</form>