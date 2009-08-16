<?=anchor('forums/topics/new_topic/'.$forum->id, ' New Topic ');?>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <th colspan="5" bgcolor="#999999" scope="col"><?=$forum->title;?></th>
  </tr>
  <tr>
    <td width="5%" bgcolor="#CCCCCC">&nbsp;</td>
    <td width="45%" bgcolor="#CCCCCC">Topic Name</td>
    <td width="10%" bgcolor="#CCCCCC">Posts</td>
    <td width="10%" bgcolor="#CCCCCC">Views</td>
    <td width="30%" bgcolor="#CCCCCC">Last Post Info </td>
  </tr>
  
  <? if(empty($forum->topics)):?>
 <tr bgcolor="#DDDDDD">
    <td colspan="5" align="center">There are no posts in this topic right now.</td>
  </tr>
  
  <? else: ?>
	  
	  <? foreach($forum->topics as $topic): ?>
	  <tr bgcolor="#DDDDDD">
	    <td></td>
	    <td valign="top">
			<b><?=anchor('forums/topics/view_topic/'.$topic->id, $topic->title);?></b><br/>
			Author: <?php echo $this->users_m->getUser(array('id' => $topic->author_id))->full_name; ?>
		</td>
	    <td align="center" valign="middle" bgcolor="#DDDDDD"><?=$topic->post_count;?></td>
	    <td align="center" valign="middle"><?=$topic->view_count?></td>
	    <td>
		<? if(!empty($topic->last_post)):?>
		Posted: <?php echo anchor('forums/posts/view_reply/'.$topic->last_post->id, date('d M y', $topic->last_post->created_on)); ?><br/>
		Author: <?php echo $this->users_m->getUser(array('id' => $topic->last_post->author_id))->full_name; ?>
		<? endif;?>
		</td>
	  </tr>
	  <? endforeach; ?>
  
  <? endif;?>
</table>
