<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TipoLugar_mdl extends CI_Model{

    public function todos()
    {
        $this->db->from('tipo_lugar_cat');
        return $this->db->get()->result();
    }

}

?>