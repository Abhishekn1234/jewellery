<?php
class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();  // Load the database here
        $this->load->model('User_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function get_user($username) {
        return $this->db->get_where('users', ['username' => $username])->row();
    }

    public function insert($data) {
        return $this->db->insert('users', $data);
    }
}
