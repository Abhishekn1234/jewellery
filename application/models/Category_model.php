<?php
class Category_model extends CI_Model {
    public function __construct() {
        parent::__construct(); // This is necessary to load the model
        $this->load->database();  
        $this->load->library('session');
    }
    // Insert a new category into the database
    public function insert($data) {
        return $this->db->insert('categories', $data);
    }

    // Get all categories
    public function get_all_categories() {
        return $this->db->get('categories')->result();
    }

    // Get a category by its ID
    public function get_category_by_id($id) {
        return $this->db->get_where('categories', ['id' => $id])->row();
    }

    // Update a category by its ID
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }

    // Delete a category by its ID
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('categories');
    }
}
