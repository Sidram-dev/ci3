<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Tabels Controller
 *
 * Handles user listing, editing, updating, deleting, viewing details, and pagination.
 *
 * @property User_model $User_model
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Pagination $pagination
 * @property CI_Db $db
 * @property CI_Uri $uri
 */
class Tabels extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('pagination');
    }

    /**
     * Index - Display all users with pagination
     */
    public function index()
    {
        // Pagination config
        $config['base_url']        = site_url('tabels/index');
        $config['total_rows']      = $this->db->count_all('users');
        $config['per_page']        = 10;
        $config['use_page_numbers'] = TRUE;

        // Pagination styling
        $config['full_tag_open']   = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']  = '</ul></nav>';
        $config['num_tag_open']    = '<li class="page-item">';
        $config['num_tag_close']   = '</li>';
        $config['cur_tag_open']    = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close']   = '</a></li>';
        $config['next_tag_open']   = '<li class="page-item">';
        $config['next_tag_close']  = '</li>';
        $config['prev_tag_open']   = '<li class="page-item">';
        $config['prev_tag_close']  = '</li>';
        $config['attributes']      = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        // Safe page number
        $page = $this->uri->segment(3);
        $page = ($page && ctype_digit((string)$page)) ? (int)$page : 1;
        $offset = ($page - 1) * $config['per_page'];

        // Load users
        $data['users'] = $this->User_model->getUsersLimit($config['per_page'], $offset);
        $data['pagination'] = $this->pagination->create_links();

        // Logged in user
        $user_id = $this->session->userdata('user_id');
        $data['logged_user'] = $this->User_model->getUserById($user_id);

        $this->load->view('tabels', $data);
    }

    /**
     * Edit user form
     */
    public function edit($id)
    {
        $data['user'] = $this->User_model->getUserById($id);

        if (!$data['user']) {
            show_404();
        }

        $this->load->view('user', $data);
    }

    /**
     * Update user
     */
    public function update($id)
    {
        $first_name = $this->input->post('first_name', TRUE);
        $last_name  = $this->input->post('last_name', TRUE);
        $status     = $this->input->post('status', TRUE);
        $role       = $this->input->post('role', TRUE);

        $full_name = trim($first_name . ' ' . $last_name);

        $updated = $this->User_model->updateUser(
            $id,
            $first_name,
            $last_name,
            $full_name,
            $status,
            $role
        );

        if ($updated) {
            $this->session->set_flashdata('success', 'User updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update user!');
        }

        redirect('tabels');
    }

    /**
     * Delete user
     */
    public function delete($id)
    {
        if (!$id) {
            $this->session->set_flashdata('error', 'Invalid user ID.');
            redirect('tabels');
        }

        $deleted = $this->User_model->deleteUser($id);

        if ($deleted) {
            $this->session->set_flashdata('success', 'User deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete user.');
        }

        redirect('tabels');
    }

    /**
     * View detailed user info
     */
    public function view($id)
    {
        $data['user'] = $this->User_model->getUserById($id);

        if (!$data['user']) {
            show_404();
        }

        $this->load->view('details', $data);
    }
}
