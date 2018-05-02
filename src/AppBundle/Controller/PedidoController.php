<?php

namespace AppBundle\Controller;

use Knp\Bundle\SnappyBundle\Snappy;
use AppBundle\Entity\Pedido;
use AppBundle\Entity\GlobalValue;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use DateTime;
use DateInterval;
use Doctrine\ORM\EntityRepository;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

/**
 * Pedido controller.
 *
 * @Route("pedido")
 */
class PedidoController extends Controller
{
    
    /**
     * @Route("/pdf/{id}", name="pedido_pdfpreview")
     * @Method({"GET","POST"})
     */
    public function pdfPreview(Request $request, Pedido $pedido){
        
        
        return $this->render('pedido/pdfpreview.html.twig',
            array(
                'pedido'=> $pedido
            ));
    }
    
   
    /**
     * @Route("/pdfprint3/{id}", name="pedido_pdfprint3")
     * @Method({"GET","POST"})
     */
    public function pdfprint3Action(Request $request, Pedido $pedido)
    {
        //$html = $this->render('pedido/pdfpreview.html.twig',array('pedido'=> $pedido));
        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('Heladeria Roma');
        $pdf->SetTitle(('Pedido'));
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 9, '', true);
        $pdf->AddPage();
        $filename = 'pedido_'.$pedido->getId();
    
        $html ="<h1>Pedido </h1>";
        
        $html = $html .  "<table class='datatable'> ";
                
        $html = $html .  "<tr><th>Nro:</th>          <td> " . $pedido->getId() ."</td> </tr>" ;
        $html = $html .  "<tr><th>Hora Entrega</th> <td> " . $pedido->getHoraEntregaFormatHMS()."</td></tr>";
        $html = $html .  "<tr><th>Cliente</th>      <td> " . $pedido->getContacto()."</td></tr>";
        $html = $html .  "<tr><th>Direccion</th>    <td> " . $pedido->getDireccionFormat()."</td></tr>";
        $html = $html .  "<tr><th>Telefono</th>     <td> " . $pedido->getTelefono()."</td></tr>";
        $html = $html .  "</table>";
        $html = $html .  "<br>";


        $pedidodetalles = $pedido->getPedidodetalles();
        
        $html = $html .  "<table border='1' cellpadding='2' cellspacing='2'> ";
        $html = $html .  "<hr>";
        $html = $html .  "<tr> ";
        $html = $html .  "<th><b>Pote</b></th>
                          <th><b>Sabor</b></th>
                          <th><b>Cantidad</b></th>" ;
        $html = $html .  "</tr> ";

        foreach ($pedidodetalles as $item) { 
            $html = $html ."<tr>";

            $html = $html ."<td>". $item->getMedidaPoteFormat(). "</td>" ; 
            $html = $html ."<td>". $item->getProducto()->getNombre(). "</td>" ; 
            $html = $html ."<td>". $item->getCantidadString(). "</td>" ; 

            $html = $html ."</tr>";
        }

        $html = $html ."<hr> <tr>";
        $html = $html .  "<td><b>Total:</b> " . $pedido->getMontoFormat()."</td>";
        $html = $html .  "<td><b>Abona con:</b> " . $pedido->getMontoAbonaFormat()."</td>";
        $html = $html ."</tr>";
        $html = $html .  "</tbody> ";
        $html = $html .  "</table>";

      
       
        

        $pdf->writeHTML($html, true, false, true, false, '');
        
        $pdf->Output($filename.".pdf",'I'); 
        
    }


    





    
    /**
     * @Route("/pdfprint2/{id}", name="pedido_pdfprint2")
     * @Method({"GET","POST"})
     */
    public function pdfprint2Action(Request $request, Pedido $pedido)
    {
        $filename = 'pedido'. $pedido->getId();

        $snappy  = $this->get('knp_snappy.pdf');
        $html = $this->render('pedido/pdfpreview.html.twig', array('pedido'=> $pedido));
        
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array('Content-type'=> 'application/pdf',
                  'Content-Disposition'=> 'inline; filename="'.$filename . '.pdf"')
        );
        
    }

    

    

    /**
     * Lists all pedido entities.
     *
     * @Route("/", name="pedido_index")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request)
    {
       
        
       
        //Crear formulario de filtro
        $pedido = new Pedido();
        $form_filter = $this->createForm('AppBundle\Form\PedidoFilterType', $pedido);
        $form_filter->add('buscar', SubmitType::class, array('label' => 'Buscar', 'attr'=>array('class'=>'btn btn-flat btn-default')));
         
        $form_filter->handleRequest($request);
        
        $queryBuilder = $this->getDoctrine()->getRepository(Pedido::class)->createQueryBuilder('bp');
        
        //Filtros
        if ($form_filter->isSubmitted() && $form_filter->isValid()) {
            $fechadesde = $pedido->getFechadesde();
            $fechahasta = $pedido->getFechahasta();
            if ($fechadesde){
                if ($fechadesde == $fechahasta){
                    $fechahasta = $fechahasta->add(new DateInterval('P10D'));
                }
            }
            
            if ($pedido->getFechadesde()){
                $queryBuilder->andWhere('bp.fecha >= :fechadesde')
                ->setParameter('fechadesde',  $fechadesde);   
            }
            if ($pedido->getFechahasta()){
                $queryBuilder->andWhere('bp.fecha <= :fechahasta')
                    ->setParameter('fechahasta', $fechahasta );   
            }
            if ($pedido->getEstadoId()){
                $queryBuilder->andWhere('bp.estadoId = :estadoid')
                             ->setParameter('estadoid',  $pedido->getEstadoId());   
            }
        }
        $queryBuilder->orderBy('bp.id', 'DESC');

        $registros = $queryBuilder;
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($registros, $request->query->getInt('page', 1),20);
        
        
        return $this->render('pedido/index.html.twig', array(
            'pagination' => $pagination, 
            'form_filter'=>$form_filter->createView(), 
            'estados'=> GlobalValue::ESTADOS
            
        ));
    }
    
    
    
    
    
    /**
     * Lists all pedido entities.
     *
     * @Route("/hoy", name="pedido_hoy")
     * @Method({"GET","POST"})
     */
    public function hoyAction(Request $request)
    {
        
        // Filtrar por  y por fecha de hoy
        $hoy = date("Y-m-d");
        
        
        $queryBuilder = $this->getDoctrine()->getRepository(Pedido::class)->createQueryBuilder('bp');
      
        $queryBuilder->Where('bp.fecha >= :hoy')
                     ->setParameter('hoy', $hoy ); 
        
        
        //Crear formulario de filtro
        $pedido = new Pedido();
        $form_filter = $this->createForm('AppBundle\Form\PedidoHoyFilterType', $pedido);
        $form_filter->add('user', EntityType::class, array(
                        'class' => 'AppBundle:User', 
                        'required'=>false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')                              
                                ->orderBy('c.email', 'DESC');
                        },
                        'choice_label' => 'TextoCombo'))
                    ->add('buscar', SubmitType::class, array('label' => 'Buscar', 'attr'=>array('class'=>'btn btn-flat btn-default')));
         
                        
        $form_filter->handleRequest($request);
        //Filtros
        if ($form_filter->isSubmitted() && $form_filter->isValid()) {
             if ($pedido->getEstadoId()){
                $queryBuilder->andWhere('bp.estadoId = :estadoid')
                             ->setParameter('estadoid',  $pedido->getEstadoId());   
             }
             
             if ($pedido->getUser()){
                 $queryBuilder->andWhere('bp.user = :user')
                 ->setParameter('user',  $pedido->getUser());
             }
        }
        
        $registros = $queryBuilder->orderBy("bp.id","DESC");
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($registros, $request->query->getInt('page', 1),20);
        
        return $this->render('pedido/pedidos_hoy.html.twig', array(
            'pagination' => $pagination, 
            'form_filter'=>$form_filter->createView(), 'hoy'=>$hoy,
            'estados'=> GlobalValue::ESTADOS
        ));
    }
    

    
    /**
     * Lists all pedido entities.
     *
     * @Route("/notificaciones", name="pedido_notificaciones")
     * @Method({"GET","POST"})
     */
    public function notificacionesAction(Request $request)
    {
        
       
        //Crear formulario de filtro
        $pedido = new Pedido();
        $form_filter = $this->createForm('AppBundle\Form\PedidoFilterType', $pedido);
        $form_filter
        ->add('user', EntityType::class, array(
            'class' => 'AppBundle:User',
            'choice_label' => 'TextoCombo',
            'required'=>false
        ))
        ->add('buscar', SubmitType::class, array('label' => 'Buscar', 'attr'=>array('class'=>'btn btn-flat btn-default')));
            
            $form_filter->handleRequest($request);
            
            $queryBuilder = $this->getDoctrine()->getRepository(Pedido::class)->findNotificaciones();
            
            //Filtros
            if ($form_filter->isSubmitted() && $form_filter->isValid()) {
                $fechadesde = $pedido->getFechadesde();
                $fechahasta = $pedido->getFechahasta();
                if ($fechadesde){
                    if ($fechadesde == $fechahasta){
                        $fechahasta = $fechahasta->add(new DateInterval('P10D'));
                    }
                }
                
                if ($pedido->getFechadesde()){
                    $queryBuilder->andWhere('t.fecha >= :fechadesde')
                    ->setParameter('fechadesde',  $fechadesde);
                }
                if ($pedido->getFechahasta()){
                    $queryBuilder->andWhere('t.fecha <= :fechahasta')
                    ->setParameter('fechahasta', $fechahasta );
                }
                if ($pedido->getEstadoId()){
                    $queryBuilder->andWhere('t.estadoId = :estadoid')
                    ->setParameter('estadoid',  $pedido->getEstadoId());
                }
            }
            $queryBuilder->orderBy('t.fecha', 'DESC');
            
            $registros = $queryBuilder;
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate($registros, $request->query->getInt('page', 1),20);
            
            
            return $this->render('pedido/notificaciones.html.twig', array(
                'pagination' => $pagination,
                'form_filter'=>$form_filter->createView(),
                'estados'=> GlobalValue::ESTADOS
                
            ));
    }
    
    /**
     * Creates a new pedido entity.
     *
     * @Route("/new", name="pedido_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pedido = new Pedido();
        /* Crea Formulario */
        $form = $this->createForm('AppBundle\Form\PedidoType', $pedido);
        $form->add('user', EntityType::class, array(
                        'label'=>'Login/Username',
                        'class' => 'AppBundle:User',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->orderBy('c.email', 'DESC');
                        },
                        'choice_label' => 'TextoCombo'));
                
                        
        $form->handleRequest($request);
        
        /* Guardar datos */          
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $pedido->setEstadoId(GlobalValue::PENDIENTE);
            $em->persist($pedido);
            $em->flush();
            $this->addFlash(  'success','Guardado Correctamente!');
            return $this->redirectToRoute('pedidodetalle_new', array('pedido_id' => $pedido->getId()));
        }

        return $this->render('pedido/new.html.twig', array(
            'pedido' => $pedido,
            'form' => $form->createView(),
           
        ));
    }

    /**
     * Finds and displays a pedido entity.
     *
     * @Route("/{id}", name="pedido_show")
     * @Method("GET")
     */
    public function showAction(Pedido $pedido)
    {
        $deleteForm = $this->createDeleteForm($pedido);

        return $this->render('pedido/show.html.twig', array(
            'pedido' => $pedido,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pedido entity.
     *
     * @Route("/{id}/edit", name="pedido_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pedido $pedido)
    {
        $deleteForm = $this->createDeleteForm($pedido);
        $editForm = $this->createForm('AppBundle\Form\PedidoType', $pedido);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(  'success','Guardado Correctamente!');
            return $this->redirectToRoute('pedido_edit', array('id' => $pedido->getId()));
        }

        return $this->render('pedido/edit.html.twig', array(
            'pedido' => $pedido,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pedido entity.
     *
     * @Route("/{id}", name="pedido_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pedido $pedido)
    {
        $form = $this->createDeleteForm($pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pedido);
            $em->flush();
        }

        return $this->redirectToRoute('pedido_index');
    }

    /**
     * Creates a form to delete a pedido entity.
     *
     * @param Pedido $pedido The pedido entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pedido $pedido)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pedido_delete', array('id' => $pedido->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    
    
    
    
    
    
    
    
    
    
    

    
}
