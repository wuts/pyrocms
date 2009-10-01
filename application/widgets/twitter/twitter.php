<?php
/*
 * @name 	Twitter Widget
 * @author 	Yorick Peterse
 * @link	http://www.yorickpeterse.com/
 * @package PyroCMS
 * @license MIT License
 * 
 * Twitter widget to display your latest tweets
 */
class Twitter extends Widgets {
	// Run function
	function run()
	{
		// Load the Twitter model
		$this->CI->load->module_model('twitter','twitter_m');
		
		// Set some variables
		$display 				= $this->get_data('twitter','display'); 
		$limit 					= $this->get_data('twitter','limit');		
		$data['title']			= $this->get_data('twitter','title');
		$data['show_image'] 	= $this->get_data('twitter','show_image');
		$data['tweets'] 		= $this->CI->twitter_m->$display($limit);
		
		// Load the view file 
		$this->display('twitter','twitter',$data);
	}
}
?>
