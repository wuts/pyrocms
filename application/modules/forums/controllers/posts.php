<?php
class Posts extends Public_Controller {

	function __construct()
	{
		parent::Public_Controller();
		
		$this->load->model('forum_model');
		$this->load->model('post_model');

		$this->lang->load('forum');
		
		// Add a link to the forum CSS into the head
		$this->layout->extra_head( css('forum.css', 'forum') );
	}
	

	function view_reply($replyID = 0)
	{
		$replyID = intval($replyID);
		$reply_data = $this->post_model->getReplyData($replyID);
		// Check if reply exists
		if(!empty($reply_data))
		{
			if($reply_data['parentID'] != 0)
				$threadID = $reply_data['parentID'];
			else 
				$threadID = $reply_data['postID'];	
			redirect('forums/topics/view_topic/'.$threadID.'/#'.$replyID);
		} else {
			
			show_error('The reply doesn\'t exist!');
			$this->template->create('message', $this->data);
		}
	}

	

	function new_reply($topic_id = 0)
	{
		if(!$this->user_lib->logged_in())
		{
			redirect('users/login');
		}
		
		//$this->load->helpers(array('smiley', 'bbcode'));

		// Get the forum name
		$topic = $this->post_model->getTopic($topic_id);
		$forum = $this->forum_model->getForum($topic->forum_id);
		
		// Chech if there is a forum with that ID
		if(!$topic or !$forum)
		{
			show_404();
		}
	
		$this->data->show_preview = FALSE;
		
		if($this->input->post('submit') or $this->input->post('preview'))
		{
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('forum_id', 'Forum', 'required|numeric');
			$this->form_validation->set_rules('title', 'Title', 'trim|strip_tags|required|max_length[100]');
			$this->form_validation->set_rules('text', 'Message', 'trim|strip_tags|required');

			if ($this->form_validation->run() === TRUE)
			{
				if( $this->input->post('submit') )
				{
					$reply->title = set_value('title');
					$reply->text = set_value('text');
					
					if($reply->id = $this->post_model->newReply($this->user_lib->user_data->id, $reply, $forum))
					{
						// Add user to notify
						//if($notify) $this->post_model->AddNotify($topic->id, $this->user_lib->user_data->id );
						
						redirect('forums/posts/view_reply/'.$topic->id);
					}
					
					else
					{
						show_error("Error Message:  Error accured while adding topic");
					}
				}
			
				// Preview button was hit, just show em what the post will look like
				elseif( $this->input->post('preview') )
				{
					// Define and Parse Preview
					//$this->data->preview = $this->post_model->postParse($message, $smileys);
					
					$this->data->show_preview = TRUE;
				}
			}
		}
		
		$this->data->forum =& $forum;
		$this->data->topic =& $topic;
		
		// Set this for later
		$this->layout->add_breadcrumb($forum->title, 'forums/view_forum/'.$topic->forum_id); 
		$this->layout->create('new_reply', $this->data);
	}

}
?>