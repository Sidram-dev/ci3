<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property User_model $User_model
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 */
class Register extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['form', 'url']);
    }

    // REGISTER PAGE
    public function index()
    {
        $this->load->view('register');
    }

    // SUBMIT REGISTRATION

public function submit()
{
    $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
    if ($this->form_validation->run() === FALSE) {
        echo json_encode([
            'status' => false,
            'message' => validation_errors()
        ]);
        return;
    }

    $full_name = $this->input->post('full_name', TRUE);
    $email     = $this->input->post('email', TRUE);
    $password  = $this->input->post('password', TRUE);

    $result = $this->User_model->registerUser($full_name, $email, $password);

    echo json_encode($result); 
}


    // LOGOUT/SIGNOUT

    public function logout()
    {
        // destroy session
        $this->session->sess_destroy();

        // redirect to login or register page
        return redirect('register');  // or 'login'
    }
}
