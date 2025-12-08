<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
    * @property Category_model $Category_model
    * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 *  @property CI_Form_validation $form_validation
 */
class CategoryController extends CI_Controller
{
    public function add_category()
    {
        $this->load->view('add_category');
    }
// storing the category
 
    public function stores()
    {
        $category_name = $this->input->post('category_name');
        $data = array(
            'category_name' => $category_name
        );
        $insert = $this->db->insert('categories', $data);
        if ($insert) {
            $this->session->set_flashdata('success', 'Category added successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to add category.');
        }
        redirect('add_category');
    }

    // accesing sub category in Dropdown
   public function sub_categories()
{
    $this->load->model('Category_model');
    $data['categories'] = $this->Category_model->get_all_categories();

    $this->load->view('add_sub_category', $data);
}

// storing sub_category
public function store_sub_category()
{   
    $this->load->model('Category_model');
    $sub_category_name = $this->input->post('sub_category_name');
    $category_id = $this->input->post('category_id');

    $data = array(
        'sub_category_name' => $sub_category_name,
        'category_id' => $category_id
    );

    $insert = $this->Category_model->insert_sub_category($data);
    if ($insert) {
        $this->session->set_flashdata('success', 'Sub Category added successfully.');
    } else {
        $this->session->set_flashdata('error', 'Failed to add sub category.');
    }
    redirect('sub_categories');
}
}
