<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacts extends CI_Controller {

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
	
	$c = new Contact();
	$c->get();
	$data['title'] = 'Form submissions';
	$data['contacts'] = $c;

	$this->template->set_content('admin/contacts/index', $data);
	$this->template->build();
    }
    
    function view($id){
	
	$c = new Contact($id);
	
	$data = array(
	    'title' => 'Viewing form submission: '.$id,
	    'contact' => $c
	);
	
	$this->template->set_content('admin/contacts/index', $data);
	$this->template->build();	
    }

}

/* End of file users.php */
/* Location: ./system/application/controllers/users.php */
