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
		$this->data->languages 	=& $this->config->item('supported_languages');
	}
	
	// Index function
	function index()
	{
		$this->data->widgets 	= $this->widgets_m->getWidgets();
		$this->layout->create('admin/index', $this->data);
	}
	
	// Activation function
	function activate()
	{
		// Get the widget ID
		$id 	= $this->uri->segment(4);
		$name 	= $this->uri->segment(5);
		
		if(isset($id) AND is_numeric($id))
		{		
			// Activate the widget if it exists
			$result = $this->widgets_m->updateWidget($id,array('active' => 'TRUE'));
			
			// TODO : Might need to slightly update the part below.
			if($result == TRUE)
			{
				// And redirect the user back to the widget index page
				$this->session->set_flashdata('success', 'The selected widget(s) have been activated.');
				redirect('admin/widgets/index');
			}
			else
			{
				// Create the table
				$result = $this->widgets_m->installWidget($name);
				if($result == TRUE)
				{
					// Widget installed
					$this->session->set_flashdata('success', 'The selected widget(s) have been activated.');
					redirect('admin/widgets/index');
				}
				else
				{
					// Widget could not be installed
					$this->session->set_flashdata('error', 'Caramba ! The selected widget(s) could not be activated.');
					redirect('admin/widgets/index');
				}
			}		
		}
		else
		{
			$this->session->set_flashdata('error', 'The specified widget ID is an invalid ID.');
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
			$result = $this->widgets_m->updateWidget($id,array('active' => 'false'));
			
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
	
	// Installation function
	function install()
	{
		$this->layout->create('admin/install', $this->data);
	}
	
	// Uninstallation function
	function delete()
	{
		
	}
}
?>