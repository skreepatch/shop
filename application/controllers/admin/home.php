<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {


    public $user;
    public $userdata;

    function __construct() {
        parent::__construct();
        $this->load->library('login_manager');
        $this->userdata = $this->session->all_userdata();
    }

    function index() {
        $this->output->cache(1);
        
        $p = new Product();
        $p->get();
        
	
        $data = array(
            'title' => lang('main'),
            'products' => $p,
            'user' => $this->user,
            'body_class' => 'home'
        );

        $slides = array(
            'test' => 'yo'
        );


        $this->template->set_content('ws/hp_slideshow', $slides, 'highlights');
        $this->template->set_content('home', $data);
        
        $this->template->build();
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
