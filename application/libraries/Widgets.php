<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Library created for PyroCMS so that it can handle widgets.
 * 
 * @name 	Widgets Library
 * @author 	Yorick Peterse
 * @link	http://www.yorickpeterse.com/	
 * @license	MIT License
 * 
 */
// TODO: Migrate this library to the widgets model
class Widgets {	
	
	// Function to retrieve the widget data from the body field (MUST BE JSON!!)
	public function get_data($name,$key = '0')
	{		
		// Create the query
		$this->CI->db->select('body');		
		$query = $this->CI->db->get_where('widgets',array('name' => $name));		
		
		// Return the results
		$results = $query->result_array();
		
		// Turn the results into a single array
		foreach($results as $row)
		{
			// Decode the JSON string into an associative array
			$array 	= json_decode($row['body'],true);						

			// Do we want to return all settings, or just a single one ?				
			return $array[$key];
		}
	}	
	
	// Function to get a list of all available areas that are defined in the areas.json based on the template. #TODO : Update this since the file format has been changed to XML
	function get_areas($template)
	{
		if($template)
		{
			$path = APPPATH . 'themes/' . $template . '/areas.xml';
			
			if(file_exists($path))
			{
				// Bring in SimpleXML
				$areas 	   = file_get_contents($path);
				$SimpleXML = new SimpleXMLElement($areas);
				
				return $SimpleXML;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{		
			// Log the error
			log_message('error','Widgets Library - The areas.xml file could not be found.');
			return FALSE;
		}
	}	
}
?>