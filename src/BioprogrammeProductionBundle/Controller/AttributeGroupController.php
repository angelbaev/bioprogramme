<?php

namespace BioprogrammeProductionBundle\Controller;

use BioprogrammeProductionBundle\Entity\AttributeGroup;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Attributegroup controller.
 *
 * @Route("nomenclature/attributegroup")
 */
class AttributeGroupController extends Controller
{
    /**
     * Lists all attributeGroup entities.
     *
     * @Route("/", name="nomenclature_attributegroup_index")
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
        $attributeGroups = $this->get('bioprogramme_production.attribute_group_manager')->search($filter, $orderBy, $page);
        $total = $attributeGroups->count();

        $queryParams = [
            'filter_name' => $request->get('filter_name'),
        ];

        return $this->render('BioprogrammeProductionBundle:attributegroup:index.html.twig', array(
            'attributeGroups' => $attributeGroups,
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
     * Creates a new attributeGroup entity.
     *
     * @Route("/new", name="nomenclature_attributegroup_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $attributeGroup = new Attributegroup();
        $form = $this->createForm('BioprogrammeProductionBundle\Form\AttributeGroupType', $attributeGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_production.attribute_group_manager')->save($attributeGroup);

            return $this->redirectToRoute('nomenclature_attributegroup_show', array('id' => $attributeGroup->getId()));
        }

        return $this->render('BioprogrammeProductionBundle:attributegroup:new.html.twig', array(
            'attributeGroup' => $attributeGroup,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a attributeGroup entity.
     *
     * @Route("/{id}", name="nomenclature_attributegroup_show")
     * @Method("GET")
     */
    public function showAction(AttributeGroup $attributeGroup)
    {
        $deleteForm = $this->createDeleteForm($attributeGroup);

        return $this->render('BioprogrammeProductionBundle:attributegroup:show.html.twig', array(
            'attributeGroup' => $attributeGroup,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing attributeGroup entity.
     *
     * @Route("/{id}/edit", name="nomenclature_attributegroup_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AttributeGroup $attributeGroup)
    {
        $deleteForm = $this->createDeleteForm($attributeGroup);
        $editForm = $this->createForm('BioprogrammeProductionBundle\Form\AttributeGroupType', $attributeGroup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->get('bioprogramme_production.attribute_group_manager')->save($attributeGroup);

            return $this->redirectToRoute('nomenclature_attributegroup_edit', array('id' => $attributeGroup->getId()));
        }

        return $this->render('BioprogrammeProductionBundle:attributegroup:edit.html.twig', array(
            'attributeGroup' => $attributeGroup,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a attributeGroup entity.
     *
     * @Route("/{id}", name="nomenclature_attributegroup_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AttributeGroup $attributeGroup)
    {
        $form = $this->createDeleteForm($attributeGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_production.attribute_group_manager')->delete($attributeGroup);
        }

        return $this->redirectToRoute('nomenclature_attributegroup_index');
    }

    /**
     * Creates a form to delete a attributeGroup entity.
     *
     * @param AttributeGroup $attributeGroup The attributeGroup entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AttributeGroup $attributeGroup)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nomenclature_attributegroup_delete', array('id' => $attributeGroup->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
