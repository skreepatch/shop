<?php


class Contact extends DataMapper {
    
    var $validation = array(
	'name' => array(
	    'rules' => array('required', 'trim')
	),
	'email' => array(
	    'rules' => array('required', 'matches' => 'email')
	),
    );
    
}