<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('menu_model');
        $this->load->model('submenu_model');
    }

    // menu
    public function index() {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('templates/footer');

    }

    // add new menu
    public function add() {
        $menu = $this->menu_model;

        $validation = $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($validation->run() == false) {
            $this->session->set_flashdata('message_error', '<div class="alert alert-danger" role="alert">
            New menu dont added!</div>');
        } else {
            $menu->saveMenu();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New menu added!</div>');
        }

        redirect('menu');
    }

    // edit menu
    function edit($id = null) {
        $data['title'] = "Edit Menu";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        if (!isset($id)) redirect('menu');

        $menu = $this->menu_model;
        $validation = $this->form_validation->set_rules('menu', 'Menu', 'required');

        $data['menu'] = $menu->getByIdMenu($id);
        if (!$data['menu']) show_404();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/edit_menu', $data);
        $this->load->view('templates/footer');

        if ($validation->run() == false) {
            $this->session->set_flashdata('message_error', '<div class="alert alert-danger" role="alert">
            Data failed to edit!</div>');
        } else {
            $menu->updateMenu();
            $this->session->set_flashdata('message_edited_success', '<div class="alert alert-success" role="alert">
            Data edited successfully!</div>');
            redirect('menu');
        }
    }

    // delete menu
    public function delete($id = null) {
        if ($this->menu_model->deleteMenu($id)) {
            $this->session->set_flashdata('message_delete', '<div class="alert alert-success" role="alert">
            Data successfully deleted!</div>');
            redirect('menu');
        }
    }

    // submenu
    public function submenu() {
        $data['title'] = "Submenu Management";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('menu_model', 'menu');

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $validation = $this->form_validation->set_rules('title', 'Title', 'required');
        $validation = $this->form_validation->set_rules('menu_id', 'Menu_id', 'required');
        $validation = $this->form_validation->set_rules('url', 'Url', 'required');
        $validation = $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            // add menu
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message_add_new_submenu', '<div class="alert alert-success" role="alert">
            New sub menu added!</div>');
            redirect('menu/submenu');
        }

    }
}