<h2><?php echo $title; ?></h2>
<ul>
	<?php foreach($tweets as $tweet): ?>
	<li>
		<?php if($show_image == 'TRUE'): ?>
		<img src="<?php echo $tweet->user->profile_image_url; ?>" alt="Profile Image" />
		<?php endif; ?>
		<p><strong><?php echo $tweet->user->name; ?></strong></p>
		<p><?php echo $tweet->text; ?></p>
	</li>
	<?php endforeach; ?>
</ul>