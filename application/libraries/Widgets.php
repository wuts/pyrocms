<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * @author 	Yorick Peterse
 * @link	http://www.yorickpeterse.com/	
 * @license	MIT License
 * 
 * Widgets library for PyroCMS. The library handles the frontend only.
 */
class Widgets {	
	// Variables
	private $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
	}
	
	// Execute all widgets for the specified area
	function area($area)
	{
		// First we need to fetch all activated widgets for the chosen area
		$this->CI->db->select('name,area');
		$this->CI->join('widget_instances','widgets.id = widget_instances.widget_id');
		$query = $this->CI->db->get_where('widgets',array('widget_instances.area' => $area));
		
		// Verify the results
		if($query->num_rows() > 0)
		{
			// Store the results
			$widgets = $query->result();
			
			// Display the widgets in an unordered list. TODO: Check whether this can't be done in a better way, this is kinda ugly...
			echo '<ul class="widgets_list">';
			
			// Execute each widget
			foreach($widgets as $widget)
			{				
				// Only run the widgets for the current area
				if($widget->area == $area)
				{
					// Validate whether the widget really exists
					if(file_exists(APPPATH . "widgets/$name/$name.php") == TRUE)
					{
						// Open the widget
						require_once(APPPATH . "widgets/$name/$name.php");

						// First letter needs to be uppercase, in case the user forgets this
						$class  = ucfirst($name);

						// Create the widget class
						$widget = new $class();			

						// Verify if we can actually call the function at all
						if(is_object($widget))
						{		
							// Execute the run() function with the specified arguements
							return $widget->run();
						}
						else
						{
							// Log the error
							log_message('error','The run function of the ' . $widget->name . ' widget could not be executed.');
							return FALSE;
						}
					}
					else
					{
						// Log the error
						log_message('error','The ' . $widget->name . ' widget could not be found. Are you sure it exists ?');
						return FALSE;
					}
				}			
			}
			
			// End of the unordered list
			echo '</ul>';
		}
		else
		{
			return FALSE;
		}
	}
	
	// Display the widget's view files
	public function display($name,$view,$data = array())
	{		
		// Verify the view file
		if(file_exists(APPPATH . "widgets/$name/views/$view.php"))
		{
			// Load the view file
			$view_file = $this->CI->load->view('../widgets/'.$name.'/views/'.$view, $data,true);
			echo "<li class='widget $name'>$view_file</li>";
		}
		else
		{		
			log_message('error','The ' . $view . ' view for the ' . $name . ' widget could not be found.');
			return FALSE;
		}		
	}

	// Function to retrieve the widget data from the body field.
	public function get_data($name,$key = '0')
	{		
		// TODO: Rewrite this function from scratch. Something like "where name = $name AND area = $this_widgets_area..."
	}	
	
	// Function to get a list of all available areas that are defined in the areas.json based on the template. #TODO : Update this since the file format has been changed to XML
	function get_areas($template)
	{
		// If the template is set
		if(isset($template))
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
			log_message('error','The areas.xml file could not be found.');
			return FALSE;
		}
	}	
	
	// Function to parse the widget's XML file
	function parse_xml($widget)
	{
		if(isset($widget))
		{			
			$widget 		= str_replace('/','',$widget);
			$widget_name 	= $widget;
			$path   		= APPPATH . 'widgets/' . $widget . '/widget.xml';

			if(file_exists($path))
			{
				// Parse the fucker
				$widget_details = file_get_contents($path);
				$XML 			= new SimpleXMLElement($widget_details);
				$object;
				$widget_body 	= array();
				
				// Get rid of the SimpleXML object classes
				foreach($XML->widget as $widget)
				{					
					// Define the body types
					foreach($widget->body->param as $param)
					{
						$widget_body[(string)$param['name']] 	= (string)$param;
					}
					
					// Define the other stuff
					$object->name 		= (string)$widget->name;
					$object->filename	= $widget_name;
					$object->author 	= (string)$widget->author;
					$object->desc 		= (string)$widget->desc;
					$object->body 		= $widget_body;
					$object->license 	= (string)$widget->license;
					$object->version 	= (string)$widget->version;
				}
				
				// Return the object
				return array($object);
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			log_message('error','No widget name for the XML file was specified.');
			return FALSE;
		}
	}
}
?>