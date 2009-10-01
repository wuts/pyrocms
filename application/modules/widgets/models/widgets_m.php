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
	
	// Big fat update functions :]
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
	
	// Function to delete a widget from the instance table, widgets table or both. It can also remove the files associated with the widget
	function removeWidget($id,$remove_files = FALSE)
	{
		if(isset($id) AND is_numeric($id))
		{
			// First we need the name of the current widget
			$query = $this->db->get_where('widgets',array('id' => $id));
			
			if($query->num_rows() > 0)
			{
				$widget_name = $query[0]->name;
			}
			else
			{
				$widget_name = FALSE;
			}
			
			$this->db->where('id',$id);
			$query = $this->db->delete('widgets');
			
			// Delete the files ?
			if($remove_files == TRUE AND $query == TRUE AND $widget_name != FALSE)
			{				
				// Load the helper
				$this->load->helper('file');
				$file_status = delete_files(APPPATH . 'widgets/' . $widget_name . '/',TRUE);
				
				return $file_status;
			}
			
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