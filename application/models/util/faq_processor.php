<?php


class Faq_processor extends CI_Model{

    public $orderBy = "desc";
    public $page = 1;
    public $pagesize = 10;
    public $pagesizes;
    public $_like;

    function  __construct() {
        parent::__construct();
        if (isset($_POST['pagesize']) && $_POST['pagesize'] != 'undefined') {
            $this->pagesize = $_POST['pagesize'];
        }
        if (isset($_POST['page'])) {
            $this->page = $_POST['page'];
        }
        if (isset($_POST['where']) && $_POST['where'] != '') {
            $this->_where = $_POST['where'];
        }
        if (isset($_POST['like']) && $_POST['like'] != '') {
            $this->_like = $_POST['like'];
        }
        

        $this->pagesizes = array(
            '1000' => lang("all"),
            '3' => 3,
            '5' => 5,
            '10' => 10,
            '15' => 15,
            '25' => 25,
            '50' => 50,
            '100' => 100
        );
        
    }

    public function getFaq($post){
	$_tableResult = array();
	$_tableResult['searches'] = 0;
	
        if (isset($post['pagesize']) && $post['pagesize'] != '') {
            $this->pagesize = $post['pagesize'];
        }
        
        
        $tr = new Faq();
        if (isset($post['orderby']) && isset($post['order'])) {
            try {
                $orderby = $post['orderby'];
                $order = $post['order'];
		$tr->order_by($orderby, $order);
            } catch (Exception $e) {
                var_dump($e->getMessage());
            }
        } else {
            $tr->order_by('id', 'desc');
        }

	if ($this->_like) {
	    foreach ($this->_like as $field => $lk) {
		$tr->like($field, $lk);
		if ($_tableResult['searches'] == 0) {
		    $_tableResult['searches'] = $this->_like;
		} else {
		    array_push($_tableResult['searches'], $this->_like);
		}
	    }
	}

        if ($this->page && $this->pagesize) {
            $tr->get_paged($page = $this->page, $pagesize = $this->pagesize)->all;
            $pagination = $tr->paged;
        } else {
            $tr->get()->all;
        }

        $data = array(
            'faqs' => $tr,
            'pagination' => $pagination,
            'pagesizes' => $this->pagesizes,
	    'searches' => $_tableResult['searches']
		
        );

        return $data;
    }

    

}