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
    // Validation rules
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
    $this->form_validation->set_rules('password', 'Password', 'required|trim');

    if ($this->form_validation->run() === FALSE) {
        echo json_encode([
            'status' => false,
            'message' => validation_errors()
        ]);
        return;
    }

    $email    = $this->input->post('email', TRUE);
    $password = $this->input->post('password', TRUE);

    $result = $this->User_model->loginUser($email, $password);

    if ($result['status']) {

        // Set session
        $this->session->set_userdata([
            'user_id'   => $result['user']->id,
            'email'     => $result['user']->email,
            'logged_in' => true
        ]);

        echo json_encode([
            'status' => true,
            'message' => "Login successful!"
        ]);

    } else {
        echo json_encode([
            'status' => false,
            'message' => $result['message']
        ]);
    }
}
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
