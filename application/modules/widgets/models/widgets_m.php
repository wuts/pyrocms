<?php 
/**
 * @package 	PyroCMS
 * @subpackage 	Widgets
 * @author		Yorick Peterse - PyroCMS Development Team
 * @since		v1.0
 *
 * Widgets model that handles database related actions for the widget controller.
 */
class Widgets_m extends Model
{	
	// Get a list of widgets based on the parameters defined by the user.
	function getWidgets($params = array())
	{
		// Create the query
		$this->db->select('widget_instances.id,widgets.name,widget_instances.body,widget_instances.area');
		$this->db->join('widget_instances','widgets.id = widget_instances.widget_id');
		$query = $this->db->get_where('widgets',$params);
		
		// Validate the results
		if($query->num_rows() > 0)
		{			
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	// Big fat update function :]
	function updateWidget($id,$params = array())
	{
		// Terminate the function if the ID isn't specified or when it isn't numeric.
		if(isset($id) AND is_numeric($id))
		{
			$this->db->where('widget_instances.id',$id);
			$query = $this->db->update('widget_instances',$params);
			
			return $query;
		}
		else
		{
			return FALSE;
		}
	}
	
	// Function to delete a widget from the database table. This will remove both the instance and regular row.
	function removeWidget($id)
	{		
		// Valid ID ? 
		if(isset($id) AND is_numeric($id))
		{
			// First we need the ID of the widget instance's widget
			$this->db->select('widget_id');
			$query = $this->db->get_where('widget_instances',array('id' => $id));
			
			if($query->num_rows() > 0)
			{
				$result = $query->result();
				$widget_id = $result[0]->widget_id;
			}
			else
			{
				return FALSE;
			}
			
			// Remove the widget from the database			
			$this->db->where('id',$id);
			$query = $this->db->delete('widget_instances');
			
			// Instance deleted, continue
			if($query == TRUE)
			{
				$this->db->where('id',$widget_id);
				$query = $this->db->delete('widgets');
				
				return $query;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	// Function to get a list of widgets that can be installed
	function getInstallableWidgets()
	{
		// Variables
		$path 				= APPPATH . 'widgets/';
		$handle 			= opendir($path);
		$widget_xml 		= array();
		$installed_widgets 	= array();
		
		// Get a list of widgets that are already installed 
		$this->db->select('name');
		$query = $this->db->get('widgets');
		
		// Store the names of all widgets currently installed
		if($query->num_rows() > 0)
		{
			$query_results = $query->result();
			
			foreach($query_results as $installed_widget)
			{
				$installed_widgets[] = $installed_widget->name;
			}
		}
		
		foreach(glob($path . '*',GLOB_ONLYDIR) as $dir)
		{
			if($dir != 'application/widgets/dummy_widget')
			{
				$widget_name = str_replace('application/widgets/','',$dir);
				
				// Only add the number to the array if the folder contains a file with the same name as the directory and a .php extension (otherwise the system might be fooled).
				if(file_exists($dir . '/' . $widget_name . '.php') AND file_exists($dir . '/widget.xml'))
				{
					if(in_array($widget_name,$installed_widgets) == FALSE)
					{
						$widget_xml[] = $this->widgets->parse_xml($widget_name);
					}
				}			
				else
				{
					return FALSE;
				}
			}			
		}	
		// Return results
		return $widget_xml;		
	}
	
	// Installing widgets. Function should only be used when the widget is activated for the first time.
	function installWidget($name)
	{
		// First we need the XML data of the widget
		$widget_data  = $this->widgets->parse_xml($name);
		$widget_data  = $widget_data[0];
		
		// Insert the name into the database table "widgets"
		$query 		  = $this->db->insert('widgets',array('name' => $widget_data->filename));
		
		if($query != FALSE)
		{
			$insert_id 	= $this->db->insert_id();

			// Insert the data into the table "widget_instances"
			$body 		= serialize($widget_data->body);
			$query 		= $this->db->insert('widget_instances',array('widget_id' => $insert_id,'body' => $body));	
			
			return $query;
		}
		
		return $query;
	}	
}
?>