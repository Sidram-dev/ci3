<?php 
/**
 * @property User_model $User_model
 * @property CI_Session $session
 * @property CI_Input $input
 */
class Contacts extends CI_Controller{
    public function index(){
        $this->load->model("User_model");
       $data['records'] = $this->User_model->getContacts();
        $this->load->view("contacts",$data);
    }
}