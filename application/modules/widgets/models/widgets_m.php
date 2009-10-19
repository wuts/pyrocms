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
			$this->db->where('id',$id);
			$query = $this->db->update('widgets',$params);
			
			return $query;
		}
		else
		{
			return FALSE;
		}
	}
	
	// Function to delete a widget from the database table.
	function removeWidget($id)
	{		
		// Valid ID ? 
		if(isset($id) AND is_numeric($id))
		{
			// Remove the widget from the database			
			$this->db->where('id',$id);
			$query = $this->db->delete('widgets');
			
			return $query;
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
			// TODO: Add this stuff
			
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