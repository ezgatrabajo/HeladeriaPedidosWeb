<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Parametro;

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



class ParametroController extends FOSRestController{
    /**
    * @Rest\Post("/api/parametros")
    */
    public function postParametrosAction(Request $request){
        $OPTION_ALL = 1;
        
        $OPTION_ONLY_PRICE = 2;
        
        $content = $request->getContent();
        $code = Response::HTTP_OK; 
        $message='OK'; 
        $result = "";
        $json = json_decode($content, true);
        $OPTION_CURRENT  = $OPTION_ALL;
        
        switch ($OPTION_CURRENT) {
            case $OPTION_ALL:
                $result = $this->getDoctrine()->getRepository('AppBundle:Parametro')->findAll();
                break;
            case $OPTION_ONLY_PRICE:
                $result = $this->getDoctrine()->getRepository('AppBundle:Parametro')->findAll();
                break;
            
            default:
                $result = $this->getDoctrine()->getRepository('AppBundle:Parametro')->findAll();
                break;
        }
        

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