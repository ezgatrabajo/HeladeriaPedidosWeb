<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller\Api;

use Mercadopago\MP;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use\Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use \FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\Controller\Annotations as Rest;



class MercadoPagoController extends FOSRestController{
   
    /**
    * @Rest\Post("/api/mercadopago/create_preference")
    */
    public function postMercadoPagosAction(Request $request){
        try{
            //parsear json
            $content = $request->getContent();
            $json    = json_decode($content, true);
            $em      = $this->getDoctrine()->getManager();
            
            $nombre      = $json['marca']['nombre'];
            $descripcion = $json['marca']['descripcion'];
            
            $mp = new Mercadopago("2207797945420831", "lZVQBryGrJ3wzcuFLBrxsWuETU4sm1IE");
            $preference_data = array (
                "items" => array (
                    array (
                        "title" => "Test",
                        "quantity" => 1,
                        "currency_id" => "USD",
                        "unit_price" => 10.4
                    )
                )
            );
            
            $preference = $mp->create_preference($preference_data);
            
            print_r ($preference);
            
            /*
                $marca = new Marca();
                $marca->setNombre($nombre);
                $marca->setDescripcion($descripcion);
                $em->persist($marca);
                $em->flush();
            */
            $respuesta = array('code'=>'200','message'=>'ok','data'=>'marca');
            return $respuesta;
        }catch(Exception $e){
            $response = array('code'=>Response::HTTP_CONFLICT,
                        'message'=>$e->getMessage(),
                        'data'=>null
                        );
            return $response;
            
        }
        
    }
    
 
}