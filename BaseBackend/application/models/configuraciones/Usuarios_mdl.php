<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_mdl extends CI_Model{
    private $pagination;
    public function __construct()
    {
        $this->load->library('Pagination_lib');
        $this->pagination = new Pagination_lib();
    }
    public function getAll($request = [])
    {
        $this->db->select('u.*,p.nombre as perfil');
        $this->db->from('usuarios as u');
        $this->db->join('perfiles as p','p.id=u.perfil_id','left');
        $this->db->where('u.estatus',1);
        $columns = [
            "u.id",
            "u.username",
            "u.correo",
            "p.nombre"
        ];
        $order = [
            "u.id",
            "u.username",
            "u.correo",
            "p.nombre"
        ];
        $this->pagination->render($request,$columns,$order);
        $result = $this->db->get()->result();

        $this->db->select("COUNT(u.id) as total");
        $this->db->from('usuarios as u');
        $this->db->join('perfiles as p','p.id=u.perfil_id','left');
        $this->db->where('u.estatus',1);
        $this->pagination->render_count($request,$columns);
        $result2 = $this->db->get()->row();
        return $this->pagination->response($request,$result,$result2->total);
    }
    public function getDetalle($id=0)
    {
        $this->db->from('usuarios');
        $this->db->where('id',$id);
        return $this->db->get()->row();
    }
    public function getUsuarioExiste($correo='',$id = '')
    {
        $this->db->select("COUNT(*) as total");
        $this->db->from('usuarios');
        $this->db->where('correo',$correo);
        if(!empty($id)){
            $this->db->where('id !=',$id);
        }
        return $this->db->get()->row()->total;
    }
    public function setUsuario($request = [],$password = '')
    {
        $request['fecha_creacion'] = date('Y-m-d H:i:s');
        $request['estatus'] = 1;
        $request['password']= $password;
        return $this->db->insert('usuarios',$request);
    }
    public function setUsuarioPermisos($id,$request = [])
    {
        $this->db->trans_start();
        $this->db->where('usuario_id',$id);
        $this->db->delete('usuarios_permisos');
        foreach($request['permisos'] as $val){
            $this->db->insert('usuarios_permisos',array(
                'usuario_id'=>$id,
                'permiso_id'=>$val
            ));
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    public function setActualizarUsuario($id,$request = [])
    {
        $this->db->where('id',$id);
        $request['fecha_actualizacion'] = date('Y-m-d H:i:s');
        $this->db->set($request);
        return $this->db->update('usuarios');
    }
    public function setEliminarUsuario($id)
    {
        $this->db->where('id',$id);
        $this->db->set(array(
            'fecha_actualizacion'=>date('Y-m-d H:i:s'),
            'estatus'=>0
        ));
        return $this->db->update('usuarios');
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
    public function __destruct()
    {
        
    }
}

?>