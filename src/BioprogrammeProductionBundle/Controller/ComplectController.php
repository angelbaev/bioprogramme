<?php

namespace BioprogrammeProductionBundle\Controller;

use AppBundle\Helper\ImageHelper;
use BioprogrammeProductionBundle\Entity\Attribute;
use BioprogrammeProductionBundle\Entity\BuildingBlockAttributeReference;
use BioprogrammeProductionBundle\Entity\Complect;
use BioprogrammeProductionBundle\Entity\ComplectAttributeReference;
use BioprogrammeProductionBundle\Entity\ComplectDocument;
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
            'name' => (string)$request->get('filter_name'),
            'number' => (string)$request->get('filter_number'),
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
        $complectDocument = new ComplectDocument();
        $complectDocument->setComplect($complect);
        $complectDocumentForm = $this->createForm('BioprogrammeProductionBundle\Form\ComplectDocumentType', $complectDocument);

//        $buildingBlockFieldForm = $this->createForm('BioprogrammeProductionBundle\Form\BuildingBlockFieldType', $complect);
        $complectAttributeReference = new ComplectAttributeReference();
        $complectAttributeReference->setComplect($complect);
        $buildingBlockFieldForm = $this->createForm('BioprogrammeProductionBundle\Form\ComplectAttributeReferenceType', $complectAttributeReference);

        return $this->render('BioprogrammeProductionBundle:complect:edit.html.twig', array(
            'complect' => $complect,
            'attributes' => $this->get('bioprogramme_production.attribute_manager')->findAll(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'building_block_field_form' => $buildingBlockFieldForm->createView(),
            'complect_document_form' => $complectDocumentForm->createView(),
        ));
    }

    /**
     *
     *
     * @Route("/add-document", name="nomenclature_complect_add_document")
     * @Method({"GET", "POST"})
     */
    public function addDocumentAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $entity = new ComplectDocument();
        $form = $this->createForm('BioprogrammeProductionBundle\Form\ComplectDocumentType', $entity);
        $form->handleRequest($request);

        $data = ['status' => false, 'document' => null];
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('file');
            //$filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $filename = $file->getClientOriginalName();
            $path = $this->container->getParameter('dir_image') . 'documents/';
            $file->move($path,$filename);
            $entity->setFile('documents/' . $filename);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $data['status'] = true;
            $data['document'] = [
                'id' => $entity->getId(),
                'name' => $entity->getName(),
                'description' => $entity->getDescription(),
                'file' => $entity->getFile()
            ];
        }

        return new JsonResponse($data);
    }

    /**
     *
     *
     * @Route("/remove-document", name="nomenclature_complect_remove_document")
     * @Method({"POST"})
     */
    public function removeDocumentAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $id = $request->get('documentId', false);
        $data = ['status' => false];
        if ($id) {
            $data['status'] = true;
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository(ComplectDocument::class)->find($id);
            $em->remove($entity);
            $em->flush();
        }

        return new JsonResponse($data);
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

        $entity = new ComplectAttributeReference();
        $form = $this->createForm('BioprogrammeProductionBundle\Form\ComplectAttributeReferenceType', $entity);
        $form->handleRequest($request);

        $data = ['status' => false, 'buildingBlock' => null];

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setComplect($complect);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $data['status'] = true;
            $attributes = [];
//            foreach ($entity->getBuildingBlock()->getAttributes() as $attribute) {
//                $attributes[] = [
//                    'name' => $attribute->getAttribute()->getName(),
//                    'text' => $attribute->getText()
//                ];
//            }
            $image = ImageHelper::resize($this->container,  $entity->getBuildingBlock()->getImage(), 64, 64);
            if (!$image) {
                $image = ImageHelper::resize($this->container, 'img/no_image.jpg', 64, 64);
            }

            $data['buildingBlock'] = [
                'id' => $entity->getId(),
                'image' => $image,
                'buildingBlockId' => $entity->getBuildingBlock()->getId(),
                'name' => $entity->getBuildingBlock()->getName(),
                'model' => $entity->getBuildingBlock()->getModel(),
                'number' => $entity->getBuildingBlock()->getNumber(),
                'attributeRefs' => [],
                'quantity' => $entity->getQuantity()
            ];
        }

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

        $id = $request->get('complectAttributeRefId', false);
        $data = ['status' => false];
        if ($id) {
            $data['status'] = true;
            $em = $this->getDoctrine()->getManager();

            $bbAttributeReferences = $em->getRepository(BuildingBlockAttributeReference::class)->findBy(['complect' => $id]);
            foreach($bbAttributeReferences as $bbAttributeReference) {
                $em->remove($bbAttributeReference);
            }
            $em->flush();

            $entity = $em->getRepository(ComplectAttributeReference::class)->find($id);
            $em->remove($entity);
            $em->flush();
        }

        return new JsonResponse($data);
    }

    /**
     *
     *
     * @Route("/add-building-block-attribute", name="nomenclature_complect_add_building_block_attr")
     * @Method({"POST"})
     */
    public function addBuildingBlockAttributeAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $complectRefId = $request->get('complect_ref_id', false);
        $attributes = $request->get('bb_attribute', []);
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(ComplectAttributeReference::class)->find($complectRefId);
        $data = [];
        foreach($attributes['id'] as $k => $attrId) {
            $attrEnity =  $em->getRepository(Attribute::class)->find($attrId);
            $bbEnity = new BuildingBlockAttributeReference();
            $bbEnity->setComplect($entity);
            $bbEnity->setAttribute($attrEnity);
            $bbEnity->setText($attributes['text'][$k]);
            $em->persist($bbEnity);
            $data[] = [
                'attribute_id' => $attrId,
                'complect_ref_id' => $complectRefId,
                'name' => $attrEnity->getName(),
                'text' => $attributes['text'][$k],
            ];
        }
        $em->flush();

        return new JsonResponse($data);
    }

    /**
     *
     *
     * @Route("/remove-building-block-attribute", name="nomenclature_complect_remove_building_block_attr")
     * @Method({"POST"})
     */
    public function removeBuildingBlockAttributeAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }
        $bbAttrRefId = $request->get('bb_attr_ref_id', false);
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(BuildingBlockAttributeReference::class)->find($bbAttrRefId);
        $em->remove($entity);
        $em->flush();

        return new JsonResponse(['status' => true]);
    }

    /**
     *
     *
     * @Route("/list-building-block-attribute", name="nomenclature_complect_list_building_block_attr")
     * @Method({"GET", "POST"})
     */
    public function listBuildingBlockAttributeAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }
        $complectRefId = $request->get('complect_ref_id', false);
        $em = $this->getDoctrine()->getManager();
        $data = [];
        $results = $em->getRepository(BuildingBlockAttributeReference::class)->findBy(['complect' => $complectRefId]);
        foreach($results as $result) {
            $data[] = [
                'id' => $result->getId(),
                'name' => $result->getAttribute()->getName(),
                'text' => $result->getText(),
            ];
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
