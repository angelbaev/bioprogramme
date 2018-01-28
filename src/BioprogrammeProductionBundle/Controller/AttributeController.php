<?php

namespace BioprogrammeProductionBundle\Controller;

use BioprogrammeProductionBundle\Entity\Attribute;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Attribute controller.
 *
 * @Route("nomenclature/attribute")
 */
class AttributeController extends Controller
{
    /**
     * Lists all attribute entities.
     *
     * @Route("/", name="nomenclature_attribute_index")
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
        $attributes = $this->get('bioprogramme_production.attribute_manager')->search($filter, $orderBy, $page);
        $total = $attributes->count();

        $queryParams = [
            'filter_name' => $request->get('filter_name'),
        ];

        return $this->render('BioprogrammeProductionBundle:attribute:index.html.twig', array(
            'attributes' => $attributes,
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
     * Creates a new attribute entity.
     *
     * @Route("/new", name="nomenclature_attribute_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $attribute = new Attribute();
        $form = $this->createForm('BioprogrammeProductionBundle\Form\AttributeType', $attribute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_production.attribute_manager')->save($attribute);

            return $this->redirectToRoute('nomenclature_attribute_show', array('id' => $attribute->getId()));
        }

        return $this->render('BioprogrammeProductionBundle:attribute:new.html.twig', array(
            'attribute' => $attribute,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a attribute entity.
     *
     * @Route("/{id}", name="nomenclature_attribute_show")
     * @Method("GET")
     */
    public function showAction(Attribute $attribute)
    {
        $deleteForm = $this->createDeleteForm($attribute);

        return $this->render('BioprogrammeProductionBundle:attribute:show.html.twig', array(
            'attribute' => $attribute,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing attribute entity.
     *
     * @Route("/{id}/edit", name="nomenclature_attribute_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Attribute $attribute)
    {
        $deleteForm = $this->createDeleteForm($attribute);
        $editForm = $this->createForm('BioprogrammeProductionBundle\Form\AttributeType', $attribute);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->get('bioprogramme_production.attribute_manager')->save($attribute);

            return $this->redirectToRoute('nomenclature_attribute_edit', array('id' => $attribute->getId()));
        }

        return $this->render('BioprogrammeProductionBundle:attribute:edit.html.twig', array(
            'attribute' => $attribute,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a attribute entity.
     *
     * @Route("/{id}", name="nomenclature_attribute_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Attribute $attribute)
    {
        $form = $this->createDeleteForm($attribute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_production.attribute_manager')->delete($attribute);
        }

        return $this->redirectToRoute('nomenclature_attribute_index');
    }

    /**
     * Creates a form to delete a attribute entity.
     *
     * @param Attribute $attribute The attribute entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Attribute $attribute)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nomenclature_attribute_delete', array('id' => $attribute->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
