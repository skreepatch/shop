<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cpanel extends CI_Controller {
    
    var $userdata;
    
    function __construct() {
	parent::__construct();
	$this->load->library('login_manager', array('required_group' => 1));
	$this->lang->load('global');
	$this->userdata = $this->session->all_userdata();
    }
    
    function index(){
	$this->load->helper('gchart');
	$o = new Order();
	$o->get();
	
	$data = array(
	    'title' => 'Control Panel',
	    'orders' => $o
	);
	$this->template->set_content('admin/cpanel', $data);
	$this->template->build();
    }
    
    
}