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
		echo $this->CI->twitter_m->__call('friends_timeline','');
	}
	
	
	// Install function (executed when the user installs the widget)
	function install() 
	{
		$name = 'dummy_widget';
		$body = '{"title":"Dummy Widget"}';
		$this->install_widget($name,$body);
	}
}
?>
