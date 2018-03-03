<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

class GlobalValue{
    /*Roles*/
    const ROLE_EMPRESA_ID = 1;
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_EMPRESA = 'ROLE_EMPRESA';
    const ROLE_VENDEDOR = 'ROLE_VENDEDOR';
    const ROLE_CARGADATOS = 'ROLE_CARGADATOS';
    const ROLE_DEPOSITO = 'ROLE_DEPOSITO';
    const ROLE_CLIENTE = 'ROLE_CLIENTE';
    
    const ROLE_ADMIN_DISPLAY = 'Administrador';
    const ROLE_EMPRESA_DISPLAY = 'Empresa';
    const ROLE_VENDEDOR_DISPLAY = 'Vendedor';
    const ROLE_CARGADATOS_DISPLAY = 'Carga de Datos';
    const ROLE_DEPOSITO_DISPLAY = 'Deposito';
    const ROLE_CLIENTE_DISPLAY = 'Cliente';
    
    const ROLES = 
            array(
                    GlobalValue::ROLE_ADMIN => GlobalValue::ROLE_ADMIN_DISPLAY,
                    GlobalValue::ROLE_EMPRESA => GlobalValue::ROLE_EMPRESA_DISPLAY,
                    GlobalValue::ROLE_VENDEDOR => GlobalValue::ROLE_VENDEDOR_DISPLAY,
                    GlobalValue::ROLE_CARGADATOS => GlobalValue::ROLE_CARGADATOS_DISPLAY,
                    GlobalValue::ROLE_DEPOSITO => GlobalValue::ROLE_DEPOSITO_DISPLAY,
                    GlobalValue::ROLE_CLIENTE => GlobalValue::ROLE_CLIENTE_DISPLAY
                );
    
    
    
    
    
    /*DIAS de la Semana*/
    const LUNES_DISPLAY = 'Lunes';
    const MARTES_DISPLAY = 'Martes';
    const MIERCOLES_DISPLAY = 'Miercoles';
    const JUEVES_DISPLAY = 'Jueves';
    const VIERNES_DISPLAY = 'Viernes';
    const SABADO_DISPLAY = 'Sabado';
    const DOMINGO_DISPLAY = 'Domingo';
    
    const LUNES_ID = 1;
    const MARTES_ID = 2;
    const MIERCOLES_ID = 3;
    const JUEVES_ID = 4;
    const VIERNES_ID = 5;
    const SABADO_ID = 6;
    const DOMINGO_ID = 7;
    
    const DIAS_SEMANA = 
            array(
                    GlobalValue::LUNES_ID => GlobalValue::LUNES_DISPLAY,
                    GlobalValue::MARTES_ID => GlobalValue::MARTES_DISPLAY,
                    GlobalValue::MIERCOLES_ID => GlobalValue::MIERCOLES_DISPLAY,
                    GlobalValue::JUEVES_ID => GlobalValue::JUEVES_DISPLAY,
                    GlobalValue::VIERNES_ID => GlobalValue::VIERNES_DISPLAY,
                    GlobalValue::SABADO_ID => GlobalValue::SABADO_DISPLAY,
                    GlobalValue::DOMINGO_ID => GlobalValue::DOMINGO_DISPLAY
                );
    
    const DIAS_SEMANA_SELECT = 
            array(
                    GlobalValue::LUNES_DISPLAY => GlobalValue::LUNES_ID  ,
                    GlobalValue::MARTES_DISPLAY => GlobalValue::MARTES_ID ,
                    GlobalValue::MIERCOLES_DISPLAY => GlobalValue::MIERCOLES_ID,
                    GlobalValue::JUEVES_DISPLAY => GlobalValue::JUEVES_ID ,
                    GlobalValue::VIERNES_DISPLAY => GlobalValue::VIERNES_ID ,
                    GlobalValue::SABADO_DISPLAY => GlobalValue::SABADO_ID ,
                    GlobalValue::DOMINGO_DISPLAY => GlobalValue::DOMINGO_ID 
                );
    
    
    
    
    
    /*Estado de pedido*/
    const PENDIENTE = 1;
    const ENVIADO = 2;
    const PREPARADO = 3;
    const ENTREGADO = 4;
    const PAGADO = 5;
    
    const PENDIENTE_DISPLAY = 'Pendiente';
    const ENVIADO_DISPLAY = 'Pendiente (Android)';
    const PREPARADO_DISPLAY = 'Preparado';
    const ENTREGADO_DISPLAY = 'Entregado';
    const PAGADO_DISPLAY = 'Pagado';
    
    const ESTADOS = array(
                            GlobalValue::PENDIENTE =>GlobalValue::PENDIENTE_DISPLAY,
                            GlobalValue::ENVIADO => GlobalValue::ENVIADO_DISPLAY,
                            GlobalValue::ENTREGADO => GlobalValue::ENTREGADO_DISPLAY,    
                            GlobalValue::PREPARADO => GlobalValue::PREPARADO_DISPLAY,
                            GlobalValue::PAGADO => GlobalValue::PAGADO_DISPLAY);
    
    const ESTADOS_SELECT = 
                        array(
                          GlobalValue::PENDIENTE_DISPLAY =>GlobalValue::PENDIENTE ,
                          GlobalValue::PREPARADO_DISPLAY => GlobalValue::PREPARADO ,
                          GlobalValue::ENVIADO_DISPLAY => GlobalValue::ENVIADO ,
                          GlobalValue::ENTREGADO_DISPLAY => GlobalValue::ENTREGADO,
                          GlobalValue::PAGADO_DISPLAY=> GlobalValue::PAGADO
                        );
    
    
    //CONDICION IVA 
    const CONDICION_RESPONSABLEINSCRIPTO = 1;
    const CONDICION_EXCENTO = 2;
    
    const CONDICION_RESPONSABLEINSCRIPTO_DISPLAY = 'RESPONSABLE INSCRIPTO';
    const CONDICION_EXCENTO_DISPLAY = 'EXCENTO';
    
    const CONDICION_IVA = array(
                                GlobalValue::CONDICION_RESPONSABLEINSCRIPTO =>GlobalValue::CONDICION_RESPONSABLEINSCRIPTO_DISPLAY,
                                GlobalValue::CONDICION_EXCENTO => GlobalValue::CONDICION_EXCENTO_DISPLAY,
                        );
    const CONDICION_IVA_SELECT = array(
                                GlobalValue::CONDICION_RESPONSABLEINSCRIPTO_DISPLAY =>GlobalValue::CONDICION_RESPONSABLEINSCRIPTO,
                                GlobalValue::CONDICION_EXCENTO_DISPLAY => GlobalValue::CONDICION_EXCENTO,
                        );
    
    
    
    //TIPO DOCUMENTO IVA 
    const TIPODOC_DNI = 1;
    const TIPODOC_LC = 2;
    
    const TIPODOC_DNI_DISPLAY = 'Documento Nacional de Identidad';
    const CONDICION_LC_DISPLAY = 'Libreta Civica';
    
    const TIPODOC = array(
                                GlobalValue::TIPODOC_DNI =>GlobalValue::TIPODOC_DNI_DISPLAY,
                                GlobalValue::TIPODOC_LC => GlobalValue::CONDICION_LC_DISPLAY,
                        );
    const TIPODOC_SELECT = array(
                                GlobalValue::TIPODOC_DNI_DISPLAY =>GlobalValue::TIPODOC_DNI,
                                GlobalValue::CONDICION_LC_DISPLAY => GlobalValue::TIPODOC_LC,
                        );
    
    
    
    //Tipo de Movimientos
    const INGRESO = 1;
    const EGRESO = 2;
    const INICIALIZACION = 3;
  
    const INGRESO_DISPLAY = 'Ingreso';
    const EGRESO_DISPLAY = 'Egreso';
    const INICIALIZACION_DISPLAY = 'Inicializacion';
    
    const TIPOMOVIMIENTOS = array(
                                GlobalValue::INGRESO =>GlobalValue::INGRESO_DISPLAY,
                                GlobalValue::EGRESO => GlobalValue::EGRESO_DISPLAY,
                                GlobalValue::INICIALIZACION => GlobalValue::INICIALIZACION_DISPLAY,
                        );
    
    const TIPOMOVIMIENTOS_SELECT = 
                        array(
                                GlobalValue::INGRESO_DISPLAY =>GlobalValue::INGRESO ,
                                GlobalValue::EGRESO_DISPLAY => GlobalValue::EGRESO ,  
                                GlobalValue::INICIALIZACION_DISPLAY => GlobalValue::INICIALIZACION 
                        );
    
    //Tipos de Archivos
    const ARCHIVO_PRODUCTOS = 1;
    const ARCHIVO_CLIENTES = 2;
    const ARCHIVO_STOCK = 3;
    const ARCHIVO_LISTAPRECIOS = 4;
    const ARCHIVO_PRODUCTOS_DISPLAY = 'PRODUCTOS';
    const ARCHIVO_CLIENTES_DISPLAY = 'CLIENTES';
    const ARCHIVO_LISTAPRECIOS_DISPLAY = 'ACTUALIZAR LISTA DE PRECIOS';
    const ARCHIVO_STOCK_DISPLAY = 'ACTUALIZAR STOCK';
    
    const ARCHIVO_TIPO_SELECT = 
                        array(
                                GlobalValue::ARCHIVO_PRODUCTOS_DISPLAY =>GlobalValue::ARCHIVO_PRODUCTOS ,
                                GlobalValue::ARCHIVO_CLIENTES_DISPLAY => GlobalValue::ARCHIVO_CLIENTES ,  
                                //GlobalValue::ARCHIVO_LISTAPRECIOS_DISPLAY => GlobalValue::ARCHIVO_LISTAPRECIOS,
                                //GlobalValue::ARCHIVO_STOCK_DISPLAY => GlobalValue::ARCHIVO_STOCK
                        );
    
    const ARCHIVO_TIPOS = 
                        array(
                                GlobalValue::ARCHIVO_PRODUCTOS =>GlobalValue::ARCHIVO_PRODUCTOS_DISPLAY ,
                                GlobalValue::ARCHIVO_CLIENTES => GlobalValue::ARCHIVO_CLIENTES_DISPLAY ,  
                               // GlobalValue::ARCHIVO_LISTAPRECIOS => GlobalValue::ARCHIVO_LISTAPRECIOS_DISPLAY,
                                //GlobalValue::ARCHIVO_STOCK => GlobalValue::ARCHIVO_STOCK_DISPLAY
                        );
    
    // Estado de Archivos
    const ARCHIVO_ESTADO_UPLOAD = 1;
    const ARCHIVO_ESTADO_PROCESADO = 2;
    const ARCHIVO_ESTADO_ERROR_UPLOAD = 3;
    const ARCHIVO_ESTADO_ERROR_PROCESADO = 4;
    
    
    const ARCHIVO_ESTADO_UPLOAD_DISPLAY = 'SUBIDO';
    const ARCHIVO_ESTADO_PROCESADO_DISPLAY = 'PROCESADO';
    const ARCHIVO_ESTADO_ERROR_UPLOAD_DISPLAY = 'NO SE PUDO SUBIR';
    const ARCHIVO_ESTADO_ERROR_PROCESADO_DISPLAY = 'NO SE PUDO PROCCESAR';
    
    const ARCHIVO_ESTADOS = 
                        array(
                                GlobalValue::ARCHIVO_ESTADO_UPLOAD =>GlobalValue::ARCHIVO_ESTADO_UPLOAD_DISPLAY ,
                                GlobalValue::ARCHIVO_ESTADO_PROCESADO => GlobalValue::ARCHIVO_ESTADO_PROCESADO_DISPLAY ,  
                                GlobalValue::ARCHIVO_ESTADO_ERROR_UPLOAD=> GlobalValue::ARCHIVO_ESTADO_ERROR_UPLOAD_DISPLAY ,  
                                GlobalValue::ARCHIVO_ESTADO_ERROR_PROCESADO => GlobalValue::ARCHIVO_ESTADO_ERROR_PROCESADO_DISPLAY ,  
                        );
    
    // PRODUCTOS
    const PRODUCTO_CODIGOEXTERNO=0;
    const PRODUCTO_NOMBRE=1;
    const PRODUCTO_DESCRIPCION=2;
    const PRODUCTO_PRECIO=3;
    const PRODUCTO_STOCK=4;
    
    // CLIENTES
    const CLIENTE_CODIGOEXTERNO = 0 ;
    const CLIENTE_RAZONSOCIAL   = 1;
    const CLIENTE_CONDICIONIVA  = 2;
    const CLIENTE_DIRECCION     = 3;
    const CLIENTE_NRODOC        = 4;
    const CLIENTE_TELEFONO      = 5;
    const CLIENTE_CONTACTO      = 6;
                        
    // STOCK
    const STOCK_CODIGOEXTERNO=0;
    const STOCK_CANTIDAD=1;
    
    // LISTA DE PRECIOS
    const LISTAPRECIOS_CODIGOEXTERNO=0;
    const LISTAPRECIOS_PRECIO=1;
    
    const ERROR_VALIDATEFILE= 99;
    
    const CODE_HELADERIA_ROMA = 1;
    
}