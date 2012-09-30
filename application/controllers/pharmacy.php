<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pharmacy extends CI_Controller {


    public $user;
    public $userdata;
    public $language;

    function __construct() {
        parent::__construct();
        //$this->load->library('login_manager');
        $this->userdata = $this->session->all_userdata();
	$this->language = $this->session->userdata('language') ? $this->session->userdata('language') : $this->config->item('language');
	$this->config->set_item('language', $this->language);
	$this->load->helper('products');
	if(!isset($this->userdata['currency'])){
	    $this->session->set_userdata('currency', 'USD');
	} else {
	    $this->config->set_item('curr', $this->userdata['currency']);
	}
    }

    function category($cid) {
        
	$c = new Category();
	$c->where('name', urldecode($cid))->get();
        $p = new Product();
        $p->where_in_related('category', $c);
	$p->where('active', TRUE);
	$p->order_by('name', 'acs');
	$p->order_by('price', 'acs');
	$p->group_by('trimmed_name')->get();
	
        
        $data = array(
            'title' => $c->name,
            'products' => $p,
            'body_class' => 'category'
        );

        $this->template->set_content('ws/home', $data);        
        $this->template->build();
    }
    function product($pname) {
	$depname = urldecode($pname);
	$p = new Product();
	$pg = new Product();
	$p->where('trimmed_name', $depname)->get();
        
        $data = array(
            'title' => $depname,
            'products' => $p,
	    'prodgroup' => $pg->where('trimmed_name', $depname)->group_by('trimmed_name')->get(),
            'body_class' => 'product'
        );

        $this->template->set_content('ws/product', $data);
        $this->template->build();
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
