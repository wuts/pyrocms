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
				<div class="field">
				
				</div>
			</fieldset>
			<!-- Widget details fieldset -->
			<fieldset id="fieldset2">
				<?php foreach($this->data->widgets_data as $widget): ?>
					<p><strong><?php echo $widget->name; ?>, by <?php echo $widget->author; ?></strong></p>
					<p><?php echo $widget->desc; ?> The widget is licensed under the <?php echo $widget->license; ?> license.</p>
				<?php endforeach; ?>
			</fieldset>
		</div>
	</div>
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save','cancel') )); ?>
</form>