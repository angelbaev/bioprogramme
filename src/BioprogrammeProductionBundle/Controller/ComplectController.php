<?php

namespace BioprogrammeProductionBundle\Controller;

use BioprogrammeProductionBundle\Entity\Complect;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Complect controller.
 *
 * @Route("nomenclature/complect")
 */
class ComplectController extends Controller
{
    /**
     * Lists all complect entities.
     *
     * @Route("/", name="nomenclature_complect_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $page = $request->get('page', 1);
        $sort = $request->get('sort', 'name');
        $order = $request->get('order', 'asc');

        $filter = [
            'name' => $request->get('filter_name'),
            'number' => $request->get('filter_number'),
        ];

        $orderBy = [$sort, $order];
        $complects = $this->get('bioprogramme_production.complect_manager')->search($filter, $orderBy, $page);
        $total = $complects->count();

        $queryParams = [
            'filter_name' => $request->get('filter_name'),
        ];

        return $this->render('BioprogrammeProductionBundle:complect:index.html.twig', array(
            'complects' => $complects,
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
     * Creates a new complect entity.
     *
     * @Route("/new", name="nomenclature_complect_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $complect = new Complect();
        $form = $this->createForm('BioprogrammeProductionBundle\Form\ComplectType', $complect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_production.complect_manager')->save($complect);

            return $this->redirectToRoute('nomenclature_complect_show', array('id' => $complect->getId()));
        }

        return $this->render('BioprogrammeProductionBundle:complect:new.html.twig', array(
            'complect' => $complect,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a complect entity.
     *
     * @Route("/{id}", name="nomenclature_complect_show")
     * @Method("GET")
     */
    public function showAction(Complect $complect)
    {
        $deleteForm = $this->createDeleteForm($complect);

        return $this->render('BioprogrammeProductionBundle:complect:show.html.twig', array(
            'complect' => $complect,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing complect entity.
     *
     * @Route("/{id}/edit", name="nomenclature_complect_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Complect $complect)
    {
        $deleteForm = $this->createDeleteForm($complect);
        $editForm = $this->createForm('BioprogrammeProductionBundle\Form\ComplectType', $complect);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->get('bioprogramme_production.complect_manager')->save($complect);

            return $this->redirectToRoute('nomenclature_complect_edit', array('id' => $complect->getId()));
        }

        $buildingBlockFieldForm = $this->createForm('BioprogrammeProductionBundle\Form\BuildingBlockFieldType', $complect);

        return $this->render('BioprogrammeProductionBundle:complect:edit.html.twig', array(
            'complect' => $complect,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'building_block_field_form' => $buildingBlockFieldForm->createView(),
        ));
    }

    /**
     *
     *
     * @Route("/{id}/add-building-block", name="nomenclature_complect_add_building_block")
     * @Method({"GET", "POST"})
     */
    public function addBuildingBlockAction(Request $request, Complect $complect)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $buildingBlockId = $request->get('buildingBlockId');

        $entity = $this->get('bioprogramme_production.building_block_manager')->findById($buildingBlockId);
        $complect->addBuildingBlock($entity);
        $this->get('bioprogramme_production.complect_manager')->save($complect);

        $data = [
             'status' => true,
             'buildingBlock' => [
                'id' => $entity->getId(),
                'name' => $entity->getName(),
                'model' => $entity->getModel()
             ]
        ];

        return new JsonResponse($data);
    }

    /**
     *
     *
     * @Route("/{id}/remove-building-block", name="nomenclature_complect_remove_building_block")
     * @Method({"POST"})
     */
    public function removeBuildingBlockAction(Request $request, Complect $complect)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $id = $request->get('buildingBlockId', false);
        $data = ['status' => false];
        if ($id) {
            $data['status'] = true;
            $entity = $this->get('bioprogramme_production.building_block_manager')->findById($id);
            $complect->removeBuildingBlock($entity);
            $this->get('bioprogramme_production.complect_manager')->save($complect);
        }

        return new JsonResponse($data);
    }

    /**
     * Deletes a complect entity.
     *
     * @Route("/{id}", name="nomenclature_complect_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Complect $complect)
    {
        $form = $this->createDeleteForm($complect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_production.complect_manager')->delete($complect);
        }

        return $this->redirectToRoute('nomenclature_complect_index');
    }

    /**
     * Creates a form to delete a complect entity.
     *
     * @param Complect $complect The complect entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Complect $complect)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nomenclature_complect_delete', array('id' => $complect->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
