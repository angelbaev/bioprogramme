<?php

namespace BioprogrammeAccountBundle\Controller;

use BioprogrammeAccountBundle\Entity\User;
use BioprogrammeAccountBundle\Form\ImageUserUploadType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * User controller.
 *
 * @Route("account/user")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="account_user_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $page = $request->get('page', 1);
        $sort = $request->get('sort', 'username');
        $order = $request->get('order', 'asc');

        $filter = [
            'username' => $request->get('filter_username'),
            'email' => $request->get('filter_email'),
            'fullName' => $request->get('filter_fullName'),
            'phone' => $request->get('filter_phone'),
            'isActive' => $request->get('filter_isActive', null),
        ];

        $orderBy = [$sort, $order];
        $users = $this->get('bioprogramme_account.user_manager')->search($filter, $orderBy, $page);
        $total = $users->count();

        $queryParams = [
            'filter_username' => $request->get('filter_username'),
            'filter_email' => $request->get('filter_email'),
            'filter_fullName' => $request->get('filter_fullName'),
            'filter_phone' => $request->get('filter_phone'),
            'filter_isActive' => $request->get('filter_isActive', null),
        ];

        if (is_null($filter['isActive'])) {
            $filter['isActive'] = -1;
        }

        return $this->render('BioprogrammeAccountBundle:user:index.html.twig', array(
            'users' => $users,
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
     * Creates a new user entity.
     *
     * @Route("/new", name="account_user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('BioprogrammeAccountBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwordEncoder = $this->container->get('security.password_encoder');
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $this->get('bioprogramme_account.user_manager')->save($user);

            return $this->redirectToRoute('account_user_show', array('id' => $user->getId()));
        }

        return $this->render('BioprogrammeAccountBundle:user:new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="account_user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('BioprogrammeAccountBundle:user:show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/profile/{id}", name="account_user_profile")
     * @Method("GET")
     */
    public function profileAction(Request $request, User $user)
    {
        return $this->render('BioprogrammeAccountBundle:user:profile.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="account_user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('BioprogrammeAccountBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if (!is_null($editForm->get('password')->getData())) {
                $passwordEncoder = $this->container->get('security.password_encoder');
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
            }

            $this->get('bioprogramme_account.user_manager')->save($user);

            return $this->redirectToRoute('account_user_edit', array('id' => $user->getId()));
        }

        return $this->render('BioprogrammeAccountBundle:user:edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Change profile image
     *
     * @Route("/{id}/image", name="account_user_image")
     * @Method({"POST"})
     */
    public function imageAction(Request $request, User $user)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $file = $request->files->get('profile_image');
        $status = ['status' => 'success', 'fileUploaded' => false];
        if(!is_null($file)){
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $this->container->getParameter('dir_image') . 'data/profile';
            $file->move($path,$filename);
            $user->setImage('data/profile/' . $filename);
            $this->get('bioprogramme_account.user_manager')->save($user);
            $status = ['status' => 'success', 'fileUploaded' => true];
        }

        return new JsonResponse($status);
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="account_user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_account.user_manager')->delete($user);
        }

        return $this->redirectToRoute('account_user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('account_user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
