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
        // Load User_model to interact with the 'users' table
        $this->load->model('User_model');
    }

    /**
     * Index - Display all users with pagination
     */
   public function index()
{
   $this->load->library('pagination');

$config['base_url']    = site_url('tabels/index');
$config['total_rows']  = $this->db->count_all('users');
$config['per_page']    = 10;

$config['use_page_numbers'] = TRUE;

// Pagination styling
$config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
$config['full_tag_close'] = '</ul></nav>';
$config['num_tag_open'] = '<li class="page-item">';
$config['num_tag_close'] = '</li>';
$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
$config['cur_tag_close'] = '</a></li>';
$config['next_tag_open'] = '<li class="page-item">';
$config['next_tag_close'] = '</li>';
$config['prev_tag_open'] = '<li class="page-item">';
$config['prev_tag_close'] = '</li>';
$config['attributes'] = ['class' => 'page-link'];

$this->pagination->initialize($config);

// Safe current page
$page = $this->uri->segment(3);
$page = ($page && ctype_digit((string)$page)) ? (int)$page : 1;

// Offset calculation
$offset = ($page - 1) * $config['per_page'];

$data['users'] = $this->User_model->getUsersLimit($config['per_page'], $offset);
$data['pagination'] = $this->pagination->create_links();


    $this->load->view('tabels', $data);
}


    /**
     * Edit - Load form to edit user
     *
     * @param int $id - User ID
     */
    public function edit($id)
    {
        // Fetch user data by ID
        $data['user'] = $this->User_model->getUserById($id);

        if (!$data['user']) {
            show_404(); // Show 404 if user not found
        }

        // Load edit view (edit_user.php)
        $this->load->view('user', $data);
    }

    /**
     * Update - Process form submission and update user
     *
     * @param int $id - User ID
     */
public function update($id)
{
    // Sanitize POST data
    $first_name = $this->input->post('first_name', TRUE);
    $last_name  = $this->input->post('last_name', TRUE);
    $status     = $this->input->post('status', TRUE);  // 'Active' or 'Inactive'

    // Concatenate full name
    $full_name = trim($first_name . ' ' . $last_name);

    // Update user in database via model
    $updated = $this->User_model->updateUser($id, $first_name, $last_name, $full_name, $status);

    // Flash message
    if ($updated) {
        $this->session->set_flashdata('success', 'User updated successfully!');
    } else {
        $this->session->set_flashdata('error', 'Failed to update user!');
    }

    redirect('tabels');
}


    /**
     * Delete - Remove a user by ID
     *
     * @param int $id - User ID
     */
public function delete($id)
{
    if (!$id) {
        $this->session->set_flashdata('error', 'Invalid user ID.');
        redirect('tabels');
    }

    // Delete user from database
    $deleted = $this->User_model->deleteUser($id);

    if ($deleted) {
        $this->session->set_flashdata('success', 'User deleted successfully!');
    } else {
        $this->session->set_flashdata('error', 'Failed to delete user.');
    }

    redirect('tabels');
}

    /**
     * View - Show detailed information of a single user
     *
     * @param int $id - User ID
     */
    public function view($id)
    {
        // Fetch user by ID
        $data['user'] = $this->User_model->getUserById($id);

        if (!$data['user']) {
            show_404(); // Show 404 if user not found
        }

        // Load view_user.php (or details.php) to show user details
        $this->load->view('details', $data);
    }
}
