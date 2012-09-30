<?php

class Newsitem extends DataMapper {
    
    
    var $default_order_by = array('date' => 'desc');
    
    
    var $validation = array(
	'name' => array(
	    'rules' => array('required', 'trim')
	),
	'date' => array(
	    'rules' => array('required', 'date')
	),
	'content' => array(
	    'rules' => array('required')
	)
    );
    
    
}