<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estado_mdl extends CI_Model{

    public function todos()
    {
        $this->db->from('cat_estados');
        return $this->db->get()->result();
    }

}

?>