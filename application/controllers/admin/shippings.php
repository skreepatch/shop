<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Shippings extends CI_Controller {

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
	$this->load->model('util/shipp_processor');
	$data = $this->shipp_processor->getShippings($post);

	$data['title'] = 'Admin Shippings';

	$this->template->set_content('admin/shippings/index', $data);
	$this->template->build();
    }

    function add($save = FALSE) {
	$this->edit($save);
    }

    function edit($id = -1) {

	// Create User Object
	$c = new Shipping();

	if ($id == 'save') {
	    // Try to save the user
	    $id = $this->input->post('id');
	    $this->_get_category($c, $id);

	    $c->trans_start();


	    // Load and save the reset of the data at once
	    // The passwords saved above are already stored.

	    $success = $c->from_array($_POST, array('name', 'weight', 'description', 'price_floor', 'price', 'active'), TRUE); // TRUE means save immediately
	    // redirect on save
	    if ($success) {

		foreach ($_FILES as $k => $f) {
		    $this->load->model('util/file_upload_model');
		    $this->load->library('upload');
		    $_uploaded = $this->file_upload_model->process_images($k);
		    if ($_uploaded['success'] == TRUE) {
			$c->{$k} = $_uploaded['filename'];
			$c->save();
		    }
		}
		$c->trans_complete();
		if ($id < 1) {
		    $this->session->set_flashdata('message', 'The shipping method ' . $c->name . ' was successfully created.');
		} else {
		    $this->session->set_flashdata('message', 'The shipping method ' . $c->name . ' was successfully updated.');
		}
		redirect('admin/shippings');
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
	    'image' => 'file',
	    'name',
	    'description' => array('type' => 'textarea', 'label' => 'Descrioption'),
	    'price_floor' => array('label' => 'Price to reach for free shipping'),
	    'weight',
	    'price',
	    'active' => 'checkbox'
	);

	// Set up page text
	if ($id > 0) {
	    $title = 'Edit Shipping';
	    $url = 'admin/shippings/edit/save';
	} else {
	    $title = 'Add Category';
	    $url = 'admin/shippings/add/save';
	}

	$data = array(
	    'title' => $title,
	    'section' => 'admin',
	    'shipping' => $c,
	    'form_fields' => $form_fields,
	    'url' => $url
	);


	$this->template->set_content('admin/shippings/edit', $data);
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
	$obj = new Shipping();
	$obj->get_by_id($id);
	if (!$obj->exists()) {
	    show_error('Invalid Id');
	}
	if ($this->input->post('deleteok') !== FALSE) {
	    // Delete the user
	    $name = $obj->name;
	    $obj->delete();
	    $this->session->set_flashdata('message', 'The shipping method ' . $name . ' was successfully deleted.');
	    redirect('admin/shippings');
	} else if ($this->input->post('cancel') !== FALSE) {
	    redirect('admin/shippings');
	}

	$data = array('obj' => $obj);

	$this->load->view('admin/common/delete', $data);
    }

}

/* End of file users.php */
/* Location: ./system/application/controllers/users.php */
