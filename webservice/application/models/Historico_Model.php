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

    public function list($inicio, $fim, $valor) {
        return $this->db->select('dispositivo.nome                                       AS dispositivo_nome,
                                  comodo.nome                                            AS comodo_nome,
                                  COALESCE(SUM(historico.consumo), 0)                    AS consumo,
                                  (COALESCE(SUM(historico.consumo), 0) * ' . $valor . ') AS valor')
                        ->from('dispositivos AS dispositivo')
                        ->join('comodos AS comodo', 'comodo.id = dispositivo.comodo_id')
                        ->join('historico AS historico', 'historico.dispositivo_id = dispositivo.id
                                                          AND DATE(historico.inicio) >= "' . $inicio . '"
                                                          AND DATE(historico.fim) <= "' . $fim . '"', 'LEFT')
                        ->group_by('dispositivo.id')
                        ->get()
                        ->result();
    }

}
