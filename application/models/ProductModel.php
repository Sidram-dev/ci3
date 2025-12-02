<?php
class ProductModel extends CI_Model {

    // Insert product
  public function insert_product($data)
{
    return $this->db->insert('products', $data);
}


    // Fetch all products
    public function get_all_products()
    {
        return $this->db->get('products')->result();
    }

    // Fetch single product by ID
    public function get_product($id)
    {
        return $this->db->get_where('products', ['id' => $id])->row();
    }

    // Update product
    public function update_product($id, $data)
    {
        return $this->db->where('id', $id)->update('products', $data);
    }

    // Delete product
    public function delete_product($id)
    {
        return $this->db->where('id', $id)->delete('products');
    }

        public function get_product_by_id($id)
    {
        return $this->db->get_where('products', ['id' => $id])->row();
    }
}
