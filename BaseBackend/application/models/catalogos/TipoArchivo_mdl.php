<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TipoArchivo_mdl extends CI_Model{

    public function todos()
    {
        $this->db->from('tipo_archivo_cat');
        return $this->db->get()->result();
    }

}

?>