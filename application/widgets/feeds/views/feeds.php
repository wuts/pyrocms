<h2><?php echo $title; ?></h2>
<ul>
	<?php foreach($items as $item): ?>
	<li>
		<h3><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h3>
		<?php 
		if($show_date == 'true') {
			echo '<p>'.$item->get_date().'</p>';
		}
		if($desc_only == 'true') {
			echo '<p>'.$item->get_description().'</p>';
		}
		else
		{
			echo '<p>'.$item->get_content().'</p>';
		}
		?>
	</li>
	<?php endforeach; ?>
</ul>