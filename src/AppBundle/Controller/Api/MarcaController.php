<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use \FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
class MarcaController extends FOSRestController{
    
    /**
    * @Rest\Post("/api/marcas")
    */
    public function getMarcasAction(Request $request){
        
        $result = $this->getDoctrine()->getRepository('AppBundle:Marca')->findAll();
        if ($result === null) {
            $respuesta = array('code'=>'500',
                           'message'=>'No se encontraron registros',
                           'data'=>$result
                        );
        }else{
            $respuesta = array('code'=>'200',
                           'message'=>'ok',
                           'data'=>$result
                        );
        
        }
        return $respuesta;
    }
    
    
    
    
    /**
    * @Rest\Get("/api/check")
    */
    public function getCheckAction(){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        return $user;
    }
}