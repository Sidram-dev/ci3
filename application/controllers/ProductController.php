<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
 * @property CI_Upload $upload
 * @property CI_Db $db                      
 * @property CI_Uri $uri
 * @property CI_ProductModel $ProductModel
 */
class ProductController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ProductModel');
          $this->load->model('User_model'); 
        $this->load->helper(['url','form']);
        $this->load->library('upload');
    
    }
        
    //   function tp pass logged user to all view

    private function load_view($page, $data = [])
    {
        $user_id = $this->session->userdata('user_id');
        $data['logged_user'] = $this->User_model->getUserById($user_id);

        $this->load->view($page, $data);
    }

  public function add_product()
{
    $this->load_view('add_products');   
}

// add product logic

public function save_product()
{
    $response = ['status' => 'error', 'message' => 'Something went wrong'];

    $image = '';

    if (!empty($_FILES['image']['name'])) {

        $config['upload_path']   = './assets/upload/';
        $config['allowed_types'] = '*';
        $config['max_size']      = 5120;
        $config['encrypt_name']  = FALSE;

        $original_name = $_FILES['image']['name'];
        $target_path = $config['upload_path'] . $original_name;
        if (file_exists($target_path)) {
            $ext = pathinfo($original_name, PATHINFO_EXTENSION);
            $filename = pathinfo($original_name, PATHINFO_FILENAME);
            $_FILES['image']['name'] = $filename . '_' . time() . '.' . $ext;
        }

        $this->upload->initialize($config);

        if ($this->upload->do_upload('image')) {
            $uploadData = $this->upload->data();
            $image = $uploadData['file_name'];
        } else {
            $response['message'] = $this->upload->display_errors();
            echo json_encode($response);
            return;
        }
    }

    $data = [
        'name'          => $this->input->post('name'),
        'description'   => $this->input->post('description'),
        'category'      => $this->input->post('category'),
        'sub_category'  => $this->input->post('sub_category'),
        'stock'         => $this->input->post('stock'),
        'price'         => $this->input->post('price'),
        'image'         => $image
    ];

    if($this->ProductModel->insert_product($data)) {
        $response['status'] = 'success';
        $response['message'] = 'Product added successfully!';
    } else {
        $response['message'] = 'Failed to save product';
    }

    echo json_encode($response);
}
public function manage_product()
{
    $per_page = 10;

    // Filters
    $selected_category = $this->input->get('category');
    $selected_subcat   = $this->input->get('subcat');

    // Total rows
    $total_rows = $this->ProductModel->count_filtered_products($selected_category, $selected_subcat);

    // SAFE PAGE (Never NULL)
    $page = $this->input->get('page');

    if ($page === null || $page === '' || !ctype_digit((string)$page) || $page < 1) {
        $page = 1;
    } else {
        $page = (int)$page;
    }

    $offset = ($page - 1) * $per_page;

    // Fix query string build
    $query_params = $_GET;
    unset($query_params['page']);

    $config['base_url'] = site_url('ProductController/manage_product') . '?' . http_build_query($query_params);

    $config['total_rows'] = $total_rows;
    $config['per_page'] = $per_page;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['use_page_numbers'] = TRUE;

    // ⭐⭐⭐ THIS IS THE REAL FIX ⭐⭐⭐
    // CI sometimes ignores cur_page, so we OVERRIDE the internal value
    $_GET['page'] = $page;

    $config['cur_page'] = $page;

    // Bootstrap
    $config['full_tag_open']   = '<nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']  = '</ul></nav>';
    $config['num_tag_open']    = '<li class="page-item mx-1">';
    $config['num_tag_close']   = '</li>';
    $config['cur_tag_open']    = '<li class="page-item active mx-1"><a class="page-link">';
    $config['cur_tag_close']   = '</a></li>';
    $config['next_tag_open']   = '<li class="page-item mx-1">';
    $config['next_tag_close']  = '</li>';
    $config['prev_tag_open']   = '<li class="page-item mx-1">';
    $config['prev_tag_close']  = '</li>';
    $config['attributes']      = ['class' => 'page-link'];

    $this->pagination->initialize($config);

    // Data fetch
    $data['products'] = $this->ProductModel->get_filtered_products(
        $selected_category,
        $selected_subcat,
        $per_page,
        $offset
    );

    $data['categories'] = $this->ProductModel->get_categories_with_subcategories();
    $data['selected_category'] = $selected_category;
    $data['selected_subcat'] = $selected_subcat;

    $data['pagination'] = $this->pagination->create_links();

    $this->load->view('manage_product', $data);
}

    // edit prdoduct logic
    public function edit_product($id)
    {
        $data['product'] = $this->ProductModel->get_product($id);
       $this->load_view('edit_product', $data);

    }
 // update prdoduct logic
 public function update_product($id)
{
    $response = ['status' => 'error', 'message' => 'Something went wrong'];

    $old_image = $this->input->post('old_image');
    $image = $old_image;

    if (!empty($_FILES['image']['name'])) {

        $config['upload_path']   = './assets/upload/';
        $config['allowed_types'] = '*';
        $config['max_size']      = 5120;
        $config['encrypt_name']  = FALSE;

        
        $original_name = $_FILES['image']['name'];
        $target_path = $config['upload_path'] . $original_name;
        if (file_exists($target_path)) {
            $ext = pathinfo($original_name, PATHINFO_EXTENSION);
            $filename = pathinfo($original_name, PATHINFO_FILENAME);
            $_FILES['image']['name'] = $filename . '_' . time() . '.' . $ext;
        }

        $this->upload->initialize($config);

        if ($this->upload->do_upload('image')) {
            $uploadData = $this->upload->data();
            $image = $uploadData['file_name'];

           
            if (!empty($old_image) && file_exists('./assets/upload/' . $old_image)) {
                unlink('./assets/upload/' . $old_image);
            }
        } else {
            $response['message'] = $this->upload->display_errors();
            echo json_encode($response);
            return;
        }
    }

    $data = [
        'name'          => $this->input->post('name'),
        'description'   => $this->input->post('description'),
        'category'      => $this->input->post('category'),
        'sub_category'  => $this->input->post('sub_category'),
        'stock'         => $this->input->post('stock'),
        'price'         => $this->input->post('price'),
        'image'         => $image
    ];

    if ($this->ProductModel->update_product($id, $data)) {
        $response['status'] = 'success';
        $response['message'] = 'Product updated successfully!';
    } else {
        $response['message'] = 'Failed to update product';
    }

    echo json_encode($response);
}
 // delete product logic
public function delete_product($id)
{
    $product = $this->ProductModel->get_product($id);

    if (!empty($product->image) && file_exists('./assets/upload/' . $product->image)) {
        unlink('./assets/upload/' . $product->image);
    }
    $this->ProductModel->delete_product($id);

    redirect('ProductController/manage_product');
}

// view products in view_product_cards
public function view_products()
{
    $selected_category = $this->input->get('category');
    $selected_subcat   = $this->input->get('subcat');

    $per_page = 9;

    // Total rows based on filters
    $total_rows = $this->ProductModel->count_filtered_products($selected_category, $selected_subcat);

    // SAFE PAGE NUMBER
    $page = $this->input->get('page');
    if ($page === null || $page === '' || !ctype_digit((string)$page) || $page < 1) {
        $page = 1;
    } else {
        $page = (int)$page;
    }

    $offset = ($page - 1) * $per_page;

    // Build base_url with existing filters
    $query_params = $_GET;
    unset($query_params['page']); // Remove page to rebuild links
    $config['base_url'] = site_url('ProductController/view_products') . '?' . http_build_query($query_params);

    $config['total_rows'] = $total_rows;
    $config['per_page'] = $per_page;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['use_page_numbers'] = TRUE;

    // Bootstrap Pagination
    $config['full_tag_open']   = '<nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']  = '</ul></nav>';
    $config['num_tag_open']    = '<li class="page-item mx-1">';
    $config['num_tag_close']   = '</li>';
    $config['cur_tag_open']    = '<li class="page-item active mx-1"><a class="page-link">';
    $config['cur_tag_close']   = '</a></li>';
    $config['next_tag_open']   = '<li class="page-item mx-1">';
    $config['next_tag_close']  = '</li>';
    $config['prev_tag_open']   = '<li class="page-item mx-1">';
    $config['prev_tag_close']  = '</li>';
    $config['attributes']      = ['class' => 'page-link'];

    // Initialize Pagination
    $this->pagination->initialize($config);

    // 🔥 FIX: force CI internal cur_page to our safe $page
    $_GET['page'] = $page;
    $config['cur_page'] = $page;

    // Fetch filtered products
    $data['products'] = $this->ProductModel->get_filtered_products(
        $selected_category,
        $selected_subcat,
        $per_page,
        $offset
    );

    $data['categories'] = $this->ProductModel->get_categories_with_subcategories();
    $data['selected_category'] = $selected_category;
    $data['selected_subcat'] = $selected_subcat;

    $data['pagination'] = $this->pagination->create_links();

    $this->load_view('view_product_cards', $data);
}



// Individual product details loading logic
public function product_details($id)
{
    $data['product'] = $this->ProductModel->get_product_by_id($id);
    $this->load_view('product_details', $data);  
}





}


