<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carrera_mdl extends CI_Model{

    public function todos()
    {
        $this->db->from('carrera_cat');
        return $this->db->get()->result();
    }

}

?>