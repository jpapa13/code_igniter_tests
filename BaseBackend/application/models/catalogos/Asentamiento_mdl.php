<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asentamiento_mdl extends CI_Model{

    public function todos($codigo_postal)
    {
        $this->db->from('cat_asentamientos');
        $this->db->where('cp',$codigo_postal);
        $this->db->order_by('nombre','asc');
        return $this->db->get()->result();
    }

}

?>