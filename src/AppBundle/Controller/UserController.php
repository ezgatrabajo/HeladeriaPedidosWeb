<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Exception;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

use AppBundle\Entity\GlobalValue;

use AppBundle\Entity\User;
/**
 * 
 *
 * @Route("users")
 */
class UserController extends Controller
{
    
/**
 * 
 *
 * @Route("/change", name="user_change")
 * @Method({"GET", "POST"})
 */
    public function changePasswordAction(Request $request)
    {
     $user = $this->getUser();
      //dispatch the appropriate events

    /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
    $dispatcher = $this->get('event_dispatcher');

    $event = new GetResponseUserEvent($user, $request);
    $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE,    $event);

    if (null !== $event->getResponse()) {
        return $event->getResponse();
    }
    /**
     * this is where you start the initialization of the form to you use
     */

    /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface           */
    $formFactory = $this->get('fos_user.change_password.form.factory');

    $form = $formFactory->createForm();
      //pass in the user data
    $form->setData($user);

    $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                //here you set the url to go to after changing the password
                  //for example i am redirecting back to the page  that triggered the change password process
                $url = $this->generateUrl('showProfileAccount');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('FOSUserBundle:ChangePassword:changePassword.html.twig', array(
           //note remove this comment. pass the form to template
            'form' => $form->createView()
        ));
    }
    
    
    
    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        
         //Obtener empresa
        $currentuser = $this->get('security.token_storage')->getToken()->getUser();
        $empresa = $currentuser->getEmpresa();
        
        //Crear formulario de filtro
        $user = new User();
        $form_filter = $this->createForm('AppBundle\Form\UserFilterType', $user);
        $form_filter->handleRequest($request);

        $queryBuilder = $this->getDoctrine()->getRepository(User::class)->createQueryBuilder('bp');
        $queryBuilder->where('bp.empresa = :empresa')->setParameter('empresa', $empresa);
                  
        
        if ($form_filter->isSubmitted() && $form_filter->isValid()) {
            if ($user->getEmail()){
                $queryBuilder->andWhere('bp.email LIKE :email')
                             ->setParameter('email', '%'. $user->getEmail(). '%');   
            }
            if($user->getContacto()){
                $queryBuilder->andWhere('bp.contacto LIKE :contacto')
                             ->setParameter('contacto', '%'. $user->getContacto(). '%');
            }
            if($user->getNdoc()){
                $queryBuilder->andWhere('bp.ndoc = :ndoc')
                             ->setParameter('ndoc',  $user->getNdoc());
            }
        }
        $registros = $queryBuilder;
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($registros, $request->query->getInt('page', 1),10);
        return $this->render('user/index.html.twig', array(
            'pagination' => $pagination, 
            'form_filter'=>$form_filter->createView(),
            'roles'=>GlobalValue::ROLES
        ));
    }


    

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newuserAction(Request $request)
    {
        $userform = new User();
        $form = $this->createForm('AppBundle\Form\userType', $userform);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            try {

                //setear empresa y establecer usuario igual a email
                $currentuser = $this->get('security.token_storage')->getToken()->getUser();
                $empresa = $currentuser->getEmpresa();
                $username = $userform->getEmail();

                //Crear usuario
                $userManager = $this->get('fos_user.user_manager');
                $usernew = $userManager->createUser();
                
                $userform->setUsername($username);
                $userform->setEmailCanonical($userform->getEmail());
                $userform->setEnabled(1); // enable the user or enable it later with a confirmation token in the email
                //$user->setApitoken
                // this method will encrypt the password with the default settings :)
                $password = 12345678;
                $userform->setRoles(array($userform->getTipo()));
                $userform->setPlainPassword($password);
                $userform->setEmpresa($empresa);
                $userManager->updateUser($userform);
                
                $usernew = $userform;
                
                $em->persist($usernew);
                $em->flush();
                $this->addFlash('success', 'Guardado Correctamente!');
                return $this->redirectToRoute('user_show', array('id' => $usernew->getId()));
            }catch (UniqueConstraintViolationException $e) {
                $this->addFlash('error', 'Error: No se pudo agregar Usuario. email de Usuario o Email ya han sido utilizados, pruebe con otros.' );
            } catch (\Doctrine\DBAL\DBALException $e) {
                $this->addFlash('error', 'Error: No se pudo agregar Usuario, '. $e->getMessage() );
            } catch (Exception $e) {
                $this->addFlash('error', 'Error: No se pudo agregar Usuario'. $e->getMessage() );
            }
        }

        return $this->render('user/new.html.twig', array(
            'user' => $userform,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showuserAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
            'roles'=>GlobalValue::ROLES
        ));
    }
    
    
     /**
     * Deletes a pedido entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        try{
            
            $form = $this->createDeleteForm($user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                    $em = $this->getDoctrine()->getManager();
                    $em->remove($user);
                    $em->flush();

            }
        }catch(ForeignKeyConstraintViolationException $e){
                $this->addFlash('error', 'Error: No se puede eliminar el usuario porque hay datos asociados al mismo que antes deben ser eliminados'  );
                
        }catch(Exception $e){
            $this->addFlash('error', 'Error: .' . $e->getMessage());
        }

        return $this->redirectToRoute('user_index');
    }
    
    
    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function edituserAction(Request $request, User $userform)
    {
        $deleteForm = $this->createDeleteForm($userform);
        $editForm = $this->createForm('AppBundle\Form\UserType', $userform);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($userform);
                $em->flush();
                $this->addFlash(  'success','Guardado Correctamente!');
                return $this->redirectToRoute('user_edit', array('id' => $userform->getId()));
            }catch (UniqueConstraintViolationException $e) {
                $this->addFlash('error', 'Error: No se pudo Editar Usuario. email de Usuario o Email ya han sido utilizados, pruebe con otros.' );
            } catch (\Doctrine\DBAL\DBALException $e) {
                $this->addFlash('error', 'Error: No se pudo Editar Usuario, error consistencia de datos: '. $e->getMessage() );
            } catch (Exception $e) {
                $this->addFlash('error', 'Error: No se pudo Editar Usuario, error externo: '. $e->getMessage() );
            }
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $userform,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    
    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/editempresa/", name="userempresa_edit")
     * @Method({"GET", "POST"})
     */
    public function editempresaAction(Request $request)
    {
        if(empty($userform)){
            $userform = $this->get('security.token_storage')->getToken()->getUser();
        }
        $editForm = $this->createForm('AppBundle\Form\UserType', $userform);
        $editForm->handleRequest($request);
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($userform);
                $em->flush();
                $this->addFlash(  'success','Guardado Correctamente!');
                return $this->redirectToRoute('userempresa_edit');
            }catch (UniqueConstraintViolationException $e) {
                $this->addFlash('error', 'Error: No se pudo Editar Usuario. email de Usuario o Email ya han sido utilizados, pruebe con otros.' );
            } catch (\Doctrine\DBAL\DBALException $e) {
                $this->addFlash('error', 'Error: No se pudo Editar Usuario, error consistencia de datos: '. $e->getMessage() );
            } catch (Exception $e) {
                $this->addFlash('error', 'Error: No se pudo Editar Usuario, error externo: '. $e->getMessage() );
            }
        }
        
        return $this->render('user/editempresa.html.twig', array(
            'user' => $userform,
            'edit_form' => $editForm->createView(),
        ));
    }
     /**
   
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    
}