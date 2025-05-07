<?php

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Category_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    
    public function index() {
      
        $user_name = $this->session->userdata('user_id');
        
       
        $data['username'] = $user_name;
        
       
        $this->load->view('products/index', $data);
    }
    

    
    public function create() {
        $data['categories'] = $this->Category_model->get_all_categories();
        $this->load->view('products/create', $data);
    }

    
    public function store() {
        $this->form_validation->set_rules('name', 'Product Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('products/create');
            } else {
                $upload_data = $this->upload->data();

            
                $resize_config['image_library'] = 'gd2';
                $resize_config['source_image'] = $upload_data['full_path'];
                $resize_config['maintain_ratio'] = TRUE;
                $resize_config['width'] = 500;
                $resize_config['height'] = 500;

                $this->load->library('image_lib', $resize_config);
                $this->image_lib->resize();

                $data = [
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'price' => $this->input->post('price'),
                    'category_id' => $this->input->post('category_id'),
                    'image' => $upload_data['file_name']
                ];

                $this->Product_model->insert($data);
                $this->session->set_flashdata('success', 'Product added successfully');
                redirect('products');
            }
        }
    }

    
    public function fetch_products() {
        try {
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search_value = $this->input->get('search')['value']; 
            $order_column_index = $this->input->get('order')[0]['column']; 
            $order_direction = $this->input->get('order')[0]['dir'];
    
           
            $where = '';
            if ($search_value) {
                
                $where = "WHERE p.name LIKE '%$search_value%' OR p.description LIKE '%$search_value%'"; 
            }
    
            $total_records = $this->Product_model->get_total_products_count($where);
    
            $products = $this->Product_model->get_products_with_category(
                $start, $length, $order_column_index, $order_direction, $where
            );
    
            $data = [];
            foreach ($products as $product) {
                $data[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'category_name' => $product->category_name,
                    'image' => $product->image
                ];
            }
    
            echo json_encode([
                'draw' => intval($draw),
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records, 
                'data' => $data
            ]);
        } catch (Exception $e) {
            log_message('error', 'Error in fetch_products: ' . $e->getMessage());
            show_error('Something went wrong: ' . $e->getMessage());
        }
    }
    
    
    
    

public function edit($id) {
   
    $data['product'] = $this->Product_model->get_product_by_id($id);

    
    if (empty($data['product'])) {
        $this->session->set_flashdata('error', 'Product not found');
        redirect('products');
    }

   
    $data['categories'] = $this->Category_model->get_all_categories();

 
    $this->load->view('products/edit', $data);
}


public function update($id) {
    $this->form_validation->set_rules('name', 'Product Name', 'required');
    $this->form_validation->set_rules('price', 'Price', 'required');

    if ($this->form_validation->run() == FALSE) {
       
        $this->edit($id);
    } else {
        
        $data = [
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'price' => $this->input->post('price'),
            'category_id' => $this->input->post('category_id')
        ];

        
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('products/edit/' . $id);
            } else {
                $upload_data = $this->upload->data();

                
                $resize_config['image_library'] = 'gd2';
                $resize_config['source_image'] = $upload_data['full_path'];
                $resize_config['maintain_ratio'] = TRUE;
                $resize_config['width'] = 500;
                $resize_config['height'] = 500;

                $this->load->library('image_lib', $resize_config);
                $this->image_lib->resize();

                
                $data['image'] = $upload_data['file_name'];

             
                $old_image = $this->Product_model->get_product_by_id($id)->image;
                if ($old_image && file_exists('./uploads/' . $old_image)) {
                    unlink('./uploads/' . $old_image);
                }
            }
        }

        
        $this->Product_model->update_product($id, $data);

        
        $this->session->set_flashdata('success', 'Product updated successfully');
        redirect('products');
    }
}

    public function delete($id) {
        $this->Product_model->delete_product($id);
        $this->session->set_flashdata('success', 'Product deleted successfully');
        redirect('products');
    }
    public function show($id){
        $data['product'] = $this->Product_model->get_by_id($id);
        $this->load->view('products/show', $data);
    }


    public function show_categories() {
       
        $data['categories'] = $this->Category_model->get_all_categories();
        
        $this->load->view('category/show', $data);
    }

   
    public function add_categories() {
        if ($this->input->post()) {
           
            $data = [
                'name' => $this->input->post('name')
                
            ];
          
            $this->Category_model->insert($data);
           
            redirect('products/show_categories');
        }
        
        $this->load->view('category/add');
    }

    
    public function edit_categories($id) {
        
        $category = $this->Category_model->get_category_by_id($id);
        if (!$category) {
            show_404(); 
        }

        if ($this->input->post()) {
           
            $data = [
                'name' => $this->input->post('name'),
                
            ];
            
            $this->Category_model->update($id, $data);
           
            redirect('products/show_categories');
        }

        
        $data['category'] = $category;
        
        $this->load->view('category/edit', $data);
    }

   
    public function delete_categories($id) {
        
        $this->Category_model->delete($id);
        
        redirect('products/show_categories');
    }

  
    public function get_categories_id($id) {
        
        $category = $this->Category_model->get_category_by_id($id);
        
        if ($category) {
            echo json_encode($category);
        } else {
            echo json_encode(['error' => 'Category not found']);
        }
    }

    
}
