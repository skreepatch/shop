<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Faqs extends CI_Controller {

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
	$this->load->model('util/faq_processor');
	$data = $this->faq_processor->getFaq($post);

	$data['title'] = 'Admin FAQ';

	$this->template->set_content('admin/faqs/index', $data);
	$this->template->build();
    }

    function add($save = FALSE) {
	$this->edit($save);
    }

    function edit($id = -1) {	

	// Create User Object
	$c = new Faq();

	if ($id == 'save') {
	    // Try to save the user
	    $id = $this->input->post('id');
	    $this->_get_faq($c, $id);

	    $c->trans_start();


	    // Load and save the reset of the data at once
	    // The passwords saved above are already stored.
	    $success = $c->from_array($_POST, array('question', 'answer', 'product', 'active'), TRUE); // TRUE means save immediately
	    // redirect on save
	    if ($success) {
		$c->trans_complete();
		if ($id < 1) {
		    $this->session->set_flashdata('message', 'The faq ' . $c->question . ' was successfully created.');
		} else {
		    $this->session->set_flashdata('message', 'The faq ' . $c->question . ' was successfully updated.');
		}
		redirect('admin/faqs');
	    }
	} else {
	    // load an existing user
	    $this->_get_faq($c, $id);
	}

	// Load the HTML Form extension
	$c->load_extension('htmlform');

	// These are the fields to edit.
	$form_fields = array(
	    'id',
	    'Basic Information' => 'section',
	    'question',
	    'answer',
	    'product' => array('type' => 'text', 'label' => 'Provide product id to atach this faq to product'),
	    'active' => 'checkbox'
	);

	// Set up page text
	if ($id > 0) {
	    $title = 'Edit faq';
	    $url = 'admin/faqs/edit/save';
	} else {
	    $title = 'Add faq';
	    $url = 'admin/faqs/add/save';
	}

	$data = array(
	    'title' => $title,
	    'section' => 'admin',
	    'faq' => $c,
	    'form_fields' => $form_fields,
	    'url' => $url
	);
	$this->template->set_content('admin/faqs/edit', $data);
	$this->template->build();
    }

    function _get_faq($cat, $id) {
	if (!empty($id)) {
	    $cat->get_by_id($id);
	    if (!$cat->exists()) {
		show_error('Invalid User ID');
	    }
	}
    }

    function delete($id = 0) {
	$obj = new Faq();
	$obj->get_by_id($id);
	if (!$obj->exists()) {
	    show_error('Invalid Id');
	}
	if ($this->input->post('deleteok') !== FALSE) {
	    // Delete the user
	    $name = $obj->question;
	    $obj->delete();
	    $this->session->set_flashdata('message', 'The faq ' . $name . ' was successfully deleted.');
	    redirect('admin/faqs');
	} else if ($this->input->post('cancel') !== FALSE) {
	    redirect('admin/faqs');
	}

	$data = array('obj' => $obj);

	$this->load->view('admin/common/delete', $data);
    }

}

/* End of file users.php */
/* Location: ./system/application/controllers/users.php */
