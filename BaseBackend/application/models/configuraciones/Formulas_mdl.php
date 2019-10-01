<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formulas_mdl extends CI_Model{
    private $pagination;
    public function __construct()
    {
        $this->load->library('Pagination_lib');
        $this->pagination = new Pagination_lib();
    }
    public function agregarVariable($datos)
    {
        $insert = array(
            'estatus'=>1,
            'fecha_creacion'=>date('Y-m-d H:i:s'),
            'nombre'=>$datos['nombre'],
            'valor'=>$datos['valor'],
            'parametro_usuario'=>$datos['parametro_usuario']
        );
        return $this->db->insert('config_variables',$insert);
    }
    public function agregarFuncion($datos)
    {
        $insert = array(
            'estatus'=>1,
            'fecha_creacion'=>date('Y-m-d H:i:s'),
            'nombre'=>$datos['nombre']
        );
        return $this->db->insert('config_funciones',$insert);
    }
    public function agregarBloque($datos)
    {
        $insert = array(
            'estatus'=>1,
            'fecha_creacion'=>date('Y-m-d H:i:s'),
            'nombre'=>$datos['nombre']
        );
        return $this->db->insert('config_bloques',$insert);
    }
    public function agregarEstructuraControl($datos)
    {
        $insert = array(
            'estatus'=>1,
            'fecha_creacion'=>date('Y-m-d H:i:s'),
            'nombre'=>$datos['nombre']
        );
        return $this->db->insert('config_estructura_control',$insert);
    }
    public function actualizarVariable($datos,$id)
    {
        $update = array(
            'usuario_id_actualizacion'=>1,
            'fecha_actualizacion'=>date('Y-m-d H:i:s'),
            'nombre'=>$datos['nombre'],
            'valor'=>$datos['valor'],
            'parametro_usuario'=>$datos['parametro_usuario'],
            'catalogo'=>$datos['catalogo'],
            'catalogo_columna'=>$datos['catalogo_columna']
        );
        $this->db->where('id',$id);
        $this->db->set($update);
        return $this->db->update('config_variables');
    }
    public function actualizarFuncion($datos,$id)
    {
        $update = array(
            'usuario_id_actualizacion'=>1,
            'fecha_actualizacion'=>date('Y-m-d H:i:s'),
            'nombre'=>$datos['nombre'],
            'valor'=>$datos['valor'],
            'funcion'=>$datos['funcion']
        );
        $this->db->where('id',$id);
        $this->db->set($update);
        return $this->db->update('config_funciones');
    }
    public function actualizarBloque($datos,$id)
    {
        $update = array(
            'usuario_id_actualizacion'=>1,
            'fecha_actualizacion'=>date('Y-m-d H:i:s'),
            'nombre'=>$datos['nombre'],
            'variable_id_uno'=>$datos['variable_id_uno'],
            'bloque_id_uno'=>$datos['bloque_id_uno'],
            'estructura_control_id_uno'=>$datos['estructura_control_id_uno'],
            'funcion_id_uno'=>$datos['funcion_id_uno'],
            'variable_id_dos'=>$datos['variable_id_dos'],
            'bloque_id_dos'=>$datos['bloque_id_dos'],
            'estructura_control_id_dos'=>$datos['estructura_control_id_dos'],
            'funcion_id_dos'=>$datos['funcion_id_dos'],
            'condicion_id'=>$datos['condicion_id'],
        );
        $this->db->where('id',$id);
        $this->db->set($update);
        return $this->db->update('config_bloques');
    }
    public function actualizarEstructuraControl($datos,$id)
    {
        $update = array(
            'usuario_id_actualizacion'=>1,
            'fecha_actualizacion'=>date('Y-m-d H:i:s'),
            'nombre'=>$datos['nombre'],
            'condicion_variable_id'=>$datos['condicion_variable_id'],
            'condicion_bloque_id'=>$datos['condicion_bloque_id'],
            'condicion_estructura_control_id'=>$datos['condicion_estructura_control_id'],
            'condicion_funcion_id'=>$datos['condicion_funcion_id'],
            'verdadero_variable_id'=>$datos['verdadero_variable_id'],
            'verdadero_bloque_id'=>$datos['verdadero_bloque_id'],
            'verdadero_estructura_control_id'=>$datos['verdadero_estructura_control_id'],
            'verdadero_funcion_id'=>$datos['verdadero_funcion_id'],
            'falso_variable_id'=>$datos['falso_variable_id'],
            'falso_bloque_id'=>$datos['falso_bloque_id'],
            'falso_estructura_control_id'=>$datos['falso_estructura_control_id'],
            'falso_funcion_id'=>$datos['falso_funcion_id'],
        );
        $this->db->where('id',$id);
        $this->db->set($update);
        return $this->db->update('config_estructura_control');
    }
    public function guardarFormula($datos)
    {
        $this->db->trans_start();
        $this->almacenamientoRecursivo($datos);
        $this->db->trans_complete();
        return $this->db->trans_complete();
    }
    public function almacenamientoRecursivo($datos)
    {   
        if(isset($datos['tipo'])){
            switch($datos['tipo']){
                case 1:
                    $this->almacenamientoVariable($datos);
                    break;
                case 2:
                    $this->almacenamientoBloque($datos);
                    break;
                case 3:
                    $this->almacenamientoEstructuraControl($datos);
                    break;
                case 4:
                    $this->almacenamientoFuncion($datos);
                    break;
            }
        }
    }
    public function almacenamientoVariable($dato)
    {
        unset($dato['tipo']);
        if(empty($dato['id'])){
            $this->agregarVariable($dato);
            $dato['id'] = $this->db->insert_id();
        }
        $this->actualizarVariable($dato,$dato['id']);
        return $dato['id'];
    }
    public function almacenamientoFuncion($dato)
    {
        unset($dato['tipo']);
        unset($dato['arreglo']);
        if(empty($dato['id'])){
            $this->agregarFuncion($dato);
            $dato['id'] = $this->db->insert_id();
        }
        $this->actualizarFuncion($dato,$dato['id']);
        return $dato['id'];
    }
    public function almacenamientoBloque($dato)
    {
        if(!empty($dato['dato_var_uno'])){
            $dato['variable_id_uno'] = $this->almacenamientoVariable($dato['dato_var_uno']);
        }
        if(!empty($dato['dato_var_dos'])){
            $dato['variable_id_dos'] = $this->almacenamientoVariable($dato['dato_var_dos']);
        }
        if(!empty($dato['dato_bl_uno'])){
            $dato['bloque_id_uno'] = $this->almacenamientoBloque($dato['dato_bl_uno']);
        }
        if(!empty($dato['dato_bl_dos'])){
            $dato['bloque_id_dos'] = $this->almacenamientoBloque($dato['dato_bl_dos']);
        }
        if(!empty($dato['dato_es_uno'])){
            $dato['estructura_control_id_uno'] = $this->almacenamientoEstructuraControl($dato['dato_es_uno']);
        }
        if(!empty($dato['dato_es_dos'])){
            $dato['estructura_control_id_dos'] = $this->almacenamientoEstructuraControl($dato['dato_es_dos']);
        }
        if(!empty($dato['dato_fn_uno'])){
            $dato['funcion_id_uno'] = $this->almacenamientoFuncion($dato['dato_fn_uno']);
        }
        if(!empty($dato['dato_fn_dos'])){
            $dato['funcion_id_dos'] = $this->almacenamientoFuncion($dato['dato_fn_dos']);
        }
        unset($dato['tipo']);
        unset($dato['dato_var_uno']);
        unset($dato['dato_var_dos']);
        unset($dato['dato_bl_uno']);
        unset($dato['dato_bl_dos']);
        unset($dato['dato_es_uno']);
        unset($dato['dato_es_dos']);
        unset($dato['dato_fn_uno']);
        unset($dato['dato_fn_dos']);
        if(empty($dato['id'])){
            $this->agregarBloque($dato);                    
            $dato['id'] = $this->db->insert_id();
        }
        $this->actualizarBloque($dato,$dato['id']);
        return $dato['id'];
    }
    public function almacenamientoEstructuraControl($dato)
    {
        if(!empty($dato['cond_var'])){
            $dato['condicion_variable_id'] = $this->almacenamientoVariable($dato['cond_var']);
        }
        if(!empty($dato['cond_bl'])){
            $dato['condicion_bloque_id'] = $this->almacenamientoBloque($dato['cond_bl']);
        }
        if(!empty($dato['cond_es'])){
            $dato['condicion_estructura_control_id'] = $this->almacenamientoEstructuraControl($dato['cond_es']);
        }
        if(!empty($dato['cond_fn'])){
            $dato['condicion_funcion_id'] = $this->almacenamientoFuncion($dato['cond_fn']);
        }
        if(!empty($dato['verd_var'])){
            $dato['verdadero_variable_id'] = $this->almacenamientoVariable($dato['verd_var']);
        }
        if(!empty($dato['verd_bl'])){
            $dato['verdadero_bloque_id'] = $this->almacenamientoBloque($dato['verd_bl']);
        }
        if(!empty($dato['verd_es'])){
            $dato['verdadero_estructura_control_id'] = $this->almacenamientoEstructuraControl($dato['verd_es']);
        }
        if(!empty($dato['verd_fn'])){
            $dato['verdadero_funcion_id'] = $this->almacenamientoFuncion($dato['verd_fn']);
        }
        if(!empty($dato['falso_var'])){
            $dato['falso_variable_id'] = $this->almacenamientoVariable($dato['falso_var']);
        }
        if(!empty($dato['falso_bl'])){
            $dato['falso_bloque_id'] = $this->almacenamientoBloque($dato['falso_bl']);
        }
        if(!empty($dato['falso_es'])){
            $dato['falso_estructura_control_id'] = $this->almacenamientoEstructuraControl($dato['falso_es']);
        }
        if(!empty($dato['falso_fn'])){
            $dato['falso_funcion_id'] = $this->almacenamientoFuncion($dato['falso_fn']);
        }
        unset($dato['tipo']);
        unset($dato['cond_var']);
        unset($dato['cond_bl']);
        unset($dato['cond_es']);
        unset($dato['cond_fn']);
        unset($dato['verd_var']);
        unset($dato['verd_bl']);
        unset($dato['verd_es']);
        unset($dato['verd_fn']);        
        unset($dato['falso_var']);
        unset($dato['falso_bl']);
        unset($dato['falso_es']);
        unset($dato['falso_fn']);
        if(empty($dato['id'])){
            $this->agregarEstructuraControl($dato);
            $dato['id'] = $this->db->insert_id();
        }
        $this->actualizarEstructuraControl($dato,$dato['id']);
        return $dato['id'];
    }
    public function obtenerTiposFormulas()
    {
        $this->db->where('estatus',1);
        return $this->db->from('config_tipos_formulas')->get()->result();
    }
    public function obtenerEstructuraControl($request)
    {
        $this->db->select('es.*,es1.nombre as cond_es,b1.nombre as cond_bl,v1.nombre as cond_var,f1.nombre as cond_fn,
        es2.nombre as verd_es,b2.nombre as verd_bl,v2.nombre as verd_var,f2.nombre as verd_fn,
        es3.nombre as fal_es,b3.nombre as fal_bl,v3.nombre as fal_var,f3.nombre as fal_fn');
        $this->db->from('config_estructura_control as es');
        
        $this->db->join('config_estructura_control as es1','es1.id=es.condicion_estructura_control_id','left');
        $this->db->join('config_bloques as b1','b1.id=es.condicion_bloque_id','left');
        $this->db->join('config_variables as v1','es1.id=es.condicion_variable_id','left');
        $this->db->join('config_funciones as f1','f1.id=es.condicion_funcion_id','left');

        $this->db->join('config_estructura_control as es2','es2.id=es.verdadero_estructura_control_id','left');
        $this->db->join('config_bloques as b2','b2.id=es.verdadero_bloque_id','left');
        $this->db->join('config_variables as v2','es2.id=es.verdadero_variable_id','left');
        $this->db->join('config_funciones as f2','f2.id=es.verdadero_funcion_id','left');
        
        $this->db->join('config_estructura_control as es3','es3.id=es.falso_estructura_control_id','left');
        $this->db->join('config_bloques as b3','b3.id=es.falso_bloque_id','left');
        $this->db->join('config_variables as v3','es3.id=es.falso_variable_id','left');
        $this->db->join('config_funciones as f3','f3.id=es.falso_funcion_id','left');
        $this->db->where('es.id',$request);
        return $this->db->get()->row();
    }
    public function obtenerEstructurasControl($request)
    {
        $this->db->select('es.*,
        (CASE WHEN es1.nombre IS NOT NULL THEN es1.nombre WHEN b1.nombre IS NOT NULL THEN b1.nombre WHEN v1.nombre IS NOT NULL THEN v1.nombre WHEN f1.nombre IS NOT NULL THEN f1.nombre END) as condicion,
        (CASE WHEN es2.nombre IS NOT NULL THEN es2.nombre WHEN b2.nombre IS NOT NULL THEN b2.nombre WHEN v2.nombre IS NOT NULL THEN v2.nombre WHEN f2.nombre IS NOT NULL THEN f2.nombre END) as verdadero,
        (CASE WHEN es3.nombre IS NOT NULL THEN es3.nombre WHEN b3.nombre IS NOT NULL THEN b3.nombre WHEN v3.nombre IS NOT NULL THEN v3.nombre WHEN f3.nombre IS NOT NULL THEN f3.nombre END) as falso');
        $this->db->from('config_estructura_control as es');
        
        $this->db->join('config_estructura_control as es1','es1.id=es.condicion_estructura_control_id','left');
        $this->db->join('config_bloques as b1','b1.id=es.condicion_bloque_id','left');
        $this->db->join('config_variables as v1','v1.id=es.condicion_variable_id','left');
        $this->db->join('config_funciones as f1','f1.id=es.condicion_funcion_id','left');

        $this->db->join('config_estructura_control as es2','es2.id=es.verdadero_estructura_control_id','left');
        $this->db->join('config_bloques as b2','b2.id=es.verdadero_bloque_id','left');
        $this->db->join('config_variables as v2','v2.id=es.verdadero_variable_id','left');
        $this->db->join('config_funciones as f2','f2.id=es.verdadero_funcion_id','left');
        
        $this->db->join('config_estructura_control as es3','es3.id=es.falso_estructura_control_id','left');
        $this->db->join('config_bloques as b3','b3.id=es.falso_bloque_id','left');
        $this->db->join('config_variables as v3','v3.id=es.falso_variable_id','left');
        $this->db->join('config_funciones as f3','f3.id=es.falso_funcion_id','left');
        $columns = [
            "es.nombre",
            "v1.nombre ",
            "b1.nombre ",
            "es1.nombre ",
            "f1.nombre ",
            "v2.nombre ",
            "b2.nombre ",
            "es2.nombre ",
            "f2.nombre ",
            "v3.nombre ",
            "b3.nombre ",
            "es3.nombre ",
            "f3.nombre ",
        ];
        $order = [
            "es.nombre",
            "(CASE WHEN es1.nombre IS NOT NULL THEN es1.nombre WHEN b1.nombre IS NOT NULL THEN b1.nombre WHEN v1.nombre IS NOT NULL THEN v1.nombre WHEN f1.nombre IS NOT NULL THEN f1.nombre END)",
            "(CASE WHEN es2.nombre IS NOT NULL THEN es2.nombre WHEN b2.nombre IS NOT NULL THEN b2.nombre WHEN v2.nombre IS NOT NULL THEN v2.nombre WHEN f2.nombre IS NOT NULL THEN f2.nombre END)",
            "(CASE WHEN es3.nombre IS NOT NULL THEN es3.nombre WHEN b3.nombre IS NOT NULL THEN b3.nombre WHEN v3.nombre IS NOT NULL THEN v3.nombre WHEN f3.nombre IS NOT NULL THEN f3.nombre END)"
        ];
        $this->pagination->render($request,$columns,$order);
        $this->db->order_by('es.nombre');
        $result = $this->db->get()->result();

        $this->db->select("COUNT(*) as total");
        $this->db->from('config_estructura_control as es');
        $this->db->join('config_estructura_control as es1','es1.id=es.condicion_estructura_control_id','left');
        $this->db->join('config_bloques as b1','b1.id=es.condicion_bloque_id','left');
        $this->db->join('config_variables as v1','v1.id=es.condicion_variable_id','left');
        $this->db->join('config_funciones as f1','f1.id=es.condicion_funcion_id','left');

        $this->db->join('config_estructura_control as es2','es2.id=es.verdadero_estructura_control_id','left');
        $this->db->join('config_bloques as b2','b2.id=es.verdadero_bloque_id','left');
        $this->db->join('config_variables as v2','v2.id=es.verdadero_variable_id','left');
        $this->db->join('config_funciones as f2','f2.id=es.verdadero_funcion_id','left');
        
        $this->db->join('config_estructura_control as es3','es3.id=es.falso_estructura_control_id','left');
        $this->db->join('config_bloques as b3','b3.id=es.falso_bloque_id','left');
        $this->db->join('config_variables as v3','v3.id=es.falso_variable_id','left');
        $this->db->join('config_funciones as f3','f3.id=es.falso_funcion_id','left');
        $this->pagination->render_count($request,$columns);
        $result2 = $this->db->get()->row();
        return $this->pagination->response($request,$result,$result2->total);
    }
    public function obtenerBloque($request)
    {
        $this->db->select('bl.*,c.valor as condicion,
        v1.nombre as var_uno,b1.nombre as bl_uno,es1.nombre as es_uno,f1.nombre as fn_uno,
        v2.nombre as var_dos,b2.nombre as bl_dos,es2.nombre as es_dos,f2.nombre as fn_dos');
        $this->db->from('config_bloques as bl');

        $this->db->join('config_variables as v1','v1.id=bl.variable_id_uno','left');
        $this->db->join('config_bloques as b1','b1.id=bl.bloque_id_uno','left');
        $this->db->join('config_estructura_control as es1','es1.id=bl.estructura_control_id_uno','left');
        $this->db->join('config_funciones as f1','f1.id=bl.funcion_id_uno','left');
        
        $this->db->join('config_variables as v2','v2.id=bl.variable_id_dos','left');
        $this->db->join('config_bloques as b2','b2.id=bl.bloque_id_dos','left');
        $this->db->join('config_estructura_control as es2','es2.id=bl.estructura_control_id_dos','left');
        $this->db->join('config_funciones as f2','f2.id=bl.funcion_id_dos','left');
        
        $this->db->join('config_condiciones as c','c.id=bl.condicion_id','left');
        $this->db->where('bl.id',$request);
        return $this->db->get()->row();
    }
    public function obtenerBloques($request)
    {
        $this->db->select('bl.*,c.valor as condicion,
        (CASE WHEN v1.nombre IS NOT NULL THEN v1.nombre WHEN b1.nombre IS NOT NULL THEN b1.nombre WHEN es1.nombre IS NOT NULL THEN es1.nombre WHEN f1.nombre IS NOT NULL THEN f1.nombre END) as dato_uno,
        (CASE WHEN v2.nombre IS NOT NULL THEN v2.nombre WHEN b2.nombre IS NOT NULL THEN b2.nombre WHEN es2.nombre IS NOT NULL THEN es2.nombre WHEN f2.nombre IS NOT NULL THEN f2.nombre END) as dato_dos');
        $this->db->from('config_bloques as bl');

        $this->db->join('config_variables as v1','v1.id=bl.variable_id_uno','left');
        $this->db->join('config_bloques as b1','b1.id=bl.bloque_id_uno','left');
        $this->db->join('config_estructura_control as es1','es1.id=bl.estructura_control_id_uno','left');
        $this->db->join('config_funciones as f1','f1.id=bl.funcion_id_uno','left');
        
        $this->db->join('config_variables as v2','v2.id=bl.variable_id_dos','left');
        $this->db->join('config_bloques as b2','b2.id=bl.bloque_id_dos','left');
        $this->db->join('config_estructura_control as es2','es2.id=bl.estructura_control_id_dos','left');
        $this->db->join('config_funciones as f2','f2.id=bl.funcion_id_dos','left');
        
        $this->db->join('config_condiciones as c','c.id=bl.condicion_id','left');
        $columns = [
            "bl.nombre",
            "v1.nombre ",
            "f1.nombre ",
            "c.valor",
            "v2.nombre",
            "b2.nombre",
            "f2.nombre"
        ];
        $order = [
            "bl.nombre",
            "(CASE WHEN v1.nombre IS NOT NULL THEN v1.nombre WHEN b1.nombre IS NOT NULL THEN b1.nombre WHEN es1.nombre IS NOT NULL THEN es1.nombre WHEN f1.nombre IS NOT NULL THEN f1.nombre END)",
            "c.valor",
            "(CASE WHEN v2.nombre IS NOT NULL THEN v2.nombre WHEN b2.nombre IS NOT NULL THEN b2.nombre WHEN es2.nombre IS NOT NULL THEN es2.nombre WHEN f2.nombre IS NOT NULL THEN f2.nombre END)"
        ];
        $this->pagination->render($request,$columns,$order);
        if(isset($request['filtro']) && $request['filtro']!=''){
            $this->db->where('bl.condicion_id',$request['filtro']);
        }
        $this->db->order_by('bl.nombre');
        $result = $this->db->get()->result();

        $this->db->select("COUNT(*) as total");
        $this->db->from('config_bloques as bl');
        $this->db->join('config_variables as v1','v1.id=bl.variable_id_uno','left');
        $this->db->join('config_bloques as b1','b1.id=bl.bloque_id_uno','left');
        $this->db->join('config_estructura_control as es1','es1.id=bl.estructura_control_id_uno','left');
        $this->db->join('config_funciones as f1','f1.id=bl.funcion_id_uno','left');
        $this->db->join('config_variables as v2','v2.id=bl.variable_id_dos','left');
        $this->db->join('config_bloques as b2','b2.id=bl.bloque_id_dos','left');
        $this->db->join('config_estructura_control as es2','es2.id=bl.estructura_control_id_dos','left');
        $this->db->join('config_funciones as f2','f2.id=bl.funcion_id_dos','left');
        $this->db->join('config_condiciones as c','c.id=bl.condicion_id','left');
        $this->pagination->render_count($request,$columns);
        if(isset($request['filtro']) && $request['filtro']!=''){
            $this->db->where('bl.condicion_id',$request['filtro']);
        }
        $result2 = $this->db->get()->row();
        return $this->pagination->response($request,$result,$result2->total);
    }
    public function obtenerVariable($request)
    {
        $this->db->from('config_variables');
        $this->db->where('id',$request);
        return $this->db->get()->row();
    }
    public function obtenerVariables($request)
    {
        $columns = ['nombre','parametro_usuario','valor'];
        $order = ['nombre','parametro_usuario','valor'];

        $this->db->select("*,(CASE WHEN parametro_usuario=1 THEN 'Usuario' ELSE 'Sistema' END) as parametro");
        $this->db->from('config_variables');
        $this->pagination->render($request,$columns,$order);
        if(isset($request['filtro']) && $request['filtro']!=''){
            $this->db->where('parametro_usuario',$request['filtro']);
        }
        $this->db->order_by('nombre');
        $result = $this->db->get()->result();
        
        $this->db->select("COUNT(*) as total");
        $this->db->from('config_variables');
        $this->pagination->render_count($request,$columns);
        if(isset($request['filtro']) && $request['filtro']!=''){
            $this->db->where('parametro_usuario',$request['filtro']);
        }
        $result2 = $this->db->get()->row();
        return $this->pagination->response($request,$result,$result2->total);
    }
    public function obtenerFuncion($request)
    {
        $this->db->from('config_funciones');
        $this->db->where('id',$request);
        return $this->db->get()->row();
    }
    public function obtenerFunciones($request)
    {
        $columns = ['nombre','funcion','valor'];
        $order = ['nombre','funcion','valor'];

        $this->db->select("id,nombre,funcion,valor");
        $this->db->from('config_funciones');
        $this->pagination->render($request,$columns,$order);
        $this->db->order_by('nombre');
        $result = $this->db->get()->result();
        
        $this->db->select("COUNT(*) as total");
        $this->db->from('config_funciones');
        $this->pagination->render_count($request,$columns);
        $result2 = $this->db->get()->row();
        return $this->pagination->response($request,$result,$result2->total);
    }
    public function obtenerCondicion($request)
    {
        $this->db->from('config_condiciones');
        $this->db->where('id',$request);
        return $this->db->get()->row();
    }
    public function obtenerCondiciones()
    {
        $this->db->from('config_condiciones');
        return $this->db->get()->result();
    }
    public function obtenerVariablesGenerales()
    {
        $this->db->select("id,CONCAT('VAR-',nombre) as nombre");
        $this->db->from("config_variables");
        $this->db->order_by('nombre');
        $variables = $this->db->get()->result();
        $this->db->select("id,CONCAT('BL-',nombre) as nombre");
        $this->db->from("config_bloques");
        $this->db->order_by('nombre');
        $bloques = $this->db->get()->result();
        $this->db->select("id,CONCAT('ES-',nombre) as nombre");
        $this->db->from("config_estructura_control");
        $this->db->order_by('nombre');
        $estructuras_control = $this->db->get()->result();
        $this->db->select("id,CONCAT('FUN-',nombre) as nombre");
        $this->db->from("config_funciones");
        $this->db->order_by('nombre');
        $funciones = $this->db->get()->result();
        $nuevo_array = array_merge($variables,$bloques,$estructuras_control,$funciones);
        return $nuevo_array;
    }
    public function obtenerCatalogos()
    {
        $tablas = $this->db->list_tables();
        $catalogos = [];
        foreach($tablas as $t){
            $columnas = $this->db->list_fields($t);
            $catalogos[] = array(
                'nombre'=>$t,
                'catalogo_columna'=>$columnas
            );
        }
        return $catalogos;
    }
    public function obtenerCatalogosLista($catalogo,$columna)
    {
        $this->db->select('nombre,'.$columna);
        $this->db->from($catalogo);
        $this->db->order_by('nombre');
        return $this->db->get()->result();
    }
    public function factorInicialMonto($request)
    {
        $this->db->from('config_funciones');
        $this->db->where('nombre','FIM');
        $result = $this->db->get()->row();
        $total = $this->totalFactor($result);
        return $total;
    }
    public function factorFinalMonto()
    {
        $this->db->from('config_funciones');
        $this->db->where('nombre','FFM');
        $result = $this->db->get()->row();
        $total = $this->totalFactor($result);
        return $total;
    }
    public function factorInicialPlazo()
    {
        $this->db->from('config_funciones');
        $this->db->where('nombre','FIP');
        $result = $this->db->get()->row();
        $total = $this->totalFactor($result);
        return $total;
    }
    public function factorFinalPlazo()
    {
        $this->db->from('config_funciones');
        $this->db->where('nombre','FFP');
        $result = $this->db->get()->row();
        $total = $this->totalFactor($result);
        return $total;
    }
    public function maximoMonto()
    {
        $this->db->from('config_funciones');
        $this->db->where('nombre','MAXM');
        $result = $this->db->get()->row();
        $total = $this->totalFactor($result);
        return $total;
    }
    public function maximoPlazo()
    {
        $this->db->from('config_funciones');
        $this->db->where('nombre','MAXP');
        $result = $this->db->get()->row();
        $total = $this->totalFactor($result);
        return $total;
    }
    public function minimoMonto()
    {
        $this->db->from('config_funciones');
        $this->db->where('nombre','MINM');
        $result = $this->db->get()->row();
        $total = $this->totalFactor($result);
        return $total;
    }
    public function totalFactor($result)
    {
        $total = 0;
        if(!empty($result)){
            $valores = json_decode($result->valor);
            $ids = [];
            foreach($valores as $val){
                $ids[] = $val->id;
            }
            switch($result->funcion){
                case 'sumar':
                    if(empty($ids)){
                        $total = 0;
                    }else{
                        $this->db->where_in('id', $ids);
                        $sumar = $this->db->from('config_variables')->get()->result();
                        foreach($sumar as $s){
                            $total = $total+$s->valor;
                        }
                    }
                    break;
            }
        }
        return $total;
    }
    public function tablaFactores()
    {
        $this->db->select('*,
        (CASE WHEN condicion_variable_id IS NOT NULL THEN 1
        WHEN condicion_bloque_id IS NOT NULL THEN 2
        WHEN condicion_estructura_control_id IS NOT NULL THEN 3
        WHEN condicion_funcion_id IS NOT NULL THEN 4 END) as condicion_tipo,
        (CASE WHEN verdadero_variable_id IS NOT NULL THEN 1
        WHEN verdadero_bloque_id IS NOT NULL THEN 2
        WHEN verdadero_estructura_control_id IS NOT NULL THEN 3
        WHEN verdadero_funcion_id IS NOT NULL THEN 4 END) as verdadero_tipo,
        (CASE WHEN falso_variable_id IS NOT NULL THEN 1
        WHEN falso_bloque_id IS NOT NULL THEN 2
        WHEN falso_estructura_control_id IS NOT NULL THEN 3
        WHEN falso_funcion_id IS NOT NULL THEN 4 END) as falso_tipo');
        $this->db->from('config_estructura_control');
        $this->db->like('nombre','FIM ', 'after');
        $this->db->or_like('nombre','FFM ', 'after');
        $this->db->or_like('nombre','FIP ', 'after');
        $this->db->or_like('nombre','FFP ', 'after');
        $this->db->or_like('nombre','MAXM ', 'after');
        $this->db->or_like('nombre','MAXP ', 'after');
        $this->db->or_like('nombre','MINM ', 'after');
        $this->db->or_like('nombre','MINP ', 'after');
        $this->db->order_by('nombre');
        $factores = $this->db->get()->result();
        foreach($factores as $key=>$val){
            $factores[$key]->{'datos'} = [];
            $factores[$key]->{'ponderacion'} = '';
            $id = '';
            $bl = false;
            switch($val->condicion_tipo){
                case 1:
                    $id= $val->condicion_variable_id;
                    break;
                case 2:
                    $id= $val->condicion_bloque_id;
                    $bl = true;
                    break;
                case 3:
                    $id= $val->condicion_estructura_control_id;
                    break;
                case 4:
                    $id= $val->condicion_funcion_id;
                    break;
            }
            $this->factoresRecursivo($val->condicion_tipo,$id,$factores,$key,$bl);
            $id = '';
            $bl = false;
            switch($val->verdadero_tipo){
                case 1:
                    $id= $val->verdadero_variable_id;
                    break;
                case 2:
                    $id= $val->verdadero_bloque_id;
                    $bl = true;
                    break;
                case 3:
                    $id= $val->verdadero_estructura_control_id;
                    break;
                case 4:
                    $id= $val->verdadero_funcion_id;
                    break;
            }
            $this->factoresRecursivo($val->verdadero_tipo,$id,$factores,$key,$bl);
            $id = '';
            $bl = false;
            switch($val->falso_tipo){
                case 1:
                    $id= $val->falso_variable_id;
                    break;
                case 2:
                    $id= $val->falso_bloque_id;
                    $bl = true;
                    break;
                case 3:
                    $id= $val->falso_estructura_control_id;
                    break;
                case 4:
                    $id= $val->falso_funcion_id;
                    break;
            }
            $this->factoresRecursivo($val->falso_tipo,$id,$factores,$key,$bl);
        }
        return $factores;

    }
    public function factoresRecursivo($tipo,$id,$factores,$key,$bloques = false)
    {
        switch($tipo){
            case 1:
                $this->db->from('config_variables');
                $this->db->where('id',$id);
                $dato = $this->db->get()->row();
                if($bloques){
                    $factores[$key]->{'datos'}[] = array(
                        'dato1'=>$dato->nombre,
                        'dato1_valor'=>$dato->valor,
                        'condicion'=>'',
                        'dato2'=>'',
                        'dato2_valor'=>''
                    );   
                }
                if(strpos($dato->nombre,'PONDERACION ')!==FALSE){
                    $factores[$key]->{'ponderacion'} = $dato->valor;
                }
                break;
            case 2:
                $dato = $this->obtenerBloque($id);
                $dato1 = '';
                $dato1_valor = '';
                $dato2 = '';
                $dato2_valor = '';
                if(!empty($dato->variable_id_uno)){
                    $dato1 = $dato->var_uno;
                    $dato1_valor = $dato->variable_id_uno;
                }
                if(!empty($dato->bloque_id_uno)){
                    $dato1 = $dato->bl_uno;
                    $dato1_valor = $dato->bloque_id_uno;
                    $this->factoresRecursivo(2,$dato->bloque_id_uno,$factores,$key,true);
                }
                if(!empty($dato->estructura_control_id_uno)){
                    $dato1 = $dato->es_uno;
                    $dato1_valor = $dato->estructura_control_id_uno;
                    $this->factoresRecursivo(3,$dato->estructura_control_id_uno,$factores,$key);
                }
                if(!empty($dato->funcion_id_uno)){
                    $dato1 = $dato->fn_uno;
                    $dato1_valor = $dato->funcion_id_uno;
                }
                if(!empty($dato->variable_id_dos)){
                    $dato2 = $dato->var_dos;
                    $dato2_valor = $dato->variable_id_dos;
                }
                if(!empty($dato->bloque_id_dos)){
                    $dato2 = $dato->bl_dos;
                    $dato2_valor = $dato->bloque_id_dos;
                    $this->factoresRecursivo(2,$dato->bloque_id_dos,$factores,$key,true);
                }
                if(!empty($dato->estructura_control_id_dos)){
                    $dato2 = $dato->es_dos;
                    $dato2_valor = $dato->estructura_control_id_dos;
                    $this->factoresRecursivo(3,$dato->estructura_control_id_dos,$factores,$key);
                }
                if(!empty($dato->funcion_id_dos)){
                    $dato2 = $dato->fn_dos;
                    $dato2_valor = $dato->funcion_id_dos;
                }
                if($bloques){
                    $factores[$key]->{'datos'}[] = array(
                        'nombre'=>$dato->nombre,
                        'dato1'=>$dato1,
                        'dato1_valor'=>$dato1_valor,
                        'condicion'=>$dato->condicion,
                        'dato2'=>$dato2,
                        'dato2_valor'=>$dato2_valor
                    );
                }
                break;
            case 3:
                $dato = $this->obtenerEstructuraControl($id);
                $dato1 = '';
                $dato1_valor = '';
                $dato2 = '';
                $dato2_valor = '';
                $dato3 = '';
                $dato3_valor = '';
                if(!empty($dato->condicion_variable_id)){
                    $dato1 = $dato->cond_var;
                    $dato1_valor = $dato->condicion_variable_id;
                    $this->factoresRecursivo(1,$dato->condicion_variable_id,$factores,$key,$bloques);
                }
                if(!empty($dato->condicion_bloque_id)){
                    $dato1 = $dato->cond_bl;
                    $dato1_valor = $dato->condicion_bloque_id;
                    $this->factoresRecursivo(2,$dato->condicion_bloque_id,$factores,$key,true);
                }
                if(!empty($dato->condicion_estructura_control_id)){
                    $dato1 = $dato->cond_es;
                    $dato1_valor = $dato->condicion_estructura_control_id;
                    $this->factoresRecursivo(3,$dato->condicion_bloque_id,$factores,$key);
                }
                if(!empty($dato->condicion_funcion_id)){
                    $dato1 = $dato->cond_fn;
                    $dato1_valor = $dato->condicion_funcion_id;
                }
                
                if(!empty($dato->verdadero_variable_id)){
                    $dato1 = $dato->verd_var;
                    $dato1_valor = $dato->verdadero_variable_id;
                    $this->factoresRecursivo(1,$dato->verdadero_variable_id,$factores,$key,$bloques);
                }
                if(!empty($dato->verdadero_bloque_id)){
                    $dato1 = $dato->verd_bl;
                    $dato1_valor = $dato->verdadero_bloque_id;
                    $this->factoresRecursivo(2,$dato->verdadero_bloque_id,$factores,$key,true);
                }
                if(!empty($dato->verdadero_estructura_control_id)){
                    $dato1 = $dato->verd_es;
                    $dato1_valor = $dato->verdadero_estructura_control_id;
                    $this->factoresRecursivo(3,$dato->verdadero_estructura_control_id,$factores,$key);
                }
                if(!empty($dato->verdadero_funcion_id)){
                    $dato1 = $dato->verd_fn;
                    $dato1_valor = $dato->verdadero_funcion_id;
                }

                if(!empty($dato->falso_variable_id)){
                    $dato1 = $dato->fal_var;
                    $dato1_valor = $dato->falso_variable_id;
                    $this->factoresRecursivo(1,$dato->falso_variable_id,$factores,$key,$bloques);
                }
                if(!empty($dato->falso_bloque_id)){
                    $dato1 = $dato->fal_bl;
                    $dato1_valor = $dato->falso_bloque_id;
                    $this->factoresRecursivo(2,$dato->falso_bloque_id,$factores,$key,true);
                }
                if(!empty($dato->falso_estructura_control_id)){
                    $dato1 = $dato->fal_es;
                    $dato1_valor = $dato->falso_estructura_control_id;
                    $this->factoresRecursivo(3,$dato->falso_estructura_control_id,$factores,$key);
                }
                if(!empty($dato->falso_funcion_id)){
                    $dato1 = $dato->fal_fn;
                    $dato1_valor = $dato->falso_funcion_id;
                }
                break;
        }
    }
    public function solicitudesAyudate()
    {
        $ayudate = $this->load->database('viejo_ayudate', TRUE);
        $ayudate->select("sol.*,s.empresa_id,s.contrato_id,s.frecuencia_id,s.id_afiliado,
        e.calificacion_id,f.plazo as frecuencia_plazo,sol.montop3 as otras_percepciones,
        TIMESTAMPDIFF(YEAR, CONCAT(SUBSTRING(s.fecha_antiguedad_trabajo, 7, 4),'-',SUBSTRING(s.fecha_antiguedad_trabajo, 4, 2),'-',SUBSTRING(s.fecha_antiguedad_trabajo, 1, 2)),CURRENT_TIMESTAMP) as antiguedad_empresa,
        TIMESTAMPDIFF(YEAR, CONCAT(SUBSTRING(s.fecha_nacimiento, 7, 4),'-',SUBSTRING(s.fecha_nacimiento, 4, 2),'-',SUBSTRING(s.fecha_nacimiento, 1, 2)), CURRENT_TIMESTAMP) as edad, 
        ((sol.total_percepciones-
        (CASE WHEN sol.montop3 IS NULL OR sol.montop3='' THEN 0 ELSE sol.montop3 END)-
        (CASE WHEN sol.montop1 IS NULL OR sol.montop1='' THEN 0 ELSE sol.montop1 END))/f.plazo) as sueldo_diario,
        ((CASE WHEN sol.total_percepciones IS NULL THEN 0 ELSE sol.total_percepciones END)-
        (CASE WHEN sol.total_deducciones IS NULL THEN 0 ELSE sol.total_deducciones END)) as sueldo_neto,
        (CASE WHEN sol.tipo_sueldo = 'Sueldo diario' THEN 1 ELSE 2 END) as percepcion_id,
        e.plazo_maximo as plazo_maximo_empresa,e.tasa_interes,(e.tasa_interes*1.16) as tdi,
        (CASE WHEN e.capacidad_pago='TRAD' THEN 1 
         WHEN e.capacidad_pago='GOB B' THEN 2
         WHEN e.capacidad_pago='GOB E' THEN 3
         WHEN e.capacidad_pago='IPEJAL' THEN 4
         WHEN e.capacidad_pago='JABIL' THEN 5
         WHEN e.capacidad_pago='MICHEL' THEN 6
         WHEN e.capacidad_pago='SEAPAL' THEN 7
         WHEN e.capacidad_pago='UDG' THEN 8 END) as capacidad_id");
        $ayudate->from('solicitudes as sol');
        $ayudate->join('solicitantes as s','s.id=sol.solicitante_id','left');
        $ayudate->join('empresas as e','e.id=s.empresa_id','left');
        $ayudate->join('frecuencias as f','f.id=s.frecuencia_id','left');
        $ayudate->order_by('sol.id','desc');
        $result = $ayudate->get()->result();
        foreach($result as $key=>$val){
            $result[$key]->{'plazo_antiguedad'} = $this->plazo_antiguedad(json_decode(json_encode($val), true));
            $result[$key]->{'ponderacion_antiguedad'} = $this->ponderacion_antiguedad(json_decode(json_encode($val), true));
        }
        return $result;
    }
    public function ponderacion_antiguedad($dato)
    {
        if(empty($dato['antiguedad_empresa'])){
            $dato['antiguedad_empresa'] = 0;
        }
        $this->db->from('cat_antiguedad');
        $this->db->where('antiguedad <=',$dato['antiguedad_empresa']);
        $this->db->order_by('antiguedad','DESC');
        $result = $this->db->get()->row();
        return $result->sueldo;
    }
    public function plazo_antiguedad($dato)
    {
        if(empty($dato['antiguedad_empresa'])){
            $dato['antiguedad_empresa'] = 0;
        }
        $this->db->from('cat_antiguedad');
        $this->db->where('antiguedad <=',$dato['antiguedad_empresa']);
        $this->db->order_by('antiguedad','DESC');
        $result = $this->db->get()->row();
        return $result->plazo_meses;
    }
    public function __destruct()
    {
        
    }
}

?>