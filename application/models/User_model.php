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
public function updateUser($id, $first_name, $last_name, $full_name, $status,$role)
{
    $data = [
           'first_name' => $first_name,
        'last_name'  => $last_name,
        'full_name'  => $full_name,
        'status'     => $status,
        'role'       => $role // <- update role
    ];

    return $this->db->where('id', $id)->update('users', $data);
}
public function deleteUser($id)
{
    $this->db->where('id', $id);
    return $this->db->delete('users'); // 'users' is your table name
}



public function getUsersLimit($limit, $offset, $role = null)
{
    $this->db->from('users');
    if (!empty($role)) {
        $this->db->where('role', $role);
    }
    $this->db->limit($limit, $offset);
    return $this->db->get()->result();
}


    /* ------------------------------
        GET USER BY EMAIL
    ------------------------------ */
    public function getUserByEmail($email)
    {
        return $this->db->where('email', $email)->get('users')->row();
    }


// Save reset token
public function saveResetToken($email, $token)
{
    $expires = date("Y-m-d H:i:s", strtotime('+15 minutes'));

    $data = [
        'reset_token' => $token,
        'reset_expires' => $expires
    ];

    return $this->db->where('email', $email)->update('users', $data);
}

// Check token validity
public function checkToken($token)
{
    $this->db->where('reset_token', $token);
    $this->db->where('reset_expires >=', date("Y-m-d H:i:s"));
    return $this->db->get('users')->row();
}

// Update password after reset
public function updatePasswordByEmail($email, $password)
{
    $data = [
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'reset_token' => NULL,
        'reset_expires' => NULL
    ];

    return $this->db->where('email', $email)->update('users', $data);
}

public function update_user($id, $data)
{
    $this->db->where('id', $id);
    return $this->db->update('users', $data);
}


}
