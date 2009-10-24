<?php
/*
 * @name 	RSS Feeds Widget
 * @author 	Yorick Peterse - PyroCMS Development Team
 * @link	http://www.yorickpeterse.com/
 * @package PyroCMS
 * @license MIT License
 * 
 * This widget displays a list of external RSS or Atom feeds using SimplePie
 */
class Feeds extends Widgets {
	
	
	// Run function
	function run($__widget)
	{
		// Set some variables
		$feed_link  = $this->get_data($__widget,'link');
		$limit 		= $this->get_data($__widget,'limit');
		
		// Load the SimplePie library
		$this->load->library('Simplepie');		
		
		// Configure SimplePie
		$this->simplepie->set_cache_location(APPPATH.'cache/simplepie');
		$this->simplepie->set_feed_url($feed_link);
		$this->simplepie->init();
		$this->simplepie->handle_content_type();
		
		// Set some variables for the view file
		$data['items'] 		= $this->simplepie->get_items(0,$limit);
		$data['title'] 		= $this->get_data($__widget,'title');
		$data['desc_only']  = $this->get_data($__widget,'desc_only');
		$data['show_date']  = $this->get_data($__widget,'show_date');
		
		// Load the view file
		$this->display($__widget,'feeds',$data);
	}
}
?>
