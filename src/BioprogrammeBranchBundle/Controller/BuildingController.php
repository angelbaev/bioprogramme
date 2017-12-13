<?php

namespace BioprogrammeBranchBundle\Controller;

use BioprogrammeBranchBundle\Entity\Building;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Building controller.
 *
 * @Route("branch/building")
 */
class BuildingController extends Controller
{
    /**
     * Lists all building entities.
     *
     * @Route("/", name="branch_building_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $page = $request->get('page', 1);
        $sort = $request->get('sort', 'name');
        $order = $request->get('order', 'asc');

        $filter = [
            'name' => $request->get('filter_name'),
            'base' => $request->get('filter_base'),
            'isActive' => $request->get('filter_isActive', null),
        ];

        $orderBy = [$sort, $order];
        $buildings = $this->get('bioprogramme_branch.building_manager')->search($filter, $orderBy, $page);
        $total = $buildings->count();

        $queryParams = [
            'filter_name' => $request->get('filter_name'),
            'filter_base' => $request->get('filter_base'),
            'filter_isActive' => $request->get('filter_isActive', null),
        ];

        if (is_null($filter['isActive'])) {
            $filter['isActive'] = -1;
        }

        return $this->render('BioprogrammeBranchBundle:building:index.html.twig', array(
            'buildings' => $buildings,
            'total' => $total,
            'page' => $page,
            'sort' => $sort,
            'order' => $order,
            'filter' => $filter,
            'queryParams' => $queryParams,
            'paginationParams' => array_merge($queryParams, ['sort' => $sort, 'order' => $order]),
            'bases' => $this->get('bioprogramme_branch.base_manager')->findAll()
        ));
    }

    /**
     * Creates a new building entity.
     *
     * @Route("/new", name="branch_building_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $building = new Building();
        $form = $this->createForm('BioprogrammeBranchBundle\Form\BuildingType', $building);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_branch.building_manager')->save($building);

            return $this->redirectToRoute('branch_building_show', array('id' => $building->getId()));
        }

        return $this->render('BioprogrammeBranchBundle:building:new.html.twig', array(
            'building' => $building,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a building entity.
     *
     * @Route("/{id}", name="branch_building_show")
     * @Method("GET")
     */
    public function showAction(Building $building)
    {
        $deleteForm = $this->createDeleteForm($building);

        return $this->render('BioprogrammeBranchBundle:building:show.html.twig', array(
            'building' => $building,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing building entity.
     *
     * @Route("/{id}/edit", name="branch_building_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Building $building)
    {
        $deleteForm = $this->createDeleteForm($building);
        $editForm = $this->createForm('BioprogrammeBranchBundle\Form\BuildingType', $building);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->get('bioprogramme_branch.building_manager')->save($building);

            return $this->redirectToRoute('branch_building_edit', array('id' => $building->getId()));
        }

        return $this->render('BioprogrammeBranchBundle:building:edit.html.twig', array(
            'building' => $building,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a building entity.
     *
     * @Route("/{id}", name="branch_building_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Building $building)
    {
        $form = $this->createDeleteForm($building);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_branch.building_manager')->delete($building);
        }

        return $this->redirectToRoute('branch_building_index');
    }

    /**
     * Creates a form to delete a building entity.
     *
     * @param Building $building The building entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Building $building)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('branch_building_delete', array('id' => $building->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
