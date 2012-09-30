<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

    var $userdata;
    
    
    function __construct() {
	parent::__construct();
	// require admin access
	$this->load->library('login_manager', array('required_group' => 1));
	$this->lang->load('global');
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
	$this->load->model('util/products_processor');
	$data = $this->products_processor->getProducts($post);

	$data['title'] = 'Admin Products';

	$this->template->set_content('admin/products/index', $data);
	$this->template->build();
    }

    function add($save = FALSE) {
	$this->edit($save);
    }

    function edit($id = -1) {
	$this->load->model('util/file_upload_model');
	$this->load->library('upload');

	// Create User Object
	$p = new Product();

	if ($id == 'save') {
	    // Try to save the user
	    $id = $this->input->post('id');
	    $this->_get_obj($p, $id);

	    $p->trans_start();


	    // Load and save the reset of the data at once
	    // The passwords saved above are already stored.
	    $success = $p->from_array($_POST, array(
			'name',
			'trimmed_name',
			'dozage',
			'price',
			'active_ingredient',
			'short_desc',
			'description',
			'active',
			'bestseller',
			'isbonus',
			'category',
			'group'
			    ), TRUE); // TRUE means save immediately
	    // redirect on save
	    if ($success) {
		foreach($_FILES as $k => $f){
		    $_uploaded = $this->file_upload_model->process_images($k);
		    if($_uploaded['success'] == TRUE){
			$p->{$k} = $_uploaded['filename'];
			$p->save();
		    }
		}
		$p->trans_complete();
		if ($id < 1) {
		    $this->session->set_flashdata('message', 'The product ' . $p->name . ' was successfully created.');
		} else {
		    $this->session->set_flashdata('message', 'The product ' . $p->name . ' was successfully updated.');
		}
		redirect('admin/products');
	    }
	} else {
	    // load an existing user
	    $this->_get_obj($p, $id);
	}

	// Load the HTML Form extension
	$p->load_extension('htmlform');

	// These are the fields to edit.
	$form_fields = array(
	    'id',
	    'Basic Information' => 'section',
	    'image' => 'file',
	    'name',
	    'trimmed_name',
	    'dozage',
	    'price' => array('label' => 'Price per tablet'),
	    'active_ingredient' => array('label' => 'Active Ingredient'),
	    'short_desc' => array('label' => 'Short Description', 'type' => 'textarea', 'class' => 'widebox'),
	    'description' => array('label' => 'Full Text Description', 'type' => 'textarea', 'class' => 'ckeditor'),
	    'category',
	    'active' => 'checkbox',
	    'bestseller' => 'checkbox',
	    'isbonus' => 'checkbox',
	);

	// Set up page text
	if ($id > 0) {
	    $title = 'Edit Product';
	    $url = 'admin/products/edit/save';
	} else {
	    $title = 'Add Product';
	    $url = 'admin/products/add/save';
	}

	$data = array(
	    'title' => $title,
	    'section' => 'admin',
	    'product' => $p,
	    'form_fields' => $form_fields,
	    'url' => $url
	);
	
	if(isset($_GET['amount']) && isset($_GET['discount'])){
	    $pck = new Package();
	    $pck->amount = $_GET['amount'];
	    $pck->discount = $_GET['discount'];
	    $pck->product_id = $p->id;
	    $pck->save();
	    redirect(site_url('admin/products/edit/'.$p->id));
	}
	

	$this->template->add_js('ckeditor/ckeditor');
	$this->template->set_content('admin/products/edit', $data);
	$this->template->build();
    }
    
    
    function removePackage($id){
	$pck = new Package($id);
	$pid = $pck->product_id;
	$pck->delete();
	redirect(site_url('admin/products/edit/'.$pid));
    }
    

    function _get_obj($obj, $id) {
	if (!empty($id)) {
	    $obj->get_by_id($id);
	    if (!$obj->exists()) {
		show_error('Invalid ID');
	    }
	}
    }

    
//    function splitNames(){
//	$p = new Product();
//	$p->get();
//	foreach($p as $product){
//	    $_splitted = preg_split('/([0-9])/', $product->name);
//	    $product->trimmed_name = trim(str_replace('Generic ', '', $_splitted[0]));
//	    $product->dozage = $splitted2 = preg_replace('/[^0-9]/i', '', $product->name);
//	    $product->save();
//	}
//    }
//    
    
    
    
    function delete($id = 0) {
	$obj = new Product();
	$obj->get_by_id($id);
	if (!$obj->exists()) {
	    show_error('Invalid Id');
	}
	if ($this->input->post('deleteok') !== FALSE) {
	    // Delete the user
	    $name = $obj->name;
	    $obj->delete();
	    $this->session->set_flashdata('message', 'The product ' . $name . ' was successfully deleted.');
	    redirect('admin/products');
	} else if ($this->input->post('cancel') !== FALSE) {
	    redirect('admin/products');
	}

	$data = array('obj' => $obj);
	
	$this->load->view('admin/common/delete', $data);
    }

}

/* End of file users.php */
/* Location: ./system/application/controllers/users.php */