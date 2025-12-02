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
          $this->load->model('User_model'); // ⭐ Added for dropdown functionality
        $this->load->helper(['url','form']);
        $this->load->library('upload');
    
    }
    

    
    // COMMON FUNCTION TO PASS LOGGED USER TO ALL VIEWS
    private function load_view($page, $data = [])
    {
        $user_id = $this->session->userdata('user_id');
        $data['logged_user'] = $this->User_model->getUserById($user_id);

        $this->load->view($page, $data);
    }

  public function add_product()
{
    $this->load_view('add_products');   // <-- this sends logged_user automatically
}


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
        $data['products'] = $this->ProductModel->get_all_products();
       $this->load_view('manage_product', $data);

    }

    public function edit_product($id)
    {
        $data['product'] = $this->ProductModel->get_product($id);
       $this->load_view('edit_product', $data);

    }

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

        // Handle filename conflict
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

            // Delete old image
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



public function delete_product($id)
{
    // Get old image
    $product = $this->ProductModel->get_product($id);

    // Delete image from folder
    if (!empty($product->image) && file_exists('./assets/upload/' . $product->image)) {
        unlink('./assets/upload/' . $product->image);
    }

    // Delete record from database
    $this->ProductModel->delete_product($id);

    // Redirect back
    redirect('ProductController/manage_product');
}


public function view_products()
{
    $data['products'] = $this->ProductModel->get_all_products();
   $this->load_view('view_product_cards', $data);

}

// product details
public function product_details($id)
{
    $data['product'] = $this->ProductModel->get_product_by_id($id);
    $this->load_view('product_details', $data);   // auto passes logged_user
}


}


