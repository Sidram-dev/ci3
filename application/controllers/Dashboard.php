<?php
/**
 * @property CI_Session $session
 */
class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        echo "Welcome to dash, ";
    }
}
