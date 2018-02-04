<?php

namespace BioprogrammeProductionBundle\Controller;

use BioprogrammeProductionBundle\Entity\Machine;
use BioprogrammeProductionBundle\Entity\MachineAttributeReference;
use BioprogrammeProductionBundle\Entity\MachineDocument;
use BioprogrammeProductionBundle\Entity\MachineManual;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Machine controller.
 *
 * @Route("nomenclature/machine")
 */
class MachineController extends Controller
{
    /**
     * Lists all machine entities.
     *
     * @Route("/", name="nomenclature_machine_index")
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
        $machines = $this->get('bioprogramme_production.machine_manager')->search($filter, $orderBy, $page);
        $total = $machines->count();

        $queryParams = [
            'filter_name' => $request->get('filter_name'),
        ];

        return $this->render('BioprogrammeProductionBundle:machine:index.html.twig', array(
            'machines' => $machines,
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
     * Creates a new machine entity.
     *
     * @Route("/new", name="nomenclature_machine_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $machine = new Machine();
        $form = $this->createForm('BioprogrammeProductionBundle\Form\MachineType', $machine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_production.machine_manager')->save($machine);

            return $this->redirectToRoute('nomenclature_machine_show', array('id' => $machine->getId()));
        }

        return $this->render('BioprogrammeProductionBundle:machine:new.html.twig', array(
            'machine' => $machine,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a machine entity.
     *
     * @Route("/{id}", name="nomenclature_machine_show")
     * @Method("GET")
     */
    public function showAction(Machine $machine)
    {
        $deleteForm = $this->createDeleteForm($machine);

        return $this->render('BioprogrammeProductionBundle:machine:show.html.twig', array(
            'machine' => $machine,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing machine entity.
     *
     * @Route("/{id}/edit", name="nomenclature_machine_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Machine $machine)
    {
        $deleteForm = $this->createDeleteForm($machine);
        $editForm = $this->createForm('BioprogrammeProductionBundle\Form\MachineType', $machine);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->get('bioprogramme_production.machine_manager')->save($machine);

            return $this->redirectToRoute('nomenclature_machine_edit', array('id' => $machine->getId()));
        }

        $machineAttributeReference = new MachineAttributeReference();
        $machineAttributeReference->setMachine($machine);
        $machineAttributeForm = $this->createForm('BioprogrammeProductionBundle\Form\MachineAttributeReferenceType', $machineAttributeReference);

        $machineDocument = new MachineDocument();
        $machineDocument->setMachine($machine);
        $machineDocumentForm = $this->createForm('BioprogrammeProductionBundle\Form\MachineDocumentType', $machineDocument);

        if ($machine->getManual() === null) {
            $machineManual = new MachineManual();
            $machineManual->setMachine($machine);
            $em = $this->getDoctrine()->getManager();
            $em->persist($machineManual);
            $em->flush();
        } else {
            $machineManual = $machine->getManual();
        }

        $machineManualForm = $this->createForm('BioprogrammeProductionBundle\Form\MachineManualType', $machineManual);

        return $this->render('BioprogrammeProductionBundle:machine:edit.html.twig', array(
            'machine' => $machine,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'machine_attribute_form' => $machineAttributeForm->createView(),
            'machine_document_form' => $machineDocumentForm->createView(),
            'machine_manual_form' => $machineManualForm->createView(),
        ));
    }

    /**
     *
     *
     * @Route("/add-attribute", name="nomenclature_machine_add_attribute")
     * @Method({"GET", "POST"})
     */
    public function addAttributeAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $entity = new MachineAttributeReference();
        $form = $this->createForm('BioprogrammeProductionBundle\Form\MachineAttributeReferenceType', $entity);
        $form->handleRequest($request);

        $data = ['status' => false, 'attribute' => null];
        if ($form->isSubmitted() && $form->isValid()) {
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
     * @Route("/remove-attribute", name="nomenclature_machine_remove_attribute")
     * @Method({"POST"})
     */
    public function removeAttributeAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $id = $request->get('machineAtrrRefId', false);
        $data = ['status' => false];
        if ($id) {
            $data['status'] = true;
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository(MachineAttributeReference::class)->find($id);
            $em->remove($entity);
            $em->flush();
        }

        return new JsonResponse($data);
    }

    /**
     *
     *
     * @Route("/add-document", name="nomenclature_machine_add_document")
     * @Method({"GET", "POST"})
     */
    public function addDocumentAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $entity = new MachineDocument();
        $form = $this->createForm('BioprogrammeProductionBundle\Form\MachineDocumentType', $entity);
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
     * @Route("/remove-document", name="nomenclature_machine_remove_document")
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
            $entity = $em->getRepository(MachineDocument::class)->find($id);
            $em->remove($entity);
            $em->flush();
        }

        return new JsonResponse($data);
    }

    /**
     *
     *
     * @Route("/add-manual", name="nomenclature_machine_add_manual")
     * @Method({"GET", "POST"})
     */
    public function addManualAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $formData = $request->get('bioprogrammeproductionbundle_machinemanual');
        $manualId = (isset($formData['id']) ? (int) isset($formData['id']) : false);
        $data = ['status' => false, 'manual' => null];

        if ($manualId) {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository(MachineManual::class);
            $entity = $repository->find(['id' => $manualId]);
            $entity->setManual($formData['manual']);
            $em->persist($entity);
            $em->flush();

            $data['status'] = true;
            $data['manual'] = $entity->getManual();
        }

        return new JsonResponse($data);
    }

    /**
     * Deletes a machine entity.
     *
     * @Route("/{id}", name="nomenclature_machine_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Machine $machine)
    {
        $form = $this->createDeleteForm($machine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_production.machine_manager')->delete($machine);
        }

        return $this->redirectToRoute('nomenclature_machine_index');
    }

    /**
     * Creates a form to delete a machine entity.
     *
     * @param Machine $machine The machine entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Machine $machine)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nomenclature_machine_delete', array('id' => $machine->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
