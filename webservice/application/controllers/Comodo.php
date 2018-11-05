<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comodo extends CI_Controller {

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
        $this->form_validation->set_rules('nome', 'Nome', 'required|min_length[2]|max_length[64]');

        if ($this->form_validation->run() == FALSE) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => validation_errors('<p class="red-text text-darken-2">', '</p>')
            )));
        }

        $comodo = array(
            'nome'      => $this->input->post('nome'),
            'status'    => 1
        );

        $this->load->model('Comodo_Model', 'model');

        $idComodo = $this->model->create($comodo);

        if ($idComodo == false) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => 'Falha ao salvar cômodo no banco de dados'
            )));
        } else {
            die(json_encode(array(
                'sucesso'  => true,
                'id'       => $idComodo
            )));
        }
    }

    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'required|is_natural');
        $this->form_validation->set_rules('nome', 'Nome', 'required|min_length[2]|max_length[64]');

        if ($this->form_validation->run() == FALSE) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => validation_errors('<p class="red-text text-darken-2">', '</p>')
            )));
        }

        $comodo = array(
            'nome'      => $this->input->post('nome'),
            'status'    => 1
        );

        $this->load->model('Comodo_Model', 'model');

        if ($this->model->update($this->input->post('id'), $comodo) == false) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => 'Falha ao atualizar cômodo no banco de dados'
            )));
        } else {
            die(json_encode(array(
                'sucesso'  => true
            )));
        }
    }

    public function list() {
        $this->load->model('Comodo_Model', 'model');

        $page   = $this->input->post('page') == null ? 0 : $this->input->post('page');
        $size   = $this->input->post('size') == null ? 10 : $this->input->post('size');
        $filter = $this->input->post('filter') == null ? '' : $this->input->post('filter');

        die(json_encode(array(
            'sucesso' => true,
            'dados'   => $this->model->list($page, $size, $filter)
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

        $this->load->model('Comodo_Model', 'model');

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

        $comodo = array(
            'status' => 0
        );

        $this->load->model('Comodo_Model', 'model');

        if ($this->model->update($this->input->post('id'), $comodo) == false) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => 'Falha ao atualizar cômodo no banco de dados'
            )));
        } else {
            die(json_encode(array(
                'sucesso'  => true
            )));
        }
    }
}
