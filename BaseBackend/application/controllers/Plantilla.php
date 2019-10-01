<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Plantilla extends REST_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('request_lib');
		$this->load->model('Plantilla_mdl');
	}
	public function index_get()
	{
		$this->response([
			'status' => TRUE,
			'msg'=>'GET = Para obtener información',
			'data'   => $this->get()
		], REST_Controller::HTTP_OK);
	}
	public function index_post()
	{		
		$this->response([
			'status' => TRUE,
			'msg'=>'POST = Para agregar información',
			'data'   => $this->post()
		], REST_Controller::HTTP_OK);
	}
	public function index_patch()
	{		
		$this->response([
			'status' => TRUE,
			'msg'=>'PATCH = Para editar solamente un dato',
			'data'   => $this->patch()
		], REST_Controller::HTTP_OK);
	}
	public function index_put()
	{		
		$this->response([
			'status' => TRUE,
			'msg'=>'PUT = Para editar toda la información',
			'data'   => $this->put()
		], REST_Controller::HTTP_OK);
	}
	public function index_delete()
	{		
		$this->response([
			'status' => TRUE,
			'msg'=>'DELETE = Para eliminar información',
			'data'   => $this->delete()
		], REST_Controller::HTTP_OK);
	}
	public function plantilla_get()
	{
		//REGLAS PARA EL ENVIO DE DATOS
		$rules = array(
			array(
				'field'=>'id',
				'rules'=>'required|numeric',
				'errors'=>array(
					'required'=>'El campo id debe ser ingresado',
					'numeric'=>'El campo id debe ser un número'
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

		//VALIDAR DATOS
		if ($this->request_lib->validar($this->get(),$rules) == FALSE)
		{
			$this->Plantilla_mdl->getObtenerUno($this->get());
			//RESPUESTA INCORRECTA
			$this->response([
				'status' => FALSE,
				'data'   => $this->form_validation->error_array()
			], REST_Controller::HTTP_BAD_REQUEST);
		}else{

			//RESPUESTA CORRECTA
			$this->response([
				'status' => TRUE,
				'data'   => 'Datos correctos'
			], REST_Controller::HTTP_OK);
		}
	}
	public function tabla_get()
	{
		$datos = $this->Plantilla_mdl->tabla($this->get());
		$this->response([
			'status' => TRUE,
			'data'   => $datos['rows'],
			"draw" => $datos['rows_actual'],
			"recordsTotal" => $datos['rows_total'],
			"recordsFiltered" => $datos['rows_total'], 
		], REST_Controller::HTTP_OK);
	}
}
