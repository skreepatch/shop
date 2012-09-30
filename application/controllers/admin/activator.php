<?php

class Activator extends CI_Controller {
    
    function change($model, $id, $field = NULL){
	$obj = new $model($id);
	if($obj->{$field} == TRUE){
	    $obj->{$field} = FALSE;
	} else {
	    $obj->{$field} = TRUE;
	}
	
	if($obj->save()){
	    redirect($_SERVER['HTTP_REFERER']);
	}
	
    }
}