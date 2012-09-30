<?php

class Users extends CI_Controller {

    function __construct() {
	parent::__construct();
	// require admin access
	$this->load->library('login_manager', array('required_group' => 1));
    }

    function index() {
	$users = new User();
	$users->include_related('group', 'name');

	$users->get_iterated();

	$data = array(
	    'users' => $users,
	    'title' => 'Admin Users'
	);

	$this->template->set_content('admin/users/index', $data);
	$this->template->build();
    }

    function add($save = FALSE) {
	$this->edit($save);
    }

    function edit($id = -1) {
	$this->output->enable_profiler(TRUE);

	// Create User Object
	$user = new User();

	if ($id == 'save') {
	    // Try to save the user
	    $id = $this->input->post('id');
	    $this->_get_user($user, $id);

	    $user->trans_start();

	    // Only add the passwords in if they aren't empty
	    // New users start with blank passwords, so they will get an error automatically.
	    if (!empty($_POST['password'])) {
		$user->from_array($_POST, array('password', 'confirm_password'));
	    }

	    // Load and save the reset of the data at once
	    // The passwords saved above are already stored.
	    $success = $user->from_array($_POST, array(
			'name',
			'email',
			'username',
			'group'
			    ), TRUE); // TRUE means save immediately
	    // redirect on save
	    if ($success) {
		$user->trans_complete();
		if ($id < 1) {
		    $this->session->set_flashdata('message', 'The user ' . $user->name . ' was successfully created.');
		} else {
		    $this->session->set_flashdata('message', 'The user ' . $user->name . ' was successfully updated.');
		}
		redirect('admin/users');
	    }
	} else {
	    // load an existing user
	    $this->_get_user($user, $id);
	}

	// Load the HTML Form extension
	$user->load_extension('htmlform');

	// These are the fields to edit.
	$form_fields = array(
	    'id',
	    'Contact Information' => 'section',
	    'name',
	    'email',
	    'Login Information' => 'section',
	    'username',
	    'password',
	    'confirm_password',
	    'Access Restrictions' => 'section',
	    'group'
	);

	// Set up page text
	if ($id > 0) {
	    $title = 'Edit User';
	    $url = 'admin/users/edit/save';
	} else {
	    $title = 'Add User';
	    $url = 'admin/users/add/save';
	}

	$data = array(
	    'title' => $title,
	    'section' => 'admin',
	    'user' => $user,
	    'form_fields' => $form_fields,
	    'url' => $url
	);


	$this->template->set_content('admin/users/edit', $data);
	$this->template->build();
    }

    function _get_user($user, $id) {
	if (!empty($id)) {
	    $user->get_by_id($id);
	    if (!$user->exists()) {
		show_error('Invalid User ID');
	    }
	}
    }

    function delete($id = 0) {
	$obj = new User();
	$obj->get_by_id($id);
	if (!$obj->exists()) {
	    show_error('Invalid Id');
	}
	if ($this->input->post('deleteok') !== FALSE) {
	    // Delete the user
	    $name = $obj->name;
	    $obj->delete();
	    $this->session->set_flashdata('message', 'The category ' . $name . ' was successfully deleted.');
	    redirect('admin/users');
	} else if ($this->input->post('cancel') !== FALSE) {
	    redirect('admin/users');
	}

	$data = array('obj' => $obj);

	$this->load->view('admin/common/delete', $data);
    }

}

/* End of file users.php */
/* Location: ./system/application/controllers/users.php */