<?php

namespace BioprogrammeBranchBundle\Controller;

use BioprogrammeBranchBundle\Entity\Line;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Line controller.
 *
 * @Route("branch/line")
 */
class LineController extends Controller
{
    /**
     * Lists all line entities.
     *
     * @Route("/", name="branch_line_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $page = $request->get('page', 1);
        $sort = $request->get('sort', 'name');
        $order = $request->get('order', 'asc');

        $filter = [
            'name' => $request->get('filter_name'),
            'isActive' => $request->get('filter_isActive', null),
        ];

        $orderBy = [$sort, $order];
        $lines = $this->get('bioprogramme_branch.line_manager')->search($filter, $orderBy, $page);
        $total = $lines->count();

        $queryParams = [
            'filter_name' => $request->get('filter_name'),
            'filter_isActive' => $request->get('filter_isActive', null),
        ];
        if (is_null($filter['isActive'])) {
            $filter['isActive'] = -1;
        }

        return $this->render('BioprogrammeBranchBundle:line:index.html.twig', array(
            'lines' => $lines,
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
     * Creates a new line entity.
     *
     * @Route("/new", name="branch_line_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $line = new Line();
        $form = $this->createForm('BioprogrammeBranchBundle\Form\LineType', $line);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_branch.line_manager')->save($line);

            return $this->redirectToRoute('branch_line_show', array('id' => $line->getId()));
        }

        return $this->render('BioprogrammeBranchBundle:line:new.html.twig', array(
            'line' => $line,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a line entity.
     *
     * @Route("/{id}", name="branch_line_show")
     * @Method("GET")
     */
    public function showAction(Line $line)
    {
        $deleteForm = $this->createDeleteForm($line);

        return $this->render('BioprogrammeBranchBundle:line:show.html.twig', array(
            'line' => $line,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing line entity.
     *
     * @Route("/{id}/edit", name="branch_line_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Line $line)
    {
        $deleteForm = $this->createDeleteForm($line);
        $editForm = $this->createForm('BioprogrammeBranchBundle\Form\LineType', $line);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->get('bioprogramme_branch.line_manager')->save($line);

            return $this->redirectToRoute('branch_line_edit', array('id' => $line->getId()));
        }

        return $this->render('BioprogrammeBranchBundle:line:edit.html.twig', array(
            'line' => $line,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a line entity.
     *
     * @Route("/{id}", name="branch_line_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Line $line)
    {
        $form = $this->createDeleteForm($line);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_branch.line_manager')->delete($line);
        }

        return $this->redirectToRoute('branch_line_index');
    }

    /**
     * Creates a form to delete a line entity.
     *
     * @param Line $line The line entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Line $line)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('branch_line_delete', array('id' => $line->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
