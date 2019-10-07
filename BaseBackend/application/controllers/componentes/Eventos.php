<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Eventos extends REST_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('request_lib');
		$this->load->model('componentes/Eventos_mdl');
	}
	public function index_get()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->get()
		], REST_Controller::HTTP_OK);
	}

	public function archivo_banner_post(){
        $rules = array(
            array(
                'field'=>'sede',
                'rules'=>'required',
                'errors'=>array(
                    'required'=>'El campo sede debe ser ingresado'
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
            $respuesta = $this->Eventos_mdl->archivo_banner($this->post('sede'));
            if($respuesta !== FALSE){
                $this->response([
                    'status' => TRUE,
                    'data'   => $respuesta
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'data'   => 'banner no encontrado'
                ], REST_Controller::HTTP_NOT_ACCEPTABLE);
            }
        }    
    }
    public function detalle_post(){
        $rules = array(
            array(
                'field'=>'evento_id',
                'rules'=>'required|numeric',
                'errors'=>array(
                    'required'=>'El campo debe ser ingresado',
                    'numeric'=> 'El campo debe ser numérico'
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
            $respuesta = $this->Eventos_mdl->detalle($this->post('evento_id'));
            if($respuesta !== FALSE){
                $this->response([
                    'status' => TRUE,
                    'data'   => $respuesta
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'data'   => 'evento no encontrado'
                ], REST_Controller::HTTP_NOT_ACCEPTABLE);
            }
        }    
    }
    public function imagenes_post(){
        $rules = array(
            array(
                'field'=>'evento_id',
                'rules'=>'required|numeric',
                'errors'=>array(
                    'required'=>'El campo debe ser ingresado',
                    'numeric'=> 'El campo debe ser numérico'
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
            $respuesta = $this->Eventos_mdl->imagenes($this->post('evento_id'));
            if($respuesta !== FALSE){
                $this->response([
                    'status' => TRUE,
                    'data'   => $respuesta
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'data'   => 'evento no encontrado'
                ], REST_Controller::HTTP_NOT_ACCEPTABLE);
            }
        }    
    }/*
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
