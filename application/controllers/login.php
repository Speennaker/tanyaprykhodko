<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once($_SERVER['DOCUMENT_ROOT'].'/application/controllers/MY_base_controller.php');
class Login extends MY_base_controller {
    public $module = 'login';
    /** @var  users_model */
    public $users_model;
    public function index()
    {
        $data = ['login' => '', 'pword' => '', 'errors' => []];
        if($this->input->post())
        {
            $errors = [];
            if(!$this->input->post('pword'))
            {
                $errors['pword'] = 'Password is required!';
            }
            if(!$this->input->post('login'))
            {
                $errors['login'] = 'Login is required!';
            }
            if(!$errors)
            {
                if(!$this->auth($this->input->post('login'), $this->input->post('pword')))
                {
                    $errors[] = 'Incorrect Login or\\and password!';
                }
            }
            $this->session->set_flashdata('danger', ['title' => 'Ошибка!', 'text' => implode('<br><br>', $errors)]);
            $data = array_merge($data, $this->input->post());
            $data['errors'] = $errors;
        }


        $this->render_view('index', [], $data, $this->module);
    }


    private function auth($login, $password)
    {
        $this->load->model('users_model');
        $user = $this->users_model->get_auth_user($login, $password);
        if(!$user) return false;
        $this->session->set_userdata('logged_in', TRUE);
        redirect(base_url('admin'));


    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url($this->module));
    }

} 