<?php

namespace BioprogrammeProductionBundle\Controller;

use BioprogrammeProductionBundle\Entity\BuildingBlock;
use BioprogrammeProductionBundle\Entity\BuildingBlockAttributeReference;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Buildingblock controller.
 *
 * @Route("nomenclature/buildingblock")
 */
class BuildingBlockController extends Controller
{
    /**
     * Lists all buildingBlock entities.
     *
     * @Route("/", name="nomenclature_buildingblock_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $page = $request->get('page', 1);
        $sort = $request->get('sort', 'name');
        $order = $request->get('order', 'asc');

        $filter = [
            'name' => $request->get('filter_name'),
            'model' => $request->get('filter_model'),
            'number' => $request->get('filter_number'),
        ];

        $orderBy = [$sort, $order];
        $buildingBlocks = $this->get('bioprogramme_production.building_block_manager')->search($filter, $orderBy, $page);
        $total = $buildingBlocks->count();

        $queryParams = [
            'filter_name' => $request->get('filter_name'),
            'filter_model' => $request->get('filter_model'),
            'filter_number' => $request->get('filter_number'),
        ];

        return $this->render('BioprogrammeProductionBundle:buildingblock:index.html.twig', array(
            'buildingBlocks' => $buildingBlocks,
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
     * Creates a new buildingBlock entity.
     *
     * @Route("/new", name="nomenclature_buildingblock_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $buildingBlock = new Buildingblock();
        $form = $this->createForm('BioprogrammeProductionBundle\Form\BuildingBlockType', $buildingBlock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_production.building_block_manager')->save($buildingBlock);

            return $this->redirectToRoute('nomenclature_buildingblock_edit', array('id' => $buildingBlock->getId()));
        }

        return $this->render('BioprogrammeProductionBundle:buildingblock:new.html.twig', array(
            'buildingBlock' => $buildingBlock,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a buildingBlock entity.
     *
     * @Route("/{id}", name="nomenclature_buildingblock_show")
     * @Method("GET")
     */
    public function showAction(BuildingBlock $buildingBlock)
    {
        $deleteForm = $this->createDeleteForm($buildingBlock);

        return $this->render('BioprogrammeProductionBundle:buildingblock:show.html.twig', array(
            'buildingBlock' => $buildingBlock,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing buildingBlock entity.
     *
     * @Route("/{id}/edit", name="nomenclature_buildingblock_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BuildingBlock $buildingBlock)
    {
        $deleteForm = $this->createDeleteForm($buildingBlock);
        $editForm = $this->createForm('BioprogrammeProductionBundle\Form\BuildingBlockType', $buildingBlock);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->get('bioprogramme_production.building_block_manager')->save($buildingBlock);

            return $this->redirectToRoute('nomenclature_buildingblock_edit', array('id' => $buildingBlock->getId()));
        }

        $buildingBlockAttributeReference = new BuildingBlockAttributeReference();
        $buildingBlockAttributeReference->setBuildingBlock($buildingBlock);
        $buildingBlockAttributeForm = $this->createForm('BioprogrammeProductionBundle\Form\BuildingBlockAttributeReferenceType', $buildingBlockAttributeReference);

        return $this->render('BioprogrammeProductionBundle:buildingblock:edit.html.twig', array(
            'buildingBlock' => $buildingBlock,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'building_block_attribute_form' => $buildingBlockAttributeForm->createView(),
        ));
    }

    /**
     *
     *
     * @Route("/{id}/add-attribute", name="nomenclature_buildingblock_add_attribute")
     * @Method({"GET", "POST"})
     */
    public function addAttributeAction(Request $request, BuildingBlock $buildingBlock)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }
        $entity = new BuildingBlockAttributeReference();
        $form = $this->createForm('BioprogrammeProductionBundle\Form\BuildingBlockAttributeReferenceType', $entity);
        $form->handleRequest($request);

        $data = ['status' => false, 'attribute' => null];

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setBuildingBlock($buildingBlock);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $data['status'] = true;
            $data['attribute'] = [
                'id' => $entity->getId(),
                'name' => $entity->getAttribute()->getName(),
                'text' => $entity->getText()
            ];
        }

        return new JsonResponse($data);
    }

    /**
     *
     *
     * @Route("/{id}/remove-attribute", name="nomenclature_buildingblock_remove_attribute")
     * @Method({"POST"})
     */
    public function removeAttributeAction(Request $request, BuildingBlock $buildingBlock)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $id = $request->get('buildingBlockAtrrRefId', false);
        $data = ['status' => false];
        if ($id) {
            $data['status'] = true;
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository(BuildingBlockAttributeReference::class)->find($id);
            $em->remove($entity);
            $em->flush();
        }

        return new JsonResponse($data);
    }

    /**
     * Deletes a buildingBlock entity.
     *
     * @Route("/{id}", name="nomenclature_buildingblock_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BuildingBlock $buildingBlock)
    {
        $form = $this->createDeleteForm($buildingBlock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_production.building_block_manager')->delete($buildingBlock);
        }

        return $this->redirectToRoute('nomenclature_buildingblock_index');
    }

    /**
     * Creates a form to delete a buildingBlock entity.
     *
     * @param BuildingBlock $buildingBlock The buildingBlock entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BuildingBlock $buildingBlock)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nomenclature_buildingblock_delete', array('id' => $buildingBlock->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
