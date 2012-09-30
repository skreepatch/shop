<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings extends CI_Controller {

    function __construct() {
	parent::__construct();
	$this->load->library('login_manager');
    }

    function index() {
	
	$data = array(
	    'title' => 'Settings',
	);
	
	if (isset($_POST['submit'])) {
	    
	    foreach($_POST as $name => $setting){
		
		$s = new Setting($name);
		$s->where('name', $name)->get();
		$s->value = $setting;
		$s->save();
	    }
	    redirect(current_url());
	}
	$this->template->add_js('ckeditor/ckeditor');
	$this->template->set_content('admin/configuration/global', $data);
	$this->template->build();
    }
}