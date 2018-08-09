<?php

namespace AdaptiveTech\DeliveryTrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdaptiveTechDeliveryTrackerBundle:Default:index.html.twig');
    }
}
