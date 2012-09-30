<?php

class Cart_processor extends CI_Model {

    var $userdata;

    function __construct() {
	parent::__construct();
	$this->userdata = $this->session->all_userdata();
    }

    function getBonus() {
	$cart_items = $this->cart->contents();
	$bonus = FALSE;
	    $b = new Bonus();
	    $b->where('active', TRUE)->order_by('price', 'asc')->get();
	    foreach($b as $bon){
		if($this->cart->total() > $bon->price){
		    
		    $bonus = $bon;
		    $this->session->set_userdata('bonus', $bon->id);
		}
	    }
	    if($bonus != FALSE){
		return $bonus;
	    }
    }
    
    
    function createCoupon($mail){
	$cou = new Coupon();
	$cou->discount = config_item('coupon_discount');
	$cou->email = $mail;
	$cou->save();
	
	return $cou;
    }

}
