<?php

namespace AppBundle\Controller;

require_once __DIR__.'/../../../vendor/autoload.php';

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use MP;

/**
 * Payment controller.
 *
 * @Route("payment")
 */
class PaymentController extends Controller
{
   
   
    /**
     * @Route("/create/", name="mercadopagocreate")
     */
    public function mercadopagoCreateAction(Request $request)
    {
        try {
            $content = $request->getContent();
            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $code    = Response::HTTP_OK; 

            
            $mp = new MP ("2207797945420831", "lZVQBryGrJ3wzcuFLBrxsWuETU4sm1IE");
            

            $preference_data = array (
                "items" => array (
                    array (
                        "title" => "Test",
                        "quantity" => 1,
                        "currency_id" => "USD",
                        "unit_price" => 10.4
                    )
                )
            );
            
            $preference = $mp->create_preference($preference_data);

            //print_r ($preference);


            $data = array('code'=>'500',
            'message'=>'error',
            'data'=>'puto',
            'content'=>$preference
            );
            $response->setContent(json_encode($data));
        
            return $response;
        } catch(Exception $e) {
            $data = array('code'=>'200',
                'message'=>'ok',
                'data'=>$e->getMessage()
            );
            $response->setData($data);
            return $response;
        }
    }
}
