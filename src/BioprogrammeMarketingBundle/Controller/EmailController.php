<?php

namespace BioprogrammeMarketingBundle\Controller;

use BioprogrammeMarketingBundle\Entity\Email;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Email controller.
 *
 * @Route("marketing/email")
 */
class EmailController extends Controller
{
    /**
     * Lists all email entities.
     *
     * @Route("/", name="marketing_email_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $page = $request->get('page', 1);

        $filter = [
            'toUser' => $this->get('security.token_storage')->getToken()->getUser()->getId(),
        ];

        $orderBy = ['createdAt', 'desc'];
        $emails = $this->get('bioprogramme_marketing.email_manager')->search($filter, $orderBy, $page);
        $total = $emails->count();

        return $this->render('BioprogrammeMarketingBundle:email:index.html.twig', array(
            'emails' => $emails,
            'total' => $total
        ));
    }
    /**
     * Lists all email entities.
     *
     * @Route("/outbox", name="marketing_email_outbox")
     * @Method("GET")
     */
    public function outboxAction(Request $request)
    {
        $page = $request->get('page', 1);

        $filter = [
            'fromUser' => $this->get('security.token_storage')->getToken()->getUser()->getId(),
        ];

        $orderBy = ['createdAt', 'desc'];
        $emails = $this->get('bioprogramme_marketing.email_manager')->search($filter, $orderBy, $page);
        $total = $emails->count();

        return $this->render('BioprogrammeMarketingBundle:email:outbox.html.twig', array(
            'emails' => $emails,
            'total' => $total
        ));
    }
    /**
     * Creates a new email entity.
     *
     * @Route("/new", name="marketing_email_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $email = new Email();
        $form = $this->createForm('BioprogrammeMarketingBundle\Form\EmailType', $email);
        $form->handleRequest($request);
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $email->setFromUser($user);
        $email->setIsReaded(false);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_marketing.email_manager')->save($email);

            return $this->redirectToRoute('marketing_email_show', array('id' => $email->getId(), 'type' => 'outbox'));
        }

        return $this->render('BioprogrammeMarketingBundle:email:new.html.twig', array(
            'email' => $email,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a email entity.
     *
     * @Route("/{id}", name="marketing_email_show")
     * @Method("GET")
     */
    public function showAction(Email $email, Request $request)
    {
        $deleteForm = $this->createDeleteForm($email);
        $type = $request->get('type', 'inbox');

        if ($type === 'inbox') {
            $email->setIsReaded(true);
            $this->get('bioprogramme_marketing.email_manager')->save($email);
        }

        return $this->render('BioprogrammeMarketingBundle:email:show.html.twig', array(
            'email' => $email,
            'delete_form' => $deleteForm->createView(),
            'type' => $type
        ));
    }

    /**
     * Displays a form to edit an existing email entity.
     *
     * @Route("/{id}/edit", name="marketing_email_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Email $replayEmail)
    {
        $email = new Email();
        $email->setToUser($replayEmail->getFromUser());
        $email->setSubject('RE: ' . $replayEmail->getSubject());
        $email->setMessage($replayEmail->getMessage());
        $form = $this->createForm('BioprogrammeMarketingBundle\Form\EmailType', $email);
        $form->handleRequest($request);
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $email->setFromUser($user);
        $email->setIsReaded(false);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_marketing.email_manager')->save($email);

            return $this->redirectToRoute('marketing_email_show', array('id' => $email->getId(), 'type' => 'outbox'));
        }

        return $this->render('BioprogrammeMarketingBundle:email:edit.html.twig', array(
            'email' => $email,
            'edit_form' => $form->createView(),
        ));

    }

    /**
     * Deletes a email entity.
     *
     * @Route("/{id}", name="marketing_email_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Email $email)
    {
        $form = $this->createDeleteForm($email);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_marketing.email_manager')->delete($email);
        }

        return $this->redirectToRoute('marketing_email_index');
    }

    /**
     * Creates a form to delete a email entity.
     *
     * @param Email $email The email entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Email $email)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('marketing_email_delete', array('id' => $email->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
