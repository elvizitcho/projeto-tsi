<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historico extends CI_Controller {

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

    public function list() {
        $this->load->model('Historico_Model', 'model');

        $inicio = $this->input->post('inicio') ? $this->input->post('inicio') : date('Y-m-d H:i:s');
        $fim    = $this->input->post('fim')    ? $this->input->post('fim')    : date('Y-m-d H:i:s');
        $valor  = $this->input->post('valor')  ? $this->input->post('valor')  : 1;

        die(json_encode(array(
            'sucesso' => true,
            'dados'   => $this->model->list($inicio, $fim, $valor)
        )));
    }
}
