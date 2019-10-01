<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EstadoCasa_mdl extends CI_Model{

    public function todos()
    {
        $this->db->from('cat_estatus');
        $this->db->where('tipo_estatus_id', 1);
        return $this->db->get()->result();
    }


}

?>