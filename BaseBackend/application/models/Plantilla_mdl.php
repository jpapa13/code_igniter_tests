<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plantilla_mdl extends CI_Model{
    private $pagination;
    public function __construct()
    {
        $this->load->library('Pagination_lib');
        $this->pagination = new Pagination_lib();
    }
    public function getObtenerUno($request)
    {
        $this->db->from('tabla');
        $this->db->where('columna','valor');
        return $this->db->get()->row();
    }
    public function getObtenerTodos($request)
    {
        $this->db->from('tabla');
        $this->db->where('columna','valor');
        return $this->db->get()->result();
    }
    public function getTabla($request)
    {
        //OBTIENE LOS DATOS DE LA TABLA
        $this->db->select('*');
        $this->db->from('tabla');
        $columns = [
            "nombre",
            "correo"
        ];
        $order = [
            "nombre",
            "correo"
        ];
        $this->pagination->render($request,$columns,$order);
        $result = $this->db->get()->result();

        $this->db->select("COUNT(*) as total");
        $this->db->from('tabla');
        $this->pagination->render_count($request,$columns);
        $result2 = $this->db->get()->row();
        return $this->pagination->response($request,$result,$result2->total);
    }
    public function setInsertar()
    {
        return $this->db->insert('tabla',array(
            'columna1'=>'valor1',
            'columna2'=>'valor2',
            'columna3'=>'valor3'
        ));
    }
    public function setActualizar()
    {
        $this->db->where('columna','valor');
        $this->db->set(array(
            'columna1'=>'valor1',
            'columna2'=>'valor2',
            'columna3'=>'valor3'
        ));
        return $this->db->update('tabla');
    }
    public function setEliminar()
    {
        $this->db->where('columna','valor');
        return $this->db->delete('tabla');
    }
    public function setTransaccion()
    {
        $this->db->trans_start();
        $this->setInsertar();
        $this->setActualizar();
        $this->setEliminar();
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    public function __destruct()
    {
        
    }
}

?>