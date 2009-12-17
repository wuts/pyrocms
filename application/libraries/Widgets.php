<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author 	Yorick Peterse - PyroCMS Development Team	
 * @since 	v0.9.8
 *
 * The widgets library handles the frontend of PyroCMS widget system.
 */
class Widgets {	
	// Variables
	public $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
	}
	
	// Execute all widgets for the specified area
	function area($area)
	{
		// First we need to fetch all activated widgets for the chosen area
		$query = $this->CI->db->query("SELECT widget_instances.id AS instance_id,widget_instances.widget_id AS widget_id,widget_instances.area AS widget_area,widgets.name AS widget_name FROM widgets JOIN widget_instances on widgets.id = widget_instances.widget_id WHERE widget_instances.area = '$area'");
		
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
				if($widget->widget_area == $area)
				{					
					// Validate whether the widget really exists
					if(file_exists(APPPATH . "widgets/$widget->widget_name/$widget->widget_name.php") == TRUE)
					{
						// Open the widget
						require_once(APPPATH . "widgets/$widget->widget_name/$widget->widget_name.php");

						// First letter needs to be uppercase, in case the user forgets this
						$class  = ucfirst($widget->widget_name);

						// Create the widget class
						$widget_obj = new $class();			

						// Verify if we can actually call the function at all
						if(is_object($widget))
						{								
							// Run the widget
							$widget_obj->run(array('instance_id' => $widget->instance_id,'widget_name' => $widget->widget_name));
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
	public function display($widget_data = array(),$view,$data = array())
	{	
		// Get the data from the array
		$name = $widget_data['widget_name'];
		
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

	// Function to retrieve the widget data from the body field. TODO: Enable a cache system for the database calls to reduce the server load.
	public function get_data($widget_data,$key)
	{		
		// Get the data from the array
		$id	  	= $widget_data['instance_id'];
		
		// Get the specified widget
		$query 	= $this->CI->db->get_where('widget_instances',array('id' => $id));
		
		if($query->num_rows() > 0)
		{
			$results = $query->result();
			
			foreach($results as $result)
			{
				$body = unserialize($result->body);
				
				// Return either the specified key or the entire body.
				if(isset($key))
				{
					return $body[$key];
				}
				else
				{
					return $body;
				}
			}
		}
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