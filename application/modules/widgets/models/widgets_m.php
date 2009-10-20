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
	// THE FOLLOWING FUNCTIONS ARE FOR THE FRONTEND ONLY !
	
	// Execute all widgets for the specified area
	function area($area)
	{
		// First we need to fetch all activated widgets for the chosen area
		$this->db->select(array('name','area'));
		$query = $this->db->get_where('widgets',array('area' => $area));
		
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
			$view_file = $this->load->view('../widgets/'.$name.'/views/'.$view, $data,true);
			echo "<li class='widget $name'>$view_file</li>";
		}
		else
		{		
			log_message('error','The ' . $view . ' view for the ' . $name . ' widget could not be found.');
			return FALSE;
		}		
	}
	
	
	// THE FOLLOWING FUNTIONS ARE FOR THE BACKEND ONLY !
	
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