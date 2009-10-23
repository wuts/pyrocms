<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package 	PyroCMS
 * @subpackage 	Widgets
 * @author		Yorick Peterse - PyroCMS Development Team
 * @since		v1.0
 *
 * Widgets controller for the widgets module. Note that whenever you are trying to fetch a widget from the database using a get statement that you'll have to use widget_instances.id instead of just id. 
 * For example: $this->widgets_m->getWidgets(array('widget_instances.id' => 2));
 */
class Admin extends Admin_Controller
{
	// Constructor function
	function __construct()
	{
		parent::Admin_Controller();
		$this->load->model('widgets_m');
		$this->load->library('Widgets');
		$this->data->languages 	=& $this->config->item('supported_languages');
	}
	
	// Index function
	function index()
	{
		$this->data->widgets_data 	= $this->widgets_m->getWidgets();
		$this->layout->create('admin/index', $this->data);
	}
	
	// Details function
	function details()
	{
		$id = $this->uri->segment(4);
		
		if(isset($id) AND is_numeric($id))
		{
			// Get the widget data from the database
			$this->data->widgets	  		= $this->widgets_m->getWidgets(array('widget_instances.id' => $id)); // Widget data from database
			$this->data->widgets_info 		= $this->widgets->parse_xml($this->data->widgets[0]->name);  // Widget data from the widget.xml 

			// Layout file
			$this->load->view('admin/details',$this->data);
		}
		elseif(isset($id) AND !is_numeric($id))
		{
			// Get the widget data from the files
			$this->data->widgets_info	= $this->widgets_m->getInstallableWidgets();
			$this->data->current_widget = $id;
			
			// Layout file
			$this->load->view('admin/details_alt',$this->data);
		}
		else
		{
			$this->session->set_flashdata('error', 'No widget ID or an invalid ID has been specified.');
			redirect('admin/widgets/index');
		}
	}
	
	
	// Installation function. TODO: Add the install function
	function install()
	{
		// I can haz post ? 
		if($_POST)
		{
			foreach($_POST['action_to'] as $widget)
			{
				$status = $this->widgets_m->installWidget($widget);
				
				// Check the installation results
				if($status == TRUE)
				{
					$this->session->set_flashdata('success', 'The specified widget(s) have been installed successfully.');
					redirect('admin/widgets/index');
				}
				else
				{
					$this->session->set_flashdata('error', 'The specified widget(s) could not be installed.');
					redirect('admin/widgets/install');
				}
			} 			
		}
		
		// Get a list of all available widgets 
		$this->data->widgets = $this->widgets_m->getInstallableWidgets();
		
		$this->layout->create('admin/install', $this->data);
	}
	
	// Activation function
	function activate()
	{
		$id = $this->uri->segment(4);
		
		// I can has POST data ? 
		if($_POST)
		{
			$results = $this->widgets_m->updateWidget($id,array('area' => $_POST['area']));
			
			if($results == TRUE)
			{
				$this->session->set_flashdata('success', 'The chosen widget has been assigned to the specified area.');
				redirect('admin/widgets/index');
			}
			else
			{
				$this->session->set_flashdata('error', 'The chosen widget could not be assigned to the specified area.');
				redirect('admin/widgets/activate/' . $id);
			}
		}
		
		// Get widget related data
		if(isset($id) AND is_numeric($id))
		{
			$widgets						= $this->widgets_m->getWidgets(array('widget_instances.id' => $id));
			$this->data->widgets_data 		= $this->widgets->parse_xml($widgets[0]->name);
			$this->data->template_areas 	= $this->widgets->get_areas('default');

			// Create the layout
			$this->layout->create('admin/activate', $this->data);
		}
		else
		{
			$this->session->set_flashdata('error', 'You did not specify an widget ID.');
			redirect('admin/widgets/index');
		}
	}
	
	// Deactivation function
	function deactivate()
	{
		// Get the widget ID
		$id = $this->uri->segment(4);
		
		if(isset($id) AND is_numeric($id))
		{
			// Deactivate the widget
			$result = $this->widgets_m->updateWidget($id,array('area' => ''));
			
			if($result == TRUE)
			{
				// And redirect the user back to the widget index page
				$this->session->set_flashdata('success', 'The selected widget(s) have been deactivated.');
				redirect('admin/widgets/index');
			}
			else
			{
				$this->session->set_flashdata('error', 'Caramba ! The selected widget(s) could not be deactivated.');
				redirect('admin/widgets/index');
			}		
		}
		else
		{
			$this->session->set_flashdata('error', 'The specified widget ID is an invalid ID.');
			redirect('admin/widgets/index');
		}
	}
	
	// Edit function. TODO: Add the edit function
	function edit()
	{
		// Get the ID
		$id = $this->uri->segment(4);
		
		// Storing the data
		if($_POST)
		{
			// Get rid of the save button
			unset($_POST['btnAction']);
			$data['area'] = $_POST['area'];
			
			// Unset the area
			unset($_POST['area']);
			
			$data['body'] = serialize($_POST);
			$status = $this->widgets_m->updateWidget($id,$data);
			
			if($status == TRUE)
			{
				$this->session->set_flashdata('success', 'The specified widget has been succesfully updated.');
				redirect('admin/widgets/index');
			}
			else
			{
				$this->session->set_flashdata('error', 'The specified widget could not be updated.');
				redirect('admin/widgets/edit/' . $id);
			}
		}
		
		// Get widget related data
		if(isset($id) AND is_numeric($id))
		{
			$this->data->widgets			= $this->widgets_m->getWidgets(array('widget_instances.id' => $id)); // Widget data from database
			
			// Create the layout
			$this->layout->create('admin/edit',$this->data);
		}
		else
		{
			$this->session->set_flashdata('error', 'You did not specify an widget ID.');
			redirect('admin/widgets/index');
		}
	}
	
	// Uninstallation function
	function delete()
	{		
		// Get the widget ID based on the URL or POST data
		if($_POST)
		{
			$id = $_POST['action_to'];
		}
		else
		{
			$id = $this->uri->segment(4);
		}
		
		// ID specified ? 
		if(isset($id))
		{
			// Removing multiple widgets
			if(is_array($id))
			{
				// Loop through each widget
				foreach($id as $key => $value)
				{
					// Get the name of the widget
					$query = $this->widgets_m->getWidgets(array('id' => $value));
					
					if($query != FALSE)
					{
						// Capitalize it and replace the underscore with a space.
						$widget_name = ucfirst(str_replace('_',' ',$query[0]->name)); 
						
						// Remove the widget
						$status = $this->widgets_m->removeWidget($value);
						
						// Get the midgets, PyroCMS failed to remove the widget !
						if($status == FALSE)
						{						
							// Something went wrong...
							$this->session->set_flashdata('error', 'The ' . $widget_name . ' widget with ID #' . $value . ' could not be uninstalled !');
							redirect('admin/widgets/index');
						}
					}
					else
					{
						$this->session->set_flashdata('error', 'It seems that the selected widget with ID #' . $value . ' does not exist !');
						redirect('admin/widgets/index');
					}
				}
				
				// Success...
				$this->session->set_flashdata('success', 'The selected widgets have been uninstalled. Don\'t forget to remove the folders as well !');
				redirect('admin/widgets/index');				
			}
			// Just remove a single widget
			else
			{
				$status = $this->widgets_m->removeWidget($id);
				
				if($status == TRUE)
				{
					// Success...
					$this->session->set_flashdata('success', 'The selected widget has been uninstalled. Don\'t forget to remove the folder as well !');
					redirect('admin/widgets/index');
				}
				else
				{
					// Something went wrong...
					$this->session->set_flashdata('error', 'The selected widget could not be uninstalled !');
					redirect('admin/widgets/index');
				}	
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'No widget ID has been specified !');
			redirect('admin/widgets/index');
		}
	}
}
?>