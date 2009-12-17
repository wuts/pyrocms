<?php echo form_open('admin/widgets/activate/' . $this->uri->segment(4));?>
	<div class="fieldset fieldsetBlock active tabs">
		<p>Choose an area in which the widget should be displayed. You can also view more information about the selected widget by clicking the "Widget Details" tab.</p>
		<!-- Header div -->
		<div class="header">
			<h3>Activate Widget</h3>
		</div>
		<!-- Tabs div -->
		<div class="tabs">
			<ul class="clear-box">
				<li><a href="#fieldset1"><span>Activate Widget</span></a></li>
				<li><a href="#fieldset2"><span>Widget Details</span></a></li>
			</ul>
			<!-- Activate widget fieldset -->
			<fieldset id="fieldset1">
				<div class="field">
					<label for="area">Widget Area</label>
					<select id="area" name="area"><?php foreach($this->data->template_areas as $key => $value): ?>
						<option value="<?php echo $value; ?>"><?php echo $value; ?></option><?php endforeach; ?>
					</select>
				</div>
			</fieldset>
			<!-- Widget details fieldset -->
			<fieldset id="fieldset2">
				<?php foreach($this->data->widgets_data as $widget): ?>
					<p><strong><?php echo $widget->name; ?>, by <?php echo $widget->author; ?></strong></p>
					<p><?php echo $widget->desc; ?></p>
					<p>The widget is licensed under the <?php echo $widget->license; ?> license.</p>
				<?php endforeach; ?>
			</fieldset>
		</div>
	</div>
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save','cancel') )); ?>
</form>