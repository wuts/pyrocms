<h2><?php echo $title; ?></h2>
<ul>
	<?php if($links != false): ?>
	<?php foreach($links as $link): ?>
	<li>
		<a href="<?php echo $link->url; ?>" title="<?php echo $link->title; ?>"><?php echo $link->title; ?></a>
	</li>
	<?php endforeach; ?>
	<?php else: ?>
	<li>
		No navigation links exist for the chosen group.
	</li>
	<?php endif; ?>
</ul>

