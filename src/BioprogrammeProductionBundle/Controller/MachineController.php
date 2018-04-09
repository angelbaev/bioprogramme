<?php

namespace BioprogrammeProductionBundle\Controller;

use AppBundle\Helper\ImageHelper;
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
            'number' => $request->get('filter_number'),
            'model' => $request->get('filter_model'),
            'base' => $request->get('filter_base'),
            'building' => $request->get('filter_building'),
//            'line' => $request->get('filter_line'),
            'state' => $request->get('filter_state'),
        ];

        $orderBy = [$sort, $order];
        $machines = $this->get('bioprogramme_production.machine_manager')->search($filter, $orderBy, $page);
        $total = $machines->count();

        $queryParams = [
            'filter_name' => $request->get('filter_name'),
            'filter_model' => $request->get('filter_model'),
            'filter_number' => $request->get('filter_number'),
            'filter_base' => $request->get('filter_base'),
            'filter_building' => $request->get('filter_building'),
//            'filter_line' => $request->get('filter_line'),
            'filter_state' => $request->get('filter_state'),
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
            'bases' => $this->get('bioprogramme_branch.base_manager')->findAll(),
            'buildings' => $this->get('bioprogramme_branch.building_manager')->findBy(['base' => $filter['base']]),
//            'lines' => $this->get('bioprogramme_branch.line_manager')->findBy(['building' => $filter['building']])
        ));
    }

    /**
     *
     * @Route("/building", name="nomenclature_building_list")
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function listBuildingofBaseAction(Request $request)
    {
        $baseId = $request->get('baseId');

        if (is_null($baseId) || empty($baseId)) {

            return new JsonResponse([]);
        }

        $buildings =  $this->get('bioprogramme_branch.building_manager')->findBy(['base' => $baseId]);
        $data = [];
        foreach($buildings as $building) {
            $data[] = [
                'id' => $building->getId(),
                'name' => $building->getName()
            ];
        }

        return new JsonResponse($data);
    }

    /**
     *
     * @Route("/lines", name="nomenclature_line_list")
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function listLineofBuildingAction(Request $request)
    {
        $buildingId = $request->get('buildingId');

        if (is_null($buildingId) || empty($buildingId)) {

            return new JsonResponse([]);
        }

        $lines =  $this->get('bioprogramme_branch.line_manager')->findBy(['building' => $buildingId]);
        $data = [];
        foreach($lines as $line) {
            $data[] = [
                'id' => $line->getId(),
                'name' => $line->getName()
            ];
        }

        return new JsonResponse($data);
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
            'complects' => $this->get('bioprogramme_production.complect_manager')->findAll(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'machine_attribute_form' => $machineAttributeForm->createView(),
            'machine_document_form' => $machineDocumentForm->createView(),
            'machine_manual_form' => $machineManualForm->createView(),
        ));
    }

    /**
     *
     * @Route("/{id}/machine-add-complect", name="nomenclature_machine_add_complect")
     * @Method({"POST"})
     */
    public function addComplectAction(Request $request, Machine $machine)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $id = $request->get('complectId', false);
        $data = ['status' => false];
        if ($id) {
            $complect = $this->get('bioprogramme_production.complect_manager')->findById($id);
            $image = ImageHelper::resize($this->container,  $complect->getImage(), 64, 64);
            if (!$image) {
                $image = ImageHelper::resize($this->container, 'img/no_image.jpg', 64, 64);
            }

            $data['status'] = true;
            $data['complect'] = [
                'id' => $complect->getId(),
                'image' =>$image,
                'number' => $complect->getNumber(),
                'name' => $complect->getName(),
                'price' => $complect->getPrice(),
                'state' => $complect->getState()
            ];
            $machine->addComplect($complect);
            $em = $this->getDoctrine()->getManager();
            $em->persist($machine);
            $em->flush();
        }

        return new JsonResponse($data);
    }

    /**
     *
     * @Route("/{id}/machine-remove-complect", name="nomenclature_machine_remove_complect")
     * @Method({"POST"})
     */
    public function removeComplectAction(Request $request, Machine $machine)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $id = $request->get('complectId', false);
        $data = ['status' => false];
        if ($id) {
            $data['status'] = true;
            $complect = $this->get('bioprogramme_production.complect_manager')->findById($id);
            $machine->removeComplect($complect);
            $em = $this->getDoctrine()->getManager();
            $em->persist($machine);
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
