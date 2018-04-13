<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Archivo;

use AppBundle\Entity\Producto;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Exception;
use AppBundle\Service\FileUploader;
use AppBundle\Entity\GlobalValue;

/**
 * Archivo controller.
 *
 * @Route("archivo")
 */
class ArchivoController extends Controller
{
    /**
     * Lists all categorium entities.
     *
     * @Route("/", name="archivo_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        
        //Obtener empresa
        
        //Crear formulario de filtro
        $archivo = new Archivo();
        $form_filter = $this->createForm('AppBundle\Form\ArchivoFilterType', $archivo);
        $form_filter->handleRequest($request);

        $queryBuilder = $this->getDoctrine()->getRepository(Archivo::class)
                ->createQueryBuilder('bp');
                     
         
        if ($form_filter->isSubmitted() && $form_filter->isValid()) {
            if ($archivo->getNombre()){
                $queryBuilder->andWhere('bp.nombre LIKE :nombre')
                             ->setParameter('nombre', '%'. $archivo->getNombre(). '%');   
            }
            if($archivo->getDescripcion()){
                $queryBuilder->andWhere('bp.descripcion LIKE :descripcion')
                             ->setParameter('descripcion', '%'. $archivo->getDescripcion(). '%');
            }
            
            if($archivo->getTipo()){
                $queryBuilder->andWhere('bp.tipo = :tipo')
                             ->setParameter('tipo',  $archivo->getTipo());
            }
            
        }
        $archivos = $queryBuilder->orderBy('bp.fecha', 'DESC');

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($archivos, $request->query->getInt('page', 1),8);

        return $this->render('archivo/index.html.twig', array(
            'pagination' => $pagination, 
            'form_filter'=>$form_filter->createView(),
            'archivo_estados'=> GlobalValue::ARCHIVO_ESTADOS,
            'archivo_tipos'=>GlobalValue::ARCHIVO_TIPOS
        ));
    }

    
    
    
    public function uploadArchivoProductos( Archivo $archivo){
        
    }
    
     //VALIDAR PRODUCTOS
    public function validateArchivoProducto($lines){
        
            foreach ($lines as $key => $value)
            {
                $csv[$key] = str_getcsv($value,";");
            }
            $fileindex = 0; $header = 0; //Variable para identificar cabecera
            $error = 0 ;
            foreach ($csv as $record)
            {
                if ($fileindex > $header){
                    try{
                        $record[GlobalValue::PRODUCTO_NOMBRE];
                        $record[GlobalValue::PRODUCTO_DESCRIPCION];
                        $record[GlobalValue::PRODUCTO_PRECIO];
                        $record[GlobalValue::PRODUCTO_STOCK];
                        $record[GlobalValue::PRODUCTO_CODIGOEXTERNO];
                        $error = GlobalValue::ERROR_VALIDATEFILE;
                    }catch(\Exception $e){
                        //return GlobalValue::ERROR_VALIDATEFILE;
                        
                    }
                }
                 $fileindex = $fileindex +1;
            }
          
    }
    
    //VALIDAR STOCKS
    public function validateArchivoStock($lines){
        
            foreach ($lines as $key => $value)
            {
                $csv[$key] = str_getcsv($value,";");
            }
            $fileindex = 0; $header = 0; //Variable para identificar cabecera
            $error = 0 ;
            foreach ($csv as $record)
            {
                if ($fileindex > $header){
                    try{
                        $record[GlobalValue::STOCK_CODIGOEXTERNO];
                        $record[GlobalValue::STOCK_CANTIDAD];
                        
                        
                    }catch(\Exception $e){
                        $error = GlobalValue::ERROR_VALIDATEFILE;
                        
                    }
                }
                 $fileindex = $fileindex +1;
            }
          
    }
     //VALIDAR STOCKS
    public function validateArchivoListaprecio($lines){
        
            foreach ($lines as $key => $value)
            {
                $csv[$key] = str_getcsv($value,";");
            }
            $fileindex = 0; $header = 0; //Variable para identificar cabecera
            $error = 0 ;
            foreach ($csv as $record)
            {
                if ($fileindex > $header){
                    try{
                        $record[GlobalValue::LISTAPRECIOS_CODIGOEXTERNO];
                        $record[GlobalValue::LISTAPRECIOS_PRECIO];
                        
                        
                    }catch(\Exception $e){
                        $error = GlobalValue::ERROR_VALIDATEFILE;
                        
                    }
                }
                 $fileindex = $fileindex +1;
            }
          
    }
    //VALIDAR CLIENTES
    public function validateArchivoClientes($lines){
        
            foreach ($lines as $key => $value)
            {
                $csv[$key] = str_getcsv($value,";");
            }
            $fileindex = 0; $header = 0; //Variable para identificar cabecera
            $error = 0 ;
            foreach ($csv as $record)
            {
                if ($fileindex > $header){
                    try{
                        $record[GlobalValue::CLIENTE_RAZONSOCIAL];
                        $record[GlobalValue::CLIENTE_CONDICIONIVA];
                        $record[GlobalValue::CLIENTE_DIRECCION];
                        $record[GlobalValue::CLIENTE_NRODOC];
                        $record[GlobalValue::CLIENTE_TELEFONO];
                        $record[GlobalValue::CLIENTE_CODIGOEXTERNO];
                        $record[GlobalValue::CLIENTE_CONTACTO];
                        
                        $error = GlobalValue::ERROR_VALIDATEFILE;
                    }catch(\Exception $e){
                        return GlobalValue::ERROR_VALIDATEFILE;
                    }
                }
                 $fileindex = $fileindex +1;
            }
          
    }
    public function procesarArchivoClientes(Archivo $archivo)
    {

        $csv = array();
        $lines = file($archivo->getArchivo(), FILE_IGNORE_NEW_LINES);
        $error = $this->validateArchivoClientes($lines);
        if ( $error > 0 ){
            return $error;
        }
        
        foreach ($lines as $key => $value)
        {
            $csv[$key] = str_getcsv($value,";");
        }
        $fileindex = 0; $header = 0;//Variable para identificar cabecera
        $em = $this->getDoctrine()->getManager();
        foreach ($csv as $record)
        {
            if ($fileindex > $header){

               
                //validar si existe producto
                $codext = $record[GlobalValue::CLIENTE_CODIGOEXTERNO];
                $result = $this->getDoctrine()->getRepository(Cliente::class)
                        ->findOneBy(array('codigoexterno'=>$codext, 'empresa'=>$empresa) );
                //si existe se sobreescriben los datos
                if ($result){
                    $registro = $result;
                }
                $registro->setCodigoexterno(utf8_decode($codext));
                $registro->setRazonsocial(utf8_decode($record[GlobalValue::CLIENTE_RAZONSOCIAL]));
                $registro->setCondicioniva(utf8_decode($record[GlobalValue::CLIENTE_CONDICIONIVA]));
                $registro->setDireccion(utf8_decode($record[GlobalValue::CLIENTE_DIRECCION])); 
                $registro->setNdoc(utf8_decode($record[GlobalValue::CLIENTE_NRODOC])); 
                $registro->setTelefono(utf8_decode($record[GlobalValue::CLIENTE_TELEFONO])); 
                $registro->setContacto(utf8_decode($record[GlobalValue::CLIENTE_CONTACTO])); 
                
                $em->persist($registro);
                $em->flush();
            }
            $fileindex = $fileindex +1;
        }


        
    }
    
   
    
    public function procesarArchivoProductos( Archivo $archivo)
    {
        $csv = array();
        $lines = file($archivo->getArchivo(), FILE_IGNORE_NEW_LINES);
        $error = $this->validateArchivoProducto($lines);
        if ( $error > 0 ){
            return $error;
        }

        foreach ($lines as $key => $value)
        {
            $csv[$key] = str_getcsv($value,";");
        }
        $em = $this->getDoctrine()->getManager();
        $fileindex = 0; $header = 0;//Variable para identificar cabecera
        $em = $this->getDoctrine()->getManager();
        $hoy = date("Y-m-d");
        foreach ($csv as $record)
        {
            if ($fileindex > $header){

                $producto = new Producto();
                //validar si existe producto
                $codext = $record[GlobalValue::PRODUCTO_CODIGOEXTERNO];
                $result = $this->getDoctrine()->getRepository(Producto::class)
                        ->findOneBy(array('codigoexterno'=>$codext, 'empresa'=>$empresa) );
                //si existe se sobreescriben los datos
                if ($result){
                    $producto = $result;
                }
                $producto->setCodigoexterno(utf8_decode($codext));
                $producto->setNombre(utf8_decode($record[GlobalValue::PRODUCTO_NOMBRE]));
                $producto->setDescripcion(utf8_decode($record[GlobalValue::PRODUCTO_DESCRIPCION]));
                $producto->setPrecio((float)$record[GlobalValue::PRODUCTO_PRECIO]); 
                $producto->setStock((float)$record[GlobalValue::PRODUCTO_STOCK]); 
                $producto->setEmpresa($empresa);
                $em->persist($producto);
                
                //generar movimiento de stock
               
                $mv = new Movimientostock();
                $mv->setFecha(new \DateTime($hoy));
                $mv->setCantidad($producto->getStock());
                $mv->setEmpresa($empresa);
                $mv->setNrocomprobante("Importacion de Archivo" );
                $mv->setProducto($producto);
                $mv->setTipomovimiento(GlobalValue::INICIALIZACION);
                $em->persist($mv);

            }
            $em->flush();
            $fileindex = $fileindex +1;
        }

    }
    
    
    
    public function procesarArchivoStocks(Archivo $archivo)
    {

        $csv = array();
        $path = $this->getParameter('archivos_productos_path');
        $pathfilename = $path . $archivo->getArchivo();
        $lines = file($pathfilename, FILE_IGNORE_NEW_LINES);
        
        $error = $this->validateArchivoStock($lines);
        
        if ( $error > 0 ){
            return $error;
        }
        
        foreach ($lines as $key => $value)
        {
            $csv[$key] = str_getcsv($value,";");
        }
        $em = $this->getDoctrine()->getManager();
        if ($archivo->getTipo() == GlobalValue::ARCHIVO_STOCKS){
            $fileindex = 0; $header = 0;//Variable para identificar cabecera
            $em = $this->getDoctrine()->getManager();
            foreach ($csv as $record)
            {
                if ($fileindex > $header){
                    
                    $producto = new Producto();
                    //validar si existe producto
                    $codext = $record[GlobalValue::STOCK_CODIGOEXTERNO];
                    $result = $this->getDoctrine()->getRepository(Producto::class)
                            ->findOneBy(array('codigoexterno'=>$codext, 'empresa'=>$empresa) );
                    //si existe se sobreescriben los datos
                    if ($result){
                        $producto = $result;
                        $producto->setCodigoexterno($codext);
                        $producto->setStock($record[GlobalValue::STOCK_CANTIDAD]); 
                        $producto->setEmpresa($empresa);
                        $em->persist($producto);
                        $em->flush();
                    }
                    
                }
                $fileindex = $fileindex +1;
            }
            
            $archivo->setEstado(GlobalValue::ARCHIVO_ESTADO_PROCESADO);
            $em->persist($archivo);
            $em->flush();
        }
    }
    
    
    public function procesarArchivoListaprecios( Archivo $archivo)
    {

        $csv = array();
        $path = $this->getParameter('archivos_productos_path');
        $pathfilename = $path . $archivo->getArchivo();
        $lines = file($pathfilename, FILE_IGNORE_NEW_LINES);
        $error = $this->validateArchivoListaprecio($lines);
        
        if ( $error > 0 ){
            return $error;
        }
        
        foreach ($lines as $key => $value)
        {
            $csv[$key] = str_getcsv($value,";");
        }
        $em = $this->getDoctrine()->getManager();
        if ($archivo->getTipo() == GlobalValue::ARCHIVO_LISTAPRECIOS){
            $fileindex = 0; $header = 0;//Variable para identificar cabecera
            $em = $this->getDoctrine()->getManager();
            foreach ($csv as $record)
            {
                if ($fileindex > $header){
                    
                    $producto = new Producto();
                    //validar si existe producto
                    $codext = $record[GlobalValue::LISTAPRECIOS_CODIGOEXTERNO];
                    $result = $this->getDoctrine()->getRepository(Producto::class)
                            ->findOneBy(array('codigoexterno'=>$codext, 'empresa'=>$empresa) );
                    //si existe se sobreescriben los datos
                    if ($result){
                        $producto = $result;
                        $producto->setCodigoexterno($codext);
                        $producto->setPrecio($record[GlobalValue::LISTAPRECIOS_PRECIO]); 
                        $producto->setEmpresa($empresa);
                        $em->persist($producto);
                        $em->flush();
                    }
                }
                $fileindex = $fileindex +1;
            }
            
            $archivo->setEstado(GlobalValue::ARCHIVO_ESTADO_PROCESADO);
            $em->persist($archivo);
            $em->flush();
        }
    }
    
    
    
    /**
     * Creates a new categorium entity.
     *
     * @Route("/new", name="archivo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, FileUploader $fileUploader)
    {
        $archivo = new Archivo();
        $form = $this->createForm('AppBundle\Form\ArchivoType', $archivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
                $archivo->setEstado(GlobalValue::ARCHIVO_ESTADO_UPLOAD);
                $archivo->setEmpresa($empresa);
                $hoy = date("Y-m-d");
                $archivo->setFecha(new \DateTime($hoy));

                $em = $this->getDoctrine()->getManager();

                if ($archivo->getTipo()==GlobalValue::ARCHIVO_PRODUCTOS){
                    $this->procesarArchivoProductos($empresa, $archivo);
                    $archivo->setEstado(GlobalValue::ARCHIVO_ESTADO_PROCESADO);
                }
                if ($archivo->getTipo()==GlobalValue::ARCHIVO_CLIENTES){
                    $this->procesarArchivoClientes($empresa, $archivo);
                    $archivo->setEstado(GlobalValue::ARCHIVO_ESTADO_PROCESADO);
                }
                if ($archivo->getTipo()==GlobalValue::ARCHIVO_STOCK){
                    
                    $this->procesarArchivoStocks($empresa, $archivo);
                    $archivo->setEstado(GlobalValue::ARCHIVO_ESTADO_PROCESADO);
                }
                if ($archivo->getTipo()==GlobalValue::ARCHIVO_LISTAPRECIOS){
                    
                    $this->procesarArchivoListaprecios($empresa, $archivo);
                    $archivo->setEstado(GlobalValue::ARCHIVO_ESTADO_PROCESADO);
                }
                $em->persist($archivo);
                $em->flush();
                $this->addFlash(  'success','Guardado y Procesado Correctamente!');
                return $this->redirectToRoute('archivo_index');

            }catch(Exception $e){
                $this->addFlash("success","Error: "+$e->getMessage());
                return $this->redirectToRoute('archivo_index');
                  
            }
            return $this->redirectToRoute('archivo_index');
        }

        return $this->render('archivo/new.html.twig', array(
            'archivo' => $archivo,
            'form' => $form->createView(),
            'archivo_estados'=> GlobalValue::ARCHIVO_ESTADOS,
            'archivo_tipos'=>GlobalValue::ARCHIVO_TIPOS
        ));
    }

    /**
     * Finds and displays a categorium entity.
     *
     * @Route("/{id}", name="archivo_show")
     * @Method("GET")
     */
    public function showAction(Archivo $archivo)
    {   
        $deleteForm = $this->createDeleteForm($archivo);
        
        return $this->render('archivo/show.html.twig', array(
            'archivo' => $archivo,
            'delete_form' => $deleteForm->createView(),
            'archivo_estados'=> GlobalValue::ARCHIVO_ESTADOS,
            'archivo_tipos'=>GlobalValue::ARCHIVO_TIPOS
        ));
    }

    
     /**
     *
     * @Route("/reprocesar/{id}", name="archivo_reprocesar")
     * @Method("GET")
     */
    public function reprocesarAction(Archivo $archivo)
    {   
        $deleteForm = $this->createDeleteForm($archivo);
     
        if ($archivo->getTipo()== GlobalValue::ARCHIVO_PRODUCTOS){
            $error = $this->procesarArchivoProductos( $archivo);
        }
        if ($archivo->getTipo()== GlobalValue::ARCHIVO_CLIENTES){
            $error = $this->procesarArchivoClientes($archivo);
        }
        if ($archivo->getTipo()== GlobalValue::ARCHIVO_LISTAPRECIOS){
            $error = $this->procesarArchivoListaprecios( $archivo);
        }
        if ($archivo->getTipo()== GlobalValue::ARCHIVO_STOCK){
            $error = $this->procesarArchivoStocks( $archivo);
        }
        
        if ($error > 0){
           $this->addFlash('error','Error al procesar el archivo, Formato incorrecto.');

        } else{
            $this->addFlash('success','Archivo Reprocesado Correctamente!');
        }
        return $this->redirectToRoute('archivo_index');
       
        
    }

   

    /**
     * Deletes a categorium entity.
     *
     * @Route("/{id}", name="archivo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Archivo $archivo)
    {
        $form = $this->createDeleteForm($archivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($archivo);
            $em->flush();
        }

        return $this->redirectToRoute('archivo_index');
    }

    /**
     * Creates a form to delete a categorium entity.
     *
     * @param Archivo $archivo The categorium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Archivo $archivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('archivo_delete', array('id' => $archivo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
