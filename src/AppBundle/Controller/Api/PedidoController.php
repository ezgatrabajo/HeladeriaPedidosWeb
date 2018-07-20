<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Pedido;

use AppBundle\Entity\Producto;

use AppBundle\Entity\User;
use AppBundle\Entity\Pedidodetalle;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use \FOS\RestBundle\Controller\FOSRestController;
use Exception;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\GlobalValue;
use DateTime;
use DateInterval;



class PedidoController extends FOSRestController{
    
    /**
     * @Rest\Post("/api/pedidos")
    */
    public function postPedidosListAction(Request $request){
        try{
            
            $content = $request->getContent();
            $code    = Response::HTTP_OK; 
            $message ='OK'; 
            $result  = "";
            $pedido  = new Pedido();
            $json    = json_decode($content, true);
            $fecha_desde = '';
            $fecha_hasta = '';
            $cliente     = '';
            $user        = '';
            $empresa     = '';

            //Preparar parametros
            $queryBuilder = $this->getDoctrine()->getRepository(Pedido::class)->createQueryBuilder('p');
            
            if (array_key_exists ('user_id', $json)){
                $user_id     = $json['user_id'];
                $user = $this->getDoctrine()->getRepository(User::class)->find($user_id);
                if (!$user) {
                    $respuesta = array('code'=>Response::HTTP_PRECONDITION_REQUIRED,  'message'=>'No se encontro usuario', 'data'=>$result);
                    return $respuesta;
                }
                $queryBuilder->andWhere('p.user = :user')->setParameter('user',  $user);   
            }
            
            if (array_key_exists ('fecha_desde', $json)){
                $fecha_desde = $json['fecha_desde'];
                $fecha_desde = (new \DateTime($fecha_desde));
                $queryBuilder->andWhere('p.fecha >= :fechadesde')->setParameter('fechadesde',  $fecha_desde);   
            }
            
            if (array_key_exists ('fecha_hasta',$json)){
                $fecha_hasta = $json['fecha_hasta'];
                $fecha_hasta = (new \DateTime($fecha_hasta));
                $queryBuilder->andWhere('p.fecha <= :fechahasta')->setParameter('fechahasta',  $fecha_hasta);   
            }
            
            if (array_key_exists ('estado_id',$json)){
                $estado_id  = $json['estado_id'];
                $queryBuilder->andWhere('p.estadoId = :estadoid')->setParameter('estadoid',  $estado_id);   
            }
            
            $registros = $queryBuilder->getQuery();
            $respuesta = array('code'=>$code,
                               'message'=>$message,
                               'data'=>$registros->execute() ,
                               'response' => 'success',
                            );

            return $respuesta;
            
        }catch(Exception $e){
            $respuesta = array('code'=>Response::HTTP_PRECONDITION_REQUIRED,  'message'=>'Error', 'data'=>$e->getMessage());
            return $respuesta;
        }
    }
    
    
    //SE USA EN PEDIDODETALLE ADD, para actualizar la direccion
    /**
     * @Rest\Post("/api/pedido/updateestado")
     */
    public function postPedidosEstadoAction(Request $request){
        try{
            $content = $request->getContent();
            $em = $this->getDoctrine()->getManager();
            $json = json_decode($content, true);
            $code = Response::HTTP_OK; $message='OK';
            
            $pedido = new Pedido();
            $id              = $json['pedido']['id'];
            $tiempodemora    = $json['pedido']['tiempodemora'];
            $estadoid        = $json['pedido']['estadoid'];
            
            $pedido = $this->getDoctrine()->getRepository(Pedido::class)->find($id);
            
            //Campos heladeria
            $pedido->setEstadoId($estadoid);
            $pedido->setTiempodemora($tiempodemora);
            
            $time = new DateTime($pedido->getFecha()->format('Y-m-d H:i:s'));
            
            $pedido->setHoraEntrega($time->add(new DateInterval('PT' . $tiempodemora . 'M')));
            $em->persist($pedido);
            $em->flush();
            
            $response = array('code'=>$code,
                'message'=>$message,
                'data'=>$pedido
            );
            
        }catch(Exception $e){
            $response = array('code'=>Response::HTTP_CONFLICT,
                'message'=>$e->getMessage(),
                'data'=>''
            );
            
        }
        return $response;
    }
    
    
    
    
    
    //SE USA EN PEDIDODETALLE ADD, para actualizar la direccion
    /**
     * @Rest\Post("/api/pedido/updateaddress")
     */
    public function postPedidosUpdateAddressAction(Request $request){
        try{
            $content = $request->getContent();
            $em = $this->getDoctrine()->getManager();
            $json = json_decode($content, true);
            $code = Response::HTTP_OK; $message='OK'; 
            
            
            $pedido = new Pedido();
            $id            = $json['pedido']['id'];
            $localidad     = $json['pedido']['localidad'];
            $calle         = $json['pedido']['calle'];
            $nro           = $json['pedido']['nro'];
            $piso          = $json['pedido']['piso'];
            $telefono      = $json['pedido']['telefono'];
            $contacto      = $json['pedido']['contacto'];
            $pedido = $this->getDoctrine()->getRepository(Pedido::class)->find($id);
            
            //Campos heladeria
            $pedido->setLocalidad($localidad);
            $pedido->setCalle($calle);
            $pedido->setNro($nro);
            $pedido->setPiso($piso);
            $pedido->setContacto($contacto);
            $pedido->setTelefono($telefono);
            
            $em->persist($pedido);
            $em->flush();
            
            $response = array('code'=>$code,
                'message'=>$message,
                'data'=>$pedido
            );
            
            }catch(Exception $e){
                $response = array('code'=>Response::HTTP_CONFLICT,
                    'message'=>$e->getMessage(),
                    'data'=>''
                );
            
        }
        return $response;
    }
    
    
    /**
     * @Rest\Post("/api/pedido/updatemontos")
     */
    public function postPedidosUpdateMontosAction(Request $request){
        try{
            $content = $request->getContent();
            $em = $this->getDoctrine()->getManager();
            $json = json_decode($content, true);
            $code = Response::HTTP_OK; $message='OK';
            
            
            $pedido = new Pedido();
            $id            = $json['pedido']['id'];
            
            $cantidadkilos     = $json['pedido']['cantidadkilos'];
            $cantidadpotes     = $json['pedido']['cantidadpotes'];
            $cucharitas        = $json['pedido']['cucharitas'];
            $cucuruchos        = $json['pedido']['cucuruchos'];
            $montocucuruchos   = $json['pedido']['montocucuruchos'];
            $montohelados      = $json['pedido']['montohelados'];
            $montodescuento    = $json['pedido']['montodescuento'];
            $enviodomicilio    = $json['pedido']['enviodomicilio'];
            $monto             = $json['pedido']['monto'];
            $montoabona        = $json['pedido']['montoabona'];
            
            
            $pedido = $this->getDoctrine()->getRepository(Pedido::class)->find($id);
            
            //Campos heladeria
            $pedido->setCantidadkilos($cantidadkilos);
            $pedido->setCantidadpotes($cantidadpotes);
            $pedido->setCucharitas($cucharitas);
            $pedido->setCucuruchos($cucuruchos);
            $pedido->setMontocucuruchos($montocucuruchos);
            $pedido->setMontohelados($montohelados);
            $pedido->setMontodescuento($montodescuento);
            $pedido->setMonto($monto);
            $pedido->setEnviodomicilio($enviodomicilio);
            $pedido->setMontoabona($montoabona);
            
            
            $em->persist($pedido);
            $em->flush();
            
            $response = array('code'=>$code,
                'message'=>$message,
                'data'=>$pedido
            );
            
        }catch(Exception $e){
            $response = array('code'=>Response::HTTP_CONFLICT,
                'message'=>$e->getMessage(),
                'data'=>''
            );
            
        }
        return $response;
    }
    
    
    
    
    
    /**
    * @Rest\Post("/api/pedido/add")
    */
    public function postPedidosAddAction(Request $request){
        //leer json
        date_default_timezone_set ( "America/Argentina/Buenos_Aires" );
        $content = $request->getContent();
        $pedido = new Pedido();
        $code = Response::HTTP_OK; 
        $message='OK'; 
        $result = "";
        //parsear detalle
        $json = json_decode($content, true);
        $em = $this->getDoctrine()->getManager();
        
        //Leer Pedido
        //$fecha          = $json['pedido']['fecha']; //recibir fecha y hora
        $user_id        = $json['pedido']['user_id'];
        $android_id     = $json['pedido']['android_id'];
        $monto          = $json['pedido']['monto'];
        $subtotal       = $json['pedido']['subtotal'];
        $montoabona     = $json['pedido']['montoabona'];
        
        //Datos Heladeria
        $localidad     = $json['pedido']['localidad'];
        $calle         = $json['pedido']['calle'];
        $nro           = $json['pedido']['nro'];
        $piso          = $json['pedido']['piso'];
        $telefono      = $json['pedido']['telefono'];
        $contacto      = $json['pedido']['contacto'];
        
        $cucharitas         = $json['pedido']['cucharitas'];
        $cucuruchos         = $json['pedido']['cucuruchos'];
        $cucurucho_monto    = $json['pedido']['cucurucho_monto'];
        $enviodomicilio     = $json['pedido']['envio_domicilio'];
        $montodescuento     = $json['pedido']['monto_descuento'];
        $cantidaddescuento = $json['pedido']['cantidad_descuento'];

        $preciokilo     = $json['pedido']['precioxkilo'];

        $cantidadkilos  = $json['pedido']['cantidadkilos'];
        $montohelados   = $json['pedido']['monto_helados'];
        $cantidadpotes  = $json['pedido']['cantidadpotes'];
        
       
        
        $user = $this->getDoctrine()->getRepository(User::class)->find($user_id);
        if(!$user){
            $respuesta = array('code'=>Response::HTTP_PRECONDITION_REQUIRED,  'message'=>'No se encontro usuario', 'data'=>$result);
            return $respuesta;
        }
       
        if ($code==Response::HTTP_OK){
            $tiempodemora   = GlobalValue::TIEMPO_45;
            $time           = new DateTime();
            $hoy            = new DateTime();
            $pedido->setFecha($hoy);
            $pedido->setTiempodemora($tiempodemora);
            $pedido->setHoraEntrega($time->add(new DateInterval('PT' . $tiempodemora . 'M')));
            

            $pedido->setEstadoId(GlobalValue::ENPREPARACION);
            $pedido->setSubtotal($subtotal);
            $pedido->setMonto($monto);
            $pedido->setUser($user);
            $pedido->setMontoabona($montoabona);
            
            //Campos heladeria 
            $pedido->setLocalidad($localidad);
            $pedido->setCalle($calle);
            $pedido->setNro($nro);
            $pedido->setPiso($piso);
            $pedido->setContacto($contacto);
            $pedido->setTelefono($telefono);
            
            $pedido->setCucharitas($cucharitas);
            $pedido->setCucuruchos($cucuruchos);
            $pedido->setCantidaddescuento($cantidaddescuento);

            $pedido->setCantidadkilos($cantidadkilos);
            $pedido->setCantidadpotes($cantidadpotes);
            
            $pedido->setEnviodomicilio($enviodomicilio);
            
            $pedido->setMontocucuruchos($cucurucho_monto);
            $pedido->setPreciokilo($preciokilo);
            $pedido->setMontodescuento($montodescuento);
            $pedido->setMontohelados($montohelados);
            $pedido->setVisto(false);
            
            
            
            
            
            
            $pedido->setAndroid_id($android_id);
        
            if ($json['pedido']['pedidodetalles']){
                $detalles = $json['pedido']['pedidodetalles'];
                foreach ($detalles as $item){
                    $producto_id = $item['producto_id'];
                    $android_id  = $item['android_id'];
                    $cantidad    = $item['cantidad'];
                    $nropote     = $item['nropote'];
                    $medidapote  = $item['medidapote'];
                    
                    //Validar que producto pertenezca a la Empresa
                    $producto = new Producto();
                    $producto = $this->getDoctrine()->getRepository(Producto::class)->find($producto_id);
                    if(!$producto){
                        $respuesta = array('code'=>Response::HTTP_PRECONDITION_REQUIRED,  'message'=>'No se encontro Producto', 'data'=>$result);
                        return $respuesta;
                         
                    } 
                    
                    $pd = new Pedidodetalle();
                    $pd->setProducto($producto);
                    $pd->setCantidad($cantidad);
                    $pd->setNropote($nropote);
                    $pd->setMedidapote($medidapote);
                    
                    $pedido->addPedidodetalle($pd);   
                    
                 
                    
                }
            }         
            //$em->persist($producto);
            $em->persist($pedido);
            //$em->persist($mv);
            $em->flush();
        }//Si paso validacion

        $respuesta = array('code'=>$code,
                           'message'=>$message,
                           'data'=>$pedido
                        );
        return $respuesta;
    }
    
    
    
    
    /**
    * @Rest\Post("/api/pedidodetalle/edit")
    */
    public function postPedidodetalleeditAction(Request $request){
        //leer json
        try{
           
            $pedido = new Pedido();
            $code = Response::HTTP_OK; 
            $message='OK'; 
            $result = "";
            //parsear detalle
            $content = $request->getContent();
            $json = json_decode($content, true);
            $em = $this->getDoctrine()->getManager();
            //Leer Pedido

            $id = $json['id'];
            $cantidad = $json['cantidad'];


            $pd = new Pedidodetalle();
            $pd = $this->getDoctrine()->getRepository(Pedidodetalle::class)->find($id);
            if (!$pd) {
                throw $this->createNotFoundException(
                    'No Pedidodetalle found for id '.$id
                );
            }
            $pd->setCantidad($cantidad);
            $em->persist($pd);
            $em->flush();

            $response = array('code'=>$code,
                               'message'=>$message,
                               'data'=>$pd
                            );
            return $response;
            }catch(Exception $e){
                $response = array('code'=>Response::HTTP_CONFLICT,
                               'message'=>$e->getMessage(),
                               'data'=>null
                            );
                return $response;
                
            }
    }
    
    /**
     * @Rest\Get("/api/pedido/notificaciones")
     */
    public function postPedidonotificacionesAction(Request $request){
        //leer json
        try{
            $pedido = new Pedido();
            $code = Response::HTTP_OK;
            $pd = $this->getDoctrine()->getRepository(Pedido::class)->cantidadNoVisto();
            
            
            $response = array('code'=>$code,
                'message'=>'Notificaciones',
                'data'=>$pd
            );
            return $response;
        }catch(Exception $e){
            $response = array('code'=>Response::HTTP_CONFLICT,
                'message'=>$e->getMessage(),
                'data'=>null
            );
            return $response;
        
        }
    }
    
    
    
    /**
     * @Rest\Post("/api/pedido/findbyid")
     */
    public function postPedidoFindByIdAction(Request $request){
        //leer json
        try{
            $pedido = new Pedido();
            $code = Response::HTTP_OK;

            $content = $request->getContent();
            $json = json_decode($content, true);

            //Leer Pedido
            $id         = $json['pedido']['id'];
           
            $pd = $this->getDoctrine()->getRepository(Pedido::class)->findOneBy(array('id'=>$id ));
            if (!empty($pd)){
                $response = array(
                    'code'=>$code,
                    'message'=>'Pedido',
                    'data'=>$pd
                );
            }else{
                $response = array(
                    'code'=>Response::HTTP_CONFLICT,
                    'message'=>'No se Encontro pedido',
                    'data'=>$pd
                );
            }
            
            return $response;
        }catch(Exception $e){
            $response = array('code'=>Response::HTTP_CONFLICT,
                'message'=>$e->getMessage(),
                'data'=>null
            );
            return $response;
            
        }
    }
    
    
    
    
    /**
    * @Rest\Get("/api/check")
    */
    public function getCheckAction(){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        return $user;
    }
    
    
    
}