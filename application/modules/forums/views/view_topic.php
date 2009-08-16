<?=anchor('forums/topics/new_topic/'.$forum->id, ' New Topic ');?> | <?=anchor('forums/posts/new_reply/'.$topic->id, ' Reply ');?>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <th colspan="3" align="left" bgcolor="#999999" scope="col"><?=$topic->title;?></th>
  </tr>
  
  <?php 
	$i=$pagination->offset;
	foreach($topic->posts as $post):	
  ?>
  <tr>
    <td width="20%" bgcolor="#CCCCCC"><?=$post->author->full_name;?></td>
    <td width="50%" bgcolor="#CCCCCC">Posted: <?=$post->created_on;?></td>
<? if($post->parent_id == 0): ?>
	<td width="30%" align=right bgcolor="#CCCCCC">[<?=anchor('forums/posts/report/'.$post->id, ' Report ');?>]</td>
<? else: ?>
	<td width="35%" align=right bgcolor="#CCCCCC">[<?=anchor('forums/posts/report/'.$post->id, ' Report ');?>] [<?=anchor('forums/posts/view_reply/'.$post->id, ' # '.$i.' ' , array('title' => 'Permalink to this post', 'name' => $post->id));?>]</td>
<? endif; ?>
  </tr>
 
  <tr bgcolor="#DDDDDD">
    <td valign="top" class="authorinfo">
	<?//=getUserDisplayPicFromId($post->author->id, 'small');?><br/><br/>
	Joined Date: 
	<?=$post->author->created_on;?>
	</td>
    <td colspan="2" valign="top"><?=$post->text;?></td>
  </tr>
  
  <tr bgcolor="#B4B4B4">
    <td>[ <?=anchor('profiles/user/'.$post->author->id, 'Profile')?> ] [ <?=anchor('messages/write/'. $post->author->id, 'Message');?> ]</td>
	
	<td colspan="2" align="right">[ <?=anchor('forums/posts/quote_reply/'.$post->id, ' Quote ');?> ]
<? if($post->author->id == $user->id && $post->parent_id == 0): ?>
	 [ <?=anchor('forums/posts/edit_reply/'.$post->id, ' Edit ');?> ]
<?	endif; ?>
<? if($post->author->id == $user->id && $post->parent_id != 0): ?>
	 [ <?=anchor('forums/posts/edit_reply/'.$post->id, ' Edit ');?> ] [ <?=anchor('forums/posts/delete_reply/'.$post->id, ' Delete ');?> ]</td>
<? endif; ?>

  </tr>
  <?php
	$i++;
	endforeach; ?>
</table>

<?=$pagination->links; ?>