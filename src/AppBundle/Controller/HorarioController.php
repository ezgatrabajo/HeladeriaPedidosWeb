<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Horario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $horarios = $em->getRepository('AppBundle:Horario')->findAll();

        return $this->render('horario/index.html.twig', array(
            'horarios' => $horarios,
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
}
