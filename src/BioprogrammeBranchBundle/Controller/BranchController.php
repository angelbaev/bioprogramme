<?php

namespace BioprogrammeBranchBundle\Controller;

use BioprogrammeBranchBundle\Entity\Branch;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Branch controller.
 *
 * @Route("branch/branch")
 */
class BranchController extends Controller
{
    /**
     * Lists all branch entities.
     *
     * @Route("/", name="branch_branch_index")
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
        $branches = $this->get('bioprogramme_branch.branch_manager')->search($filter, $orderBy, $page);
        $total = $branches->count();

        $queryParams = [
            'filter_name' => $request->get('filter_name'),
        ];

        return $this->render('BioprogrammeBranchBundle:branch:index.html.twig', array(
            'branches' => $branches,
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
     * Creates a new branch entity.
     *
     * @Route("/new", name="branch_branch_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $branch = new Branch();
        $form = $this->createForm('BioprogrammeBranchBundle\Form\BranchType', $branch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_branch.branch_manager')->save($branch);

            return $this->redirectToRoute('branch_branch_show', array('id' => $branch->getId()));
        }

        return $this->render('BioprogrammeBranchBundle:branch:new.html.twig', array(
            'branch' => $branch,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a branch entity.
     *
     * @Route("/{id}", name="branch_branch_show")
     * @Method("GET")
     */
    public function showAction(Branch $branch)
    {
        $deleteForm = $this->createDeleteForm($branch);

        return $this->render('BioprogrammeBranchBundle:branch:show.html.twig', array(
            'branch' => $branch,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing branch entity.
     *
     * @Route("/{id}/edit", name="branch_branch_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Branch $branch)
    {
        $deleteForm = $this->createDeleteForm($branch);
        $editForm = $this->createForm('BioprogrammeBranchBundle\Form\BranchType', $branch);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->get('bioprogramme_branch.branch_manager')->save($branch);

            return $this->redirectToRoute('branch_branch_edit', array('id' => $branch->getId()));
        }

        return $this->render('BioprogrammeBranchBundle:branch:edit.html.twig', array(
            'branch' => $branch,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a branch entity.
     *
     * @Route("/{id}", name="branch_branch_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Branch $branch)
    {
        $form = $this->createDeleteForm($branch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_branch.branch_manager')->delete($branch);
        }

        return $this->redirectToRoute('branch_branch_index');
    }

    /**
     * Creates a form to delete a branch entity.
     *
     * @param Branch $branch The branch entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Branch $branch)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('branch_branch_delete', array('id' => $branch->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
