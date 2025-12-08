    <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Category_model extends CI_Model
    {

        public function insert_category($data)
        {
            return $this->db->insert('categories', $data);
        }

        public function get_all_categories()
        {
            $query = $this->db->get('categories');
            return $query->result();
        }

        public function insert_sub_category($data)
        {
            return $this->db->insert('sub_categories', $data);
        }


        public function get_all_sub_categories()
        {
            $query = $this->db->get('sub_categories');
            return $query->result();
        }


        public function get_subcategories_by_category($category_id)
{
    $this->db->where('category_id', $category_id);
    $query = $this->db->get('sub_categories');
    return $query->result();
}

    }
