<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Smiley Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Rick Ellis
 * @link		http://www.codeigniter.com/user_guide/helpers/smiley_helper.html
 */

// ------------------------------------------------------------------------

/**
 * JS Insert Smiley
 *
 * Generates the javascrip function needed to insert smileys into a form field
 *
 * @access	public
 * @param	string	form name
 * @param	string	field name
 * @return	string
 */	

function parse_bbcode($str = '', $max_images = 400)
{
	$str = str_replace("\n", '\newline\\', $str);
	$find = array( 
		"'\[b\](.*?)\[/b\]'is",
		"'\[i\](.*?)\[/i\]'is",
		"'\[u\](.*?)\[/u\]'is",
		"'\[strike\](.*?)\[/strike\]'is",
		"'\[img\](.*?)\[/img\]'i",
		"'\[url\](.*?)\[/url\]'i", 
		"'\[url=(.*?)\](.*?)\[/url\]'i", 
		"'\[link\](.*?)\[/link\]'i", 
		"'\[link=(.*?)\](.*?)\[/link\]'i",
		
		"'\[code\](.*?)\[/code\]'i",
		
		"'\[quote\](.*?)\[/quote\]'i", 
		"'\[quote author=(.*?) date=([0-9]+)\](.*?)\[/quote\]'i",
		"'\[quote date=([0-9]+) author=(.*?)\](.*?)\[/quote\]'i",
		"'\[quote author=(.*?)\](.*?)\[/quote\]'i"
	); 
	
	$replace = array( 
		'<strong>\1</strong>',
		'<em>\1</em>',
		'<u>\1</u>', 
		'<strike>\1</strike>',
		'<img src="\1" style="max-width:'.$max_images.'px; width: expression(this.width > '.$max_images.' ? '.$max_images.': true);">', 
		'<a href="\1">\1</a>', 
		'<a href="\1">\2</a>',
		'<a href="\1">\1</a>', 
		'<a href="\1">\2</a>',
		
		'<code>\1</code>', 
		
		'<blockquote><p>\1</p></blockquote>', 
		'<blockquote class="quote"><div>\1 \2</div><p>\3</p></blockquote>',
		'<blockquote class="quote"><div>\2 \1</div><p>\3</p></blockquote>',
		'<blockquote class="quote"><div>\1</div><p>\2</p></blockquote>'
		
	); 
	
	$str = str_replace('\newline\\', '<br />', $str);
	
	return preg_replace($find,$replace,$str);

}

function bbcode_menu($input_name = "")
{
	$bbcode_menu = "";
	// add script
	$bbcode_menu .= '<script language="JavaScript" type="text/javascript" src="/media/javascript/toolbar.js"></script>';
	// add style
	$bbcode_menu .= '<link href="/media/css/toolbar.css" rel="stylesheet" type="text/css">';
	
	// add buttons
	$bbcode_menu .= '<div>';
	if($input_name != "")
	{
		$bbcode_menu .= '<input type="button" onclick="addBBCode(\'b\', \''.$input_name.'\');" title="click to make your text selection bold" value="Bold">';
		$bbcode_menu .= '<input type="button" onclick="addBBCode(\'i\', \''.$input_name.'\');" title="click to make your text selection italic" value="Italic">';
		$bbcode_menu .= '<input type="button" onclick="addBBCode(\'u\', \''.$input_name.'\');" title="click to make your text selection underline" value="Underline">';
		$bbcode_menu .= '<input type="button" onclick="addBBCode(\'quote\', \''.$input_name.'\');" title="click to quote text" value="Quote">';
		$bbcode_menu .= '<input type="button" onclick="addBBCode(\'code\', \''.$input_name.'\');" title="Click to add code" value="Code">';
		$bbcode_menu .= '<input type="button" onclick="addBBCode(\'link\', \''.$input_name.'\');" title="Click to add Link" value="Link">';
		$bbcode_menu .= '<input type="button" onclick="addLink(\''.$input_name.'\');" title="Click to add Link" value="Link = ">';
	} else {
		$bbcode_menu .= '<input type="button" onclick="addBBCode(\'b\');" title="click to make your text selection bold" value="B" style="font-weight:bold">';
		$bbcode_menu .= '<input type="button" onclick="addBBCode(\'i\');" title="click to make your text selection italic" value="I" style="font-style:italic">';
		$bbcode_menu .= '<input type="button" onclick="addBBCode(\'u\');" title="click to make your text selection underline" value="U" style="text-decoration:underline">';
		
		$bbcode_menu .= '<input type="button" onclick="addBBCode(\'quote\');" title="click to quote text" value="Quote">';
		$bbcode_menu .= '<input type="button" onclick="addBBCode(\'code\');" title="click to add code" value="Code">';
		$bbcode_menu .= '<input type="button" onclick="addBBCode(\'link\');" title="click to add Link" value="Link">';
		$bbcode_menu .= '<input type="button" onclick="addLink();" title="Click to add Link=" value="Link = ">';
	}
	$bbcode_menu .= '</div>';
	
	return $bbcode_menu;
}

?>