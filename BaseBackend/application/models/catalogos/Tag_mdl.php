<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag_mdl extends CI_Model{

    public function todos()
    {
        $this->db->from('tag_cat');
        return $this->db->get()->result();
    }

}

?>