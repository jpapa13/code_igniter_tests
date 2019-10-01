<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfiles_mdl extends CI_Model{
    private $pagination;
    public function __construct()
    {
        $this->load->library('Pagination_lib');
        $this->pagination = new Pagination_lib();
    }
    public function getPermisosExisten($request)
    {
        $existen_todos = true;
        foreach($request['permisos'] as $v){
            $this->db->select('COUNT(*) as total');
            $this->db->from('permisos');
            $this->db->where('id',$v);
            if($this->db->get()->row()->total==0){
                $existen_todos = false;
                break;
            }
        }        
        return $existen_todos;
    }
    public function getAll($request = [])
    {
        $this->db->select('*');
        $this->db->from('perfiles');
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
        $this->db->from('perfiles');
        $this->db->where('estatus',1);
        $this->pagination->render_count($request,$columns);
        $result2 = $this->db->get()->row();
        return $this->pagination->response($request,$result,$result2->total);
    }
    public function getPerfilesPermisos($request = [])
    {
        $this->db->select('*');
        $this->db->from('perfiles_permisos');
        $this->db->where('perfil_id',$request['perfil_id']);
        return $this->db->get()->result();
    }
    public function all()
    {
        $this->db->from('perfiles');
        return $this->db->get()->result();
    }
    public function getDetalle($id=0)
    {
        $this->db->from('perfiles');
        $this->db->where('id',$id);
        $perfil = $this->db->get()->row();
        $this->db->from('perfiles_permisos');
        $this->db->where('perfil_id',$perfil->id);
        $permisos = $this->db->get()->result();
        $permisos_lista = [];
        foreach($permisos as $val){
            $permisos_lista[] = $val->permiso_id;
        }
        $perfil->{'permisos'} = $permisos_lista;
        return $perfil;
    }
    public function setPerfil($request = [])
    {
        unset($request['id']);
        unset($request['permisos']);
        $request['fecha_creacion'] = date('Y-m-d H:i:s');
        $request['estatus'] = 1;
        $this->db->insert('perfiles',$request);
        return $this->db->insert_id();
    }
    public function setPerfilPermisos($id,$request = [])
    {
        $this->db->trans_start();
        $this->db->where('perfil_id',$id);
        $this->db->delete('perfiles_permisos');
        foreach($request['permisos'] as $val){
            $this->db->insert('perfiles_permisos',array(
                'perfil_id'=>$id,
                'permiso_id'=>$val
            ));
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    public function setActualizarPerfil($id,$request = [])
    {
        unset($request['permisos']);
        $this->db->where('id',$id);
        $request['fecha_actualizacion'] = date('Y-m-d H:i:s');
        $this->db->set($request);
        return $this->db->update('perfiles');
    }
    public function setEliminarPerfil($id)
    {
        $this->db->where('id',$id);
        $this->db->set(array(
            'fecha_actualizacion'=>date('Y-m-d H:i:s'),
            'estatus'=>0
        ));
        return $this->db->update('perfiles');
    }
    public function __destruct()
    {
        
    }
}

?>