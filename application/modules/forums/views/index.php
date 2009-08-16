<style type="text/css">
<!--
.lastpost_info {font-size: small}
.description {font-size: small}
-->
</style>

<?php foreach($forum_categories as $category): ?>

<table width="100%" border="0" cellpadding="4" cellspacing="0">
	<thead>
	  <tr>
	    <th colspan="5" bgcolor="#999999" scope="col"><?=$category->title;?></th>
	  </tr>
	  <tr>
	    <th>&nbsp;</th>
	    <th>Forum Name</th>
	    <th>Topics</th>
	    <th>Replies</th>
	    <th>Last Post Info </th>
	  </tr>
	</thead>
	
	<tbody>

  <?php foreach($category->forums as $forum): ?>
  <tr bgcolor="#DDDDDD">
    <td></td>
    <td valign="top">
		<b><?=anchor('forums/view_forum/'.$forum->id, $forum->title);?></b><br/>
		<span class="description"><?=$forum->description;?></span>
	</td>
    <td align="center" valign="middle" bgcolor="#DDDDDD"><?=$forum->topic_count; ?></td>
    <td align="center" valign="middle"><?=$forum->reply_count; ?></td>
    <td class="lastpost_info">
	<?php if(isset($forum->last_post->title)):?>
	<?=anchor('forums/posts/view_reply/'.$forum->last_post->id, $forum->last_post->title); ?><br/>
	Posted: <?php echo date('d M y', $forum->last_post->created_on); ?><br/>
	Author: <?php echo $this->users_m->getUser(array('id' => $forum->last_post->author_id))->full_name; ?>
	<?php endif;?>
	</td>
  </tr>
  <?php endforeach; ?>
  
  </tbody>
  
</table>
<br/><br/>
<?php endforeach; ?>