<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EstadoCivil_mdl extends CI_Model{

    public function todos()
    {
        $this->db->from('cat_estado_civil');
        return $this->db->get()->result();
    }


}

?>