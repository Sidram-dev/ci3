<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property User_model $User_model
 * @property CI_Session $session
 * @property CI_Input $input
 */
class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index()
    {
        // Get logged-in user ID from session
        $user_id = $this->session->userdata('user_id');

        if (!$user_id) {
            redirect('login'); // If session expired or not logged in
        }

        // Get full user details
        $data['user'] = $this->User_model->getUserById($user_id);

        // Now pass full_name separately if needed
        $data['full_name'] = $data['user']->full_name;
        
        $this->load->view('dashboard', $data);
        
    }
}
