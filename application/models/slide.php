<?php

class Slide extends DataMapper {
    
    var $validation = array(
	'label' => array(
	    'rules' => array('required'),
	),
    );
    
}