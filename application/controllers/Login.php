<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property User_model $User_model
 * @property CI_Session $session
 * @property CI_Input $input
 *  @property CI_Form_validation $form_validation
 */

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->library('form_validation');

    }

    public function index()
    {
        $this->load->view('login'); 
    }

public function submit()
{
    // Load form validation
    $this->load->library('form_validation');

    // Validation rules
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
    $this->form_validation->set_rules('password', 'Password', 'required|trim');

    // Run validation
    if ($this->form_validation->run() === FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        return redirect('login');
    }

    // Get safe XSS-cleaned input
    $email    = $this->input->post('email', TRUE);
    $password = $this->input->post('password', TRUE);

    // Call model
    $result = $this->User_model->loginUser($email, $password);

    if ($result['status']) {

        // Set session data
        $this->session->set_userdata([
            'user_id'   => $result['user']->id,
            'email'     => $result['user']->email,
            'logged_in' => true
        ]);

        return redirect('dashboard');

    } else {
        $this->session->set_flashdata('error', $result['message']);
        return redirect('login');
    }
}

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
