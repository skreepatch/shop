<?php

class Product extends DataMapper {

    var $has_one = array('category');
    var $has_many = array('orderitem', 'faq', 'package', 'bonus');
    
    var $default_order_by = array('trimmed_name' => 'desc');
    
    var $validation = array(
	'name' => array(
	    'rules' => array('required', 'trim', 'max_length' => 512)
	)
    );
    
    function lowestPrice(){
//	$p = new Product();
//	$p->where('price >', 0)->where(array('trimmed_name' => $this->trimmed_name, 'active' => TRUE))->order_by('price', 'asc')->limit(1)->get();
	$p = $this;
	$p_disc = $p->package->order_by('discount', 'desc')->limit(1)->get();
	$percent = $this->price / 100;
	$sum_disc = $p_disc->discount * $percent;
	$after_disc = $p->price - $sum_disc;
	return $after_disc;
    }
    
    
    function __toString() {
	return empty($this->name) ? $this->localize_label('unset') : $this->trimmed_name;
    }
}

