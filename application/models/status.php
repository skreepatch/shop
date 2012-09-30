<?php

class Status extends DataMapper {

	// Overridden because inflector has trouble convering status <> statuses
	var $model = 'status';
	var $table = 'statuses';

	// --------------------------------------------------------------------
	// Relationships
	// --------------------------------------------------------------------

	var $has_many = array('order');	
}

/* End of file status.php */
/* Location: ./application/models/status.php */