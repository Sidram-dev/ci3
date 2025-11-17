<?php
class User_model extends CI_Model {

    // Register user
    public function registerUser($email, $password)
    {
        $existingUser = $this->db->where('email', $email)->get('users')->row();

        if ($existingUser) {
            return ['status' => false, 'message' => 'Email already exists'];
        }

      // Hash the password before storing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'email'      => $email,
            'password'   => $hashedPassword,
            'created_at' => date('Y-m-d H:i:s')
        ];

      // Insert new user into 'users' table
        $insert = $this->db->insert('users', $data);

        return [
            'status'  => $insert ? true : false,
            'message' => $insert ? 'User registered successfully' : 'Registration failed'
        ];
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
     // Login success, return user data
        return [
            'status'  => true,
            'message' => 'Login successful',
            'user'    => $user
        ];
    }

    public function getContacts(){
        $this->load->database();
        $result=$this->db->query("select * from users");
       if( $result->num_rows()>0){
        return $result->result();
       }else{
        return false;
       }
    }
}
