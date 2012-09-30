<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statuses extends CI_Controller {

    var $userdata;

    function __construct() {
	parent::__construct();
	// require admin access
	$this->load->library('login_manager', array('required_group' => 1));
	$this->userdata = $this->session->all_userdata();
    }

    function index() {
	$meth = __METHOD__;
	$whereami = explode('::', $meth);
	$dataset = $whereami[0] . '_' . $whereami[1];
	if (isset($_POST) && count($_POST) > 0) {
	    $this->session->unset_userdata($dataset);
	    $post = $_POST;
	    $this->session->set_userdata($dataset, $post);
	} else if (isset($this->userdata[$dataset])) {
	    $post = $this->userdata[$dataset];
	} else {
	    $post = array();
	    $post['related'] = array();
	}
	$this->load->model('util/status_processor');
	$data = $this->status_processor->getStatuses($post);

	$data['title'] = 'Admin Statuses';

	$this->template->set_content('admin/statuses/index', $data);
	$this->template->build();
    }

    function add($save = FALSE) {
	$this->edit($save);
    }

    function edit($id = -1) {
	$this->output->enable_profiler(TRUE);

	// Create User Object
	$c = new Status();

	if ($id == 'save') {
	    // Try to save the user
	    $id = $this->input->post('id');
	    $this->_get_status($c, $id);

	    $c->trans_start();


	    // Load and save the reset of the data at once
	    // The passwords saved above are already stored.
	    $success = $c->from_array($_POST, array('name', 'medex'), TRUE); // TRUE means save immediately
	    // redirect on save
	    if ($success) {
		$c->trans_complete();
		if ($id < 1) {
		    $this->session->set_flashdata('message', 'The status ' . $c->name . ' was successfully created.');
		} else {
		    $this->session->set_flashdata('message', 'The status ' . $c->name . ' was successfully updated.');
		}
		redirect('admin/statuses');
	    }
	} else {
	    // load an existing user
	    $this->_get_status($c, $id);
	}

	// Load the HTML Form extension
	$c->load_extension('htmlform');

	// These are the fields to edit.
	$form_fields = array(
	    'id',
	    'Basic Information' => 'section',
	    'name',
	    'medex' => 'checkbox',
	);

	// Set up page text
	if ($id > 0) {
	    $title = 'Edit Status';
	    $url = 'admin/statuses/edit/save';
	} else {
	    $title = 'Add Status';
	    $url = 'admin/statuses/add/save';
	}

	$data = array(
	    'title' => $title,
	    'section' => 'admin',
	    'status' => $c,
	    'form_fields' => $form_fields,
	    'url' => $url
	);


	$this->template->set_content('admin/statuses/edit', $data);
	$this->template->build();
    }

    function _get_status($cat, $id) {
	if (!empty($id)) {
	    $cat->get_by_id($id);
	    if (!$cat->exists()) {
		show_error('Invalid statuses ID');
	    }
	}
    }

    function delete($id = 0) {
	$obj = new Status();
	$obj->get_by_id($id);
	if (!$obj->exists()) {
	    show_error('Invalid Id');
	}
	if ($this->input->post('deleteok') !== FALSE) {
	    // Delete the user
	    $name = $obj->name;
	    $obj->delete();
	    $this->session->set_flashdata('message', 'The category ' . $name . ' was successfully deleted.');
	    redirect('admin/categories');
	} else if ($this->input->post('cancel') !== FALSE) {
	    redirect('admin/categories');
	}

	$data = array('obj' => $obj);
	
	$this->load->view('admin/common/delete', $data);
    }

}

/* End of file users.php */
/* Location: ./system/application/controllers/users.php */
