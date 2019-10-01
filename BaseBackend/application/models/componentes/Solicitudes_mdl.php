<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitudes_mdl extends CI_Model{
    private $pagination;
    public function __construct()
    {
        $this->load->library('Pagination_lib');
        $this->pagination = new Pagination_lib();
    }

    public function todos($request)
    {
        $columns = ['id','cliente_id','nombre_completo','nombre_empresa','bien','especificar_bien','costo_bien','fecha_captura','nombre_promotor','nombre_distribuidor','estatus','fecha_estatus','tipo_persona'];
        $order = ['id','cliente_id','nombre_completo','nombre_empresa','bien','especificar_bien','costo_bien','fecha_captura','nombre_promotor','nombre_distribuidor','estatus','fecha_estatus','tipo_persona'];

        
        $this->db->select("*");
        $this->db->from('lista_solicitudes');
        $this->pagination->render($request,$columns,$order);
        if(isset($request['filtro']) && $request['filtro']!=''){
            $this->db->where('id',$request['filtro']);
        }
        $result = $this->db->get()->result();
        
        $this->db->select("COUNT(*) as total");
        $this->db->from('lista_solicitudes');
        $this->pagination->render_count($request,$columns);
        if(isset($request['filtro']) && $request['filtro']!=''){
            $this->db->where('id',$request['filtro']);
        }
        $result2 = $this->db->get()->row();
        return $this->pagination->response($request,$result,$result2->total);
    }



}

?>