<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property User_model $User_model
 * @property CI_Session $session
 * @property CI_Input $input
 */

class Register extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index()
    {
        $this->load->view('register');
    }

    public function submit()
    {
        $email    = $this->input->post('email');
        $password = $this->input->post('password');

        // Calling model with parameters
        $result = $this->User_model->registerUser($email, $password);

        if ($result['status']) {
            $this->session->set_flashdata('success', $result['message']);
            redirect('login');
        } else {
            $this->session->set_flashdata('error', $result['message']);
            redirect('register');
        }
    }
}
