<?php

class Testimonial extends DataMapper {
    
    var $validation = array(
	'name' => array(
	    'rules' => array('required')
	),
	'date' => array(
	    'rules' => array('required')
	),
	'content' => array(
	    'rules' => array('required')
	)
    );
    
    
}