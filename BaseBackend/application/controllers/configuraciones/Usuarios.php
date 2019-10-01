<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Usuarios extends REST_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('request_lib');
		$this->load->model('configuraciones/Usuarios_mdl');		
	}

	public function index_get()
	{
		
		$this->response([
			'status' => TRUE,
			'data'   => $this->get()
		], REST_Controller::HTTP_OK);
	}
	public function obtenerUsuarios_get()
	{
		$datos = $this->Usuarios_mdl->getAll($this->get());
		$this->response([
			'status' => TRUE,
			'data'   => $datos['rows'],
			"draw" => $datos['rows_actual'],
			"recordsTotal" => $datos['rows_total'],
			"recordsFiltered" => $datos['rows_total'], 
		], REST_Controller::HTTP_OK);
	}
	public function obtenerDetalleUsuario_get()
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
			$usuario = $this->Usuarios_mdl->getDetalle($this->get('id'));
			$usuario->{'password_dec'} = $this->encryption->decrypt($usuario->password);
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
				'field'=>'username',
				'rules'=>'required',
				'errors'=>array(
					'required'=>'El campo username debe ser ingresado'
				)
			),array(
				'field'=>'password',
				'rules'=>'required',
				'errors'=>array(
					'required'=>'El campo password debe ser ingresado'
				)
			),array(
				'field'=>'perfil_id',
				'rules'=>'required|numeric',
				'errors'=>array(
					'required'=>'El campo perfil debe ser ingresado',
					'numeric'=>'El campo perfil debe ser numérico'
				)
			)
		);
		if ($this->request_lib->validar($this->post(),$rules) == FALSE)
		{
			$this->response([
				'status' => FALSE,
				'data'   => $this->form_validation->error_array()
			], REST_Controller::HTTP_BAD_REQUEST);
		}else if($this->Usuarios_mdl->getUsuarioExiste($this->post('correo'))){
			$this->response([
				'status' => FALSE,
				'data'   => 'El correo '.$this->post('correo').' ya existe'
			], REST_Controller::HTTP_BAD_REQUEST);
		}else{
			$password = $this->encryption->encrypt($this->post('password'));
			$result = $this->Usuarios_mdl->setUsuario($this->post(),$password);
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
	public function agregar_permisos_post()
	{
		$rules = array(
			array(
				'field'=>'id',
				'rules'=>'required|numeric',
				'errors'=>array(
					'required'=>'Es necesario ingresar el identificador del Usuario',
					'numeric'=>'El identificador del Usuario debe ser numérico'
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
		}else if(!$this->Usuarios_mdl->getPermisosExisten($this->post())){
			$this->response([
				'status' => FALSE,
				'data'   => "Algunos permisos que intentas agregar no existen en la tabla de permisos"
			], REST_Controller::HTTP_BAD_REQUEST);
		}else{
			$result = $this->Usuarios_mdl->setUsuarioPermisos($this->post('id'),$this->post());
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
				'field'=>'username',
				'rules'=>'required',
				'errors'=>array(
					'required'=>'El campo username debe ser ingresado'
				)
			),array(
				'field'=>'password',
				'rules'=>'required',
				'errors'=>array(
					'required'=>'El campo password debe ser ingresado'
				)
			),array(
				'field'=>'perfil_id',
				'rules'=>'required|numeric',
				'errors'=>array(
					'required'=>'El campo perfil debe ser ingresado',
					'numeric'=>'El campo perfil debe ser numérico'
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
		}else if($this->Usuarios_mdl->getUsuarioExiste($this->put('correo'),$this->put('id'))){
			$this->response([
				'status' => FALSE,
				'data'   => 'El correo '.$this->put('correo').' ya existe'
			], REST_Controller::HTTP_BAD_REQUEST);
		}else{
			$put = $this->put();
			$put['password'] = $this->encryption->encrypt($this->put('password'));
			$result = $this->Usuarios_mdl->setActualizarUsuario($this->put('id'),$put);
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
			$result = $this->Usuarios_mdl->setEliminarUsuario($id);
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
