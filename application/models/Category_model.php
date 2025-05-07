<?php
class Category_model extends CI_Model {
    public function __construct() {
        parent::__construct(); 
        $this->load->database();  
        $this->load->library('session');
    }

    public function insert($data) {
        return $this->db->insert('categories', $data);
    }

   
    public function get_all_categories() {
        return $this->db->get('categories')->result();
    }

    
    public function get_category_by_id($id) {
        return $this->db->get_where('categories', ['id' => $id])->row();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }


    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('categories');
    }
}
