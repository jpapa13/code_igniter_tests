<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Directorio extends REST_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('request_lib');
		$this->load->model('componentes/Directorio_mdl');
	}
	public function index_get()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->get()
		], REST_Controller::HTTP_OK);
	}
	public function recursivo($arreglo, $res)
	{
		//if(!empty($arreglo)){
			foreach($arreglo as $d){
				$res[$d->nombre] = array(
					'id'=>$d->id,
					'hoja'=>null
				);
				$aux = $this->Directorio_mdl->obtener_area($d->id);
				$res[$d->nombre]['hoja'] = $this->recursivo($aux,$res[$d->nombre]['hoja']);
			}
		//}
		return $res;
	}
	public function obtener_area_post(){
        $rules = array(
            array(
                'field'=>'parent',
                'rules'=>'required',
                'errors'=>array(
                    'required'=>'El campo parent debe ser ingresado'
                )
            )
        );
        if ($this->request_lib->validar($this->post(),$rules) == FALSE)
        {
            $this->response([
                'status' => FALSE,
                'data'   => $this->form_validation->error_array()
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else{
			
            $respuesta = $this->Directorio_mdl->obtener_area($this->post('parent'));
            if($respuesta !== FALSE){
				$res = [];
				$respuestaR = $this->recursivo($respuesta,$res);
				$this->response([
                    'status' => TRUE,
                    'data'   => $respuestaR
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'data'   => 'area no encontrada'
                ], REST_Controller::HTTP_NOT_ACCEPTABLE);
            }
        }    
    }
    /*
    public function archivos_todos_post()
    {
        $rules = array(
            array(
                'field'=>'sede',
                'rules'=>'required',
                'errors'=>array(
                    'required'=>'El campo sede debe ser ingresado',
                    'valid_email'=>'El campo correo debe tener un correo valido'
                )
            ),array(
                'field'=>'tipo',
                'rules'=>'required',
                'errors'=>array(
                    'required'=>'El campo sede debe ser ingresado',
                    'valid_email'=>'El campo correo debe tener un correo valido'
                )
            )
        );
        if ($this->request_lib->validar($this->post(),$rules) == FALSE)
        {
            $this->response([
                'status' => FALSE,
                'data'   => $this->form_validation->error_array()
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else{
            $respuesta = $this->Lugares_mdl->archivos_todos($this->post('sede'),$this->post('tipo'));
            if($respuesta !== FALSE){
                $this->response([
                    'status' => TRUE,
                    'data'   => $respuesta
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'data'   => 'sede o tipo no encontrado'
                ], REST_Controller::HTTP_NOT_ACCEPTABLE);
            }
        }		
    }*/
}
