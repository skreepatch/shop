<?php


class Sitemap extends CI_Controller {
	
	function __construct() {
	    parent::__construct();
	}
	
	function index()
	{
		$this->load->model('util/sitemap_model');
		$this->load->library('sitemaps');
		
		$cats = $this->sitemap_model->getCategories();
		
		foreach($cats as $cat)
		{
			$item = array(
				"loc" => site_url("online-pharmacy/" . urlencode(strtolower($cat->name))),
				// ISO 8601 format - date("c") requires PHP5
				"lastmod" => date("c", strtotime($cat->updated)),
				"changefreq" => "hourly",
				"priority" => "0.8"
			);
			
			$this->sitemaps->add_item($item);
		}
		$prods = $this->sitemap_model->getProducts();
		foreach($prods as $pr) {
			$item = array(
				"loc" => site_url('online-pharmacy/' . urlencode(strtolower($pr->category->name)) . '/' . urlencode(strtolower($pr->trimmed_name))),
				// ISO 8601 format - date("c") requires PHP5
				"lastmod" => date("c", strtotime($pr->updated)),
				"changefreq" => "hourly",
				"priority" => "0.8"
			);
			$this->sitemaps->add_item($item);
		}
		
		// file name may change due to compression
		$file_name = $this->sitemaps->build("sitemap_linespharmacy.xml");

		$reponses = $this->sitemaps->ping(site_url($file_name));
		
		// Debug by printing out the requests and status code responses
		// print_r($reponses);

		redirect(site_url($file_name));
	}
}