<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @name 		Widgets Admin Controller
 * @package 	PyroCMS
 * @subpackage 	Widgets
 * @author		Yorick Peterse - PyroCMS Development Team
 * @since		v1.0
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
	
	// Activation function
	function activate()
	{
		$id = $this->uri->segment(4);
		
		// I can has POST data ? 
		if($_POST)
		{
			$results = $this->widgets_m->updateWidget('instance',$id,array('area' => $_POST['area']));
			
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
			$widgets						= $this->widgets_m->getWidgets(array('id' => $id));
			$this->data->widgets_data 		= $this->widgets->get_info($widgets[0]->name);
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
			$result = $this->widgets_m->updateWidget('instance',$id,array('delete' => TRUE));
			
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
	
	// Installation function. #TODO
	function install()
	{
		$this->layout->create('admin/install', $this->data);
	}
	
	// Edit function. #TODO
	function edit()
	{
		$this->layout->create('admin/edit',$this->data);
	}
	
	// Uninstallation function
	function delete()
	{
		// Get the widget ID
		$id = $this->uri->segment(4);
		
		if(isset($id) AND is_numeric($id))
		{
			// Delete the instance
			$instance = $this->widgets_m->updateWidget('instance',$id,array('delete' => TRUE));	
			// Only delete the widget if the instance was deleted as well
			if($instance == TRUE)
			{
				$widget = $this->widgets_m->updateWidget('widget',$id,array('delete' => TRUE));	
				
				// Validate the results
				if($instance == TRUE AND $widget == TRUE)
				{
					// Database has been cleaned, time to delete the files
					// #TODO
				}
			}
		}
	}
}
?>