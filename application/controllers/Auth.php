<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('session');
    }

    public function login(){
        $data['error'] = $this->session->flashdata('error');  
        $this->load->view('auth/login', $data);
    }
    public function register() {
        $this->load->view('auth/register');
    }
    
    public function register_post() {
        
        $this->load->library('form_validation');
    
        
        $data = [
            'username' => $this->input->post('username'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT)
        ];
    
        
        $this->load->model('User_model');
        $this->User_model->insert($data);
    
      
        $this->session->set_flashdata('success', 'Registration successful. Please login.');
        redirect('auth/login');
    }
    
    public function login_post(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->User_model->get_user($username);

        if($user && password_verify($password, $user->password)){
            $this->session->set_userdata('user_id', $user->id);
            redirect('products');
        } else {
            $this->session->set_flashdata('error', 'Invalid credentials');
            redirect('auth/login');
        }
    }

    public function logout(){
        $this->session->unset_userdata('user_id');
        redirect('auth/login');
    }
}
