<?php

/**
 * @property User_model $User_model
 * @property CI_Session $session
 * @property CI_Input $input
 *  @property CI_Form_validation $form_validation
 * @property CI_Email $email
 */

class Email extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load libraries one-by-one (CI3 cannot load as array)
        $this->load->library('session');
        $this->load->library('email');

        $this->load->helper(['form', 'url']);
    }

    public function index()
    {
        $this->load->view('email_form');
    }

    public function send_mail()
    {
        $to_email = $this->input->post('email');

        // SMTP configuration
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_user' => 'chadchansidram963@gmail.com',
            'smtp_pass' => 'acfn thee ipuh lwaf',  // IMPORTANT
            'smtp_crypto' => 'tls',
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        );

        $this->email->initialize($config);

        $this->email->from('chadchansidram963@gmail.com', 'Sidramappa');
        $this->email->to($to_email);
        $this->email->subject('Email Testing');
        $this->email->message('Testing email sending in CodeIgniter 3');
        $this->email->attach(FCPATH . 'assets/upload/dte2.png');


        if ($this->email->send()) {
            $this->session->set_flashdata("email_sent", "Email sent successfully.");
        } else {
            $this->session->set_flashdata("email_sent", $this->email->print_debugger());
        }
        redirect('Email');
    }
}
