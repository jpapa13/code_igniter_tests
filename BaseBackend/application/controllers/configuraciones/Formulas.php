<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Formulas extends REST_Controller {
	private $formula;
	private $factores_formula;
	public function __construct()
	{
		parent::__construct();
		$this->load->library('request_lib');
		$this->load->library('funciones_lib');
		$this->load->model('configuraciones/Formulas_mdl');
		$this->formula = "";
		$this->factores_formula = [];
	}
	public function index_get()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->get()
		], REST_Controller::HTTP_OK);
	}
	public function obtenerDetalleVariable_get()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->Formulas_mdl->obtenerVariable($this->get('id'))
		], REST_Controller::HTTP_OK);
	}
	public function obtenerDetalleBloque_get()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->Formulas_mdl->obtenerBloque($this->get('id'))
		], REST_Controller::HTTP_OK);
	}
	public function obtenerDetalleEstructuraControl_get()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->Formulas_mdl->obtenerEstructuraControl($this->get('id'))
		], REST_Controller::HTTP_OK);
	}
	public function obtenerDetalleFuncion_get()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->Formulas_mdl->obtenerFuncion($this->get('id'))
		], REST_Controller::HTTP_OK);
	}
	public function obtenerVariablesGenerales_get()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->Formulas_mdl->obtenerVariablesGenerales()
		], REST_Controller::HTTP_OK);
	}
	public function obtenerTiposFormulas_get()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->Formulas_mdl->obtenerTiposFormulas()
		], REST_Controller::HTTP_OK);
	}
	public function agregarVariables_post()
	{
		$rules = array(
			array(
				'field'=>'nombre',
				'rules'=>'required|max_length[128]|alpha_dash',
				'errors'=>array(
					'required'=>'El campo nombre debe ser ingresado',
					'max_length'=>'El campo nombre no permite más de 128 carácteres',
					'alpha_dash'=>'El campo nombre solo acepta letras, numeros, guión bajo y diagonal'
				)
			),array(
				'field'=>'valor',
				'rules'=>'required',
				'errors'=>array(
					'required'=>'El campo valor debe ser ingresado'
				)
			)
		);
		if ($this->request_lib->validar($this->post(),$rules) == FALSE)
		{
			$this->response([
				'status' => FALSE,
				'data'   => $this->form_validation->error_array()
			], REST_Controller::HTTP_BAD_REQUEST);
		}else if($this->Formulas_mdl->agregarVariable($this->post())){
			$this->response([
				'status' => TRUE,
				'data'   => 'Variable ingresada exitosamente'
			], REST_Controller::HTTP_OK);
		}else{
			$this->response([
				'status' => FALSE,
				'data'   => 'No se pudo agregar la información'
			], REST_Controller::HTTP_CONFLICT);
		}
	}
	public function agregarBloques_post()
	{
		$rules = array(
			array(
				'field'=>'nombre',
				'rules'=>'required|max_length[128]|alpha_dash',
				'errors'=>array(
					'required'=>'El campo nombre debe ser ingresado',
					'max_length'=>'El campo nombre no permite más de 128 carácteres',
					'alpha_dash'=>'El campo nombre solo acepta letras, numeros, guión bajo y diagonal'
				)
			),array(
				'field'=>'variable_id_uno',
				'rules'=>'numeric',
				'errors'=>array(
					'numeric'=>'El campo id debe ser un número'
				)
			),array(
				'field'=>'variable_id_dos',
				'rules'=>'numeric',
				'errors'=>array(
					'numeric'=>'El campo id debe ser un número'
				)
			),array(
				'field'=>'bloque_id_uno',
				'rules'=>'numeric',
				'errors'=>array(
					'numeric'=>'El campo id debe ser un número'
				)
			),array(
				'field'=>'bloque_id_dos',
				'rules'=>'numeric',
				'errors'=>array(
					'numeric'=>'El campo id debe ser un número'
				)
			)
		);
		if ($this->request_lib->validar($this->post(),$rules) == FALSE)
		{
			$this->response([
				'status' => FALSE,
				'data'   => $this->form_validation->error_array()
			], REST_Controller::HTTP_BAD_REQUEST);
		}else if($this->Formulas_mdl->agregarBloque($this->post())){
			$this->response([
				'status' => TRUE,
				'data'   => 'Bloque ingresada exitosamente'
			], REST_Controller::HTTP_OK);
		}else{
			$this->response([
				'status' => FALSE,
				'data'   => 'No se pudo agregar la información'
			], REST_Controller::HTTP_CONFLICT);
		}
	}


	public function agregarEstructuraControl_post()
	{
		$rules = array(
			array(
				'field'=>'nombre',
				'rules'=>'required|max_length[128]|alpha_dash',
				'errors'=>array(
					'required'=>'El campo nombre debe ser ingresado',
					'max_length'=>'El campo nombre no permite más de 128 carácteres',
					'alpha_dash'=>'El campo nombre solo acepta letras, numeros, guión bajo y diagonal'
				)
			),array(
				'field'=>'condicion_variable_id',
				'rules'=>'numeric',
				'errors'=>array(
					'numeric'=>'El campo id debe ser un número'
				)
			),array(
				'field'=>'condicion_bloque_id',
				'rules'=>'numeric',
				'errors'=>array(
					'numeric'=>'El campo id debe ser un número'
				)
			),array(
				'field'=>'condicion_estructura_control_id',
				'rules'=>'numeric',
				'errors'=>array(
					'numeric'=>'El campo id debe ser un número'
				)
			),array(
				'field'=>'verdadero_variable_id',
				'rules'=>'numeric',
				'errors'=>array(
					'numeric'=>'El campo id debe ser un número'
				)
			),array(
				'field'=>'verdadero_bloque_id',
				'rules'=>'numeric',
				'errors'=>array(
					'numeric'=>'El campo id debe ser un número'
				)
			),array(
				'field'=>'verdadero_estructura_control_id',
				'rules'=>'numeric',
				'errors'=>array(
					'numeric'=>'El campo id debe ser un número'
				)
			),array(
				'field'=>'falso_variable_id',
				'rules'=>'numeric',
				'errors'=>array(
					'numeric'=>'El campo id debe ser un número'
				)
			),array(
				'field'=>'falso_bloque_id',
				'rules'=>'numeric',
				'errors'=>array(
					'numeric'=>'El campo id debe ser un número'
				)
			),array(
				'field'=>'falso_estructura_control_id',
				'rules'=>'numeric',
				'errors'=>array(
					'numeric'=>'El campo id debe ser un número'
				)
			)
		);
		
		if ($this->request_lib->validar($this->post(),$rules) == FALSE)
		{
			$this->response([
				'status' => FALSE,
				'data'   => $this->form_validation->error_array()
			], REST_Controller::HTTP_BAD_REQUEST);
		}else if($this->Formulas_mdl->agregarEstructuraControl($this->post())){
				
			$this->response([
				'status' => TRUE,
				'data'   => $this->post()
			], REST_Controller::HTTP_OK);
		}else{
			$this->response([
				'status' => FALSE,
				'data'   => 'No se pudo agregar la información'
			], REST_Controller::HTTP_CONFLICT);
		}
	}
	public function guardarFormula_post()
	{		
		$this->response([
			'status' => TRUE,
			'data'   => $this->Formulas_mdl->guardarFormula($this->post('datos'))
		], REST_Controller::HTTP_OK);
	}
	public function generarResultado_get()
	{
		$post = $this->post();

		$variable = $this->Formulas_mdl->obtenerVariable($this->get('id'));
		if(!empty($variable) && !empty($variable->id)){
			$this->verificarVariable($variable,$post);
		}
		
		$bloque = $this->Formulas_mdl->obtenerBloque($this->get('id'));
		if(!empty($bloque) && !empty($bloque->id)){
			$this->verificarBloque($bloque,$post);
		}
		$estructura_control = $this->Formulas_mdl->obtenerEstructuraControl($this->get('id'));
		if(!empty($estructura_control) && !empty($estructura_control->id)){
			$this->verificarEstructuraControl($estructura_control,$post);
		}
		$funcion = $this->Formulas_mdl->obtenerFuncion($this->get('id'));
		if(!empty($funcion) && !empty($funcion->id)){
			$this->verificarFuncion($funcion,$post);
		}
		$respuesta='';
		eval('$respuesta='.$this->formula.';');
		$this->response([
			'status' => TRUE,
			'data'   => $this->formula,
			'resultado' => $respuesta,
		], REST_Controller::HTTP_OK);
	}
	public function obtenerCatalogos_get()
	{
		//RESPUESTA CORRECTA
		$catalogos = $this->Formulas_mdl->obtenerCatalogos();
		$this->response([
			'status' => TRUE,
			'data'   => $catalogos
		], REST_Controller::HTTP_OK);
	}
	public function obtenerCatalogosLista_get()
	{
		//RESPUESTA CORRECTA
		$catalogos = $this->Formulas_mdl->obtenerCatalogosLista($this->get('catalogo'),$this->get('columna'));
		$this->response([
			'status' => TRUE,
			'data'   => $catalogos
		], REST_Controller::HTTP_OK);
	}
	public function obtenerVariables_get()
	{
		//RESPUESTA CORRECTA
		$variables = $this->Formulas_mdl->obtenerVariables($this->get());
		$this->response([
			'status' => TRUE,
			'data'   => $variables['rows'],
			"draw" => $variables['rows_actual'],
			"recordsTotal" => $variables['rows_total'],
			"recordsFiltered" => $variables['rows_total'], 
		], REST_Controller::HTTP_OK);
	}
	public function obtenerFunciones_get()
	{
		//RESPUESTA CORRECTA
		$funciones = $this->Formulas_mdl->obtenerFunciones($this->get());
		$this->response([
			'status' => TRUE,
			'data'   => $funciones['rows'],
			"draw" => $funciones['rows_actual'],
			"recordsTotal" => $funciones['rows_total'],
			"recordsFiltered" => $funciones['rows_total'], 
		], REST_Controller::HTTP_OK);
	}
	public function obtenerCondiciones_get()
	{
		//RESPUESTA CORRECTA
		$this->response([
			'status' => TRUE,
			'data'   => $this->Formulas_mdl->obtenerCondiciones() 
		], REST_Controller::HTTP_OK);
	}
	public function obtenerBloques_get()
	{
		//RESPUESTA CORRECTA
		$bloques = $this->Formulas_mdl->obtenerBloques($this->get());
		$this->response([
			'status' => TRUE,
			'data'   => $bloques['rows'],
			"draw" => $bloques['rows_actual'],
			"recordsTotal" => $bloques['rows_total'],
			"recordsFiltered" => $bloques['rows_total']
		], REST_Controller::HTTP_OK);
	}
	public function obtenerEstructurasControl_get()
	{
		//RESPUESTA CORRECTA
		$es = $this->Formulas_mdl->obtenerEstructurasControl($this->get());
		$this->response([
			'status' => TRUE,
			'data'   => $es['rows'],
			"draw" => $es['rows_actual'],
			"recordsTotal" => $es['rows_total'],
			"recordsFiltered" => $es['rows_total']
		], REST_Controller::HTTP_OK);
	}
	private function verificarEstructuraControl($x,$post)
	{
		$condicion = null;
		$condicion_tipo = null;
		if(!empty($x->condicion_variable_id)){
			$condicion = $x->condicion_variable_id;
			$condicion_tipo = 1;//variable
		}
		if(!empty($x->condicion_bloque_id)){
			$condicion = $x->condicion_bloque_id;
			$condicion_tipo = 2;//bloque
		}
		if(!empty($x->condicion_estructura_control_id)){
			$condicion = $x->condicion_estructura_control_id;
			$condicion_tipo = 3;//estructura
		}
		if(!empty($x->condicion_funcion_id)){
			$condicion = $x->condicion_funcion_id;
			$condicion_tipo = 4;//funcion
		}

		$verdadero = null;
		$verdadero_tipo = null;
		if(!empty($x->verdadero_variable_id)){
			$verdadero = $x->verdadero_variable_id;
			$verdadero_tipo = 1;
		}
		if(!empty($x->verdadero_bloque_id)){
			$verdadero = $x->verdadero_bloque_id;
			$verdadero_tipo = 2;
		}
		if(!empty($x->verdadero_estructura_control_id)){
			$verdadero = $x->verdadero_estructura_control_id;
			$verdadero_tipo = 3;
		}
		if(!empty($x->verdadero_funcion_id)){
			$verdadero = $x->verdadero_funcion_id;
			$verdadero_tipo = 4;
		}
		
		$falso = null;
		$falso_tipo = null;
		if(!empty($x->falso_variable_id)){
			$falso = $x->falso_variable_id;
			$falso_tipo = 1;
		}
		if(!empty($x->falso_bloque_id)){
			$falso = $x->falso_bloque_id;
			$falso_tipo = 2;
		}
		if(!empty($x->falso_estructura_control_id)){
			$falso = $x->falso_estructura_control_id;
			$falso_tipo = 3;
		}		
		if(!empty($x->falso_funcion_id)){
			$falso = $x->falso_funcion_id;
			$falso_tipo = 4;
		}
		$this->formula.="(";
		$this->generarArbol($condicion,$condicion_tipo,$post); //condicion
		$this->formula.="?";
		$this->generarArbol($verdadero,$verdadero_tipo,$post); //verdadero
		$this->formula.=":";
		$this->generarArbol($falso,$falso_tipo,$post); //falso
		$this->formula.=")";
	}

	private function verificarBloque($x,$post)
	{

		$variable_uno = null;
		$variable_uno_tipo = null;
		if(!empty($x->variable_id_uno)){
			$variable_uno = $x->variable_id_uno;
			$variable_uno_tipo = 1;
		}
		if(!empty($x->bloque_id_uno)){
			$variable_uno = $x->bloque_id_uno;
			$variable_uno_tipo = 2;
		}
		if(!empty($x->estructura_control_id_uno)){
			$variable_uno = $x->estructura_control_id_uno;
			$variable_uno_tipo = 3;
		}
		if(!empty($x->funcion_id_uno)){
			$variable_uno = $x->funcion_id_uno;
			$variable_uno_tipo = 4;
		}

		$condicion = null;
		$condicion_tipo = null;
		if(!empty($x->condicion_id)){
			$condicion = $x->condicion_id;
			$condicion_tipo = 5;//condicion
		}

		$variable_dos = null;
		$variable_dos_tipo = null;
		if(!empty($x->variable_id_dos)){
			$variable_dos = $x->variable_id_dos;
			$variable_dos_tipo = 1;
		}
		if(!empty($x->bloque_id_dos)){
			$variable_dos = $x->bloque_id_dos;
			$variable_dos_tipo = 2;
		}
		if(!empty($x->estructura_control_id_dos)){
			$variable_dos = $x->estructura_control_id_dos;
			$variable_dos_tipo = 3;
		}
		if(!empty($x->funcion_id_dos)){
			$variable_dos = $x->funcion_id_dos;
			$variable_dos_tipo = 4;
		}

		//verificaciones de vacíos
		$this->formula.="((";
		$this->generarArbol($variable_uno,$variable_uno_tipo,$post); //variable_uno
		$this->formula.=")";
		$this->generarArbol($condicion,$condicion_tipo,$post); //condicion
		$this->formula.="(";
		$this->generarArbol($variable_dos,$variable_dos_tipo,$post); //variable_dos
		$this->formula.="))";
	}
	private function verificarVariable($x,$post = [])
	{
		if ($x->parametro_usuario == 1) {
			$this->formula.= (empty($post[$x->nombre])?0:$post[$x->nombre]);
		} else {
			$this->formula.=(empty($x->valor)?0:$x->valor);
		}		
	}
	private function verificarFuncion($x,$post)
	{
		$arreglo = json_decode($x->valor);
		$valores = [];
		$formula_temp = $this->formula;
		foreach($arreglo as $val){
			$this->db->select('COUNT(*) as total');
			$this->db->from('config_variables');
			$this->db->where(array(
				'id'=>$val->id,
				'nombre'=>preg_replace("/VAR-/","",$val->nombre,1)
			));
			$result = $this->db->get()->row()->total;
			if($result>0){
				$variable = $this->Formulas_mdl->obtenerVariable($val->id);
				if(!empty($variable) && !empty($variable->id)){
					$this->formula = "";
					$this->verificarVariable($variable,$post);
					// echo $this->formula.'<br>';
					eval('$resultado ='.$this->formula.';');
					$this->factores_formula[] = $this->formula." = ".$resultado;
					$valores[] = $resultado;
					$this->formula = "";
				}		
			}
			$this->db->select('COUNT(*) as total');
			$this->db->from('config_bloques');
			$this->db->where(array(
				'id'=>$val->id,
				'nombre'=>preg_replace("/BL-/","",$val->nombre,1)
			));
			$result = $this->db->get()->row()->total;
			if($result>0){
				$bloque = $this->Formulas_mdl->obtenerBloque($val->id);
				if(!empty($bloque) && !empty($bloque->id)){
					$this->formula = "";
					$this->verificarBloque($bloque,$post);
					// echo $this->formula.'<br>';
					eval('$resultado ='.$this->formula.';');
					$this->factores_formula[] = $this->formula." = ".$resultado;
					$valores[] = $resultado;
					$this->formula = "";
				}
			}
			$this->db->select('COUNT(*) as total');
			$this->db->from('config_estructura_control');
			$this->db->where(array(
				'id'=>$val->id,
				'nombre'=>preg_replace("/ES-/","",$val->nombre,1)
			));
			$result = $this->db->get()->row()->total;
			if($result>0){
				$estructura_control = $this->Formulas_mdl->obtenerEstructuraControl($val->id);
				if(!empty($estructura_control) && !empty($estructura_control->id)){
					$this->formula = "";
					$this->verificarEstructuraControl($estructura_control,$post);
					// echo $this->formula.'<br>';
					eval('$resultado ='.$this->formula.';');
					$this->factores_formula[] = $this->formula." = ".$resultado;
					$valores[] = $resultado;
					$this->formula = "";
				}
			}
			$this->db->select('COUNT(*) as total');
			$this->db->from('config_funciones');
			$this->db->where(array(
				'id'=>$val->id,
				'nombre'=>preg_replace("/FUN-/","",$val->nombre,1)
			));
			$result = $this->db->get()->row()->total;
			if($result>0){
				$funcion = $this->Formulas_mdl->obtenerFuncion($val->id);
				if(!empty($funcion) && !empty($funcion->id)){
					$this->formula = "";
					$this->verificarFuncion($funcion,$post);
					// echo $this->formula.'<br>';
					eval('$resultado ='.$this->formula.';');
					$this->factores_formula[] = $this->formula." = ".$resultado;
					$valores[] = $resultado;
					$this->formula = "";
				}
			}
		}
		$this->formula = $formula_temp;
		switch($x->funcion){
			case 'sumar':
				$this->formula.=$this->funciones_lib->sumar($valores);
				break;
			case 'restar':
				$this->formula.=$this->funciones_lib->restar($valores);
				break;
			case 'multiplicar':
				$this->formula.=$this->funciones_lib->multiplicar($valores);
				break;
			case 'maximo':
				$this->formula.=$this->funciones_lib->maximo($valores);
				break;
			case 'minimo':
				$this->formula.=$this->funciones_lib->minimo($valores);
				break;
			default:
				break;
		}
	}
	private function verificarCondicion($x)
	{
		$this->formula.=$x->valor;
	}

	private function generarArbol($x,$tipo,$post)
	{
		switch($tipo){
			case 1:
				$x = $this->Formulas_mdl->obtenerVariable($x);
				$this->verificarVariable($x,$post);
				break;
			case 2:
				$x = $this->Formulas_mdl->obtenerBloque($x);
				$this->verificarBloque($x,$post);
				break;
			case 3:
				$x = $this->Formulas_mdl->obtenerEstructuraControl($x);
				$this->verificarEstructuraControl($x,$post);				
				break;
			case 4:
				$x = $this->Formulas_mdl->obtenerFuncion($x);
				$this->verificarFuncion($x,$post);				
				break;
			case 5:
				$x = $this->Formulas_mdl->obtenerCondicion($x);
				$this->verificarCondicion($x,$post);				
				break;
			default:
				break;
		}
	}
	public function plazoMaximo_post()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->plazo_maximo(),
			'data_formula' => $this->formula
		], REST_Controller::HTTP_OK);
	}
	public function descuentoMaximo_post()
	{
		$post = $this->post();
		$descuento_maximo_politicas = $this->descuento_maximo_politicas();
		$pago_maximo = $this->capacidad_pago_politicas();

		// Descuento máximo nomina
		$this->formula = '';
		if($descuento_maximo_politicas>$pago_maximo){
			$post['formula_nomina'] = $pago_maximo;
		}else{
			$post['formula_nomina'] = $descuento_maximo_politicas;
		}
		$funcion = $this->Formulas_mdl->obtenerEstructuraControl(77);
		if(!empty($funcion) && !empty($funcion->id)){
			$this->verificarEstructuraControl($funcion,$post);
		}
		$descuento_maximo_nomina = '';
		eval('$descuento_maximo_nomina='.$this->formula.';');
		
		//MONTO
		$plazo_max = $this->plazo_maximo();
		$periodo_mes = $this->periodo_mes();
		$credito_maximo_nomina = $this->credito_maximo_nomina();
		$credito_maximo = floor($credito_maximo_nomina/500)*500;
		$tasa = $post['tdi']/($periodo_mes*12);
		$monto = -$this->funciones_lib->pmt($tasa,$plazo_max,$credito_maximo,0);
		$this->response([
			'status' => TRUE,
			'data'   => $this->funciones_lib->minimo([$descuento_maximo_nomina,$descuento_maximo_politicas]),
			'data_formula'   => array(
				'tasa'=>$this->post('tasa_interes'),
				'descuento_maximo_nomina'=>$descuento_maximo_nomina,
				'descuento_maximo_politicas'=>$descuento_maximo_politicas,
				'pago_maximo'=>$pago_maximo,
				'monto'=>$monto
			)
		], REST_Controller::HTTP_OK);
	}
	public function creditoMaximo_post()
	{
		$post = $this->post();
		$sueldo = $this->sueldo();
		$periodo_mes = $this->periodo_mes();
		$ponderacion_ant = $this->Formulas_mdl->ponderacion_antiguedad($post);
		$pago_maximo = $this->capacidad_pago_politicas();
		$plazo_max = $this->plazo_maximo();
		$descuento_maximo_politicas = $this->descuento_maximo_politicas();
		$fim = $this->fim();
		$ffm = $this->ffm();
		$credito_maximo_politicas = $this->credito_maximo_politicas();

		// Credito máximo nomina
		$this->formula = '';
		$tasa = $post['tdi']/($periodo_mes*12);
		if($descuento_maximo_politicas>$pago_maximo){
			$post['formula_nomina'] = -$this->funciones_lib->pv($tasa,$plazo_max,$pago_maximo,0);
		}else{
			$post['formula_nomina'] = $credito_maximo_politicas;
		}
		$funcion = $this->Formulas_mdl->obtenerEstructuraControl(77);
		if(!empty($funcion) && !empty($funcion->id)){
			$this->verificarEstructuraControl($funcion,$post);
		}
		$credito_maximo_nomina = '';
		eval('$credito_maximo_nomina='.$this->formula.';');
		
		//MONTO
		$monto = floor($credito_maximo_nomina/500)*500;

		$this->response([
			'status' => TRUE,
			'data' => $this->funciones_lib->minimo([$credito_maximo_nomina,$credito_maximo_politicas]),
			'data_formula' => array(
				'tasa'=>$this->post('tasa_interes'),
				'pago_maximo'=>$pago_maximo,
				'plazo_maximo'=>$plazo_max,
				'fim'=>$fim,
				'ffm'=>$ffm,
				'tdi'=>$post['tdi'],
				'tasa'=>$tasa,
				'ponderacion_antiguedad'=>$ponderacion_ant,
				'sueldo'=>$sueldo,
				'periodo_mes'=>$periodo_mes,
				'credito_maximo_nomina'=>$credito_maximo_nomina,
				'credito_maximo_politicas'=>$credito_maximo_politicas,
				'descuento_maximo_politicas'=>$descuento_maximo_politicas,
				'monto'=>$monto
			)
		], REST_Controller::HTTP_OK);
	}
	private function capacidad_pago_politicas()
	{
		$dato = $this->post();
		$this->formula = '';
		switch($dato['capacidad_id'])
		{
			case 1: // TRADICIONAL
				$funcion = $this->Formulas_mdl->obtenerEstructuraControl(60);
				break;
			case 2: // GOB B
				$funcion = $this->Formulas_mdl->obtenerEstructuraControl(63);
				break;
			case 3: // GOB E
				$funcion = $this->Formulas_mdl->obtenerEstructuraControl(64);
				break;
			case 4: // IPEJAL
				$funcion = $this->Formulas_mdl->obtenerEstructuraControl(59);
				break;
			case 5: // JABIL
				$funcion = $this->Formulas_mdl->obtenerEstructuraControl(61);
				break;
			case 6: // MICHEL
				$funcion = $this->Formulas_mdl->obtenerEstructuraControl(58);
				break;
			case 7: // SEAPAL
				$funcion = $this->Formulas_mdl->obtenerEstructuraControl(65);
				break;
			case 8: // UDG
				$funcion = $this->Formulas_mdl->obtenerEstructuraControl(62);
				break;
			default:
				echo "No entró";
				break;
		}
		if(!empty($funcion) && !empty($funcion->id)){
			$this->verificarEstructuraControl($funcion,$dato);
		}
		
		$respuesta='';
		eval('$respuesta='.$this->formula.';');
		return $respuesta;
	}
	public function factorInicialMonto_post()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->fim(),
			'formula' => $this->formula
		], REST_Controller::HTTP_OK);
	}
	public function factorFinalMonto_post()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->ffm(),
			'formula' => $this->formula
		], REST_Controller::HTTP_OK);
	}
	public function factorInicialPlazo_post()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->fip(),
			'formula' => $this->formula
		], REST_Controller::HTTP_OK);
	}
	public function factorFinalPlazo_post()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->ffp(),
			'formula' => $this->formula
		], REST_Controller::HTTP_OK);
	}
	public function maximoMonto_post()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->maxm(),
			'formula' => $this->formula
		], REST_Controller::HTTP_OK);
	}
	public function maximoPlazo_post()
	{		
		$this->response([
			'status' => TRUE,
			'data'   => $this->maxp(),
			'formula' => $this->formula
		], REST_Controller::HTTP_OK);
	}
	public function tablaFactores_get()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->Formulas_mdl->tablaFactores()
		], REST_Controller::HTTP_OK);
	}
	public function solicitudesAyudate_get()
	{
		$this->response([
			'status' => TRUE,
			'data'   => $this->Formulas_mdl->solicitudesAyudate()
		], REST_Controller::HTTP_OK);
	}
	private function fim()
	{
		$post = $this->post();
		$this->formula = '';
		$funcion = $this->Formulas_mdl->obtenerEstructuraControl(66);
		if(!empty($funcion) && !empty($funcion->id)){
			$this->verificarEstructuraControl($funcion,$post);
		}
		$respuesta='';
		eval('$respuesta='.$this->formula.';');
		return $respuesta;
	}
	private function ffm()
	{
		$post = $this->post();
		$this->formula = '';
		$funcion = $this->Formulas_mdl->obtenerEstructuraControl(67);
		if(!empty($funcion) && !empty($funcion->id)){
			$this->verificarEstructuraControl($funcion,$post);
		}
		$respuesta='';
		eval('$respuesta='.$this->formula.';');
		return $respuesta;
	}
	private function fip(){
		$post = $this->post();
		$this->formula = '';
		$funcion = $this->Formulas_mdl->obtenerEstructuraControl(68);
		if(!empty($funcion) && !empty($funcion->id)){
			$this->verificarEstructuraControl($funcion,$post);
		}
		$respuesta='';
		eval('$respuesta='.$this->formula.';');
		return $respuesta;
	}
	private function ffp(){
		$post = $this->post();
		$this->formula = '';
		$funcion = $this->Formulas_mdl->obtenerEstructuraControl(69);
		if(!empty($funcion) && !empty($funcion->id)){
			$this->verificarEstructuraControl($funcion,$post);
		}
		$respuesta='';
		eval('$respuesta='.$this->formula.';');
		return $respuesta;
	}
	private function maxm(){
		$post = $this->post();
		$this->formula = '';
		$funcion = $this->Formulas_mdl->obtenerEstructuraControl(70);
		if(!empty($funcion) && !empty($funcion->id)){
			$this->verificarEstructuraControl($funcion,$post);
		}
		$respuesta='';
		eval('$respuesta='.$this->formula.';');
		return $respuesta;
	}
	private function maxp(){
		$post = $this->post();
		$this->formula = '';
		$funcion = $this->Formulas_mdl->obtenerEstructuraControl(71);
		if(!empty($funcion) && !empty($funcion->id)){
			$this->verificarEstructuraControl($funcion,$post);
		}
		$respuesta='';
		eval('$respuesta='.$this->formula.';');
		return $respuesta;
	}
	private function plazo_maximo()
	{
		$post = $this->post();
		$this->formula = '';
		$funcion = $this->Formulas_mdl->obtenerEstructuraControl(72);
		if(!empty($funcion) && !empty($funcion->id)){
			$this->verificarEstructuraControl($funcion,$post);
		}
		$plazo_max='';
		eval('$plazo_max='.$this->formula.';');
		return floor($plazo_max);
	}
	private function descuento_maximo_politicas()
	{
		$post = $this->post();
		$plazo_max = $this->plazo_maximo();
		$periodo_mes = $this->periodo_mes();
		$credito_maximo_politicas = $this->credito_maximo_politicas();
		$tasa = $post['tdi']/($periodo_mes*12);
		$descuento_maximo_politicas = $this->funciones_lib->pmt($tasa,$plazo_max,-$credito_maximo_politicas,0);
		return round($descuento_maximo_politicas,2);
	}
	private function credito_maximo_politicas($usar_monto = true)
	{
		$post = $this->post();
		$this->formula = '';
		$funcion = $this->Formulas_mdl->obtenerEstructuraControl(78);
		if(!empty($funcion) && !empty($funcion->id)){
			$this->verificarEstructuraControl($funcion,$post);
		}
		$credito_maximo_politicas = '';
		eval('$credito_maximo_politicas='.$this->formula.';');
		if($usar_monto){
			$credito_maximo_politicas = floor($credito_maximo_politicas/500)*500;
		}
		return $credito_maximo_politicas;
	}
	private function credito_maximo_nomina()
	{
		$post = $this->post();
		$sueldo = $this->sueldo();
		$periodo_mes = $this->periodo_mes();
		$ponderacion_ant = $this->Formulas_mdl->ponderacion_antiguedad($post);
		$pago_maximo = $this->capacidad_pago_politicas();
		$plazo_max = $this->plazo_maximo();
		$descuento_maximo_politicas = $this->descuento_maximo_politicas();
		$fim = $this->fim();
		$ffm = $this->ffm();
		$credito_maximo_politicas = $this->credito_maximo_politicas();

		// Credito máximo nomina
		$this->formula = '';
		$tasa = $post['tdi']/($periodo_mes*12);
		if($descuento_maximo_politicas>$pago_maximo){
			$post['formula_nomina'] = -$this->funciones_lib->pv($tasa,$plazo_max,$pago_maximo,0);
		}else{
			$post['formula_nomina'] = $credito_maximo_politicas;
		}
		$funcion = $this->Formulas_mdl->obtenerEstructuraControl(77);
		if(!empty($funcion) && !empty($funcion->id)){
			$this->verificarEstructuraControl($funcion,$post);
		}
		$credito_maximo_nomina = '';
		eval('$credito_maximo_nomina='.$this->formula.';');
		return $credito_maximo_nomina;
	}
	private function periodo_mes()
	{
		$post = $this->post();
		$this->formula = '';
		$funcion = $this->Formulas_mdl->obtenerEstructuraControl(56);
		if(!empty($funcion) && !empty($funcion->id)){
			$this->verificarEstructuraControl($funcion,$post);
		}
		$periodo_mes = '';
		eval('$periodo_mes='.$this->formula.';');
		return $periodo_mes;
	}
	private function sueldo()
	{
		$post = $this->post();
		$this->formula = '';
		$funcion = $this->Formulas_mdl->obtenerEstructuraControl(52);
		if(!empty($funcion) && !empty($funcion->id)){
			$this->verificarEstructuraControl($funcion,$post);
		}
		$sueldo = '';
		eval('$sueldo='.$this->formula.';');
		return $sueldo;
	}
}
