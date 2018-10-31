<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_Model extends CI_Model {

	public function verificaPermissao($permissao) {
		return $this->db->where('permissao', $permissao)
		                ->get('usuarios')
		                ->first_row();
	}

    public function validaLogin($usuario, $senha) {
        return $this->db->select('id, nome, usuario, permissao')
                        ->where('usuario', $usuario)
                        ->where('senha', md5($senha))
                        ->where('status', 1)
                        ->from('usuarios')
                        ->get()
                        ->first_row();
    }
}
