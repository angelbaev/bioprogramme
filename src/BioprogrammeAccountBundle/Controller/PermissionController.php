<?php

namespace BioprogrammeAccountBundle\Controller;

use BioprogrammeAccountBundle\Entity\Permission;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Permission controller.
 *
 * @Route("account/permission")
 */
class PermissionController extends Controller
{
    /**
     * Lists all permission entities.
     *
     * @Route("/", name="account_permission_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $permissions = $em->getRepository('BioprogrammeAccountBundle:Permission')->findAll();

        return $this->render('permission/index.html.twig', array(
            'permissions' => $permissions,
        ));
    }

    /**
     * Creates a new permission entity.
     *
     * @Route("/new", name="account_permission_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $permission = new Permission();
        $form = $this->createForm('BioprogrammeAccountBundle\Form\PermissionType', $permission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($permission);
            $em->flush();

            return $this->redirectToRoute('account_permission_show', array('id' => $permission->getId()));
        }

        return $this->render('permission/new.html.twig', array(
            'permission' => $permission,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a permission entity.
     *
     * @Route("/{id}", name="account_permission_show")
     * @Method("GET")
     */
    public function showAction(Permission $permission)
    {
        $deleteForm = $this->createDeleteForm($permission);

        return $this->render('permission/show.html.twig', array(
            'permission' => $permission,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing permission entity.
     *
     * @Route("/{id}/edit", name="account_permission_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Permission $permission)
    {
        $deleteForm = $this->createDeleteForm($permission);
        $editForm = $this->createForm('BioprogrammeAccountBundle\Form\PermissionType', $permission);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('account_permission_edit', array('id' => $permission->getId()));
        }

        return $this->render('permission/edit.html.twig', array(
            'permission' => $permission,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a permission entity.
     *
     * @Route("/{id}", name="account_permission_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Permission $permission)
    {
        $form = $this->createDeleteForm($permission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($permission);
            $em->flush();
        }

        return $this->redirectToRoute('account_permission_index');
    }

    /**
     * Creates a form to delete a permission entity.
     *
     * @param Permission $permission The permission entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Permission $permission)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('account_permission_delete', array('id' => $permission->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
