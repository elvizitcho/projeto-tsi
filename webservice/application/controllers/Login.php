<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {
        if ($this->session->has_userdata('id')) {
            redirect('');
        }

        $this->load->view('login/login');
    }

    public function validaLogin() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('usuario', 'Usuário', 'required|min_length[5]|max_length[32]');
        $this->form_validation->set_rules('senha', 'Senha', 'required|min_length[5]|max_length[32]');

        if ($this->form_validation->run() == FALSE) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => validation_errors('<p class="red-text text-darken-2">', '</p>')
            )));
        }

        $this->load->model('Login_Model', 'model');

        $dadosUsuario = $this->model->validaLogin(
            $this->input->post('usuario'),
            $this->input->post('senha')
        );

        if ($dadosUsuario == null) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => 'Dados não conferem'
            )));
        }

        die(json_encode(array(
            'sucesso'  => true,
            'dados_usuario' => $dadosUsuario
        )));
    }
}
