<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller\Api;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use \FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use \AppBundle\Entity\GlobalValue;
use Exception;


class UserController extends FOSRestController
{
    
 /**
  * @Rest\Post("/api/user/login")
  */
  public function loginJson(Request $request)
  {
          try{
                $content = $request->getContent();
                $code = '200'; $message='OK'; $result = ""; $bool=false;
               
                $username = $request->get('username');
                $password = $request->get('password');
                $user_manager = $this->get('fos_user.user_manager');
                $factory = $this->get('security.encoder_factory');
                $user = $user_manager->findUserByUsername($username);
                if (!$user){
                    $user = $user_manager->findUserByEmail($username);    
                }
        
                if ($user){
                    $encoder = $factory->getEncoder($user);  
                    $bool = $encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt());
                }
        
                if ($bool==true){
                    $respuesta = array('code'=>Response::HTTP_OK,
                                       'message'=>$message,
                                       'data'=>$user
                                    );
                }else{
                    $respuesta = array('code'=>Response::HTTP_UNAUTHORIZED,
                                       'message'=>'Usuario y/o Contraseña Invalido',
                                       'data'=>''
                                    );  
                }
              }catch(Exception $e){
                  $respuesta = array('code'=>Response::HTTP_UNAUTHORIZED,
                      'message'=>$e->getMessage(),
                      'data'=>''
                  );
                }
          return $respuesta;
          
  }
   
    
 /**
  * @Rest\Post("/api/user/register")
  */
  public function registerJson(Request $request)
  { 
      try{
            //Registracion del usuario via App Android
            $message='OK'; 
            $em = $this->getDoctrine()->getManager();
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->createUser();
            
            //SI viene el ID, Significa que el usuario esta editando sus datos
            $id  = $request->get('id');
            if($id > 0){
                //BUSCAR EL ID
                $user = $em->getRepository('AppBundle:User')->find($id);
            }
            
            //Leer datos desde el JSON
            $username  = $request->get('username');
            $password  = $request->get('password');
            $email     = $request->get('email');
            
            $localidad = $request->get('localidad');
            $calle     = $request->get('calle');
            $nro       = $request->get('nro');
            $piso      = $request->get('piso');
            $contacto  = $request->get('contacto');
            $telefono  = $request->get('telefono');

            //Asignar datos a nuevo usuario
            
            $user->setRoles(array(GlobalValue::ROLE_CLIENTE));
            $user->setEnabled(1);
            
            
            if ($username) $user->setUsername($username);
            if ($email)    $user->setEmail($email);
            if ($email)    $user->setEmailCanonical($email);
            if ($password) $user->setPlainPassword($password);
            
            if ($telefono)  $user->setTelefono($telefono);
            if ($localidad) $user->setLocalidad($localidad);
            if ($calle)     $user->setCalle($calle);
            if ($nro)       $user->setNro($nro);
            if ($piso)      $user->setPiso($piso);
            if ($contacto)  $user->setContacto($contacto);
            
            
            $em->persist($user);
            $em->flush();
            $respuesta = array('code'=>Response::HTTP_OK,
                                   'message'=>$message,
                                   'data'=>$user
                                );
            return $respuesta;
        }catch (UniqueConstraintViolationException $e) {
            $respuesta = array('code'=>Response::HTTP_UNAUTHORIZED,
                               'message'=>'El Usuario ya Existe en la base de datos ',
                               'data'=>$user
                            ); 
            return $respuesta;
        } catch (Exception $e) {
            $respuesta = array('code'=>Response::HTTP_UNAUTHORIZED,
                               'message'=>'Error Al Crear el Usuario '. $e->getMessage(),
                               'data'=>$user
                            ); 
            return $respuesta;
        }
    }
}
