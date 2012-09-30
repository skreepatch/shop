<?php

class Slideshow extends CI_Controller {

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
	$this->load->model('util/slides_processor');
	$data = $this->slides_processor->getSlides($post);

	$data['title'] = 'Admin Slideshow';

	$this->template->set_content('admin/slideshow/index', $data);
	$this->template->build();
    }

    function add($save = FALSE) {
	$this->edit($save);
    }

    function edit($id = -1) {
	$this->load->model('util/file_upload_model');
	$this->load->library('upload');

	// Create User Object
	$c = new Slide();

	if ($id == 'save') {
	    // Try to save the user
	    $id = $this->input->post('id');
	    $this->_get_category($c, $id);

	    $c->trans_start();


	    // Load and save the reset of the data at once
	    // The passwords saved above are already stored.
	    $success = $c->from_array($_POST, array('label', 'active'), TRUE); // TRUE means save immediately
	    // redirect on save
	    if ($success) {
		foreach($_FILES as $k => $f){
		    $_uploaded = $this->file_upload_model->process_images($k);
		    if($_uploaded['success'] == TRUE){
			$c->{$k} = $_uploaded['filename'];
			$c->save();
		    }
		}
		$c->trans_complete();
		if ($id < 1) {
		    $this->session->set_flashdata('message', 'The slide ' . $c->name . ' was successfully created.');
		} else {
		    $this->session->set_flashdata('message', 'The slide ' . $c->name . ' was successfully updated.');
		}
		redirect('admin/slideshow');
	    }
	} else {
	    // load an existing user
	    $this->_get_category($c, $id);
	}

	// Load the HTML Form extension
	$c->load_extension('htmlform');

	// These are the fields to edit.
	$form_fields = array(
	    'id',
	    'Basic Information' => 'section',
	    'label',
	    'image' => 'file',
	    'active' => 'checkbox'
	);

	// Set up page text
	if ($id > 0) {
	    $title = 'Edit Slide';
	    $url = 'admin/slideshow/edit/save';
	} else {
	    $title = 'Add Slide';
	    $url = 'admin/slideshow/add/save';
	}

	$data = array(
	    'title' => $title,
	    'section' => 'admin',
	    'slide' => $c,
	    'form_fields' => $form_fields,
	    'url' => $url
	);


	$this->template->set_content('admin/slideshow/edit', $data);
	$this->template->build();
    }

    function _get_category($cat, $id) {
	if (!empty($id)) {
	    $cat->get_by_id($id);
	    if (!$cat->exists()) {
		show_error('Invalid User ID');
	    }
	}
    }

    function delete($id = 0) {
	$c = new Category();
	$c->get_by_id($id);
	if (!$c->exists()) {
	    show_error('Invalid User Id');
	}
	if ($this->input->post('deleteok') !== FALSE) {
	    // Delete the user
	    $name = $c->name;
	    $c->delete();
	    $this->session->set_flashdata('message', 'The category ' . $name . ' was successfully deleted.');
	    redirect('admin/categories');
	} else if ($this->input->post('cancel') !== FALSE) {
	    redirect('admin/categories');
	}

	$this->load->view('template_header', array('title' => 'Delete User', 'section' => 'admin'));
	$this->load->view('users/delete', array('user' => $user));
	$this->load->view('template_footer');
    }

}

/* End of file users.php */
/* Location: ./system/application/controllers/users.php */
