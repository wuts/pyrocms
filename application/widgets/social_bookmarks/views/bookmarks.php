<h2><?php echo $title; ?></h2>
<ul>
	<li><a href="http://del.icio.us/post?url=<?php echo $current_url; ?>&amp;title=" title="Submit to Del.icio.us">Del.icio.us</a></li>
	<li><a href="http://digg.com/submit?url=<?php echo $current_url; ?>&amp;title=" title="Submit to Digg">Digg</a></li>
	<li><a href="http://reddit.com/submit?url=<?php echo $current_url; ?>&amp;title=" title="Submit to Reddit">Reddit</a></li>
	<li><a href="http://www.facebook.com/sharer.php?u=<?php echo $current_url; ?>" title="Submit to Facebook">Facebook</a></li>
	<li><a href="http://www.stumbleupon.com/submit?url=<?php echo $current_url; ?>&amp;title=" title="Submit to StumbleUpon">StumbleUpon</a></li>
	<li><a href="http://www.dzone.com/links/add.html?url=<?php echo $current_url; ?>&amp;title=" title="SUbmit to DZone">DZone</a></li>
	<li><a href="http://www.google.com/bookmarks/mark?op=edit&amp;bkmk=<?php echo $current_url; ?>&amp;title=" title="Submit to Google">Google</a></li>
	<li><a href="http://twitter.com/home/?source=<?php echo base_url(); ?>&amp;status= : <?php echo $current_url; ?>" title="Submit to Twitter">Twitter</a></li>
</ul>