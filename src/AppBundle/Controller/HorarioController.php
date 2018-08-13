<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Horario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\GlobalValue;


/**
 * Horario controller.
 *
 * @Route("horario")
 */
class HorarioController extends Controller
{
    /**
     * Lists all horario entities.
     *
     * @Route("/", name="horario_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $horarios = $em->getRepository('AppBundle:Horario')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($horarios, $request->query->getInt('page', 1),10);
        return $this->render('horario/index.html.twig', 
        array(
              'pagination' => $pagination, 'select_dia'=> GlobalValue::DIAS_SEMANA
        ));
    }

    /**
     * Creates a new horario entity.
     *
     * @Route("/new", name="horario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $horario = new Horario();
        $form = $this->createForm('AppBundle\Form\HorarioType', $horario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($horario);
            $em->flush();
            $this->addFlash('success', 'Guardado Correctamente');
            return $this->redirectToRoute('horario_show', array('id' => $horario->getId()));
        }

        return $this->render('horario/new.html.twig', array(
            'horario' => $horario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a horario entity.
     *
     * @Route("/{id}", name="horario_show")
     * @Method("GET")
     */
    public function showAction(Horario $horario)
    {
        $deleteForm = $this->createDeleteForm($horario);

        return $this->render('horario/show.html.twig', array(
            'horario' => $horario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing horario entity.
     *
     * @Route("/{id}/edit", name="horario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Horario $horario)
    {
        $deleteForm = $this->createDeleteForm($horario);
        $editForm = $this->createForm('AppBundle\Form\HorarioType', $horario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Guardado Correctamente');
            return $this->redirectToRoute('horario_edit', array('id' => $horario->getId()));
        }

        return $this->render('horario/edit.html.twig', array(
            'horario' => $horario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a horario entity.
     *
     * @Route("/{id}", name="horario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Horario $horario)
    {
        $form = $this->createDeleteForm($horario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($horario);
            $this->addFlash('success', 'Eliminado Correctamente');
            $em->flush();
        }

        return $this->redirectToRoute('horario_index');
    }

    /**
     * Creates a form to delete a horario entity.
     *
     * @param Horario $horario The horario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Horario $horario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('horario_delete', array('id' => $horario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


     /**
     * @Route("/v1/all/", name="horariofindall")
     */
    public function horariofindallAction(Request $request)
    {
        try {
            $content = $request->getContent();
            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $code    = Response::HTTP_OK; 
            
            $em = $this->getDoctrine()->getManager();
            $horarios = $em->getRepository('AppBundle:Horario')->findAll();
            //print_r($horarios);
            $data = json_encode(array('data'=>$horarios));
            $response->setContent($data);
            $response->setStatusCode(200);
            return $response;

        } catch(Exception $e) {
            $response->setStatusCode(200);
            $data = array('data'=>$e->getMessage());
            $response->setContent($data);
            return $response;
        }
    }





}
