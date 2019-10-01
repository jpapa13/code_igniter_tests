<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Login extends REST_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Auth');
		$this->load->library('request_lib');
		$this->load->model('Login_mdl');		
	}
	public function index_get()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->get()
		], REST_Controller::HTTP_NOT_FOUND);
	}
	public function auth_get()
	{
		$http_auth = $this->input->server('REDIRECT_HTTP_AUTHORIZATION');
		if(empty($http_auth)){
			$http_auth = $this->input->server('HTTP_AUTHENTICATION');
		}
		if($this->auth->authenticate($http_auth)){
			$permisos_db = $this->auth->permisos($http_auth);
			$permisos = [];
			foreach($permisos_db as $p){
				$permisos[] = $p->permiso_id;
			}
			$this->response([
				'status' => TRUE,
				'data'   => $permisos
			], REST_Controller::HTTP_OK);
		}else{
			$this->response([
				'status' => FALSE,
				'data'   => 'No se encuentra autenticado'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
	public function permisos_get()
	{
		$http_auth = $this->input->server('REDIRECT_HTTP_AUTHORIZATION');
		if(empty($http_auth)){
			$http_auth = $this->input->server('HTTP_AUTHENTICATION');
		}
		$permisos_db = $this->auth->permisos($http_auth);
		$permisos = [];
		foreach($permisos_db as $p){
			$permisos[] = $p->permiso_id;
		}
		$this->response([
			'status' => TRUE,
			'data'   => $permisos
		], REST_Controller::HTTP_OK);
	}
	public function login_post()
	{
		$rules = array(
			array(
				'field'=>'correo',
				'rules'=>'required|valid_email',
				'errors'=>array(
					'required'=>'El campo correo debe ser ingresado',
					'valid_email'=>'El campo correo debe tener un correo valido'
				)
			),array(
				'field'=>'password',
				'rules'=>'required',
				'errors'=>array(
					'required'=>'El campo password debe ser ingresado'
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
			$respuesta = $this->Login_mdl->buscarUsuario($this->post('correo'),$this->post('password'));
			if($respuesta !== FALSE){
				$this->response([
					'status' => TRUE,
					'data'   => $respuesta
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'status' => FALSE,
					'data'   => 'Correo o password incorrectos'
				], REST_Controller::HTTP_NOT_ACCEPTABLE);
			}
		}		
	}
	public function logout_post()
	{
		$rules = array(
			array(
				'field'=>'id',
				'rules'=>'required',
				'errors'=>array(
					'required'=>'El identificador del usuario debe ser ingresado'
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
			if($this->Login_mdl->terminarSesion($this->post('id'))){
				$this->response([
					'status' => TRUE,
					'data'   => 'La sesión ha finalizado exitosamente'
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'status' => FALSE,
					'data'   => 'No se pudo terminar la sesión'
				], REST_Controller::HTTP_NOT_ACCEPTABLE);
			}
		}		
	}
}
