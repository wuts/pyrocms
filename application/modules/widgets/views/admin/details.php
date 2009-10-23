<?php foreach($this->data->widgets_info as $widget): ?>
<p><strong><?php echo $widget->name; ?>, by <?php echo $widget->author; ?></strong></p>
<p><?php echo $widget->desc; ?></p>
<p>The widget is licensed under the <?php echo $widget->license; ?> and is currently at version <?php echo $widget->version; ?>.<p>
<?php endforeach; ?>
