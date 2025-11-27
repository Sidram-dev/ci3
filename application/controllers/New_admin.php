<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property User_model $User_model
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 * @property CI_Logged_User $logged_user
 * @property CI_DB_mysqli_driver $db   // Correct DB driver (Fixes insert_id warning)
 * @property CI_Security $security 
 */

class New_admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');

        // Load logged user globally for all views
        if ($this->session->userdata('user_id')) {
            $this->logged_user = $this->User_model->getUserById(
                $this->session->userdata('user_id')
            );
        } else {
            $this->logged_user = null;
        }
    }

    // Create page
    public function index()
    {
        $data['logged_user'] = $this->logged_user;
        $this->load->view('new_admin', $data);
    }

    // Show profile of logged-in user
    public function profile()
    {
        $user_id = $this->session->userdata('user_id');

        if (!$user_id) {
            redirect('login');
        }

        $data['user']  = $this->User_model->getUserById($user_id);
        $data['title'] = "My Profile | AdminLTE";

        $this->load->view('profile', $data);
    }

    // Update profile
public function update_profile()
{
    if (!$this->input->is_ajax_request()) {
        echo json_encode(['status' => false, 'msg' => 'Invalid Request']);
        return;
    }

    // ----------- VALIDATION RULES ----------
    $this->form_validation->set_rules('first_name', 'First Name', 'required');
    $this->form_validation->set_rules('last_name', 'Last Name', 'required');
    $this->form_validation->set_rules('country_code', 'Country Code', 'required');
    $this->form_validation->set_rules('phone', 'Phone', 'required');

    if ($this->form_validation->run() === FALSE) {
        echo json_encode([
            'status' => false,
            'msg'    => validation_errors()
        ]);
        return;
    }

    $id = $this->session->userdata('user_id');

    // ----------- DATA TO UPDATE ----------
    $data = [
        "first_name"    => $this->input->post('first_name'),
        "last_name"     => $this->input->post('last_name'),
        "role"          => $this->input->post('role'),
        "status"        => $this->input->post('status'),
        "country_code"  => $this->input->post('country_code'),
        "phone"         => $this->input->post('phone'),
    ];

    // ---------- IMAGE UPLOAD ----------
    if (!empty($_FILES['profile_image']['name'])) {

        $config['upload_path'] = './assets/upload/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('profile_image')) {
            $file = $this->upload->data('file_name');
            $data['profile_image'] = $file;
        } else {
            echo json_encode([
                'status' => false,
                'msg'    => $this->upload->display_errors()
            ]);
            return;
        }
    }

    // ---------- UPDATE USER ----------
    $this->db->where('id', $id)->update('users', $data);

    echo json_encode([
        'status' => true,
        'msg'    => 'Profile updated successfully'
    ]);
}



    // Save New Admin
public function save()
{
    // Load form validation if not already loaded
    $this->load->library('form_validation');

    // Set validation rules
    $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
    $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
    $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');

    header('Content-Type: application/json');

    // If validation fails, return errors
    if ($this->form_validation->run() === FALSE) {
        $errors = validation_errors('<div>','</div>');
        $response = [
            'status' => 'error',
            'message' => $errors ?: 'Validation failed.',
        ];

        // include fresh CSRF token if available
        if (method_exists($this->security, 'get_csrf_token_name')) {
            $response['csrf_token_name'] = $this->security->get_csrf_token_name();
            $response['csrf_hash'] = $this->security->get_csrf_hash();
        }

        echo json_encode($response);
        return;
    }

    // Prepare data (XSS filtered via second param true)
    $data = [
        'full_name'  => $this->input->post('full_name', true),
        'first_name' => $this->input->post('first_name', true),
        'last_name'  => $this->input->post('last_name', true),
        'email'      => $this->input->post('email', true),
        'password'   => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
        'role'       => 'admin',
        'status'     => 1,
        'created_at' => date("Y-m-d H:i:s")
    ];

    // Insert and handle DB errors
    if ($this->db->insert('users', $data)) {
        $insert_id = $this->db->insert_id();

        // Auto-login the new admin
        $this->session->set_userdata([
            'user_id' => $insert_id,
            'email'   => $data['email'],
            'role'    => 'admin'
        ]);

        $response = [
            'status' => 'success',
            'message' => 'Admin created successfully.'
        ];

        if (method_exists($this->security, 'get_csrf_token_name')) {
            $response['csrf_token_name'] = $this->security->get_csrf_token_name();
            $response['csrf_hash'] = $this->security->get_csrf_hash();
        }

        echo json_encode($response);
        return;
    } else {
        // log DB error
        $db_error = $this->db->error();
        log_message('error', 'Insert user failed: ' . print_r($db_error, true) . ' -- Query: ' . $this->db->last_query());

        $response = [
            'status' => 'error',
            'message' => 'Database error: ' . ($db_error['message'] ?? 'unknown')
        ];

        if (method_exists($this->security, 'get_csrf_token_name')) {
            $response['csrf_token_name'] = $this->security->get_csrf_token_name();
            $response['csrf_hash'] = $this->security->get_csrf_hash();
        }

        echo json_encode($response);
        return;
    }
}

}