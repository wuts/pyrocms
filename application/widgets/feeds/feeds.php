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
		require_once('simplepie.php');
		$feed = new SimplePie();		
		
		// Configure SimplePie
		$feed->set_cache_location(APPPATH.'widgets/feeds/cache/');
		$feed->set_feed_url($feed_link);
		$feed->init();
		$feed->handle_content_type();
		
		// Set some variables for the view file
		$data['items'] 		= $feed->get_items(0,$limit);
		$data['title'] 		= $this->get_data('feeds','title');
		$data['desc_only']  = $this->get_data('feeds','desc_only');
		$data['show_date']  = $this->get_data('feeds','show_date');
		
		// Load the view file
		$this->display('feeds','feeds',$data);
	}
	
	
	// Install function (executed when the user installs the widget)
	function install() 
	{
		$name = 'feeds';
		$body = '{"title":"Dummy Widget"}';
		$this->install_widget($name,$body);
	}
	
	
	// Uninstall function (executed when the user uninstalls the widget)
	function uninstall()
	{
		$name = 'feeds';
		$this->uninstall_widget($name);
	}
}
?>
