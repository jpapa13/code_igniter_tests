<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Solicitud extends REST_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('request_lib');
		$this->load->model('componentes/Solicitud_mdl');
	}
	public function index_get()
	{
		
		$this->response([
			'status' => TRUE,
			'data'   => $this->get()
		], REST_Controller::HTTP_OK);
	}

	public function agregarDatos_post()
	{
		$save = $this->Solicitud_mdl->insertarDatos($this->post());
		$this->response([
			'status' => TRUE,
			'data'   => $this->post()
		], REST_Controller::HTTP_OK);
	}

}
