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
 * @Route("mercadopago")
 */
class PaymentController extends Controller
{
   
   
    /**
     * @Route("/create/checkout/", name="mercadopagocreatecheckout")
     */
    public function mercadopagoCreateCheckoutAction(Request $request)
    {
        try {
            $content = $request->getContent();
            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $code    = Response::HTTP_OK; 

            
            $mp = new MP ("2207797945420831", "lZVQBryGrJ3wzcuFLBrxsWuETU4sm1IE");
            
            $json    = json_decode($content, true);
            
           /*
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
            */

            $preference_data = array (
                "items" => array (
                    array (
                        "title" => $json['title'],
                        "quantity" => 1,
                        "currency_id" => $json['currency_id'],
                        "unit_price" => $json['amount']
                    )
                )
            );
            $preference = $mp->create_preference($preference_data);

            


            $response->setContent(json_encode($preference));
        
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

    /**
     * @Route("/create/payment/", name="mercadopagocreatepayment")
     */
    public function mercadopagoCreatePaymentAction(Request $request)
    {
        try {
            $content = $request->getContent();
            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $code    = Response::HTTP_OK; 

            $json    = json_decode($content, true);
            $mp = new MP('2207797945420831', 'lZVQBryGrJ3wzcuFLBrxsWuETU4sm1IE');

                $preapproval_data = array(
                    "payer_email" => "ezequielgalvan1895@gmail.com",
                    "back_url" => "http://www.my-site.com",
                    "reason" => "Monthly subscription to premium package",
                    "external_reference" => "OP-1234",
                    "auto_recurring" => array(
                        "frequency" => 1,
                        "frequency_type" => "months",
                        "transaction_amount" => 120,
                        "currency_id" => "ARS",
                        "start_date" => "2018-12-10T14:58:11.778-03:00",
                        "end_date" => "2020-06-10T14:58:11.778-03:00",
                        
                        
                    )
                );

                $preapproval = $mp->create_preapproval_payment($preapproval_data);


            $response->setContent(json_encode($preapproval));
        
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


    /**
     * @Route("/list/payment/", name="mercadopagolistpayment")
     */
    public function mercadopagoListPaymentAction(Request $request)
    {
        try {
            $content = $request->getContent();
            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $code    = Response::HTTP_OK; 

            $json    = json_decode($content, true);
            $mp = new MP('2207797945420831', 'lZVQBryGrJ3wzcuFLBrxsWuETU4sm1IE');


          
           
            $payment_info = $mp->get_payment_info("a481df73c8d14c8f97be12a0a83ce6f6");
            

            $response->setContent(json_encode($searchResult));
        
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








    //-------------

   



}
