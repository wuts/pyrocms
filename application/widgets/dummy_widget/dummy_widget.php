<?php
/*
 * @name 	Dummy Widget
 * @author 	Yorick Peterse
 * @link	http://www.yorickpeterse.com/
 * @package PyroCMS
 * @license MIT License
 * 
 * A dummy widget that can be used to create your own widgets.
 */
class Dummy_widget extends Widgets {
	
	
	// Run function
	function run()
	{
		
	}
	
	
	// Install function (executed when the user installs the widget)
	function install() 
	{
		$name = 'dummy_widget';
		$body = '{"title":"Dummy Widget"}';
		$this->install_widget($name,$body);
	}
	
	
	// Uninstall function (executed when the user uninstalls the widget)
	function uninstall()
	{
		$name = 'dummy_widget';
		$this->uninstall_widget($name);
	}
}
?>
