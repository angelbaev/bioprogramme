<?php

namespace BioprogrammeSettingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/setting")
     */
    public function indexAction()
    {
        return $this->render('BioprogrammeSettingBundle:Default:index.html.twig');
    }
}
