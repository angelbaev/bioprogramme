<?php

namespace BioprogrammeAccountBundle\Controller;

use BioprogrammeAccountBundle\Entity\Position;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Position controller.
 *
 * @Route("account/position")
 */
class PositionController extends Controller
{
    /**
     * Lists all position entities.
     *
     * @Route("/", name="account_position_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $positions = $em->getRepository('BioprogrammeAccountBundle:Position')->findAll();

        return $this->render('position/index.html.twig', array(
            'positions' => $positions,
        ));
    }

    /**
     * Creates a new position entity.
     *
     * @Route("/new", name="account_position_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $position = new Position();
        $form = $this->createForm('BioprogrammeAccountBundle\Form\PositionType', $position);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($position);
            $em->flush();

            return $this->redirectToRoute('account_position_show', array('id' => $position->getId()));
        }

        return $this->render('position/new.html.twig', array(
            'position' => $position,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a position entity.
     *
     * @Route("/{id}", name="account_position_show")
     * @Method("GET")
     */
    public function showAction(Position $position)
    {
        $deleteForm = $this->createDeleteForm($position);

        return $this->render('position/show.html.twig', array(
            'position' => $position,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing position entity.
     *
     * @Route("/{id}/edit", name="account_position_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Position $position)
    {
        $deleteForm = $this->createDeleteForm($position);
        $editForm = $this->createForm('BioprogrammeAccountBundle\Form\PositionType', $position);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('account_position_edit', array('id' => $position->getId()));
        }

        return $this->render('position/edit.html.twig', array(
            'position' => $position,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a position entity.
     *
     * @Route("/{id}", name="account_position_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Position $position)
    {
        $form = $this->createDeleteForm($position);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($position);
            $em->flush();
        }

        return $this->redirectToRoute('account_position_index');
    }

    /**
     * Creates a form to delete a position entity.
     *
     * @param Position $position The position entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Position $position)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('account_position_delete', array('id' => $position->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
