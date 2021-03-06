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
     * @Route("/role/{role_id}", name="account_permission_role")
     * @Method("GET")
     */
    public function roleAction(Request $request)
    {
        /** @var Router $router */
        $router = $this->get('router');
        $routes = $router->getRouteCollection()->all();
        $permissions = $this->get('bioprogramme_account.permission_manager')->convertRouteCollection($routes);
        $roleId = $request->get('role_id');
        $role = $this->get('bioprogramme_account.role_manager')->findById($roleId);
        $rolePermissions = unserialize($role->getPermission());
        $access = [];
        $modify = [];
        if (isset($rolePermissions['access'])) {
            $access = $rolePermissions['access'];
        }
        if (isset($rolePermissions['modify'])) {
            $modify = $rolePermissions['modify'];
        }

        return $this->render('BioprogrammeAccountBundle:permission:index.html.twig', array(
            'permissions' => $permissions,
            'role' => $role,
            'access' => $access,
            'modify' => $modify,
        ));
    }

    /**
     * Save permissions
     *
     * @Route("/save-permissions", name="account_permission_save")
     * @Method({"GET", "POST"})
     */
    public function saveAction(Request $request)
    {
        $roleId = $request->get('role_id');
        $permission = serialize($request->get('permission'));
        $role = $this->get('bioprogramme_account.role_manager')->findById($roleId);
        $role->setPermission($permission);
        $this->get('bioprogramme_account.role_manager')->save($role);

        return $this->redirectToRoute('account_permission_role', array('role_id' => $roleId));
    }

    /**
     * Lists all permission entities.
     *
     * @Route("/", name="account_permission_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        /** @var Router $router */
        $router = $this->get('router');
        $routes = $router->getRouteCollection()->all();
        $this->get('bioprogramme_account.permission_manager')->convertRouteCollection($routes);


        $page = $request->get('page', 1);
        $sort = $request->get('sort', 'name');
        $order = $request->get('order', 'desc');

        if ($order === 'desc') {
            $order = 'asc';
        } else {
            $order = 'desc';
        }

        $orderBy = [$sort, $order];
        $permissions = $this->get('bioprogramme_account.permission_manager')->search([], $orderBy, $page);
        $total = $permissions->count();

        return $this->render('BioprogrammeAccountBundle:permission:index.html.twig', array(
            'permissions' => $permissions,
            'total' => $total,
            'page' => $page,
            'sort' => $sort,
            'order' => $order,
            'paginationParams' => ['sort' => $sort, 'order' => $order]
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
            $this->get('bioprogramme_account.permission_manager')->save($permission);

            return $this->redirectToRoute('account_permission_show', array('id' => $permission->getId()));
        }

        return $this->render('BioprogrammeAccountBundle:permission:new.html.twig', array(
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

        return $this->render('BioprogrammeAccountBundle:permission:show.html.twig', array(
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
            $this->get('bioprogramme_account.permission_manager')->save($permission);

            return $this->redirectToRoute('account_permission_edit', array('id' => $permission->getId()));
        }

        return $this->render('BioprogrammeAccountBundle:permission:edit.html.twig', array(
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
            $this->get('bioprogramme_account.position_manager')->delete($permission);
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
