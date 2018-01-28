<?php

namespace BioprogrammeProductionBundle\Controller;

use BioprogrammeProductionBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Category controller.
 *
 * @Route("nomenclature/category")
 */
class CategoryController extends Controller
{
    /**
     * Lists all category entities.
     *
     * @Route("/", name="nomenclature_category_index")
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
        $categories = $this->get('bioprogramme_production.category_manager')->search($filter, $orderBy, $page);
        $total = $categories->count();

        $queryParams = [
            'filter_name' => $request->get('filter_name'),
        ];

        return $this->render('BioprogrammeProductionBundle:category:index.html.twig', array(
            'categories' => $categories,
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
     * Creates a new category entity.
     *
     * @Route("/new", name="nomenclature_category_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm('BioprogrammeProductionBundle\Form\CategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_production.category_manager')->save($category);

            return $this->redirectToRoute('nomenclature_category_show', array('id' => $category->getId()));
        }

        return $this->render('BioprogrammeProductionBundle:category:new.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a category entity.
     *
     * @Route("/{id}", name="nomenclature_category_show")
     * @Method("GET")
     */
    public function showAction(Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);

        return $this->render('BioprogrammeProductionBundle:category:show.html.twig', array(
            'category' => $category,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing category entity.
     *
     * @Route("/{id}/edit", name="nomenclature_category_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        $editForm = $this->createForm('BioprogrammeProductionBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->get('bioprogramme_production.category_manager')->save($category);

            return $this->redirectToRoute('nomenclature_category_edit', array('id' => $category->getId()));
        }

        return $this->render('BioprogrammeProductionBundle:category:edit.html.twig', array(
            'category' => $category,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a category entity.
     *
     * @Route("/{id}", name="nomenclature_category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_production.category_manager')->delete($category);
        }

        return $this->redirectToRoute('nomenclature_category_index');
    }

    /**
     * Creates a form to delete a category entity.
     *
     * @param Category $category The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nomenclature_category_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
