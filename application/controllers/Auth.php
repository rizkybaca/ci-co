<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
  }

  public function index()
  {
    $data['title'] = 'CO Login Page';
    $this->load->view('templates/auth_header', $data);
    $this->load->view('auth/login');
    $this->load->view('templates/auth_footer');
  }

  public function regist()
  {
    $this->form_validation->set_rules('name', 'Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
    // $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
    //   'is_unique' => 'Email has already registered!'
    // ]);
    $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[4]|matches[password2]', [
      'matches' => 'Password dont match!',
      'min_length' => 'Password too short!'
    ]);
    $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
    $this->form_validation->set_rules('phone', 'Phone Number', 'required|trim|numeric');
    // $this->form_validation->set_rules('phone', 'Phone number', 'required|trim|numeric|is_unique[user.phone]', [
    //   'is_unique' => 'Phone number has already registered!'
    // ]);

    if ($this->form_validation->run() == FALSE) {
      $data['title'] = 'CO Registration Page';
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/regist');
      $this->load->view('templates/auth_footer');
    } else {
      $data = [
        'name' => htmlspecialchars($this->input->post('name', true)),
        'email' => htmlspecialchars($this->input->post('email', true)),
        'password' => htmlspecialchars(password_hash($this->input->post('password1', true), PASSWORD_DEFAULT)),
        'phone' => htmlspecialchars($this->input->post('phone', true)),
        'image' => 'default.jpg',
        'role_id' => 2,
        'is_active' => 1,
        'date_created' => time(),
        'date_modified' => time()
      ];
      $this->db->insert('user', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation! Your account has been created. Please login</div>');
      redirect('auth');
    }
  }
}
