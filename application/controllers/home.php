<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {
    
    var $userdata;
    
    function __construct() {
	parent::__construct();
	$this->load->helper('products');
	$this->userdata = $this->session->all_userdata();
	if(!isset($this->userdata['currency'])){
	    $this->session->set_userdata('currency', 'USD');
	} else {
	    $this->config->set_item('curr', $this->userdata['currency']);
	}
	
    }

    public function index($search = NULL) {
	if (isset($_REQUEST['search'])) {
	    $search = $_REQUEST['search'];
	}
	$data = array();
	$slides = new Slide();
	$slides->where('active', TRUE)->get();

	$p = new Product();
	$p->where('active', TRUE);
	$p->group_by('trimmed_name');
	if ($search != NULL) {
	    if (strlen($search) == 1) {
		$p->like('name', 'generic ' . $search);
		$data['title'] = 'Search by letter ' . $search;
	    } else {
		$p->like('name', $search);
		$data['title'] = 'Search by ' . $search;
	    }
	    $data['search'] = $search;
	    $p->get();
	} else {
	    $_w = array(
		'bestseller' => TRUE
	    );
	    $p->where($_w);
	    $p->limit('9')->get();
	    $data['title'] = 'Bestsellers';
	}
	
	$n = new Newsitem();
	$n->where('active', TRUE)->limit(3)->get();
	$data['news'] = $n;
	$t = new Testimonial();
	$t->where('active', TRUE)->limit(3)->get();
	$data['testimonials'] = $t;
	$data['products'] = $p;
	$data['slides'] = $slides;
	$data['is_homepage'] = TRUE;


	$this->template->add_js('slideshow');
	$this->template->set_content('ws/home', $data);
	$this->template->build();
    }

    function contactUs() {

	$this->load->helper('captcha');
	$post = $this->input->post();


	$error = array();
	$captcha_err = FALSE;
	if ($post) {
	    // First, delete old captchas
	    $expiration = time() - 7200; // Two hour limit
	    $this->db->query("DELETE FROM captcha WHERE captcha_time < " . $expiration);

// Then see if a captcha exists:
	    $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
	    $binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
	    $query = $this->db->query($sql, $binds);
	    $row = $query->row();

	    if ($row->count == 0) {
		$captcha_err = "You must submit the word that appears in the image";
	    }
	    
	    
	    $c = new Contact();

	    $c->trans_start();

	    $success = $c->from_array($post, array('name', 'email', 'subject', 'message'), TRUE);
	    if ($success) {
		$c->trans_complete();
		redirect(site_url());
	    } else {
		$error = $c->error->all;
	    }
	}

	$data = array(
	    'title' => lang('contact_us'),
	    'error' => $error,
	    'captcha_words' => $this->_generateCaptcha()
	);
	
	if($captcha_err != FALSE){
	    $data['captcha_err'] = $captcha_err;
	}
	
	$this->template->set_content('ws/contact_form', $data);
	$this->template->build();
    }
    
    function bonus(){
	
	$b = new Bonus();
	$b->get();
	
	$data = array(
	    'bonuses' => $b,
	    'title' => 'Bonuses'
	);
	
	$this->template->set_content('ws/bonuses', $data);
	$this->template->build();
    }


    function aboutus(){
	
	$s = new Setting();
	$s->where('name', 'about_us')->get();
	
	$data = array(
	    'title' => 'About Us',
	    'content' => $s->value
	);
	
	
	$this->template->set_content('ws/aboutus', $data);
	$this->template->build();
    }
    function privacy(){
	$s = new Setting();
	$s->where('name', 'privacy')->get();
	
	$data = array(
	    'title' => 'Privacy policy',
	    'content' => $s->value
	);
	
	
	$this->template->set_content('ws/aboutus', $data);
	$this->template->build();
    }
    
    function shippings(){
	
	$b = new Shipping();
	$b->where('active', TRUE)->get();
	
	$data = array(
	    'shippings' => $b,
	    'title' => 'Shipping methods'
	);
	
	$this->template->set_content('ws/shippings', $data);
	$this->template->build();
    }
    

    function switch_currency($cur){
	$this->session->set_userdata('currency', $cur);
	redirect($_SERVER['HTTP_REFERER']);
    }
    
    private function _generateCaptcha() {
	$letters = range('a', 'z');

	$word = '';
	for ($i = 0; $i < 9; $i++) {
	    $letter = $letters[rand(0, sizeof($letters) - 1)];
	    $word .= $letter;
	}
	return $word;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */