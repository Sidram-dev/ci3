<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Tabels Controller
 *
 * Handles user listing, editing, updating, deleting, viewing details, and pagination.
 *
 * @property User_model $User_model
 * @property CI_Session $session
 
 */
class Dashboard_v1 extends CI_Controller {
	  public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
       ;
           // Enable CodeIgniter profiler
    
    }
	public function index()
	{
	$user_id = $this->session->userdata('user_id');
    $data['logged_user'] = $this->User_model->getUserById($user_id);
		$this->load->view('dashboard_v1', $data);
	}
}
