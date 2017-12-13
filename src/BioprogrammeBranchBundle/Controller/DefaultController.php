<?php

namespace BioprogrammeBranchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/branch")
     */
    public function indexAction()
    {
        return $this->render('BioprogrammeBranchBundle:Default:index.html.twig');
    }
}
