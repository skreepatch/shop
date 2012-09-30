<?php


class Status_processor extends CI_Model{

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

    public function getStatuses($post){
	$_tableResult = array();
	$_tableResult['searches'] = 0;
	
        if (isset($post['pagesize']) && $post['pagesize'] != '') {
            $this->pagesize = $post['pagesize'];
        }
        
        
        $tr = new Status();
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
            'statuses' => $tr,
            'pagination' => $pagination,
            'pagesizes' => $this->pagesizes,
	    'searches' => $_tableResult['searches']
		
        );

        return $data;
    }

    public function editTracks($tid = NULL){
        
    }

    public function saveTrack($tid = NULL){
        if($tid != NULL){
            $tr = new Track();
            $tr->get_by_id($tid)->all;
            $p = new Product();
            $p->get();
            $tr->delete($p->all);
        } else {
            $tr = new Track();
            $tr->save();
        }
        $tr->name = $_POST['name'];
        $tr->value = $_POST['value'];
        $tr->status_id = $_POST['status_id'];
        $tr->tracktype_id = $_POST['tracktype_id'];
        $tr->weight = $_POST['weight'];

        if (isset($_POST['product'])) {
                $p = new Product();
                $p->where('id', $_POST['product']);
                $p->get()->all;
                $p->save($tr);
        }

        $tr->save();

    }

    public function saveToProduct($tid = NULL, $pid = NULL){

    }

}