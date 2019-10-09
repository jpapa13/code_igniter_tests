<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['(.)+']['OPTIONS']='Plantilla';

//USUARIOS
$route['configuraciones/usuarios']['GET'] = 'configuraciones/Usuarios/obtenerUsuarios';
$route['configuraciones/usuarios/detalle']['GET'] = 'configuraciones/Usuarios/obtenerDetalleUsuario';
$route['configuraciones/usuarios/agregar']['POST'] = 'configuraciones/Usuarios/agregar';
$route['configuraciones/usuarios/agregar_permisos']['POST'] = 'configuraciones/usuarios/agregar_permisos';
$route['configuraciones/usuarios/agregar_perfiles']['POST'] = 'configuraciones/usuarios/agregar_perfiles';
$route['configuraciones/usuarios/editar']['PUT'] = 'configuraciones/Usuarios/editar';
$route['configuraciones/usuarios/eliminar/(:num)']['DELETE'] = 'configuraciones/Usuarios/eliminar/$1';

//PERFILES
$route['configuraciones/perfiles']['GET'] = 'configuraciones/Perfiles/obtenerPerfiles';
$route['configuraciones/perfiles/todos']['GET'] = 'configuraciones/Perfiles/obtenerPerfilesTodos';
$route['configuraciones/perfiles/detalle']['GET'] = 'configuraciones/Perfiles/obtenerDetallePerfil';
$route['configuraciones/perfiles/agregar']['POST'] = 'configuraciones/Perfiles/agregar';
$route['configuraciones/perfiles/agregar_permisos']['POST'] = 'configuraciones/Perfiles/agregar_permisos';
$route['configuraciones/perfiles/editar']['PUT'] = 'configuraciones/Perfiles/editar';
$route['configuraciones/perfiles/eliminar/(:num)']['DELETE'] = 'configuraciones/Perfiles/eliminar/$1';

//PERMISOS
$route['configuraciones/permisos']['GET'] = 'configuraciones/Permisos/obtenerPermisos';
$route['configuraciones/permisos/detalle']['GET'] = 'configuraciones/Permisos/obtenerDetallePermiso';
$route['configuraciones/permisos/agregar']['POST'] = 'configuraciones/Permisos/agregar';
$route['configuraciones/permisos/editar']['PUT'] = 'configuraciones/Permisos/editar';
$route['configuraciones/permisos/eliminar/(:num)']['DELETE'] = 'configuraciones/Permisos/eliminar/$1';

//LOGIN
$route['login/auth']['GET'] = 'Login/auth';
$route['login/permisos']['GET'] = 'Login/permisos';
$route['login/ingresar']['POST'] = 'Login/login';
$route['login/salir']['POST'] = 'Login/logout';

//CONFIGURACION FORMULAS
$route['configuraciones/formulas/generar_formula']['POST'] = 'configuraciones/Formulas/guardarFormula';
$route['configuraciones/formulas/generar_resultado']['GET'] = 'configuraciones/Formulas/generarResultado';

$route['configuraciones/formulas/estructura_control/agregar']['POST'] = 'configuraciones/Formulas/agregarEstructuraControl';
$route['configuraciones/formulas/bloques/agregar']['POST'] = 'configuraciones/Formulas/agregarBloques';
$route['configuraciones/formulas/variables/agregar']['POST'] = 'configuraciones/Formulas/agregarVariables';

$route['configuraciones/formulas/estructura_control/editar']['PUT'] = 'configuraciones/Formulas/editarEstructuraControl';
$route['configuraciones/formulas/bloques/editar']['PUT'] = 'configuraciones/Formulas/editarBloques';
$route['configuraciones/formulas/variables/editar']['PUT'] = 'configuraciones/Formulas/editarVariables';

$route['configuraciones/formulas/estructura_control/eliminar']['DELETE'] = 'configuraciones/Formulas/eliminarEstructuraControl';
$route['configuraciones/formulas/bloques/eliminar']['DELETE'] = 'configuraciones/Formulas/eliminarBloques';
$route['configuraciones/formulas/variables/eliminar']['DELETE'] = 'configuraciones/Formulas/eliminarVariables';

$route['configuraciones/formulas/obtener_variables']['GET'] = 'configuraciones/Formulas/obtenerVariables';
$route['configuraciones/formulas/obtener_condiciones']['GET'] = 'configuraciones/Formulas/obtenerCondiciones';
$route['configuraciones/formulas/obtener_bloques']['GET'] = 'configuraciones/Formulas/obtenerBloques';
$route['configuraciones/formulas/obtener_estructuras_control']['GET'] = 'configuraciones/Formulas/obtenerEstructurasControl';
$route['configuraciones/formulas/obtener_funciones']['GET'] = 'configuraciones/Formulas/obtenerFunciones';

$route['configuraciones/formulas/catalogos']['GET'] = 'configuraciones/Formulas/obtenerCatalogos';
$route['configuraciones/formulas/catalogos_lista']['GET'] = 'configuraciones/Formulas/obtenerCatalogosLista';
$route['configuraciones/formulas/variable_generales']['GET'] = 'configuraciones/Formulas/obtenerVariablesGenerales';
$route['configuraciones/formulas/variable']['GET'] = 'configuraciones/Formulas/obtenerDetalleVariable';
$route['configuraciones/formulas/bloque']['GET'] = 'configuraciones/Formulas/obtenerDetalleBloque';
$route['configuraciones/formulas/estructura_control']['GET'] = 'configuraciones/Formulas/obtenerDetalleEstructuraControl';
$route['configuraciones/formulas/funcion']['GET'] = 'configuraciones/Formulas/obtenerDetalleFuncion';
$route['configuraciones/formulas/tipos_formulas']['GET'] = 'configuraciones/Formulas/obtenerTiposFormulas';

$route['configuraciones/formulas/factor_inicial_monto']['POST'] = 'configuraciones/Formulas/factorInicialMonto';
$route['configuraciones/formulas/factor_final_monto']['POST'] = 'configuraciones/Formulas/factorFinalMonto';
$route['configuraciones/formulas/factor_inicial_plazo']['POST'] = 'configuraciones/Formulas/factorInicialPlazo';
$route['configuraciones/formulas/factor_final_plazo']['POST'] = 'configuraciones/Formulas/factorFinalPlazo';
$route['configuraciones/formulas/factor_maximo_monto']['POST'] = 'configuraciones/Formulas/maximoMonto';
$route['configuraciones/formulas/factor_maximo_plazo']['POST'] = 'configuraciones/Formulas/maximoPlazo';
$route['configuraciones/formulas/pago_maximo']['POST'] = 'configuraciones/Formulas/pagoMaximo';
$route['configuraciones/formulas/plazo_maximo']['POST'] = 'configuraciones/Formulas/plazoMaximo';
$route['configuraciones/formulas/credito_maximo']['POST'] = 'configuraciones/Formulas/creditoMaximo';
$route['configuraciones/formulas/descuento_maximo']['POST'] = 'configuraciones/Formulas/descuentoMaximo';
$route['configuraciones/formulas/tabla_factores']['GET'] = 'configuraciones/Formulas/tablaFactores';
$route['configuraciones/formulas/solicitudesAyudate']['GET'] = 'configuraciones/Formulas/solicitudesAyudate';

//SOLICITUDES
$route['componentes/solicitud/agregar']['POST'] = 'componentes/Solicitud/agregarDatos';
$route['componentes/solicitudes/ver_todos']['GET'] = 'componentes/Solicitudes/todos';

//LUGARES
$route['componentes/lugares/galeria']['POST'] = 'componentes/Lugares/archivos_todos';

//EVENTOS
$route['componentes/eventos/banners']['POST'] = 'componentes/Eventos/archivo_banner';
$route['componentes/eventos/detalle']['POST'] = 'componentes/Eventos/detalle';
$route['componentes/eventos/imagenes']['POST'] = 'componentes/Eventos/imagenes';

//DIRECTORIO
$route['componentes/directorio/area/obtener']['POST'] = 'componentes/Directorio/obtener_area';

//CATALOGOS
$route['catalogos/carreras']['GET'] = 'catalogos/Carrera/todos';
$route['catalogos/tipos_archivo']['GET'] = 'catalogos/TipoArchivo/todos';
$route['catalogos/tags']['GET'] = 'catalogos/Tag/todos';
$route['catalogos/puestos']['GET'] = 'catalogos/Puesto/todos';
$route['catalogos/tipos_lugar']['GET'] = 'catalogos/TipoLugar/todos';
$route['catalogos/estatus']['GET'] = 'catalogos/Estatus/todos';

//PLANTILLA
$route['plantilla']['GET'] = 'Plantilla/index';
$route['plantilla/agregar']['POST'] = 'Plantilla/index';
$route['plantilla/editar']['PUT'] = 'Plantilla/index';
$route['plantilla/editar_uno']['PATCH'] = 'Plantilla/index';
$route['plantilla/borrar']['DELETE'] = 'Plantilla/index';

$route['default_controller'] = 'Error';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
