<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dispositivo_Model extends CI_Model {

    public function create($data) {
        return $this->db->insert('dispositivos', $data) ? $this->db->insert_id() : false;
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)
        				->update('dispositivos', $data);
    }

    public function list($page, $size, $filter, $comodo = null) {
    	$this->db->select('dispositivos.id, dispositivos.nome, comodos.id as comodo_id, comodos.nome as comodo_nome')
                        ->join('comodos', 'comodos.id = dispositivos.comodo_id')
    					->where('comodos.status', 1)
    					->where('dispositivos.status', 1)
        				->group_start()
    						->where('dispositivos.id', $filter)
    						->or_like('dispositivos.nome', $filter)
    						->or_like('comodos.nome', $filter)
						->group_end();

        if ($comodo != null) {
            $this->db->where('comodo_id', $comodo);
        }

    	return $this->db->from('dispositivos')
    					->limit($size, $page * $size)
    					->get()
    					->result();
    }

    public function detalhes($id) {
    	return $this->db->select('*')
    					->where('status', 1)
						->where('id', $id)
    					->from('dispositivos')
    					->get()
    					->first_row();
    }
}
