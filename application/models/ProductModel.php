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



// Get all categories with their subcategories (for dropdown)
    public function get_categories_with_subcategories()
    {
        $this->db->select('category, sub_category');
        $this->db->from('products');
        $query = $this->db->get()->result();

        $categories = [];
        foreach ($query as $row) {
            $categories[$row->category][] = $row->sub_category;
        }

        // Remove duplicate subcategories for each category
        foreach ($categories as $cat => $subs) {
            $categories[$cat] = array_unique($subs);
        }

        return $categories;
    }

    // Fetch products by main category
public function get_products_by_category($category)
{
    return $this->db->get_where('products', ['category' => $category])->result();
}

    // Get products by subcategory
    public function get_products_by_subcategory($subcat)
    {
        return $this->db->get_where('products', ['sub_category' => $subcat])->result();
    }




    
}
