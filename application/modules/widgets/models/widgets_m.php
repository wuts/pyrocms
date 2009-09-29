<?php 
/**
 * @name 		Widgets Model
 * @package 	PyroCMS
 * @subpackage 	Widgets
 * @author		Yorick Peterse - PyroCMS Development Team
 * @since		v1.0
 */
class Widgets_m extends Model
{
	// Get a list of widgets based on their state (active / deactive)
	function getWidgets($params = array())
	{
		// Create the query
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
	
	// Function to change the fields of a widget
	function updateWidget($id,$params = array())
	{
		// Terminate the function if the ID isn't specified or when it isn't numeric.
		if(isset($id) AND is_numeric($id))
		{
			$query = $this->db->update('widgets',$params,"id = $id");
			
			if($query != FALSE)
			{
				return TRUE;
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
	
	// Installing widgets. Function should only be used when the widget is activated for the first time.
	function installWidget($name)
	{
		if(isset($name) AND $name != '')
		{
			// First we need to retrieve the data for the current widget
			
			
			// Now we can install it
			$install_data['name'] = $name;
			$install_data['body'] = '';
		}
		else
		{
			return FALSE;
		}
	}	
}
?>