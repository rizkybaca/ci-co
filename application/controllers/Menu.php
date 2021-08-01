<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
    $this->load->model('Menu_model', 'menu');
  }

  public function index()
  {
    $data['title'] = 'Menu Management';
    $data['user'] = $this->menu->getUserBySession();

    $data['menu'] = $this->db->get('user_menu')->result_array();

    $this->form_validation->set_rules('menu', 'Menu', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/index', $data);
      $this->load->view('templates/footer');
    } else {
      $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New menu added.</div>');
      redirect('menu');
    }
  }

  public function submenu()
  {
    $data['title'] = 'Submenu Management';
    $data['user'] = $this->menu->getUserBySession();


    $this->load->model('Menu_model', 'menu');
    $data['submenu'] = $this->menu->getSubMenu();
    $data['menu'] = $this->db->get('user_menu')->result_array();

    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('menu_id', 'Menu', 'required');
    $this->form_validation->set_rules('url', 'URL', 'required');
    $this->form_validation->set_rules('icon', 'Icon', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/submenu', $data);
      $this->load->view('templates/footer');
    } else {
      $data = [
        'title' => $this->input->post('title'),
        'menu_id' => $this->input->post('menu_id'),
        'url' => $this->input->post('url'),
        'icon' => $this->input->post('icon'),
        'is_active' => $this->input->post('is_active')
      ];
      $this->db->insert('user_sub_menu', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New submenu added.</div>');
      redirect('menu/submenu');
    }
  }

  public function delete($id)
  {
    $this->menu->deleteMenu($id);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu deleted!</div>');
    redirect('menu');
  }

  public function edit($id)
  {
    $data['title'] = 'Form Edit Menu Management';
    $data['user'] = $this->menu->getUserBySession();
    $data['menu'] = $this->menu->getMenuById($id);

    $this->form_validation->set_rules('menu', 'Menu', 'required|trim');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/menu-edit', $data);
      $this->load->view('templates/footer');
    } else {
      $this->menu->editDataMenu($id);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu updated!</div>');
      redirect('menu');
    }
  }

  public function editSubmenu($id)
  {
    $data['title'] = 'Form Edit Submenu Management';
    $data['user'] = $this->menu->getUserBySession();
    $data['submenu'] = $this->menu->getSubmenuById($id);
    $data['menu'] = $this->menu->getAllMenu();

    $this->form_validation->set_rules('title', 'Submenu Title', 'required|trim');;
    $this->form_validation->set_rules('url', 'Submenu URL', 'required|trim');
    $this->form_validation->set_rules('icon', 'Submenu URL', 'required|trim');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/submenu-edit', $data);
      $this->load->view('templates/footer');
    } else {
      $this->menu->editDataSubmenu();
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu updated!</div>');
      redirect('menu/submenu');
    }
  }

  public function changeactive()
  {
    $tangkap = $this->input->post('tangkap');
    $submenu = $this->input->post('submenu');

    $data = [
      'is_active' => $tangkap
    ];

    $result = $this->db->get_where('user_sub_menu', ['id' => $submenu]);

    if ($result->num_rows() == 1) {
      $this->db->where('id', $submenu);
      $this->db->update('user_sub_menu', $data);
    }
    // $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access changed!</div>');
  }
}
