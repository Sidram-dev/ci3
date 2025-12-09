<?php
class ProductModel extends CI_Model
{

    // Insert product
    public function insert_product($data)
    {
        return $this->db->insert('products', $data);
    }

    // fetch all products
    public function get_all_products()
    {
        $this->db->select('
        products.*,
        categories.category_name,
        sub_categories.sub_category_name
    ');
        $this->db->from('products');
        $this->db->join('categories', 'categories.category_id = products.category', 'left');
        $this->db->join('sub_categories', 'sub_categories.sub_category_id = products.sub_category', 'left');

        return $this->db->get()->result();
    }


    // fetch single product by ID
    public function get_product($id)
    {
        $this->db->select('
        products.*,
        categories.category_name,
        sub_categories.sub_category_name
    ');
        $this->db->from('products');
        $this->db->join('categories', 'categories.category_id = products.category', 'left');
        $this->db->join('sub_categories', 'sub_categories.sub_category_id = products.sub_category', 'left');
        $this->db->where('products.id', $id);

        return $this->db->get()->row();
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
        $this->db->select('
        products.*,
        categories.category_name,
        sub_categories.sub_category_name
    ');
        $this->db->from('products');


        $this->db->join('categories', 'categories.category_id = products.category', 'left');
        $this->db->join('sub_categories', 'sub_categories.sub_category_id = products.sub_category', 'left');

        $this->db->where('products.id', $id);

        return $this->db->get()->row();
    }

    public function count_all_products()
    {
        return $this->db->count_all('products');
    }

    public function get_products_limit($limit, $offset)
    {
        return $this->db
            ->limit($limit, $offset)
            ->get('products')
            ->result();
    }

    // Gettting all categories with their subcategories for dropdown

    public function get_categories_with_subcategories()
    {
        $this->db->select('
        categories.category_id,
        categories.category_name,
        sub_categories.sub_category_id,
        sub_categories.sub_category_name
    ');
        $this->db->from('categories');
        $this->db->join('sub_categories', 'sub_categories.category_id = categories.category_id', 'left');

        $result = $this->db->get()->result();

        $categories = [];

        foreach ($result as $row) {
            if (!isset($categories[$row->category_id])) {
                $categories[$row->category_id] = [
                    'name' => $row->category_name,
                    'subs' => []
                ];
            }

            if ($row->sub_category_id) {
                $categories[$row->category_id]['subs'][$row->sub_category_id] = $row->sub_category_name;
            }
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

    // Count products with filter
    public function count_filtered_products($category, $subcat)
    {
        $this->db->from('products');

        if ($subcat) {
            $this->db->where('products.sub_category', $subcat);
        } elseif ($category) {
            $this->db->where('products.category', $category);
        }


        return $this->db->count_all_results();
    }

    // Fetch filtered products with pagination
    public function get_filtered_products($category, $subcat, $limit, $offset)
    {
        $this->db->select('
        products.*,
        categories.category_name,
        sub_categories.sub_category_name
    ');
        $this->db->from('products');
        $this->db->join('categories', 'categories.category_id = products.category', 'left');
        $this->db->join('sub_categories', 'sub_categories.sub_category_id = products.sub_category', 'left');

        if ($subcat) {
            $this->db->where('products.sub_category', $subcat);
        } elseif ($category) {
            $this->db->where('products.category', $category);
        }

        return $this->db->limit($limit, $offset)->get()->result();
    }
}
