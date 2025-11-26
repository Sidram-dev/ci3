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

    $this->form_validation->set_rules('first_name', 'First Name', 'required');
    $this->form_validation->set_rules('last_name', 'Last Name', 'required');

    if ($this->form_validation->run() === FALSE) {
        echo json_encode([
            'status' => false,
            'msg'    => validation_errors()
        ]);
        return;
    }

    $id = $this->session->userdata('user_id');

    $data = [
        "first_name" => $this->input->post('first_name'),
        "last_name"  => $this->input->post('last_name'),
        "role"       => $this->input->post('role'),
        "status"     => $this->input->post('status'),
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
    // ----------------------------------

    $this->User_model->update_user($id, $data);

    echo json_encode([
        'status' => true,
        'msg' => 'Profile Updated Successfully!'
    ]);
}


    // Save New Admin
    public function save()
    {
        $data = [
            'full_name'  => $this->input->post('full_name'),
            'first_name' => $this->input->post('first_name'),
            'last_name'  => $this->input->post('last_name'),
            'email'      => $this->input->post('email'),
            'password'   => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role'       => 'admin',
            'status'     => 1,
            'created_at' => date("Y-m-d H:i:s")
        ];

        if ($this->db->insert('users', $data)) {

            // AUTO LOGIN THE NEW ADMIN
            $this->session->set_userdata([
                'user_id' => $this->db->insert_id(),
                'email'   => $data['email'],
                'role'    => 'admin'
            ]);

            redirect('dashboard');

        } else {

            $this->session->set_flashdata('error', 'Failed to create admin');
            redirect('new_admin');
        }
    }
}