<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth {
    protected $CI;

    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
            // Assign the CodeIgniter super-object
            $this->CI =& get_instance();
            $this->CI->load->library("form_validation");
    }

    public function authenticate($authorization)
    {
        $data = explode(' ',$authorization);
        if(count($data)>1 && !empty($data[1])){
            $token = $this->CI->encryption->decrypt($data[1]);
            $elements = explode(' ',$token);
            $this->CI->db->select('COUNT(*) as total');
            $this->CI->db->from('usuarios');
            $this->CI->db->where(array(
                'id'=>$elements[0],
                'correo'=>$elements[1],
                'token_expiracion >'=>date('Y-m-d H:i:s')
            ));
            if($this->CI->db->get()->row()->total>0){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function permisos($authorization)
    {
        $data = explode(' ',$authorization);
        if(count($data)>1 && !empty($data[1])){
            $token = $this->CI->encryption->decrypt($data[1]);
            $elements = explode(' ',$token);
            $this->CI->db->select('COUNT(*) as total');
            $this->CI->db->from('usuarios_permisos');
            $this->CI->db->where(array(
                'usuario_id'=>$elements[0]
            ));
            if($this->CI->db->get()->row()->total>0){
                return $this->permisos_usuario($elements[0]);
            }else{
                return $this->permisos_perfiles($elements[0]);;
            }
        }else{
            return [];
        }
    }
    private function permisos_usuario($usuario_id)
    {
        $this->CI->db->from('usuarios_permisos');
        $this->CI->db->where(array(
            'usuario_id'=>$usuario_id
        ));
        return $this->CI->db->get()->result();
    }
    private function permisos_perfiles($usuario_id)
    {
        $this->CI->db->from('usuarios');
        $this->CI->db->where(array(
            'id'=>$usuario_id
        ));
        $usuario = $this->CI->db->get()->row();

        $this->CI->db->from('perfiles_permisos');
        $this->CI->db->where(array(
            'perfil_id'=>$usuario->perfil_id
        ));
        return $this->CI->db->get()->result();
    }
}
