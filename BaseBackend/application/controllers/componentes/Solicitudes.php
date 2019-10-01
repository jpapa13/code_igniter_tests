<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Solicitudes extends REST_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('request_lib');
		$this->load->model('componentes/Solicitudes_mdl');
	}
	public function index_get()
	{
		$this->response([
			'status' => TRUE,
			'msg'=>'GET = Para obtener información',
			'data'   => $this->get()
		], REST_Controller::HTTP_OK);
	}
	public function todos_get()
	{
		//RESPUESTA CORRECTA
		$variables = $this->Solicitudes_mdl->todos($this->get());
		$this->response([
			'status' => TRUE,
			'data'   => $variables['rows'],
			"draw" => $variables['rows_actual'],
			"recordsTotal" => $variables['rows_total'],
			"recordsFiltered" => $variables['rows_total'], 
		], REST_Controller::HTTP_OK);
	}
}