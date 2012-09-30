<?php

class Sitemap_model extends CI_Model {
    
    function getCategories(){
	
	$c = new Category();
	$c->get();
	return $c;
    }
    
    function getProducts(){
	$c = new Product();
	$c->get();
	return $c;
    }
    
    
}
