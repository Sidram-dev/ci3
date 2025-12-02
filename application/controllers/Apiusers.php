<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property User_model $User_model
 * @property CI_Session $session
 * @property CI_Input $input
 *  @property CI_Form_validation $form_validation
 * @property CI_Pagination $pagination 
 * @property CI_Uri $uri
 */
class ApiUsers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('pagination');
    }

    public function index($page = 1)
    {
        $per_page = 50;

        // Role filter
        $role_filter = $this->input->get('role');

        // Fetch all users from API
        $all_users = $this->fetchAllUsers();

        $roles = ['admin', 'manager', 'customer'];
        $users = [];

        // Map API data
        foreach ($all_users as $index => $u) {

            // assign rotating role
            $role = $roles[$index % count($roles)];

            // Apply role filter
            if (!empty($role_filter) && $role != $role_filter) {
                continue;
            }

            $users[] = (object)[
                'id'         => $u['id'],
                'first_name' => $u['firstName'],
                'last_name'  => $u['lastName'],
                'full_name'  => $u['firstName'] . ' ' . $u['lastName'],
                'email'      => $u['email'],
                'role'       => $role,
                'gender'     => $u['gender']  // IMPORTANT
            ];
        }

        // Pagination
        $total_rows = count($users);
        $config['base_url'] = site_url('api_user');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['use_page_numbers'] = TRUE;

        // Bootstrapped pagination
        $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_tag_open'] = '<li class="page-item mx-1">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active mx-1"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['attributes'] = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        // Get current page
        $page = $this->uri->segment(2);
        $page = ($page && is_numeric($page)) ? (int)$page : 1;
        $start = ($page - 1) * $per_page;

        // Slice pagination
        $data['users'] = array_slice($users, $start, $per_page);
        $data['pagination'] = $this->pagination->create_links();
        $data['role_filter'] = $role_filter;

            $user_id = $this->session->userdata('user_id');
            $data['logged_user'] = $this->User_model->getUserById($user_id);

        $this->load->view('api_user', $data);
    }

    private function fetchAllUsers()
    {
        $all = [];
        $limit = 100;
        $skip = 0;

        do {
            $url = "https://dummyjson.com/users?limit={$limit}&skip={$skip}";
            $response = file_get_contents($url);
            $data = json_decode($response, true);

            if (!empty($data['users'])) {
                $all = array_merge($all, $data['users']);
                $skip += $limit;
            } else {
                break;
            }
        } while ($skip < $data['total']);

        return $all;
    }

    
}