<?php

namespace BioprogrammeAccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/account")
     */
    public function indexAction()
    {
        return $this->render('BioprogrammeAccountBundle:Default:index.html.twig');
    }
}
