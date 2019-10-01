<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Perfiles extends REST_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('request_lib');
		$this->load->model('configuraciones/Perfiles_mdl');		
	}

	public function index_get()
	{
		
		$this->response([
			'status' => TRUE,
			'data'   => $this->get()
		], REST_Controller::HTTP_OK);
	}
	public function obtenerPerfiles_get()
	{
		$datos = $this->Perfiles_mdl->getAll($this->get());
		$this->response([
			'status' => TRUE,
			'data'   => $datos['rows'],
			"draw" => $datos['rows_actual'],
			"recordsTotal" => $datos['rows_total'],
			"recordsFiltered" => $datos['rows_total'], 
		], REST_Controller::HTTP_OK);
	}
	public function obtenerPerfilesPermisos_get()
	{
		$datos = $this->Perfiles_mdl->getPerfilesPermisos($this->get());
		$this->response([
			'status' => TRUE,
			'data'   => $datos, 
		], REST_Controller::HTTP_OK);
	}
	public function obtenerPerfilesTodos_get()
	{
		$usuarios = $this->Perfiles_mdl->all($this->get());
		$this->response([
			'status' => TRUE,
			'data'   => $usuarios
		], REST_Controller::HTTP_OK);
	}
	public function obtenerDetallePerfil_get()
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
			$usuario = $this->Perfiles_mdl->getDetalle($this->get('id'));
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
			$result = $this->Perfiles_mdl->setPerfil($this->post());
			if($result){
				$this->response([
					'status' => TRUE,
					'data'   => 'Los datos fueron almacenados correctamente',
					'id' 	 => $result
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'status' => FALSE,
					'data'   => $this->post()
				], REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}
	public function agregar_permisos_post()
	{
		$rules = array(
			array(
				'field'=>'id',
				'rules'=>'required|numeric',
				'errors'=>array(
					'required'=>'Es necesario ingresar el identificador del perfil',
					'numeric'=>'El identificador del perfil debe ser numérico'
				)
			)
		);
		if ($this->request_lib->validar($this->post(),$rules) == FALSE)
		{
			$this->response([
				'status' => FALSE,
				'data'   => $this->form_validation->error_array()
			], REST_Controller::HTTP_BAD_REQUEST);
		}else if(!is_array($this->post('permisos'))){
			$this->response([
				'status' => FALSE,
				'data'   => "El formato para recibir los permisos no es válido"
			], REST_Controller::HTTP_BAD_REQUEST);
		}else if(!$this->Perfiles_mdl->getPermisosExisten($this->post())){
			$this->response([
				'status' => FALSE,
				'data'   => "Algunos permisos que intentas agregar no existen en la tabla de permisos"
			], REST_Controller::HTTP_BAD_REQUEST);
		}else{
			$result = $this->Perfiles_mdl->setPerfilPermisos($this->post('id'),$this->post());
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
			$result = $this->Perfiles_mdl->setActualizarPerfil($this->put('id'),$this->put());
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
			$result = $this->Perfiles_mdl->setEliminarPerfil($id);
			if($result){
				$this->response([
					'status' => TRUE,
					'data'   => 'Los datos fueron eliminados correctamente'
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'status' => FALSE,
					'data'   => $this->post()
				], REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}
}
