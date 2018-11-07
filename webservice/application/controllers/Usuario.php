<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Login_Model', 'loginModel');

        $this->usuario = $this->loginModel->verificaPermissao($this->input->post('permissao'));

        if ($this->usuario == null) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => 'Sem permissão'
            )));
        }
    }

    public function create() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome', 'Nome', 'required|min_length[5]|max_length[128]');
        $this->form_validation->set_rules('usuario', 'Usuário', 'required|min_length[5]|max_length[32]|is_unique[usuarios.usuario]');
        $this->form_validation->set_rules('senha', 'Senha', 'required|min_length[5]|max_length[32]');

        if ($this->form_validation->run() == FALSE) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => validation_errors('<p class="red-text text-darken-2">', '</p>')
            )));
        }

        $usuario = array(
            'nome'      => $this->input->post('nome'),
            'usuario'   => $this->input->post('usuario'),
            'senha'     => md5($this->input->post('senha')),
            'status'    => 1,
            'permissao' => uniqid()
        );

        $this->load->model('Usuario_Model', 'model');

        $idUsuario = $this->model->create($usuario);

        if ($idUsuario == false) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => 'Falha ao salvar usuário no banco de dados'
            )));
        } else {
            die(json_encode(array(
                'sucesso'  => true,
                'id'       => $idUsuario
            )));
        }
    }

    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'required|is_natural');
        $this->form_validation->set_rules('nome', 'Nome', 'required|min_length[5]|max_length[128]');

        $usuario = $this->db->select('usuario')
                             ->from('usuarios')
                             ->where('id', $this->input->post('id'))
                             ->get()
                             ->first_row();

        $uniq = $usuario != null && $usuario->usuario != $this->input->post('usuario') ? '|is_unique[usuarios.usuario]' : '';

        $this->form_validation->set_rules('usuario', 'Usuário', 'required|min_length[5]|max_length[32]' . $uniq);
        $this->form_validation->set_rules('senha', 'Senha', 'min_length[5]|max_length[32]');

        if ($this->form_validation->run() == FALSE) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => validation_errors('<p class="red-text text-darken-2">', '</p>')
            )));
        }

        $usuario = array(
            'nome'      => $this->input->post('nome'),
            'usuario'   => $this->input->post('usuario'),
            'status'    => 1
        );

        if ($this->input->post('senha') != null) {
            $usuario['senha'] = md5($this->input->post('senha'));
        }

        $this->load->model('Usuario_Model', 'model');

        $idUsuario = $this->model->update($this->input->post('id'), $usuario);

        if ($idUsuario == false) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => 'Falha ao salvar usuário no banco de dados'
            )));
        } else {
            die(json_encode(array(
                'sucesso'  => true
            )));
        }
    }

    public function list() {
        $this->load->model('Usuario_Model', 'model');

        $filter = $this->input->post('filter') == null ? '' : $this->input->post('filter');

        die(json_encode(array(
            'sucesso' => true,
            'dados'   => $this->model->list($filter)
        )));
    }

    public function detalhes() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'required|is_natural');

        if ($this->form_validation->run() == FALSE) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => validation_errors('<p class="red-text text-darken-2">', '</p>')
            )));
        }

        $id = $this->input->post('id');

        $this->load->model('Usuario_Model', 'model');

        die(json_encode(array(
            'sucesso' => true,
            'dados'   => $this->model->detalhes($id)
        )));
    }

    public function deletar() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'required|is_natural');

        if ($this->form_validation->run() == FALSE) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => validation_errors('<p class="red-text text-darken-2">', '</p>')
            )));
        }

        $usuario = array(
            'status' => 0
        );

        $this->load->model('Usuario_Model', 'model');

        $idUsuario = $this->model->update($this->input->post('id'), $usuario);

        if ($idUsuario == false) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => 'Falha ao salvar usuário no banco de dados'
            )));
        } else {
            die(json_encode(array(
                'sucesso'  => true
            )));
        }
    }

    public function createToken() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome', 'Nome', 'required|min_length[5]|max_length[128]');

        if ($this->form_validation->run() == FALSE) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => validation_errors('<p class="red-text text-darken-2">', '</p>')
            )));
        }

        $usuario = array(
            'nome'      => $this->input->post('nome'),
            'token'     => uniqid(),
            'status'    => 1,
            'permissao' => uniqid()
        );

        $this->load->model('Usuario_Model', 'model');

        $idUsuario = $this->model->create($usuario);

        if ($idUsuario == false) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => 'Falha ao salvar usuário no banco de dados'
            )));
        } else {
            die(json_encode(array(
                'sucesso'  => true,
                'id'       => $idUsuario
            )));
        }
    }

    public function updateToken() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'required|is_natural');
        $this->form_validation->set_rules('nome', 'Nome', 'required|min_length[5]|max_length[128]');

        if ($this->form_validation->run() == FALSE) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => validation_errors('<p class="red-text text-darken-2">', '</p>')
            )));
        }

        $usuario = array(
            'nome'      => $this->input->post('nome'),
            'status'    => 1
        );

        $this->load->model('Usuario_Model', 'model');

        $idUsuario = $this->model->update($this->input->post('id'), $usuario);

        if ($idUsuario == false) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => 'Falha ao salvar usuário no banco de dados'
            )));
        } else {
            die(json_encode(array(
                'sucesso'  => true
            )));
        }
    }

}
