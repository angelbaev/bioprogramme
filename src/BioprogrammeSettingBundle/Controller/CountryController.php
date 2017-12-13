<?php

namespace BioprogrammeSettingBundle\Controller;

use BioprogrammeSettingBundle\Entity\Country;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Country controller.
 *
 * @Route("setting/country")
 */
class CountryController extends Controller
{
    /**
     * Lists all country entities.
     *
     * @Route("/", name="setting_country_index")
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
        $countries = $this->get('bioprogramme_setting.country_manager')->search($filter, $orderBy, $page);
        $total = $countries->count();

        $queryParams = [
            'filter_name' => $request->get('filter_name'),
        ];

        return $this->render('BioprogrammeSettingBundle:country:index.html.twig', array(
            'countries' => $countries,
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
     * Creates a new country entity.
     *
     * @Route("/new", name="setting_country_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $country = new Country();
        $form = $this->createForm('BioprogrammeSettingBundle\Form\CountryType', $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($country);
            $em->flush();

            return $this->redirectToRoute('setting_country_show', array('id' => $country->getId()));
        }

        return $this->render('BioprogrammeSettingBundle:country:new.html.twig', array(
            'country' => $country,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a country entity.
     *
     * @Route("/{id}", name="setting_country_show")
     * @Method("GET")
     */
    public function showAction(Country $country)
    {
        $deleteForm = $this->createDeleteForm($country);

        return $this->render('BioprogrammeSettingBundle:country:show.html.twig', array(
            'country' => $country,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing country entity.
     *
     * @Route("/{id}/edit", name="setting_country_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Country $country)
    {
        $deleteForm = $this->createDeleteForm($country);
        $editForm = $this->createForm('BioprogrammeSettingBundle\Form\CountryType', $country);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('setting_country_edit', array('id' => $country->getId()));
        }

        return $this->render('BioprogrammeSettingBundle:country:edit.html.twig', array(
            'country' => $country,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a country entity.
     *
     * @Route("/{id}", name="setting_country_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Country $country)
    {
        $form = $this->createDeleteForm($country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($country);
            $em->flush();
        }

        return $this->redirectToRoute('setting_country_index');
    }

    /**
     * Creates a form to delete a country entity.
     *
     * @param Country $country The country entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Country $country)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('setting_country_delete', array('id' => $country->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
