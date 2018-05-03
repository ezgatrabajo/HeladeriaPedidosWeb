<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Parametro;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Parametro controller.
 *
 * @Route("parametro")
 */
class ParametroController extends Controller
{
    /**
     * Lists all parametro entities.
     *
     * @Route("/", name="parametro_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        //Crear formulario de filtro
        $parametro = new Parametro();
        $form_filter = $this->createForm('AppBundle\Form\ParametroFilterType', $parametro);
        $form_filter->handleRequest($request);
        $queryBuilder = $this->getDoctrine()->getRepository(Parametro::class)->createQueryBuilder('bp');
        if ($form_filter->isSubmitted() && $form_filter->isValid()) {
            if ($parametro->getNombre()){
                $queryBuilder->andWhere('bp.nombe LIKE :nombre')
                             ->setParameter('nombre', '%'. $parametro->getNombre(). '%');   
            }            
        }
        $registros = $queryBuilder;
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($registros, $request->query->getInt('page', 1),20);

        return $this->render('parametro/index.html.twig', array(
            'pagination' => $pagination,
            'form_filter'=>$form_filter->createView()
      
        ));
    }

    /**
     * Creates a new parametro entity.
     *
     * @Route("/new", name="parametro_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $parametro = new Parametro();
        $form = $this->createForm('AppBundle\Form\ParametroType', $parametro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($parametro);
            $em->flush();
            $this->addFlash(  'success','Guardado Correctamente!');
            return $this->redirectToRoute('parametro_show', array('id' => $parametro->getId()));
        }

        return $this->render('parametro/new.html.twig', array(
            'parametro' => $parametro,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a parametro entity.
     *
     * @Route("/{id}", name="parametro_show")
     * @Method("GET")
     */
    public function showAction(Parametro $parametro)
    {
        $deleteForm = $this->createDeleteForm($parametro);

        return $this->render('parametro/show.html.twig', array(
            'parametro' => $parametro,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    

    /**
     * Displays a form to edit an existing parametro entity.
     *
     * @Route("/{id}/edit", name="parametro_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Parametro $parametro)
    {
        
        $editForm = $this->createForm('AppBundle\Form\ParametroType', $parametro);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(  'success','Guardado Correctamente!');

            return $this->redirectToRoute('parametro_edit', array('id' => $parametro->getId()));
        }

        return $this->render('parametro/edit.html.twig', array(
            'parametro' => $parametro,
            'edit_form' => $editForm->createView(),
        ));
    }
    
    
    /**
     * Displays a form to edit an existing parametro entity.
     *
     * @Route("/{nombre}/editmoney", name="parametro_edit_money")
     * @Method({"GET", "POST"})
     */
    public function editmoneyAction(Request $request, Parametro $parametro)
    {
        
        if (!$parametro){
            $criteria =array('nombre'=>$nombre);
            $parametro = $this->getDoctrine()->getRepository(Parametro::class)->findBy($criteria);
        }
        
        $editForm  = $this->createForm('AppBundle\Form\ParametroMoneyType', $parametro);
        $editForm->handleRequest($request);
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(  'success','Guardado Correctamente!');
            return $this->redirectToRoute('parametro_edit_money', array('nombre' => $parametro->getNombre()));
        }
        
        return $this->render('parametro/editmoney.html.twig', array(
            'parametro' => $parametro,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a parametro entity.
     *
     * @Route("/{id}", name="parametro_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Parametro $parametro)
    {
        $form = $this->createDeleteForm($parametro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($parametro);
            $this->addFlash(  'success','Eliminado Correctamente!');

            $em->flush();
        }

        return $this->redirectToRoute('parametro_index');
    }

    /**
     * Creates a form to delete a parametro entity.
     *
     * @param Parametro $parametro The parametro entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Parametro $parametro)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('parametro_delete', array('id' => $parametro->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
