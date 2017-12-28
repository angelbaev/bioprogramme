<?php

namespace AppBundle\Controller;

use AppBundle\Helper\ImageHelper;
use BioprogrammeMarketingBundle\Entity\Email;
use BioprogrammeMarketingBundle\Entity\Notification;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

//https://symfony.com/doc/current/components/serializer.html
/**
 * Class NotificationController
 *
 * @package AppBundle\Controller
 */
class NotificationController extends Controller
{
    /**
     * @Route("/notification", name="notification")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $notifications = $em->getRepository(Notification::class)->findBy(
            [
                'user' => $this->get('security.token_storage')->getToken()->getUser()->getId(),
                'isReaded' => 0
            ],
            ['createdAt' => 'DESC'],
            5
        );

        $emails = $em->getRepository(Email::class)->findBy(
            [
                'toUser' => $this->get('security.token_storage')->getToken()->getUser()->getId(),
                'isReaded' => 0
            ],
            ['createdAt' => 'DESC'],
            5
        );

        foreach($emails as $email) {
            $image = ImageHelper::resize($this->container, $email->getFromUser()->getImage(), 64, 64);
            if (!$image) {
                $image = ImageHelper::resize($this->container, 'img/no_image.jpg', 64, 64);
            }
            $email->getFromUser()->setImage($image);
        }

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');

        $response->setCallback(function () use ($serializer, $notifications, $emails) {
            $notifications = $serializer->serialize(
                $notifications,
                'json',
                [
                    'attributes' => [
                        'id',
                        'message',
                        'user' =>['email', 'fullName']
                    ]
                ]
            );

            $emails = $serializer->serialize(
                $emails,
                'json',
                [
                    'attributes' => [
                        'id',
                        'subject',
                        'fromUser' =>['email', 'fullName', 'image']
                    ]
                ]
            );
            echo 'data: {"notifications": ' . $notifications . ', "emails":' . $emails . ', "tasks":[]}';
            echo "\n\n";

            ob_flush();
            flush();
        });

        return $response;
    }
}
