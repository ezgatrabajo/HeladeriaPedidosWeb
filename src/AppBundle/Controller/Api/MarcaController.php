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
use AppBundle\Entity\Marca;


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
    * @Rest\Post("/api/marcas/create_preference")
    */
    public function getCreatepreferenceAction(Request $request){
        
        
      
       
        
        $result = $mp;
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
    * @Rest\Post("/api/marcas/add")
    */
    public function addMarcasAction(Request $request){
        try{
            //parsear json
            $content = $request->getContent();
            $json    = json_decode($content, true);
            $em      = $this->getDoctrine()->getManager();
            
            $nombre      = $json['marca']['nombre'];
            $descripcion = $json['marca']['descripcion'];
            
            $marca = new Marca();
            $marca->setNombre($nombre);
            $marca->setDescripcion($descripcion);
            $em->persist($marca);
            $em->flush();

            $respuesta = array('code'=>'200','message'=>'ok','data'=>$marca);
            return $respuesta;
        }catch(Exception $e){
            $response = array('code'=>Response::HTTP_CONFLICT,
                        'message'=>$e->getMessage(),
                        'data'=>null
                        );
            return $response;
            
        }
       
    }
    
    /**
    * @Rest\Post("/api/marcas/edit")
    */
    public function editMarcasAction(Request $request){
        try{
            //parsear json
            $content = $request->getContent();
            $json    = json_decode($content, true);
            $em = $this->getDoctrine()->getManager();
            $marca       = new Marca();
            
            $id          = $json['marca']['id'];
            $nombre      = $json['marca']['nombre'];
            $descripcion = $json['marca']['descripcion'];

            $marca = $this->getDoctrine()->getRepository(Marca::class)->find($id);
            if (!$marca){
                throw $this->createNotFoundException(
                    'No register found for id '.$id
                );
            }
            if($nombre)       $marca->setNombre($nombre);
            if($descripcion)  $marca->setDescripcion($descripcion);
            
            $em->persist($marca);
            $em->flush();
           
            $response = array('code'=>'200','message'=>'ok','data'=>$marca);
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
    * @Rest\Post("/api/marcas/delete")
    */
    public function deleteMarcasAction(Request $request){
        try{
            //parsear json
            $content = $request->getContent();
            $json    = json_decode($content, true);
            $em = $this->getDoctrine()->getManager();
            $marca       = new Marca();

            $id          = $json['marca']['id'];
            $marca = $this->getDoctrine()->getRepository(Marca::class)->find($id);
            if (!$marca){
                throw $this->createNotFoundException(
                    'No register found for id '.$id
                );
            }
            $em->remove($marca);
            $em->flush();
           
            $response = array('code'=>'200','message'=>'ok','data'=>$marca);
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