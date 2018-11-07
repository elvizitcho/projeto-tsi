<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_Model extends CI_Model {

    public function create($data) {
        return $this->db->insert('usuarios', $data) ? $this->db->insert_id() : false;
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)
        				->update('usuarios', $data);
    }

    public function list($filter) {
        return $this->db->select('id, nome, usuario')
                        ->where('status', 1)
                        ->group_start()
                            ->where('id', $filter)
                            ->or_like('nome', $filter)
                            ->or_like('usuario', $filter)
                        ->group_end()
                        ->from('usuarios')
                        ->get()
                        ->result();
    }

    public function detalhes($id) {
    	return $this->db->select('id, nome, usuario')
    					->where('status', 1)
						->where('id', $id)
    					->from('usuarios')
    					->get()
    					->first_row();
    }
}
