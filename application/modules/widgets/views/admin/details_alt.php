<?php foreach($this->data->widgets_info as $widgets): ?>
<?php foreach($widgets as $widget): if($widget->filename == $this->data->current_widget): ?>
<p><strong><?php echo $widget->name; ?>, by <?php echo $widget->author; ?></strong></p>
<p><?php echo $widget->desc; ?></p>
<?php endif; endforeach; endforeach; ?>
