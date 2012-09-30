<?php


class Testimonials extends CI_Controller {
    
    public $userdata;
    
    function __construct() {
	parent::__construct();
	$this->userdata = $this->session->all_userdata();
	if(!isset($this->userdata['currency'])){
	    $this->session->set_userdata('currency', 'USD');
	} else {
	    $this->config->set_item('curr', $this->userdata['currency']);
	}
    }
    
    function index(){

	$t = new Newsitem();
	$t->get();
	
	$data = array(
	    'title' => lang('news'),
	    'news' => $t
	);
	
	$this->template->set_content('ws/news', $data);
	$this->template->build();
		
	
    }
    
    
}