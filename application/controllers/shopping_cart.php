<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Shopping_cart extends CI_Controller {

    public $userdata;

    function __construct() {
	parent::__construct();
	$this->userdata = $this->session->all_userdata();
	if (!isset($this->userdata['currency'])) {
	    $this->session->set_userdata('curr', 'USD');
	} else {
	    $this->config->set_item('curr', $this->userdata['currency']);
	}
    }

    function index($bonus_product = NULL) {

	$this->load->model('util/cart_processor');

	$sh = new Shipping();
	$sh->where('active', TRUE)->get();


	$bonus = $this->cart_processor->getBonus();
	$p = new Product();
	if ($bonus_product != NULL) {
	    $this->session->unset_userdata('bonus_product');
	    $this->session->set_userdata('bonus_product', $bonus_product);
	    $p->where('id', $bonus_product);
	} else if(isset($this->userdata['bonus_product'])){
	    $p->where('id', $this->userdata['bonus_product']);
	} else {
	    $p->where(array('isbonus' => TRUE))->limit(1);
	}
	$p->get();
	$data = array(
	    'p' => $p,
	    'cart' => $this->cart->contents(),
	    'title' => 'Shopping cart',
	    'shipping' => $sh
	);
	
	if ($bonus) {
	    $bonus_item = array(
		'id' => $p->id,
		'qty' => 1,
		'price' => -1,
		'name' => $p->name,
		'options' => array('package' => $bonus->amount . ' pills')
	    );
	    $data['bonus_item'] = $bonus_item;
	    $data['current_bonus'] = $bonus->id;
	}
	if (isset($_GET['shipping']) && $_GET['shipping'] != 0) {
	    $sel_sh = new Shipping($_GET['shipping']);
	    $data['selected_shipping'] = $sel_sh;
	}

	$this->template->set_content('ws/shopping_cart', $data);
	$this->template->build();
    }

    function add($pid, $amount, $price) {
	$p = new Product($pid);
	$data = array(
	    'id' => $p->id,
	    'qty' => 1,
	    'price' => $price,
	    'name' => $p->name,
	    'options' => array('package' => $amount . ' pills')
	);
	$this->cart->insert($data);
	redirect(site_url('shopping_cart'));
    }

    function discard() {
	$this->cart->destroy();
    }

    function update($rid = NULL) {
	if ($rid != NULL) {
	    $data = array(
		'rowid' => $rid,
		'qty' => 0
	    );
	    $this->cart->update($data);
	} else {
	    $this->cart->update($_POST);
	}
	redirect(site_url('shopping_cart'));
    }

    function checkout($id = FALSE) {
	// Create User Object
	$c = new Order();

	if ($id == 'save') {
	    // Try to save the user
	    $id = $this->input->post('id');
	    $this->_get_order($c, $id);

	    $c->trans_start();
	    $success = $c->from_array($_POST, array('email', 'fullname', 'address', 'country', 'adrress', 'city', 'zip', 'shipping'), TRUE); // TRUE means save immediately
	    // redirect on save
	    if ($success) {
		foreach ($this->cart->contents() as $item) {
		    $oi = new Orderitem();
		    $oi->product_id = $item['id'];
		    $oi->quantity = $item['options']['package'];
		    $oi->price = floatval($item['price']);
		    $oi->save($c);
		}
		$c->trans_complete();
		if ($id < 1) {
		    $this->session->set_flashdata('message', 'The order ' . $c->id . ' was successfully placed.');
		} else {
		    $this->session->set_flashdata('message', 'The order ' . $c->id . ' was successfully updated.');
		}
		$this->load->library('medex');
		$c->orderitem->get();
		if ($this->medex->uploadOrder($c)) {
		    $c->status_id = 6;
		    $c->save();
		    $this->cart->destroy();
		    redirect(site_url());
		}
	    }
	} else {
	    // load an existing user
	    $this->_get_order($c, $id);
	}

	// Load the HTML Form extension
	$c->load_extension('htmlform');

	// These are the fields to edit.
	$form_fields = array(
	    'id',
	    'Credit Card Details' => 'section',
	    'cctype' => array('label' => 'Credit Card Type*', 'type' => 'dropdown', 'list' => array('VISA' => 'visa', 'MasterCard' => 'mastercard')),
	    'ccnumber' => array('label' => 'Credit Card Number*', 'type' => 'text'),
	    'Credit Card Expiration' => 'section',
	    'ccmonth' => array('label' => 'Month*', 'type' => 'dropdown', 'list' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)),
	    'ccyear' => array('label' => 'Year*', 'type' => 'dropdown', 'list' => array(2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020)),
	    'Shipping details' => 'section',
	    'email' => array('label' => 'E-mail*'),
	    'fullname' => array('label' => 'Fullname*'),
	    'country' => array('type' => 'dropdown', 'list' => config_item('country_list'), 'label' => 'Country*'),
	    'address' => array('label' => 'Address*'),
	    'city'=> array('label' => 'City*'),
	    'zip' => array('label' => 'ZIP*'),
	    'shipping' => array('disabled' => 'true')
	);

	// Set up page text
	if ($id > 0) {
	    $title = 'Checkout';
	    $url = 'shopping_cart/checkout/save';
	} else {
	    $title = 'Checkout';
	    $url = 'shopping_cart/checkout/save';
	}

	$data = array(
	    'title' => $title,
	    'section' => 'admin',
	    'order' => $c,
	    'form_fields' => $form_fields,
	    'url' => $url
	);

	$this->template->set_content('ws/checkout', $data);
	$this->template->build();
    }

    function process_order() {
	$post = $this->input->post();
    }

    function changeBonus($pid) {
	$p = new Product();
	$p->where('isbonus', TRUE)->get();
	$b = new Bonus();
	$b->get();
	$data = array(
	    'bonus_products' => $p,
	    'bonus_item' => $pid,
	    'bonuses' => $b,
	    'current_bonus' => $this->userdata['bonus'],
	);
	$this->load->view('ws/change_bonus', $data);
    }

    function _get_order($cat, $id) {
	if (!empty($id)) {
	    $cat->get_by_id($id);
	    if (!$cat->exists()) {
		show_error('Invalid User ID');
	    }
	}
    }

}

