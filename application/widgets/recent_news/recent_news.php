<?php
/*
 * @name 	Recent News Widget
 * @author 	Yorick Peterse - PyroCMS Development Team
 * @link	http://www.yorickpeterse.com/
 * @package PyroCMS
 * @license MIT License
 * 
 * This widget displays a list of recent articles
 */
class Recent_news extends Widgets {
	// Run function
	function run($__widget)
	{
		// First retrieve all the settings for the Recent News widget
		$data['title'] 		= $this->get_data($__widget,'title');
		$data['limit'] 		= $this->get_data($__widget,'article_limit');
		$data['display'] 	= $this->get_data($__widget,'display');
		$data['intro'] 		= $this->get_data($__widget,'show_intro');
		
		// Load the view file, based on the display type (all, category or archive)
		switch($data['display'])
		{
			// Show all articles, regardless of archive or category
			case "all":
				$this->display($__widget,'news_all',$data); 
			break;
			// Show only a list of articles for a specified category
			case "category":
				// Get the category and load the view file 
				$data['category'] = $this->get_data($__widget,'category');
				$this->display($__widget,'news_category',$data); 
			break;
			// Show only a list of articles for a specified year (e.g. 2008)
			case "archive_year":
				// Get the arhive year (e.g. 2008)
				$data['year']  = $this->get_data($__widget,'archive_year');
				$this->display($__widget,'news_archive_year',$data); 
			break;
			// Show articles for a single month
			case "archive_month":
				$data['month'] = $this->get_data($__widget,'archive_month');
				$this->display($__widget,'news_archive_month',$data);
			break;
		}		
	}
}
?>
