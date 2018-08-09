<?php 
namespace AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;

use \FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\Controller\Annotations as Rest;

class ProductoController extends FOSRestController
{
    
    
    
    
    /**
     * @Rest\Post("/api/productos")
     */
    public function getProductosAction(Request $request){
        $empresa_id = $request->get('empresa_id');
        //$empresa = $this->getDoctrine()->getRepository('AppBundle:Empresa')->findById($empresa_id);
        $result = $this->getDoctrine()->getRepository('AppBundle:Producto')->findAll();
        if ($result == null) {
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
     * @Rest\Post("/api/producto/1")
     */
    public function getProductoIdAction(Request $request){
        $empresa_id = $request->get('empresa_id');
        //$empresa = $this->getDoctrine()->getRepository('AppBundle:Empresa')->findById($empresa_id);
        $result = $this->getDoctrine()->getRepository('AppBundle:Producto')->find(8);
        if ($result == null) {
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

}

?>