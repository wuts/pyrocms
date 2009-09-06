<?php
/*
 * @name 	RSS Feeds Widget
 * @author 	Yorick Peterse
 * @link	http://www.yorickpeterse.com/
 * @package PyroCMS
 * @license MIT License
 * 
 * This widget displays a list of external RSS or Atom feeds using SimplePie
 */
class Feeds extends Widgets {
	
	
	// Run function
	function run()
	{
		// Set some variables
		$feed_link  = $this->get_data('feeds','link');
		$limit 		= $this->get_data('feeds','limit');
		
		// Load the SimplePie library
		$this->load->library('Simplepie');		
		
		// Configure SimplePie
		$this->simplepie->set_cache_location(APPPATH.'widgets/feeds/cache/');
		$this->simplepie->set_feed_url($feed_link);
		$this->simplepie->init();
		$this->simplepie->handle_content_type();
		
		// Set some variables for the view file
		$data['items'] 		= $this->simplepie->get_items(0,$limit);
		$data['title'] 		= $this->simplepie->get_data('feeds','title');
		$data['desc_only']  = $this->simplepie->get_data('feeds','desc_only');
		$data['show_date']  = $this->simplepie->get_data('feeds','show_date');
		
		// Load the view file
		$this->display('feeds','feeds',$data);
	}
	
	
	// Install function (executed when the user installs the widget)
	function install() 
	{
		$name = 'feeds';
		$body = '{"title":"RSS Feeds","link":"http://www.yorickpeterse.com/blog/feed/","limit":"2","desc_only":"true","show_date":"true"}';
		$this->install_widget($name,$body);
	}
}
?>
