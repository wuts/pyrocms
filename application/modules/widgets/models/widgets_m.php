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
			// Dirty as hell, but works perfect.
			$result = $query->result();
			$rows 	= count($result);
			$i 		= 0;
			
			// Loop through each row
			while($i < $rows)
			{
				$result[$i]->area = $this->getInstanceData($result[$i]->id,'area');
				$i++;
			}
			
			// Return the results
			return $result;
		}
		else
		{
			return FALSE;
		}
	}
	
	// Function to retrieve data from the widget instance (area / active)
	function getInstanceData($widget_id,$field)
	{
		if(isset($widget_id) AND is_numeric($widget_id))
		{
			// Query time
			$query = $this->db->get_where('widget_instances',array('widget_id' => $widget_id));
			
			// Return the results
			if($query->num_rows() > 0)
			{
				foreach($query->result() as $result)
				{
					return $result->$field;
				}
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
	
	// Big fat update functions :]
	function updateWidget($type = 'widget',$widget_id,$params = array())
	{
		// Terminate the function if the ID isn't specified or when it isn't numeric.
		if(isset($widget_id) AND is_numeric($widget_id) AND isset($type))
		{
			if($type == 'widget')
			{
				if($params['delete'] == TRUE)
				{
					$this->db->where('id',$widget_id);
					$query = $this->db->delete('widgets');
				}
				else
				{
					$this->db->where('id',$widget_id);
					$query = $this->db->update('widgets',$params);
				}			
				
				return $query; // Returns false or true
			}
			elseif($type == 'instance')
			{
				$query = $this->db->get_where('widget_instances',array('widget_id' => $widget_id));
				
				// The widget has already been activated but the user wants to change the area
				if($query->num_rows() > 0)
				{
					$this->db->where('widget_id',$widget_id);
					
					// Delete or update ? 
					if($params['delete'] == TRUE)
					{
						$query = $this->db->delete('widget_instances');
					}
					else
					{
						$query = $this->db->update('widget_instances',$params);
					}					
					
					return $query; // Returns false or true
				}
				// The user activated the widget for the first time and wants to add it to a certain area
				else
				{
					$query = $this->db->insert('widget_instances',array('widget_id' => $widget_id,'body' => '','area' => $params['area']));
					
					return $query; // Returns false or true
				}
				return TRUE;
			}
			// $type not reconized
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