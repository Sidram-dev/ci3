<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property User_model $User_model
 * @property CI_Session $session
 * @property CI_Input $input
 *  @property CI_Form_validation $form_validation
 * @property CI_Db $db
 */

class New_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    // Create page
    public function index() {
        $this->load->view('new_admin');
    }


    // Show profile of logged-in user
    public function profile() {
        $user_id = $this->session->userdata('user_id');

        if (!$user_id) {
            redirect('login'); // Redirect if not logged in
        }

        $data['user'] = $this->User_model->getUserById($user_id);
        $data['title'] = "My Profile | AdminLTE";

 
        $this->load->view('profile', $data);
       
    }

    // Update profile
public function update_profile()
{
    $user_id = $this->session->userdata('user_id');

    $first_name = $this->input->post('first_name', TRUE);
    $last_name  = $this->input->post('last_name', TRUE);
    $role       = $this->input->post('role', TRUE);
    $status     = $this->input->post('status', TRUE);

    $data = [
        'first_name' => $first_name,
        'last_name'  => $last_name,
        'role'       => $role,
        'status'     => $status,
    ];

    // ---------- IMAGE UPLOAD ----------
    if (!empty($_FILES['profile_image']['name'])) {

        // File content (BLOB)
        $imageData = file_get_contents($_FILES['profile_image']['tmp_name']);

        $data['profile_image'] = $imageData;
    }

    // Update in DB
    $this->db->where('id', $user_id);
    $updated = $this->db->update('users', $data);

    if ($updated) {
        $this->session->set_flashdata('success', 'Profile updated successfully');
    } else {
        $this->session->set_flashdata('error', 'Failed to update profile');
    }

    redirect('New_admin/profile');
}


    public function save() {
        $data = [
            'full_name'  => $this->input->post('full_name'),
            'first_name' => $this->input->post('first_name'),
            'last_name'  => $this->input->post('last_name'),
            'email'      => $this->input->post('email'),
            'password'   => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'status'     => 1,
            'created_at' => date("Y-m-d H:i:s")
        ];

        if ($this->db->insert('users', $data)) {
            $this->session->set_flashdata('success', 'Admin created successfully!');
            redirect('tabels');
        } else {
            $this->session->set_flashdata('error', 'Failed to create admin');
            redirect('new_admin');
        }
    }
}