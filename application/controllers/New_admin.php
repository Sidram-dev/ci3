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

    // Profile page (logged-in user)
    public function profile() {
        $id = $this->session->userdata('user_id');
        if(!$id) redirect('register/login');

        $data['user'] = $this->User_model->getUserById($id);
        $this->load->view('profile', $data);
    }

    // 👉 EDIT PAGE LOAD --- URL: /new_admin/edit/10
  public function edit($id) {
        $data['user'] = $this->User_model->getUserById($id);
        $this->load->view('edit_user', $data);
    }

    // 👉 UPDATE USER --- URL: /new_admin/update/10
    public function update($id)
    {
        $updateData = [
            'full_name'  => $this->input->post('full_name'),
            'first_name' => $this->input->post('first_name'),
            'last_name'  => $this->input->post('last_name'),
            'email' => $this->input->post('email'),

            'status'     => $this->input->post('status'),
        ];

        $this->db->where('id', $id);
        $this->db->update('users', $updateData);

        $this->session->set_flashdata('success', 'User Updated Successfully!');
        redirect('/new_admin/profile');
    }

    // Save new user
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