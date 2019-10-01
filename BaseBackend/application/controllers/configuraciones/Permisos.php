<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Permisos extends REST_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('request_lib');
		$this->load->model('configuraciones/Permisos_mdl');		
	}

	public function index_get()
	{
		
		$this->response([
			'status' => TRUE,
			'data'   => $this->get()
		], REST_Controller::HTTP_OK);
	}
	public function obtenerPermisos_get()
	{
		$datos = $this->Permisos_mdl->getAll($this->get());
		$this->response([
			'status' => TRUE,
			'data'   => $datos['rows'],
			"draw" => $datos['rows_actual'],
			"recordsTotal" => $datos['rows_total'],
			"recordsFiltered" => $datos['rows_total'], 
		], REST_Controller::HTTP_OK);
	}
	public function obtenerDetallePermiso_get()
	{
		$rules = array(
			array(
				'field'=>'id',
				'rules'=>'required|numeric',
				'errors'=>array(
					'required'=>'El campo id debe ser ingresado',
					'numeric'=>'El campo id debe ser un número'
				)
			)
		);
		if ($this->request_lib->validar($this->get(),$rules) == FALSE)
		{
			$this->response([
				'status' => FALSE,
				'data'   => $this->form_validation->error_array()
			], REST_Controller::HTTP_BAD_REQUEST);
		}else{
			$usuario = $this->Permisos_mdl->getDetalle($this->get('id'));
			$this->response([
				'status' => TRUE,
				'data'   => $usuario
			], REST_Controller::HTTP_OK);
		}
	}
	public function agregar_post()
	{
		$rules = array(
			array(
				'field'=>'nombre',
				'rules'=>'required',
				'errors'=>array(
					'required'=>'El campo nombre debe ser ingresado'
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
			$result = $this->Permisos_mdl->setPermiso($this->post());
			if($result){
				$this->response([
					'status' => TRUE,
					'data'   => 'Los datos fueron almacenados correctamente'
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'status' => FALSE,
					'data'   => $this->post()
				], REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}
	public function editar_put()
	{
		$rules = array(
			array(
				'field'=>'nombre',
				'rules'=>'required',
				'errors'=>array(
					'required'=>'El campo nombre debe ser ingresado'
				)
			),array(
				'field'=>'id',
				'rules'=>'required|numeric',
				'errors'=>array(
					'required'=>'El campo id debe ser ingresado',
					'numeric'=>'El campo id debe ser un número'
				)
			)
		);
		if ($this->request_lib->validar($this->put(),$rules) == FALSE)
		{
			$this->response([
				'status' => FALSE,
				'data'   => $this->form_validation->error_array()
			], REST_Controller::HTTP_BAD_REQUEST);
		}else{
			$result = $this->Permisos_mdl->setActualizarPermiso($this->put('id'),$this->put());
			if($result){
				$this->response([
					'status' => TRUE,
					'data'   => 'Los datos fueron almacenados correctamente'
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'status' => FALSE,
					'data'   => $this->post()
				], REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}
	public function eliminar_delete($id)
	{
		$rules = array(
			array(
				'field'=>'id',
				'rules'=>'required|numeric',
				'errors'=>array(
					'required'=>'El campo id debe ser ingresado',
					'numeric'=>'El campo id debe ser un número'
				)
			)
		);
		if ($this->request_lib->validar(['id'=>$id],$rules) == FALSE)
		{
			$this->response([
				'status' => FALSE,
				'data'   => $this->form_validation->error_array()
			], REST_Controller::HTTP_BAD_REQUEST);
		}else{
			$result = $this->Permisos_mdl->setEliminarPermiso($id);
			if($result){
				$this->response([
					'status' => TRUE,
					'data'   => 'Los datos fueron eliminados correctamente'
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'status' => FALSE,
					'data'   => $this->delete()
				], REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}
}
