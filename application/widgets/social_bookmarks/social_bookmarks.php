<?php
/*
 * @name 	Dummy Widget
 * @author 	Yorick Peterse
 * @link	http://www.yorickpeterse.com/
 * @package PyroCMS
 * @license MIT License
 * 
 * Widget to display a list of links that can be used to share the current page with others (Twitter, Digg, etc)
 */
class Social_bookmarks extends Widgets {
	
	// Run function
	function run($__widget)
	{
		// First fetch the current URL and title
		$data['current_url'] = current_url();
		$data['current_title'] = '';
		
		// Then set some extra variables
		$data['title'] = $this->get_data($__widget,'title');
		$data['links'] = $this->get_data($__widget,'links');
		
		// Then load the view file
		$this->display($__widget,'bookmarks',$data);
	}
}
?>