<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller\Api;
use AppBundle\Entity\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use \FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use \AppBundle\Entity\GlobalValue;


class UserController extends FOSRestController
{
    
 /**
  * @Rest\Post("/api/user/login")
  */
  public function loginJson(Request $request)
  {
        $content = $request->getContent();
        $code = '200'; $message='OK'; $result = ""; $bool=false;
        //$json = json_decode($content, true);
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
            $telefono  = $request->get('telefono');
            $localidad = $request->get('localidad');
            $calle     = $request->get('calle');
            $nro       = $request->get('nro');
            $piso      = $request->get('piso');
            $contacto  = $request->get('contacto');

            //Asignar datos a nuevo usuario
            
            $user->setRoles(array(GlobalValue::ROLE_CLIENTE));
            $user->setEnabled(1);
            $user->setUsername($username);
            $user->setEmail($username);
            $user->setEmailCanonical($username);
            $user->setPlainPassword($password);
            $user->setTelefono($telefono);
            $user->setLocalidad($localidad);
            $user->setCalle($calle);
            $user->setNro($nro);
            $user->setPiso($piso);
            $user->setContacto($contacto);
            $empresa = $em->getRepository('AppBundle:Empresa')->find(GlobalValue::CODE_HELADERIA_ROMA);
            $user->setEmpresa($empresa);
          
            
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
