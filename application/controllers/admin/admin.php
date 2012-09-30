<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {

    var $user;
    var $language;
    function __construct() {
        parent::__construct();

        $this->load->library('login_manager');
        $this->lang->load('cpanel');
        $this->user = $this->login_manager->logged_in_user;
        $this->template->clear_js();
        $this->language = $this->session->userdata('language') ? $this->session->userdata('language') : $this->config->item('language');
    }

    function index() {
        if($this->user->group->id == 3){
            redirect(site_url());
        }
        
        $u = new User();
        $u->order_by('created', 'desc');
        $u->limit('5')
                ->where_in_related('group', 'id', '3')
                ->get();
        
        $p = new Product();
        $p->order_by('created', 'desc');
        $p->limit('5')->get();
        
        $o = new Cart();
        $o->where('registered >', 0);
        $o->order_by('created', 'desc');
        $o->limit('5')->get();

        $data = array(
            'users' => $u,
            'products' => $p,
            'orders' => $o,
	    'title' => lang('main')
        );

        $this->template->set_content('admin/cpanel', $data);
        $this->template->build();
    }
    
    function backupDb(){
	$this->load->dbutil();

	$prefs = array(
                'format'      => 'zip',             // gzip, zip, txt
                'filename'    => 'mybackup_'.time().'.zip',    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );
	$backup =& $this->dbutil->backup($prefs);
	$this->load->helper('file');
	write_file('/var/www/nvm.co.il/htdocs/files/backups/'.$prefs['filename'], $backup); 
	$this->load->helper('download');
	force_download($prefs['filename'], $backup); 
	
	$this->set_flashdata('message', 'Database backup successfull!');
	redirect(site_url('admin'));
    }

}