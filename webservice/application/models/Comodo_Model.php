<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comodo_Model extends CI_Model {

    public function create($data) {
        return $this->db->insert('comodos', $data) ? $this->db->insert_id() : false;
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)
        				->update('comodos', $data);
    }

    public function list($page, $size, $filter) {
    	return $this->db->select('id, nome')
    					->where('status', 1)
        				->group_start()
    						->where('id', $filter)
    						->or_like('nome', $filter)
						->group_end()
    					->from('comodos')
    					->limit($size, $page * $size)
    					->get()
    					->result();
    }

    public function detalhes($id) {
    	return $this->db->select('id, nome')
    					->where('status', 1)
						->where('id', $id)
    					->from('comodos')
    					->get()
    					->first_row();
    }
}
