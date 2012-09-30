<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bonuses extends CI_Controller {

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
	$this->load->model('util/bonus_processor');
	$data = $this->bonus_processor->getBonuses($post);

	$data['title'] = 'Admin Bonuses';
	
	$this->template->set_content('admin/bonuses/index', $data);
	$this->template->build();
    }

    function add($save = FALSE) {
	$this->edit($save);
    }

    function edit($id = -1) {

	// Create User Object
	$c = new Bonus();

	if ($id == 'save') {
	    // Try to save the user
	    $id = $this->input->post('id');
	    $this->_get_bonus($c, $id);

	    $c->trans_start();


	    // Load and save the reset of the data at once
	    // The passwords saved above are already stored.
	    $success = $c->from_array($_POST, array('price', 'name', 'description', 'amount', 'active'), TRUE); // TRUE means save immediately
	    // redirect on save
	    if ($success) {
		$c->trans_complete();
		if ($id < 1) {
		    $this->session->set_flashdata('message', 'The bonus ' . $c->id . ' was successfully created.');
		} else {
		    $this->session->set_flashdata('message', 'The bonus ' . $c->id . ' was successfully updated.');
		}
		redirect('admin/bonuses');
	    }
	} else {
	    // load an existing user
	    $this->_get_bonus($c, $id);
	}

	// Load the HTML Form extension
	$c->load_extension('htmlform');

	// These are the fields to edit.
	$form_fields = array(
	    'id',
	    'Basic Information' => 'section',
	    'name' => array('label' => 'Bonus Name'),
	    'description' => array('label' => 'Description', 'type' => 'textarea'),
	    'price' => array('label' => 'Price to reach for this bonus'),
	    'amount' => array('label' => 'Amount of bonus pills'),
	    'active' => 'checkbox'
	);

	// Set up page text
	if ($id > 0) {
	    $title = 'Edit Bonus';
	    $url = 'admin/bonuses/edit/save';
	} else {
	    $title = 'Add Bonus';
	    $url = 'admin/bonuses/add/save';
	}

	$data = array(
	    'title' => $title,
	    'section' => 'admin',
	    'category' => $c,
	    'form_fields' => $form_fields,
	    'url' => $url
	);

	$this->template->set_content('admin/categories/edit', $data);
	$this->template->build();
    }

    function _get_bonus($cat, $id) {
	if (!empty($id)) {
	    $cat->get_by_id($id);
	    if (!$cat->exists()) {
		show_error('Invalid User ID');
	    }
	}
    }

    function delete($id = 0) {
	$obj = new Bonus();
	$obj->get_by_id($id);
	if (!$obj->exists()) {
	    show_error('Invalid Id');
	}
	if ($this->input->post('deleteok') !== FALSE) {
	    // Delete the user
	    $name = $obj->name;
	    $obj->delete();
	    $this->session->set_flashdata('message', 'The bonus ' . $name . ' was successfully deleted.');
	    redirect('admin/bonuses');
	} else if ($this->input->post('cancel') !== FALSE) {
	    redirect('admin/bonuses');
	}

	$data = array('obj' => $obj);
	
	$this->load->view('admin/common/delete', $data);
    }

}

/* End of file users.php */
/* Location: ./system/application/controllers/users.php */
