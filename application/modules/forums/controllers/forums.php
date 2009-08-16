<?php
class Forums extends Public_Controller {

	function __construct()
	{
		parent::Public_Controller();
			
		$this->load->model('forum_model');
		$this->load->model('post_model');

		$this->lang->load('forum');
		
		// Add a link to the forum CSS into the head
		$this->layout->extra_head( css('forum.css', 'forum') );
		
		$this->userID = $this->user_lib->user_data->id;
	}
	
	
	function index()
	{
		$this->load->helper('date');
		
		if( $forum_categories = $this->forum_model->getCategories() )
		{
			// Get list of categories
			foreach($forum_categories as &$category)
			{
				$category->forums = $this->forum_model->getForums($category->id);
				
				// Get a list of forums in each category
				foreach($category->forums as &$forum)
				{
					$forum->topic_count = $this->post_model->countTopicsInForum( $forum->id );
					$forum->reply_count = $this->post_model->countRepliesInForum( $forum->id );
					$forum->last_post = $this->post_model->getLastPostInForum($forum->id);
				}
			}
		}
	
		$this->data->forum_categories =& $forum_categories;
		
		$this->layout->create('index', $this->data);
	}


	function view_forum($id = 0)
	{
		$this->load->helper('date');
	
		$forum = $this->forum_model->getForum($id);
		
		// Check if forum exists, if not 404
		if(!$forum)
		{
			show_404();
		}
		
		// Get all topics for this forum
		$forum->topics = $this->post_model->getTopicsInForum($id);
		
		// Get a list of posts which have no parents (topics) in this forum
		foreach($forum->topics as &$topic)
		{
			$topic->post_count = $this->post_model->countPostsInTopic($topic->id);
			$topic->last_post = $this->post_model->getLastPostInTopic($topic->id);
		}
		
		$this->data->forum =& $forum;
		
		$this->layout->create('view_forum', $this->data);
	}

}
?>