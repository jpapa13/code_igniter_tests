<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitud_mdl extends CI_Model{

    
    public function insertarDatos($dato)
    {
        $this->db->trans_start();
        $this->db->insert('clientes',array(
            'nombre'=> $dato['nombre'],
            'apellido_materno'=>$dato['apellido_paterno'],
            'apellido_paterno'=>$dato['apellido_materno'],
            'fecha_nacimiento'=>$dato['fecha_nacimiento'],
            'estado_nacimiento_id'=>$dato['lugar_nacimiento'] == '' ? NULL : $dato['lugar_nacimiento'],
            'genero_id'=> $dato['sexo'] == '' ? NULL : $dato['sexo'],
            'ubicacion_negocio_id'=>$dato['tipo_ubicacion_negocio'] == '' ? NULL : $dato['tipo_ubicacion_negocio'],
            'tipo_cliente_id'=>$dato['tipo_cliente'],
            'estatus_id' => 4,
            'fecha_creacion' => date('Y-m-d H:i:s'),
        ));

        $last_insert_id_cliente = $this->db->insert_id();

        $this->db->insert('usuarios',array(
            'correo' => 'correo',
            'password' => 'contrasena',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus' => 1
        ));

        $last_insert_id_usuario = $this->db->insert_id();

        $this->db->where('id', $last_insert_id_cliente);
        $this->db->set(array(
            'usuario_id'=> $last_insert_id_usuario
        ));
        $this->db->update('clientes');

        $this->db->insert('detalle_cliente',array(
            'cliente_id'=> $last_insert_id_cliente,
            'curp'=>$dato['curp'],
            'rfc'=>$dato['rfc'],
            'codigo_postal'=>$dato['codigo_postal'],
            'no_exterior'=>$dato['no_exterior'],
            'no_interior'=>$dato['no_interior'],
            'calle'=>$dato['calle'],
            'colonia'=>$dato['colonia'] == '' ? NULL : $dato['colonia'],
            'municipio'=>$dato['municipio'] == '' ? NULL : $dato['municipio'],
            'entidad_id'=>$dato['estado'] == '' ? NULL : $dato['estado'],
            'telefono' => $dato['telefono'],
            'codigo_postal_negocio' => $dato['codigo_postal_negocio'],
            'no_exterior_negocio' => $dato['no_exterior_negocio'],
            'no_interior_negocio' => $dato['no_interior_negocio'],
            'calle_negocio' => $dato['calle_negocio'],
            'colonia_negocio' => $dato['colonia_negocio'] == '' ? NULL : $dato['colonia_negocio'],
            'municipio_negocio' => $dato['municipio_negocio'] == '' ? NULL : $dato['municipio_negocio'],
            'estado_negocio' => $dato['estado_negocio'] == '' ? NULL : $dato['estado_negocio'],
            'industria' => $dato['industria'],
            'subindustria' => $dato['subindustria'],
            'nombre_negocio' => $dato['nombre_negocio'],
            'no_empleados' => $dato['no_empleados'],
            'pag_web' => $dato['pag_web'],
            'nombre_contacto_admin' => $dato['nombre_contacto_admin'],
            'correo_contacto_admin' => $dato['correo_contacto_admin'],
            'telefono_contacto_admin' => $dato['telefono_contacto_admin'],
        ));

        $this->db->insert('solicitudes',array(
            'cliente_id' => $last_insert_id_cliente,
            'usuario_id' => $last_insert_id_usuario,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'fecha_estatus' => date('Y-m-d H:i:s'),
            'bien' => $dato['bien'],
            'especificar_bien' => $dato['especificar_bien'],
            'costo_bien' => $dato['costo_bien']  == '' ? NULL : $dato['costo_bien'],
            'estatus' => 1,
            'estatus_id' => 4
        ));

        $last_insert_id_solicitud = $this->db->insert_id();

        if($dato['tipo_cliente'] == 1){
            $this->db->insert('personas_fisicas',array(
                'id_cliente' => $last_insert_id_cliente,
                'estatus_casa_id' => $dato['estatus_casa'],
                'ingreso_mensual_banco' => $dato['ingreso_mensual_banco'],
                'ingreso_mensual_efectivo' => $dato['ingreso_mensual_efectivo'],
                'pago_fin_auto' => $dato['pago_fin_auto'],
                'pago_renta' => $dato['pago_renta'],
                'otros_gastos' => $dato['otros_gastos'],
                'ocupacion' => $dato['ocupacion'],
                'ocupacion_otro' => $dato['ocupacion_otro']
            ));
        } else {
            $this->db->insert('accionistas',array(
                'cliente_id' => $last_insert_id_cliente,
                'nombre_accionista' => $dato['nombre_accionista1'],
                'rfc_accionista' => $dato['rfc_accionista1'],
                'porcentaje_accionista' => $dato['porcentaje_accionista1'],
            ));
            $i=2;
            foreach($dato['accionistas'] as $accionista){
                $this->db->insert('accionistas',array(
                    'cliente_id' => $last_insert_id_cliente,
                    'nombre_accionista' => $accionista['nombre_accionista'.$i],
                    'rfc_accionista' => $accionista['rfc_accionista'.$i],
                    'porcentaje_accionista' => $accionista['porcentaje_accionista'.$i],
                ));
                $i++;
            }
        }



        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Copia de identificación oficial vigente',
            'subtipo_documento_id' => 1,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Copia del comprobante de domicilio',
            'subtipo_documento_id' => 1,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Formato Buro de Crédito* firmado',
            'subtipo_documento_id' => 1,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Copia de la cédula del RFC',
            'subtipo_documento_id' => 1,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Acta constitutiva completa y ultima modificación',
            'subtipo_documento_id' => 1,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));     
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Última declaración de impuestos',
            'subtipo_documento_id' => 1,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));           
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Estados de cuenta emitidos por el banco 1',
            'subtipo_documento_id' => 1,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Estados de cuenta emitidos por el banco 2',
            'subtipo_documento_id' => 1,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));  
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Estados de cuenta emitidos por el banco 3',
            'subtipo_documento_id' => 1,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));      
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Cotizacion de Garantía Firmada por titular',
            'subtipo_documento_id' => 1,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        )); 
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Copia de identificación oficial vigente',
            'subtipo_documento_id' => 2,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Copia del comprobante de domicilio',
            'subtipo_documento_id' => 2,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));        
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Formato Buro de Crédito* firmado',
            'subtipo_documento_id' => 2,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));     
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Estados de cuenta de cheques 1',
            'subtipo_documento_id' => 2,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Estados de cuenta de cheques 2',
            'subtipo_documento_id' => 2,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Estados de cuenta de cheques 3',
            'subtipo_documento_id' => 2,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Contrato firmado',
            'subtipo_documento_id' => 2,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Factura',
            'subtipo_documento_id' => 3,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Poliza seguro',
            'subtipo_documento_id' => 3,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Instalación GPS',
            'subtipo_documento_id' => 3,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Tarjeta de circulación',
            'subtipo_documento_id' => 3,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));
        $this->db->insert('documentos',array(
            'solicitud_id' => $last_insert_id_solicitud,
            'tipo_documento_id' => 1,
            'titulo' => 'Carta recepción de equipo',
            'subtipo_documento_id' => 3,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'estatus_id' => 15
        ));
        $this->db->trans_complete();
        return $this->db->trans_status();
    }


}

?>