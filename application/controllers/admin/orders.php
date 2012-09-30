<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {

    var $userdata;

    function __construct() {
	parent::__construct();
	// require admin access
	$this->load->library('login_manager', array('required_group' => 1));
	$this->userdata = $this->session->all_userdata();
    }
    
    function index(){
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
	$this->load->model('util/orders_processor');
	$data = $this->orders_processor->getOrders($post);
	
	$data['title'] = 'Admin Orders';
	$this->template->add_css('jquery-ui-1.8.20.custom');
	$this->template->add_js('jquery-ui-1.8.20.custom.min');
	$this->template->set_content('admin/orders/index', $data);
	$this->template->build();
    }
    
    function open($id){
	$o = new Order($id);
	
	$data = array(
	    'title' => 'Viewing Order number '.$o->id,
	    'order' => $o
	);
	$this->template->set_content('admin/orders/open', $data);
	$this->template->build();
    }
    
    function reshipp($id){
	$o = new Order($id);
	
	$this->load->library('medex');
	$this->medex->reShippment($o);
    }
    
    function track(){
	$o = new Order($id);
	$this->load->library('medex');
	print_r($this->medex->reShippment($o));
    }
    
}