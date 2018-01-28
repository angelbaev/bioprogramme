<?php

namespace BioprogrammeProductionBundle\Controller;

use BioprogrammeProductionBundle\Entity\Machine;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Machine controller.
 *
 * @Route("nomenclature/machine")
 */
class MachineController extends Controller
{
    /**
     * Lists all machine entities.
     *
     * @Route("/", name="nomenclature_machine_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $page = $request->get('page', 1);
        $sort = $request->get('sort', 'name');
        $order = $request->get('order', 'asc');

        $filter = [
            'name' => $request->get('filter_name'),
        ];

        $orderBy = [$sort, $order];
        $machines = $this->get('bioprogramme_production.machine_manager')->search($filter, $orderBy, $page);
        $total = $machines->count();

        $queryParams = [
            'filter_name' => $request->get('filter_name'),
        ];

        return $this->render('BioprogrammeProductionBundle:machine:index.html.twig', array(
            'machines' => $machines,
            'total' => $total,
            'page' => $page,
            'sort' => $sort,
            'order' => $order,
            'filter' => $filter,
            'queryParams' => $queryParams,
            'paginationParams' => array_merge($queryParams, ['sort' => $sort, 'order' => $order]),
        ));
    }

    /**
     * Creates a new machine entity.
     *
     * @Route("/new", name="nomenclature_machine_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $machine = new Machine();
        $form = $this->createForm('BioprogrammeProductionBundle\Form\MachineType', $machine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_production.machine_manager')->save($machine);

            return $this->redirectToRoute('nomenclature_machine_show', array('id' => $machine->getId()));
        }

        return $this->render('BioprogrammeProductionBundle:machine:new.html.twig', array(
            'machine' => $machine,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a machine entity.
     *
     * @Route("/{id}", name="nomenclature_machine_show")
     * @Method("GET")
     */
    public function showAction(Machine $machine)
    {
        $deleteForm = $this->createDeleteForm($machine);

        return $this->render('BioprogrammeProductionBundle:machine:show.html.twig', array(
            'machine' => $machine,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing machine entity.
     *
     * @Route("/{id}/edit", name="nomenclature_machine_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Machine $machine)
    {
        $deleteForm = $this->createDeleteForm($machine);
        $editForm = $this->createForm('BioprogrammeProductionBundle\Form\MachineType', $machine);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->get('bioprogramme_production.machine_manager')->save($machine);

            return $this->redirectToRoute('nomenclature_machine_edit', array('id' => $machine->getId()));
        }

        return $this->render('BioprogrammeProductionBundle:machine:edit.html.twig', array(
            'machine' => $machine,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a machine entity.
     *
     * @Route("/{id}", name="nomenclature_machine_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Machine $machine)
    {
        $form = $this->createDeleteForm($machine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_production.machine_manager')->delete($machine);
        }

        return $this->redirectToRoute('nomenclature_machine_index');
    }

    /**
     * Creates a form to delete a machine entity.
     *
     * @param Machine $machine The machine entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Machine $machine)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nomenclature_machine_delete', array('id' => $machine->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
