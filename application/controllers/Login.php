<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property User_model $User_model
 * @property CI_Session $session
 * @property CI_Input $input


 */

class Login extends CI_Controller
{
    public function __construct()
    {
       
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');


      
    }

    public function index()
    {
        $this->load->view('login'); 
    }

    public function submit()
    {
        $email    = $this->input->post('email', true) ?? '';
        $password = $this->input->post('password', true) ?? '';

        if (!$email || !$password) {
            $this->session->set_flashdata('error', 'Email and Password are required');
            return redirect('login');
        }

        $result = $this->User_model->loginUser($email, $password);

        if ($result['status']) {

            // Save session
            $this->session->set_userdata([
                'user_id' => $result['user']->id,
                'email'   => $result['user']->email,
                'logged_in' => true
            ]);

            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', $result['message']);
            redirect('login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

  
}
