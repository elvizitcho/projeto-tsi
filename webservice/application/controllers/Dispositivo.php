<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dispositivo extends CI_Controller {

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
        $this->form_validation->set_rules('comodo_id', 'Cômodo', 'required|is_natural');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required|in_list[1,2]');
        $this->form_validation->set_rules('potencia', 'Potência', 'required|numeric');
        $this->form_validation->set_rules('porta', 'Porta', 'required|is_natural');

        if ($this->form_validation->run() == FALSE) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => validation_errors('<p class="red-text text-darken-2">', '</p>')
            )));
        }

        $dispositivo = array(
            'nome'      => $this->input->post('nome'),
            'comodo_id' => $this->input->post('comodo_id'),
            'tipo'      => $this->input->post('tipo'),
            'potencia'  => $this->input->post('potencia'),
            'porta'     => $this->input->post('porta'),
            'status'    => 1
        );

        $this->load->model('Dispositivo_Model', 'model');

        $idDispositivo = $this->model->create($dispositivo);

        if ($idDispositivo == false) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => 'Falha ao salvar dispositivo no banco de dados'
            )));
        } else {
            die(json_encode(array(
                'sucesso'  => true,
                'id'       => $idDispositivo
            )));
        }
    }

    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'required|is_natural');
        $this->form_validation->set_rules('nome', 'Nome', 'required|min_length[2]|max_length[64]');
        $this->form_validation->set_rules('comodo_id', 'Cômodo', 'required|is_natural');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required|in_list[1,2]');
        $this->form_validation->set_rules('potencia', 'Potência', 'required|numeric');
        $this->form_validation->set_rules('porta', 'Porta', 'required|is_natural');

        if ($this->form_validation->run() == FALSE) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => validation_errors('<p class="red-text text-darken-2">', '</p>')
            )));
        }

        $dispositivo = array(
            'nome'      => $this->input->post('nome'),
            'comodo_id' => $this->input->post('comodo_id'),
            'tipo'      => $this->input->post('tipo'),
            'potencia'  => $this->input->post('potencia'),
            'porta'     => $this->input->post('porta'),
            'status'    => 1
        );

        $this->load->model('Dispositivo_Model', 'model');

        if ($this->model->update($this->input->post('id'), $dispositivo) == false) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => 'Falha ao atualizar o dispositivo no banco de dados'
            )));
        } else {
            die(json_encode(array(
                'sucesso'  => true
            )));
        }
    }

    public function list() {
        $this->load->model('Dispositivo_Model', 'model');

        $page          = $this->input->post('page') == null ? 0 : $this->input->post('page');
        $size          = $this->input->post('size') == null ? 10 : $this->input->post('size');
        $filter        = $this->input->post('filter') == null ? '' : $this->input->post('filter');
        $comodoId      = $this->input->post('comodo_id');

        die(json_encode(array(
            'sucesso' => true,
            'dados'   => $this->model->list($page, $size, $filter, $comodoId)
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

        $this->load->model('Dispositivo_Model', 'model');

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

        $this->load->model('Dispositivo_Model', 'model');

        if ($this->model->update($this->input->post('id'), $comodo) == false) {
            die(json_encode(array(
                'sucesso'  => false,
                'mensagem' => 'Falha ao atualizar o dispositivo no banco de dados'
            )));
        } else {
            die(json_encode(array(
                'sucesso'  => true
            )));
        }
    }

    public function ligar() {
        echo 'Em construção...';
    }

    public function desligar() {
        echo 'Em construção...';
    }
}
