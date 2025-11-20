<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Register user
    public function registerUser($full_name, $email, $password)
    {
        $existingUser = $this->db->where('email', $email)->get('users')->row();

        if ($existingUser) {
            return ['status' => false, 'message' => 'Email already exists'];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'full_name'  => $full_name,
            'email'      => $email,
            'password'   => $hashedPassword,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $insert = $this->db->insert('users', $data);

        return [
            'status'  => $insert ? true : false,
            'message' => $insert ? 'User registered successfully' : 'Registration failed'
        ];
    }

    // Get all users
    public function getContacts()
    {
        $query = $this->db->get('users');
        return $query->num_rows() ? $query->result() : false;
    }

    // Get single user by id
    public function getUserById($id)
    {
        return $this->db->where('id', $id)->get('users')->row();
    }

    // Login user
    public function loginUser($email, $password)
    {
        $user = $this->db->where('email', $email)->get('users')->row();
        if (!$user) {
            return ['status' => false, 'message' => 'User not found'];
        }

        if (!password_verify($password, $user->password)) {
            return ['status' => false, 'message' => 'Incorrect password'];
        }

        return [
            'status'  => true,
            'message' => 'Login successful',
            'user'    => $user
        ];
    }
    // update
public function updateUser($id, $first_name, $last_name, $full_name, $status)
{
    $data = [
        'first_name' => $first_name,
        'last_name'  => $last_name,
        'full_name'  => $full_name,
        'status'     => $status
    ];

    return $this->db->where('id', $id)->update('users', $data);
}
public function deleteUser($id)
{
    $this->db->where('id', $id);
    return $this->db->delete('users'); // 'users' is your table name
}



public function getUsersLimit($limit, $offset)
{
    $query = $this->db->limit($limit, $offset)->get('users');
    return $query->result();
}








}
