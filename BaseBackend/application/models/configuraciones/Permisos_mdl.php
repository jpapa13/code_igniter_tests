<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permisos_mdl extends CI_Model{
    private $pagination;
    public function __construct()
    {
        $this->load->library('Pagination_lib');
        $this->pagination = new Pagination_lib();
    }
    public function getAll($request = [])
    {
        $this->db->select('*');
        $this->db->from('permisos');
        $this->db->where('estatus',1);
        $columns = [
            "id",
            "nombre",
            "descripcion"
        ];
        $order = [
            "id",
            "nombre",
            "descripcion"
        ];
        $this->pagination->render($request,$columns,$order);
        $result = $this->db->get()->result();

        $this->db->select("COUNT(*) as total");
        $this->db->from('permisos');
        $this->db->where('estatus',1);
        $this->pagination->render_count($request,$columns);
        $result2 = $this->db->get()->row();
        return $this->pagination->response($request,$result,$result2->total);
    }
    public function getDetalle($id=0)
    {
        $this->db->from('permisos');
        $this->db->where('id',$id);
        return $this->db->get()->row();
    }
    public function setPermiso($request = [])
    {
        $request['fecha_creacion'] = date('Y-m-d H:i:s');
        $request['estatus'] = 1;
        return $this->db->insert('permisos',$request);
    }
    public function setActualizarPermiso($id,$request = [])
    {
        $this->db->where('id',$id);
        $request['fecha_actualizacion'] = date('Y-m-d H:i:s');
        $this->db->set($request);
        return $this->db->update('permisos');
    }
    public function setEliminarPermiso($id)
    {
        $this->db->where('id',$id);
        $this->db->set(array(
            'fecha_actualizacion'=>date('Y-m-d H:i:s'),
            'estatus'=>0
        ));
        return $this->db->update('permisos');
    }
    public function __destruct()
    {
        
    }
}

?>