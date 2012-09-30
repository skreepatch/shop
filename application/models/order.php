<?php

class Order extends DataMapper {
    
    var $has_one = array('shipping', 'status');
    var $has_many = array('orderitem');
    var $validation = array(
	'fullname' => array(
	    'rules' => array('required', 'trim')
	),
	'email' => array(
	    'rules' => array('required')
	),
	'country' => array(
	    'rules' => array('required')
	),
	'address' => array(
	    'rules' => array('required')
	),
	'city' => array(
	    'rules' => array('required')
	),
	'zip' => array(
	    'rules' => array('required')
	),
	'shipping' => array(
	    'rules' => array('required')
	),
    );

    
    public function total() {
	$oi = new Orderitem();
	$oi->where('order_id', $this->id)->select_sum('price', 'total_price')->get();
	return $oi->total_price;
    }
}

?>