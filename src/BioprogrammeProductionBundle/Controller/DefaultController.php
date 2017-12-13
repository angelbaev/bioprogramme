<?php

namespace BioprogrammeProductionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/production")
     */
    public function indexAction()
    {
        return $this->render('BioprogrammeProductionBundle:Default:index.html.twig');
    }
}
