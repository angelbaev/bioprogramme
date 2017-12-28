<?php

namespace BioprogrammeMarketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/marketing")
     */
    public function indexAction()
    {
        return $this->render('BioprogrammeMarketingBundle:Default:index.html.twig');
    }
}
