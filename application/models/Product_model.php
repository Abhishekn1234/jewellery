<?php
class Product_model extends CI_Model {
    public function __construct() {
        parent::__construct(); 
        $this->load->database();  
        $this->load->library('session');
    }
    
    public function insert($data) {
        return $this->db->insert('products', $data);
    }
    public function get_product_by_id($id) {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function update_product($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('products', $data);
    }
  
    public function get_total_products_count($where = '') {
       
        $query = $this->db->query("SELECT COUNT(*) AS total FROM products p $where");
        return $query->row()->total;
    }
    

    public function get_products_with_category($start, $length, $order_column_index, $order_direction, $where = '') {
        
            $order_columns = ['p.name', 'p.description', 'p.price', 'c.name']; 

            
            $query = $this->db->query("
                SELECT p.*, c.name AS category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                $where
                ORDER BY {$order_columns[$order_column_index]} $order_direction
                LIMIT $start, $length
            ");
            
            return $query->result();
    }


    public function get_product($id) {
            return $this->db->get_where('products', ['id' => $id])->row();
    }
    public function get_all_products_with_category() {
            $this->db->select('products.id, products.name, products.description, products.price, products.image, categories.name as category_name');
            $this->db->from('products');
            $this->db->join('categories', 'categories.id = products.category_id'); 
            $query = $this->db->get();
            
            return $query->result();  
    }
        
    
    public function get_all_products() {
        $this->db->select('products.id, products.name, products.description, products.price, categories.name as category_name, products.image');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id');
        $query = $this->db->get();
        
       
        if (!$query) {
            log_message('error', 'Error fetching products: ' . $this->db->last_query());
            return [];
        }
    
        return $query->result();
    }
    

    
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('products', $data);
    }

   
    public function delete($id) {
        return $this->db->delete('products', ['id' => $id]);
    }

    
    public function search_products($keyword) {
        $this->db->like('name', $keyword);
        return $this->db->get('products')->result();
    }

    
    public function count_all_products() {
        return $this->db->count_all('products');
    }

   
    public function get_products_with_pagination($limit, $offset) {
        return $this->db->get('products', $limit, $offset)->result();
    }
}
