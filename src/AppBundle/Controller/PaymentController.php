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
            $json    = json_decode($content, true);
            
            $mp = new MP ("2207797945420831", "lZVQBryGrJ3wzcuFLBrxsWuETU4sm1IE");
            

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
     * @Route("/create/preapproval/", name="mercadopagocreatepreapproval")
     */
    public function mercadopagoCreatePreapprovalAction(Request $request)
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
            $filters = array (
                "id"=>"bc65828116044fccbfa2e4001f0a6eb3"
            );
            $searchResult = $mp->search_payment ($filters);


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
           
            $mp = new MP('TEST-2207797945420831-122010-06933213e1f9eda6452bffee4786b2bd__LC_LA__-214222883');
            /*
            $json['transaction_amount']
            $json['token']
            $json['description']
            $json['installments']
            $json['payment_method_id']
            $json['email']
            */

            $payment_data = array(
                "transaction_amount" => 100,
                "token" => "ff8080814c11e237014c1ff593b57b4d",
                "description" => "Title of what you are paying for",
                "installments" => 1,
                "payment_method_id" => "visa",
                "payer" => array (
                    "email" => "test_user_19653727@testuser.com"
                )
            );

            $payment = $mp->post("/v1/payments", $payment_data);


            $response->setContent(json_encode($payment));
        
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
