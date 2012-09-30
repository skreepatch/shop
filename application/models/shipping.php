<?php

class Shipping extends DataMapper {
    
    var $has_one = array('order');
    
    var $validation = array(
	'price' => array(
	    'rules' => array('required')
	)
    );
    
    function __toString() {
	return empty($this->name) ? $this->localize_label('unset') : $this->name;
    }
    
}