<?php

class Category extends DataMapper {
    
    var $table = 'categories';
    var $model = 'category';
    
    var $has_one = array();
    var $has_many = array('product');
    
    var $validation = array(
	'name' => array (
	    'rules' => array('required', 'trim')
	)
    );
    
    function __toString() {
	return empty($this->name) ? $this->localize_label('unset') : $this->name;
    }
}