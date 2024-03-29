<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lugares_mdl extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }
    public function archivos_todos($sede,$tipo)
    {   
        $this->db->select("a.ruta");
        $this->db->from('lugar as l');
        $this->db->join('galeria_lugar as g_l','l.id = g_l.lugar_fk','inner');
        $this->db->join('archivo as a','g_l.archivo_fk = a.id','inner');
        $this->db->join('tipo_archivo_cat as t_a','a.tipo_fk = t_a.id','inner');
        $this->db->where(array(
            't_a.tipo'=>$tipo,
            'l.nombre'=>$sede
        ));
        return $this->db->get()->result();
    }
    
    public function __destruct()
    {
        
    }
}

?>