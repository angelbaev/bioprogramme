<?php

namespace BioprogrammeProductionBundle\Controller;

use BioprogrammeProductionBundle\Entity\MachineOrder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Machineorder controller.
 *
 * @Route("machineorder")
 */
class MachineOrderController extends Controller
{
    /**
     * Lists all machineOrder entities.
     *
     * @Route("/", name="machineorder_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $machineOrders = $em->getRepository('BioprogrammeProductionBundle:MachineOrder')->findAll();

        return $this->render('BioprogrammeProductionBundle:machineorder:index.html.twig', array(
            'machineOrders' => $machineOrders,
        ));
    }

    /**
     * Creates a new machineOrder entity.
     *
     * @Route("/new", name="machineorder_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        //https://symfony.com/doc/current/form/form_collections.html
        //https://symfony-collection.fuz.org/symfony3/
        //https://knpuniversity.com/screencast/collections/embedded-form-collection
        // Symfony Advanced - Forms and Events 02:00
        $machineOrder = new Machineorder();
        $form = $this->createForm('BioprogrammeProductionBundle\Form\MachineOrderType', $machineOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($machineOrder);
            $em->flush();

            return $this->redirectToRoute('machineorder_show', array('id' => $machineOrder->getId()));
        }

        $machines = $this->get('bioprogramme_production.machine_manager')->findAll();

        return $this->render('BioprogrammeProductionBundle:machineorder:new.html.twig', array(
            'machineOrder' => $machineOrder,
            'machines' => $machines,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a machineOrder entity.
     *
     * @Route("/{id}", name="machineorder_show")
     * @Method("GET")
     */
    public function showAction(MachineOrder $machineOrder)
    {
        $deleteForm = $this->createDeleteForm($machineOrder);

        return $this->render('BioprogrammeProductionBundle:machineorder:show.html.twig', array(
            'machineOrder' => $machineOrder,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing machineOrder entity.
     *
     * @Route("/{id}/edit", name="machineorder_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MachineOrder $machineOrder)
    {
        $deleteForm = $this->createDeleteForm($machineOrder);
        $editForm = $this->createForm('BioprogrammeProductionBundle\Form\MachineOrderType', $machineOrder);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('machineorder_edit', array('id' => $machineOrder->getId()));
        }

        return $this->render('BioprogrammeProductionBundle:machineorder:edit.html.twig', array(
            'machineOrder' => $machineOrder,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a machineOrder entity.
     *
     * @Route("/{id}", name="machineorder_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MachineOrder $machineOrder)
    {
        $form = $this->createDeleteForm($machineOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($machineOrder);
            $em->flush();
        }

        return $this->redirectToRoute('machineorder_index');
    }

    /**
     * Creates a form to delete a machineOrder entity.
     *
     * @param MachineOrder $machineOrder The machineOrder entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MachineOrder $machineOrder)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('machineorder_delete', array('id' => $machineOrder->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
