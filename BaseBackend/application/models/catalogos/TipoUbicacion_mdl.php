<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TipoUbicacion_mdl extends CI_Model{

    public function todos()
    {
        $this->db->from('cat_ubicacion_negocio');
        return $this->db->get()->result();
    }


}

?>