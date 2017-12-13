<?php

namespace BioprogrammeAccountBundle\Controller;

use BioprogrammeAccountBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Role controller.
 *
 * @Route("account/role")
 */
class RoleController extends Controller
{
    /**
     * Lists all role entities.
     *
     * @Route("/", name="account_role_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $page = $request->get('page', 1);
        $sort = $request->get('sort', 'name');
        $order = $request->get('order', 'asc');

        $orderBy = [$sort, $order];
        $roles = $this->get('bioprogramme_account.role_manager')->search([], $orderBy, $page);
        $total = $roles->count();


        return $this->render('BioprogrammeAccountBundle:role:index.html.twig', array(
            'roles' => $roles,
            'total' => $total,
            'page' => $page,
            'sort' => $sort,
            'order' => $order,
            'paginationParams' => ['sort' => $sort, 'order' => $order]
        ));
    }

    /**
     * Creates a new role entity.
     *
     * @Route("/new", name="account_role_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $role = new Role();
        $form = $this->createForm('BioprogrammeAccountBundle\Form\RoleType', $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_account.role_manager')->save($role);

            return $this->redirectToRoute('account_role_show', array('id' => $role->getId()));
        }

        return $this->render('BioprogrammeAccountBundle:role:new.html.twig', array(
            'role' => $role,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a role entity.
     *
     * @Route("/{id}", name="account_role_show")
     * @Method("GET")
     */
    public function showAction(Role $role)
    {
        $deleteForm = $this->createDeleteForm($role);

        return $this->render('BioprogrammeAccountBundle:role:show.html.twig', array(
            'role' => $role,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing role entity.
     *
     * @Route("/{id}/edit", name="account_role_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Role $role)
    {
        $deleteForm = $this->createDeleteForm($role);
        $editForm = $this->createForm('BioprogrammeAccountBundle\Form\RoleType', $role);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->get('bioprogramme_account.role_manager')->save($role);

            return $this->redirectToRoute('account_role_edit', array('id' => $role->getId()));
        }

        return $this->render('BioprogrammeAccountBundle:role:edit.html.twig', array(
            'role' => $role,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a role entity.
     *
     * @Route("/{id}", name="account_role_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Role $role)
    {
        $form = $this->createDeleteForm($role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_account.role_manager')->delete($role);
        }

        return $this->redirectToRoute('account_role_index');
    }

    /**
     * Creates a form to delete a role entity.
     *
     * @param Role $role The role entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Role $role)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('account_role_delete', array('id' => $role->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
