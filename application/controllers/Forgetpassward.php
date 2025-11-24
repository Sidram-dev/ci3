<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property User_model $User_model
 * @property CI_Session $session
 * @property CI_Input $input
 *  @property CI_Form_validation $form_validation
 * @property CI_Email $email
 */
class Forgetpassward extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(['session', 'email']);
        $this->load->helper(['form', 'url']);
    }

    // Step 1: Show email input form
    public function index()
    {
        $this->load->view('forgetpassward');
    }

    // Step 2: Send reset link
   public function sendLink()
{
    $email = $this->input->post('email');

    $user = $this->User_model->getUserByEmail($email);
    if (!$user) {
        $this->session->set_flashdata('error', 'Email not found.');
        redirect('reset_passward');
    }

    $token = bin2hex(random_bytes(20));
    $this->User_model->saveResetToken($email, $token);

    $resetLink = base_url("forgetpassward/reset/$token");

    // Email config
    $config = [
        'protocol'  => 'smtp',
        'smtp_host' => 'smtp.gmail.com',
        'smtp_port' => 587,
        'smtp_user' => 'chadchansidram963@gmail.com',
        'smtp_pass' => 'iomi qwfs spyk fxnu', // APP PASSWORD (NOT Gmail login password)
        'smtp_crypto' => 'tls',
        'mailtype' => 'html',
        'charset'  => 'utf-8',
        'newline'  => "\r\n"
    ];

    // Initialize email
    $this->email->initialize($config);
    $this->email->from('your_email@gmail.com', 'MyApp');
    $this->email->to($email);
    $this->email->subject('Reset Your Password');
    $this->email->message("
        <p>Click the link below to reset your password:</p>
        <a href='$resetLink'>$resetLink</a>
        <p>Link valid for 15 minutes.</p>
    ");

    // 🚨 Debugging for email not sending
    if (!$this->email->send()) {
        echo "<pre>";
        print_r($this->email->print_debugger());
        echo "</pre>";
        exit; // IMPORTANT: Stop further execution
    }

    $this->session->set_flashdata('success', 'Password reset link sent.');
    redirect('forgetpassward');
}


    // Step 3: Show new password form
    public function reset($token)
    {
        $user = $this->User_model->checkToken($token);

        if (!$user) {
            echo "Invalid or expired token.";
            return;
        }

        $data['token'] = $token;
        $this->load->view('reset_passward', $data);
    }

    // Step 4: Update password
    public function updatePassword()
    {
        $token = $this->input->post('token');
        $password = $this->input->post('password');
        $confirm = $this->input->post('confirm');

        if ($password !== $confirm) {
            $this->session->set_flashdata('error', 'Passwords do not match.');
            redirect("forgetpassward/reset/$token");
        }

        $user = $this->User_model->checkToken($token);
        if (!$user) {
            echo "Invalid or expired token.";
            return;
        }

        $this->User_model->updatePasswordByEmail($user->email, $password);

        $this->session->set_flashdata('success', 'Password updated. Login now.');
        redirect('login');
    }
}
