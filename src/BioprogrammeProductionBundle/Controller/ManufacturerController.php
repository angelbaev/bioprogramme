<?php

namespace BioprogrammeProductionBundle\Controller;

use BioprogrammeProductionBundle\Entity\Manufacturer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Manufacturer controller.
 *
 * @Route("nomenclature/manufacturer")
 */
class ManufacturerController extends Controller
{
    /**
     * Lists all manufacturer entities.
     *
     * @Route("/", name="nomenclature_manufacturer_index")
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
        $manufacturers = $this->get('bioprogramme_production.manufacturer_manager')->search($filter, $orderBy, $page);
        $total = $manufacturers->count();

        $queryParams = [
            'filter_name' => $request->get('filter_name'),
        ];

        return $this->render('BioprogrammeProductionBundle:manufacturer:index.html.twig', array(
            'manufacturers' => $manufacturers,
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
     * Creates a new manufacturer entity.
     *
     * @Route("/new", name="nomenclature_manufacturer_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $manufacturer = new Manufacturer();
        $form = $this->createForm('BioprogrammeProductionBundle\Form\ManufacturerType', $manufacturer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_production.manufacturer_manager')->save($manufacturer);

            return $this->redirectToRoute('nomenclature_manufacturer_show', array('id' => $manufacturer->getId()));
        }

        return $this->render('BioprogrammeProductionBundle:manufacturer:new.html.twig', array(
            'manufacturer' => $manufacturer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a manufacturer entity.
     *
     * @Route("/{id}", name="nomenclature_manufacturer_show")
     * @Method("GET")
     */
    public function showAction(Manufacturer $manufacturer)
    {
        $deleteForm = $this->createDeleteForm($manufacturer);

        return $this->render('BioprogrammeProductionBundle:manufacturer:show.html.twig', array(
            'manufacturer' => $manufacturer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing manufacturer entity.
     *
     * @Route("/{id}/edit", name="nomenclature_manufacturer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Manufacturer $manufacturer)
    {
        $deleteForm = $this->createDeleteForm($manufacturer);
        $editForm = $this->createForm('BioprogrammeProductionBundle\Form\ManufacturerType', $manufacturer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->get('bioprogramme_production.manufacturer_manager')->save($manufacturer);

            return $this->redirectToRoute('nomenclature_manufacturer_edit', array('id' => $manufacturer->getId()));
        }

        return $this->render('BioprogrammeProductionBundle:manufacturer:edit.html.twig', array(
            'manufacturer' => $manufacturer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a manufacturer entity.
     *
     * @Route("/{id}", name="nomenclature_manufacturer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Manufacturer $manufacturer)
    {
        $form = $this->createDeleteForm($manufacturer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('bioprogramme_production.manufacturer_manager')->delete($manufacturer);
        }

        return $this->redirectToRoute('nomenclature_manufacturer_index');
    }

    /**
     * Creates a form to delete a manufacturer entity.
     *
     * @param Manufacturer $manufacturer The manufacturer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Manufacturer $manufacturer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nomenclature_manufacturer_delete', array('id' => $manufacturer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
