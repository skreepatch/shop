<?php

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('login_manager', array('autologin' => FALSE));
    }

    function index() {
        $this->load->helper('captcha');
        $user = $this->login_manager->get_user();
        if ($user !== FALSE) {
            // already logged in, redirect to welcome page
            redirect(site_url());
        }
        // Create a user to store the login validation
        $user = new User();
        if ($this->input->post('email') !== FALSE) {
            // A login was attempted, load the user data
            $user->from_array($_POST, array('email', 'password'));
            // get the result of the login request
            $login_redirect = $this->login_manager->process_login($user);


            if ($login_redirect) {
                if ($login_redirect === TRUE) {
                    // if the result was simply TRUE, redirect to the welcome page.
                    redirect(site_url());
                } else {
                    // otherwise, redirect to the stored page that was last accessed.
                    redirect($login_redirect);
                }
            }
        }

        $data = array(
            'user' => $user,
            'title' => lang('login')
        );

        $this->template->set_content('ws/login_register', $data);
        $this->template->build();
    }

    function register() {
        $this->load->library('email');
        $this->load->helper('email');

        $mailconfig['charset'] = 'utf-8';
        $mailconfig['mailtype'] = 'html';
        $mailconfig['wordwrap'] = TRUE;

        $this->email->initialize($mailconfig);


        if (isset($_POST) && count($_POST) > 0) {
            // First, delete old captchas
            $expiration = time() - 7200; // Two hour limit
            $this->db->query("DELETE FROM captcha WHERE captcha_time < " . $expiration);

// Then see if a captcha exists:
            $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
            $binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
            $query = $this->db->query($sql, $binds);
            $row = $query->row();

            if ($row->count == 0) {
                echo "You must submit the word that appears in the image";
            }

// Try to save the user        
            $user = new User();

            $user->trans_start();
            // Only add the passwords in if they aren't empty
            // New users start with blank passwords, so they will get an error automatically.
            if (!empty($_POST['password']) && !empty($_POST['confirm_password'])) {
                $user->from_array($_POST, array('password', 'confirm_password'));
            }

            // Load and save the reset of the data at once
            // The passwords saved above are already stored.
            $success = $user->from_array($_POST, array('name', 'last_name', 'email', 'group_id'), TRUE); // TRUE means save immediately 
            // redirect on save
            if ($success) {
                $user->trans_complete();
                $u = new User();
                $u->get_by_id($user->id);
                $login_redirect = $this->login_manager->process_login($u);
                echo $login_redirect;
                if ($login_redirect) {
                    if ($login_redirect === TRUE) {
                        // if the result was simply TRUE, redirect to the welcome page.
                        redirect(site_url());
                    } else {
                        // otherwise, redirect to the stored page that was last accessed.
                        redirect($login_redirect);
                    }
                }
//                if (valid_email($_POST['email'])) {
//                    $this->email->from('my@nvm.co.il', 'NVM - New Vision Media');
//                    $this->email->to($_POST['email']);
//                    $this->email->subject('Welcome');
//                    $this->email->message('Thank you for registering at NVM! <br/>You have successfully registered with the following credentials:<br/>Email/Login: <strong>' . $user->email . '</strong></br>Password: <strong>' . $_POST['password'] . '</strong>');
//                    $this->email->send();
//                } else {
//                    $this->session->set_flashdata('message', 'the email address is not valid');
//                }
            } else {
                $this->session->set_flashdata('message', lang('message_something_wrong'));
                redirect(site_url('login'));
            }
        }
    }

    function forgot_password() {
        
    }

}

/* End of file login.php */
/* Location: ./system/application/controllers/login.php */