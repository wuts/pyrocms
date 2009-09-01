<?php
class Posts extends Public_Controller {

	function __construct()
	{
		parent::Public_Controller();
		
		$this->load->model('forum_model');
		$this->load->model('post_model');

		$this->lang->load('forum');
		
		$this->load->helper('bbcode');
		
		// Add a link to the forum CSS into the head
		$this->layout->extra_head( css('forum.css', 'forum') );
	}
	

	function view_reply($reply_id = 0)
	{
		$reply = $this->post_model->getReply($reply_id);
		
		// Check if reply exists
		if(empty($reply))
		{
			show_404();
		}
		
		// This is a reply
		if($reply->parent_id > 0)
		{
			redirect('forums/topics/view_topic/'.$reply->parent_id.'#'.$reply_id);
		}
		
		// This is a new topic
		else
		{
			redirect('forums/topics/view_topic/'.$reply_id);
		}
			
	}

	
	function quote_reply($post_id)
	{
		$quote = $this->post_model->getPost($post_id);
		
		if(!$quote)
		{
			show_404();
		}

		// Send the message object through
		$this->session->set_flashdata('forum_quote', serialize($quote));
		
		$topic->id = $quote->parent_id > 0 ? $quote->parent_id : $quote->id;
		
		// Redirect to the normal reply form. It will pick the quote up
		redirect('forums/posts/new_reply/'.$topic->id);
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
		$forum = $this->forum_model->getForum(@$topic->forum_id);
		
		// Chech if there is a forum with that ID
		if(!$topic or !$forum)
		{
			show_404();
		}

		// If there was a quote, send it to the view
		$this->data->quote = unserialize($this->session->flashdata('forum_quote'));

		// We'll assume there was no preview, unless told otherwise later
		$this->data->show_preview = FALSE;
		
		// The form has been submitted one way or another
		if($this->input->post('submit') or $this->input->post('preview'))
		{
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('text', 'Message', 'trim|strip_tags|required');
			$this->form_validation->set_rules('notify', 'Subscription notification', 'trim|strip_tags|max_length[1]');

			if ($this->form_validation->run() === TRUE)
			{
				if( $this->input->post('submit') )
				{
					$reply->title = set_value('title');
					$reply->text = set_value('text');
					
					if($reply->id = $this->post_model->newReply($this->user_lib->user_data->id, $reply, $topic))
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
			
			else
			{
				$this->data->validation_errors = $this->form_validation->error_string();
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