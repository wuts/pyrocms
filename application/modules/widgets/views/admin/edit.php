<?php echo form_open('admin/widgets/edit/' . $this->uri->segment(4));?>
	<div class="fieldset fieldsetBlock active tabs">
		<!-- Header div -->
		<div class="header">
			<h3>Edit Widget</h3>
		</div>
		<!-- Tabs div -->
		<div class="tabs">
			<ul class="clear-box">
				<li><a href="#fieldset1"><span>Edit Widget</span></a></li>
			</ul>
			<!-- Edit widget fieldset -->
			<fieldset id="fieldset1">
				<?php foreach($this->data->widgets as $widget): foreach($widget as $key => $value): if($key != 'name' AND $key != 'id'): ?>
				<?php if($key == 'body'): ?>

				<?php foreach(unserialize($value) as $key => $value): ?>
				<div class="field">
					<?php if($value == 'TRUE' OR $value == 'FALSE'): ?>
					<label for="<?php echo $key; ?>"><?php echo ucfirst(str_replace('_',' ',$key)); ?></label><select id="<?php echo $key; ?>" name="<?php echo $key; ?>"><option value="TRUE" <?php if($value == TRUE): ?>selected="selected"<?php endif; ?>>Yes</option><option value="FALSE" <?php if($value == FALSE): ?>selected="selected"<?php endif; ?>>No</option></select>
					<?php else: ?>
					<label for="<?php echo $key; ?>"><?php echo ucfirst(str_replace('_',' ',$key)); ?></label><input type="text" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $value; ?>"/>
					<?php endif; ?>
				</div>
				<?php endforeach; ?>

				<?php else: ?>
				<div class="field">
					<label for="<?php echo $key; ?>"><?php echo ucfirst(str_replace('_',' ',$key)); ?></label><input type="text" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $value; ?>"/>	
				</div>
				<?php endif; ?>			

				<?php endif; endforeach; endforeach; ?>
			</fieldset>
		</div>
	</div>
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save','cancel') )); ?>
</form>