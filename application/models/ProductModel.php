<?php
class ProductModel extends CI_Model {

    // Insert product
  public function insert_product($data)
{
    return $this->db->insert('products', $data);
}

// fetch all products
    public function get_all_products()
    {
        return $this->db->get('products')->result();
    }

    // fetch single product by ID
    public function get_product($id)
    {
        return $this->db->get_where('products', ['id' => $id])->row();
    }

    //    Update product
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

    public function get_products_limit($limit, $offset)
{
    return $this->db
        ->limit($limit, $offset)
        ->get('products')
        ->result();
}

// Fetch distinct categories
public function get_all_categories(){
    $this->db->select('category');
    $this->db->distinct();
    return $this->db->get('products')->result();
}

public function get_subcategories_by_category($cat_name){
    $this->db->select('sub_category');
    $this->db->distinct();
    $this->db->where('category', $cat_name);
    return $this->db->get('products')->result();
}

// Filter products by category or subcategory
public function get_products_by_filter($value = null){
    $this->db->from('products');

    if($value){
        $this->db->group_start();
        $this->db->where('category', $value);
        $this->db->or_where('sub_category', $value);
        $this->db->group_end();
    }

    return $this->db->get()->result();
}




    
}
