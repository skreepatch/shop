<?php

class Bonus extends DataMapper {
    
    var $model = 'bonus';
    var $table = 'bonuses';
    
    var $has_many = array();
    var $has_one = array();
    
    var $default_order_by = array('amount' => 'desc');
    
    var $validation = array(
	'name' => array('required')
    );
    
    function __toString() {
	return empty($this->name) ? $this->localize_label('unset') : $this->name;
    }
    
}

?>