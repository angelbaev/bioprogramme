<?php

namespace BioprogrammeMarketingBundle\Controller;

use BioprogrammeMarketingBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Notification controller.
 *
 * @Route("marketing/notification")
 */
class NotificationController extends Controller
{
    /**
     * Lists all notification entities.
     *
     * @Route("/", name="marketing_notification_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $page = $request->get('page', 1);

        $filter = [
            'user' => $this->get('security.token_storage')->getToken()->getUser()->getId(),
        ];

        $orderBy = ['createdAt', 'desc'];
        $notifications = $this->get('bioprogramme_marketing.notification_manager')->search($filter, $orderBy, $page);
        $total = $notifications->count();

        return $this->render('BioprogrammeMarketingBundle:notification:index.html.twig', array(
            'notifications' => $notifications,
            'total' => $total
        ));
    }

    /**
     * Finds and displays a notification entity.
     *
     * @Route("/{id}", name="marketing_notification_show")
     * @Method("GET")
     */
    public function showAction(Notification $notification)
    {
        if (!$notification->getIsReaded()) {
            $notification->setIsReaded(true);
            $this->get('bioprogramme_marketing.notification_manager')->save($notification);
        }

        return $this->render('BioprogrammeMarketingBundle:notification:show.html.twig', array(
            'notification' => $notification,
        ));
    }
    /**
     * @Route("/update", name="marketing_email_update")
     * @Method({"GET", "POST"})
     */
    public function updateAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $result = $this->get('bioprogramme_marketing.notification_manager')->updateAllAsRead(
            $this->get('security.token_storage')->getToken()->getUser()->getId()
        );

        return new JsonResponse(['status' => $result]);
    }
}
