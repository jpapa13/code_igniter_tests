<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Municipio_mdl extends CI_Model{

    public function todos($dato)
    {
        $this->db->from('cat_municipios');
        $this->db->where('estado_id',$dato);
        $this->db->order_by('nombre','asc');
        return $this->db->get()->result();
    }

}

?>