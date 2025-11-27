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
 * @property CI_Output $output
 */
class Tabels extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('pagination');
           // Enable CodeIgniter profiler
    
    }

    /**
     * Index - Display all users with pagination
     */
public function index()
{
    $per_page = 50;

    // Get role filter from GET
    $role = $this->input->get('role');

    // Count total users with optional role filter
    $this->db->from('users');
    if (!empty($role)) {
        $this->db->where('role', $role);
    }
    $total_rows = $this->db->count_all_results();

    // Pagination config
    $config['base_url'] = site_url('tabels/index');
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $per_page;
    $config['use_page_numbers'] = TRUE;

    // Pagination styling
    $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
    $config['full_tag_close'] = '</ul></nav>';
    $config['num_tag_open'] = '<li class="page-item mx-1">';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="page-item active mx-1"><span class="page-link">';
    $config['cur_tag_close'] = '</span></li>';
    $config['attributes'] = ['class' => 'page-link'];
    $config['prev_link'] = '&laquo;';
    $config['prev_tag_open'] = '<li class="page-item mx-1">';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = '&raquo;';
    $config['next_tag_open'] = '<li class="page-item mx-1">';
    $config['next_tag_close'] = '</li>';
    $config['first_link'] = 'First';
    $config['first_tag_open'] = '<li class="page-item mx-1">';
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = 'Last';
    $config['last_tag_open'] = '<li class="page-item mx-1">';
    $config['last_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    // Current page
    $page = $this->uri->segment(3);
    $page = ($page && ctype_digit((string)$page)) ? (int)$page : 1;
    $offset = ($page - 1) * $per_page;

    // Fetch users with limit and role filter
    $data['users'] = $this->User_model->getUsersLimit($per_page, $offset, $role);
    $data['pagination'] = $this->pagination->create_links();
    $data['role_filter'] = $role;

    // Logged-in user
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
        // Set up form validation rules (Recommended for robust AJAX)
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('status', 'Status', 'required|integer');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[customer,admin,manager]');
        
        // Set the response header to JSON
        $this->output->set_content_type('application/json');

        if ($this->form_validation->run() == FALSE)
        {
            // Validation failed: Send errors back as JSON
            $response = array(
                'status' => 'error',
                'message' => 'Validation failed.',
                'validation_errors' => validation_errors() // Send validation errors
            );
            echo json_encode($response);
            return;
        }

        // Validation succeeded: Proceed with update logic
        $first_name = $this->input->post('first_name', TRUE);
        $last_name = $this->input->post('last_name', TRUE);
        $status  = $this->input->post('status', TRUE);
        $role  = $this->input->post('role', TRUE);

        $full_name = trim($first_name . ' ' . $last_name);

        // Assuming User_model->updateUser returns TRUE on success, FALSE otherwise
        $updated = $this->User_model->updateUser( $id, $first_name,$last_name,$full_name,$status,$role);
          
        if ($updated) {
            $response = array(
                'status' => 'success',
                'message' => 'User updated successfully!'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Failed to update user. Please try again.'
            );
        }

        // Send JSON response
        echo json_encode($response);
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
