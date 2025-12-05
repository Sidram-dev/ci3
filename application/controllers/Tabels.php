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
 * @property CI_Security $security
 */
class Tabels extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('pagination');
    

    }

    public function index()
    {
        $per_page = 10;

        $role = $this->input->get('role');
        $this->db->from('users');
        if (!empty($role)) {
            $this->db->where('role', $role);
        }
        $total_rows = $this->db->count_all_results();
        $config['base_url']        = site_url('tabels/index');
        $config['total_rows']      = $total_rows;
        $config['per_page']        = $per_page;
        $config['use_page_numbers'] = TRUE;

        $config['full_tag_open']   = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']  = '</ul></nav>';

        $config['num_tag_open']    = '<li class="page-item mx-1">'; // spacing added
        $config['num_tag_close']   = '</li>';

        $config['cur_tag_open']    = '<li class="page-item active mx-1"><a class="page-link">'; // spacing added
        $config['cur_tag_close']   = '</a></li>';

        $config['next_tag_open']   = '<li class="page-item mx-1">'; // spacing added
        $config['next_tag_close']  = '</li>';

        $config['prev_tag_open']   = '<li class="page-item mx-1">'; // spacing added
        $config['prev_tag_close']  = '</li>';

        $config['first_tag_open']  = '<li class="page-item mx-1">'; // spacing added
        $config['first_tag_close'] = '</li>';

        $config['last_tag_open']   = '<li class="page-item mx-1">'; // spacing added
        $config['last_tag_close']  = '</li>';

        $config['attributes']      = ['class' => 'page-link'];


        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $page = ($page && ctype_digit((string)$page)) ? (int)$page : 1;
        $offset = ($page - 1) * $per_page;

        // Fetch users with limit and role filter
        $data['users'] = $this->User_model->getUsersLimit($per_page, $offset, $role);

        $data['pagination'] = $this->pagination->create_links();
        $data['role_filter'] = $role;

        // Logged in user
        $user_id = $this->session->userdata('user_id');
        $data['logged_user'] = $this->User_model->getUserById($user_id);

        $this->load->view('tabels', $data);
    }

    //   Edit user form

    public function edit($id)
    {
        $data['user'] = $this->User_model->getUserById($id);

        if (!$data['user']) {
            show_404();
        }

        $this->load->view('user', $data);
    }

        //   Update user
    
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

        if ($this->form_validation->run() == FALSE) {
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
        $phone        = $this->input->post('phone', TRUE);       
        $country_code = $this->input->post('country_code', TRUE);
        $full_name = trim($first_name . ' ' . $last_name);

        // Assuming User_model->updateUser returns TRUE on success, FALSE otherwise
        $updated = $this->User_model->updateUser($id, $first_name, $last_name, $full_name, $status, $role ,$phone,$country_code);

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
        echo json_encode($response);
    }

    // Delete user
     
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
 
    // View detailed user info
    public function view($id)
    {
        $data['user'] = $this->User_model->getUserById($id);

        if (!$data['user']) {
            show_404();
        }

        $this->load->view('details', $data);
    }

 public function filter_column()
{
    $field = $this->input->post('field');
    $operator = $this->input->post('operator');
    $value = trim($this->input->post('value'));

    if (!$field || !$operator || $value === '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid filter values',
            'newToken' => $this->security->get_csrf_hash()
        ]);
        return;
    }

    // Special Case: STATUS FIX
    if ($field === 'status') {
        if (strtolower($value) === 'active') {
            $value = 1;
        } elseif (strtolower($value) === 'inactive') {
            $value = 0;
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Status must be Active or Inactive',
                'newToken' => $this->security->get_csrf_hash()
            ]);
            return;
        }
    }

    //  created_at column
    if ($field === 'created_at') {
      
        $dateValue = date('Y-m-d', strtotime($value));
        if ($operator === 'contains') {
            $this->db->like('DATE(created_at)', $dateValue);
        } elseif ($operator === '=') {
            $this->db->where('DATE(created_at)', $dateValue);
        } elseif ($operator === '!=') {
            $this->db->where('DATE(created_at) !=', $dateValue);
        } else {
            // fallback
            $this->db->like('DATE(created_at)', $dateValue);
        }
    } else {
        if ($operator === 'contains') {
            $this->db->like($field, $value);
        } else {
            $this->db->where("$field $operator", $value);
        }
    }

    $users = $this->db->get('users')->result();

    if (!$users) {
        echo json_encode([
            'status' => 'error',
            'message' => 'No matching records found',
            'newToken' => $this->security->get_csrf_hash()
        ]);
        return;
    }

    $html = "";
    foreach ($users as $u) {
        $html .= "
    <tr>
        <td>VV-" . str_pad($u->id, 4, '0', STR_PAD_LEFT) . "</td>
        <td>{$u->first_name}</td>
        <td>{$u->last_name}</td>
        <td>{$u->full_name}</td>
        <td>{$u->email}</td>
        <td>{$u->country_code}</td>
        <td>{$u->phone}</td>
        <td>" . ucfirst($u->role) . "</td>
        <td>" . ($u->status == 1 ? '<span class=\"badge bg-success\">Active</span>' : '<span class=\"badge bg-danger\">Inactive</span>') . "</td>
        <td>" . date('d-m-Y H:i', strtotime($u->created_at)) . "</td>
        <td>
            <a href='" . site_url('tabels/view/' . $u->id) . "' class='btn btn-sm btn-info'><i class='bi bi-eye'></i></a>
            <a href='" . site_url('tabels/edit/' . $u->id) . "' class='btn btn-sm btn-primary'>Edit</a>
            <a href='" . site_url('tabels/delete/' . $u->id) . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
        </td>
    </tr>";
    }

    echo json_encode([
        'status' => 'success',
        'html' => $html,
        'newToken' => $this->security->get_csrf_hash()
    ]);
}

}
