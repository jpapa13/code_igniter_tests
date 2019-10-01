<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CodigoPostal_mdl extends CI_Model{

    public function todos($cp)
    {
        $this->db->from('cat_asentamientos');
        $this->db->where('cp',$cp);
        return $this->db->get()->row();
    }

}

?>