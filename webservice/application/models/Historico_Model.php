<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historico_Model extends CI_Model {

    public function create($data) {
        return $this->db->insert('historico', $data) ? $this->db->insert_id() : false;
    }

    public function update($data) {
        return $this->db->where('fim', null)
                        ->where('dispositivo_id', $data['dispositivo_id'])
                        ->update('historico', $data);
    }

    public function getUltimoHistoricoDispositivo($dispositivoId) {
        return $this->db->select('*')
                        ->where('fim', null)
                        ->where('dispositivo_id', $dispositivoId)
                        ->from('historico')
                        ->get()
                        ->first_row();
    }

}
