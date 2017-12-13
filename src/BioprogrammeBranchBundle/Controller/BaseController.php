<?php

namespace BioprogrammeBranchBundle\Controller;

use BioprogrammeBranchBundle\Entity\Base;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Base controller.
 *
 * @Route("branch/base")
 */
class BaseController extends Controller
{
    /**
     * Lists all base entities.
     *
     * @Route("/", name="branch_base_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $page = $request->get('page', 1);
        $sort = $request->get('sort', 'name');
        $order = $request->get('order', 'asc');

        $filter = [
            'name' => $request->get('filter_name'),
            'phone' => $request->get('filter_phone'),
            'isActive' => $request->get('filter_isActive', null),
        ];

        $orderBy = [$sort, $order];
        $bases = $this->get('bioprogramme_branch.base_manager')->search($filter, $orderBy, $page);
        $total = $bases->count();

        $queryParams = [
            'filter_name' => $request->get('filter_name'),
            'filter_phone' => $request->get('filter_phone'),
            'filter_isActive' => $request->get('filter_isActive', null),
        ];

        if (is_null($filter['isActive'])) {
            $filter['isActive'] = -1;
        }

        return $this->render('BioprogrammeBranchBundle:base:index.html.twig', array(
            'bases' => $bases,
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
     * Creates a new base entity.
     *
     * @Route("/new", name="branch_base_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $base = new Base();
        $form = $this->createForm('BioprogrammeBranchBundle\Form\BaseType', $base);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_branch.branch_manager')->save($base);

            return $this->redirectToRoute('branch_base_show', array('id' => $base->getId()));
        }

        return $this->render('BioprogrammeBranchBundle:base:new.html.twig', array(
            'base' => $base,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a base entity.
     *
     * @Route("/{id}", name="branch_base_show")
     * @Method("GET")
     */
    public function showAction(Base $base)
    {
        $deleteForm = $this->createDeleteForm($base);

        return $this->render('BioprogrammeBranchBundle:base:show.html.twig', array(
            'base' => $base,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing base entity.
     *
     * @Route("/{id}/edit", name="branch_base_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Base $base)
    {
        $deleteForm = $this->createDeleteForm($base);
        $editForm = $this->createForm('BioprogrammeBranchBundle\Form\BaseType', $base);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->get('bioprogramme_branch.branch_manager')->save($base);

            return $this->redirectToRoute('branch_base_edit', array('id' => $base->getId()));
        }

        return $this->render('BioprogrammeBranchBundle:base:edit.html.twig', array(
            'base' => $base,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a base entity.
     *
     * @Route("/{id}", name="branch_base_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Base $base)
    {
        $form = $this->createDeleteForm($base);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_branch.branch_manager')->delete($base);
        }

        return $this->redirectToRoute('branch_base_index');
    }

    /**
     * Creates a form to delete a base entity.
     *
     * @param Base $base The base entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Base $base)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('branch_base_delete', array('id' => $base->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
