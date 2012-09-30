<?php

class Faq extends DataMapper {
    
    var $has_one = array('product');
    
    var $validation = array(
	'question' => array(
	    'rules' => array('required')
	),
	'answer' => array(
	    'rules' => array('required')
	)
    );
    
    
}