<?php
class Topics extends Public_Controller {

	var $data;
	var $userID;

	function Topics()
	{
		parent::Public_Controller();
		
		$this->load->model('forum_model');
		$this->load->model('post_model');

		$this->lang->load('forum');
		
		// Add a link to the forum CSS into the head
		$this->layout->extra_head( css('forum.css', 'forum') );
	}
	
	function view_topic($topic_id = 0, $offset = 0)
	{
		// Load all needed files
		//$this->load->helpers(array('smiley', 'bbcode', 'date'));
		$this->load->library('pagination');
		
		// Update view counter
		$this->post_model->increaseViewcount($topic_id);
		
		// Pagination junk
		$per_page = '10';
		if($offset < $per_page) $offset = 0;
		$config['base_url'] = site_url('forums/topics/view_topic/'.$topic_id);
		$config['total_rows'] = $this->post_model->countPostsInTopic($topic_id);
		$config['per_page'] = $per_page;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config); 
		// End Pagination

		// Which topic in which forum are we looking at?
		$topic = $this->post_model->getTopic($topic_id);
		$forum = $this->forum_model->getForum($topic->forum_id);
		
		// Check if topic exists, if not show 404
		if(!$topic or !$forum)
		{
			show_404();
		}
	
		// Get a list of posts which have no parents (topics) in this forum
		$topic->posts = $this->post_model->getPostsInTopic($topic_id, $offset, $per_page);
		foreach($topic->posts as &$post)
		{	
			$post->author = $this->users_m->getUser(array('id' => $post->author_id));
		}
		
		$this->data->topic =& $topic;
		$this->data->forum =& $forum;
		$this->data->pagination->offset = $offset;
		$this->data->pagination->links = $this->pagination->create_links();
		
		// Create page
		$this->layout->title($topic->title);
		$this->layout->add_breadcrumb($forum->title, 'forums/view_forum/'.$forum->id);
		$this->layout->add_breadcrumb($topic->title);
		$this->layout->create('view_topic', $this->data);
	}


	function new_topic($forum_id = 0)
	{
		if(!$this->user_lib->logged_in())
		{
			redirect('users/login');
		}
		
		//$this->load->helpers(array('smiley', 'bbcode'));

		// Get the forum name
		$forum = $this->forum_model->getForum($forum_id);
		
		// Chech if there is a forum with that ID
		if(!$forum)
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
					
					$topic->title = set_value('title');
					$topic->text = set_value('text');
					
					if($topic->id = $this->post_model->newTopic($this->user_lib->user_data->id, $topic, $forum))
					{
						// Add user to notify
						//if($notify) $this->post_model->AddNotify($topic->id, $this->user_lib->user_data->id );
						
						redirect('forums/topics/view_topic/'.$topic->id);
					}
					
					else
					{
						show_error("Error Message:  Error Accured While Adding Topic");
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
		$this->layout->add_breadcrumb($forum->title, 'forums/view_forum/'.$forum_id); 
		$this->layout->create('new_topic', $this->data);
	}


	function unsubscribe($topic_id = 0)
	{
		$this->freakauth_light->check();

		$topic_id = intval($topic_id);
		if($this->post_model->unSubscribe($topic_id, $this->userID))
		{
			$this->layout->error('You Were Successfully un-subscribed!');
		} else {
			$this->layout->error('You are not subscribed to this topic.');
		}
		
		if(!empty($this->layout->error_string)) $this->layout->create('message', $this->data);
	}

}
?>