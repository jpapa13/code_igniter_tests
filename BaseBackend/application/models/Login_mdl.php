<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_mdl extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }
    public function buscarUsuario($correo,$password)
    {
        $this->db->select("usuarios.*,perfiles.nombre as perfil_nombre");
        $this->db->from('usuarios');
        $this->db->join('perfiles','usuarios.perfil_id=perfiles.id','left');
        $this->db->where(array(
            'usuarios.correo'=>$correo,
            'usuarios.estatus'=>1
        ));
        $usuario = $this->db->get()->row();
        if(!empty($usuario) && isset($usuario->correo) && !empty($usuario->correo)){
            $password_db = $this->encryption->decrypt($usuario->password);
            if($password_db == $password){
                return $this->generarToken($usuario);
            }
        }
        return false;
    }
    public function terminarSesion($id)
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('usuarios');
        $this->db->where('id',$id);
        if($this->db->get()->row()->total>0){
            $this->db->where('id',$id);
            $this->db->set(array(
                'token'=>NULL,
                'token_expiracion'=>NULL
            ));
            return $this->db->update('usuarios');
        }else{
            return false;
        }
    }
    public function generarToken($usuario)
    {
        $token = $usuario->id.' '.$usuario->correo;
        $token_encriptado = $this->encryption->encrypt($token);
        $fecha_expiracion = modificacionFecha(date('Y-m-d H:i:s'),$this->config->item('sess_expiration'),'second','+');

        $this->db->where('id',$usuario->id);
        $this->db->set(array(
            'token'=>$token_encriptado,
            'token_expiracion'=>$fecha_expiracion
        ));
        if($this->db->update('usuarios')){
            $respuesta = array(
                'id'=>$usuario->id,
                'correo'=>$usuario->correo,
                'perfil_nombre'=>$usuario->perfil_nombre,
                'token'=>$token_encriptado,
                'token_expiracion'=>$fecha_expiracion
            );
            return $respuesta;
        }else{
            return FALSE;
        }
    }
    public function __destruct()
    {
        
    }
}

?>