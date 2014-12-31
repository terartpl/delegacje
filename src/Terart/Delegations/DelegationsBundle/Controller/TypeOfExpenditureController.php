<?php

namespace Terart\Delegations\DelegationsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Terart\Delegations\DelegationsBundle\Entity\TypeOfExpenditure;
use Terart\Delegations\DelegationsBundle\Form\TypeOfExpenditureType;

/**
 * TypeOfExpenditure controller.
 *
 * @Route("/{_locale}/type-of-expenditure")
 */
class TypeOfExpenditureController extends Controller
{

    /**
     * @return bool
     */
    private function checkPermission()
    {
        if (!$this->getUser()->getIsAdmin()) {
            $this->get('session')->getFlashBag()->add(
                'danger',
                $this->get('translator')->trans('translations.permissionDenied', array(), "DelegationsBundle")
            );
            return true;
        }
        return false;
    }

    /**
     * Lists all TypeOfExpenditure entities.
     *
     * @Route("/", name="type-of-expenditure")
     * @Method("GET")
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('DelegationsBundle:TypeOfExpenditure')->findAllTranslations(TypeOfExpenditure::getTranFieldName(), $request->getLocale());
        return array(
            'entities' => $entities,
            'pageTitle' => $this->get("translator")->trans("translations.TypeOfExpenditure", array(), "DelegationsBundle"),
        );
    }

    /**
     * Creates a new TypeOfExpenditure entity.
     *
     * @Route("/", name="type-of-expenditure_create")
     * @Method("POST")
     * @Template("DelegationsBundle:TypeOfExpenditure:new.html.twig")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }
        $entity = new TypeOfExpenditure();
        $form = $this->createCreateForm($entity, $request->getLocale());
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            foreach ($entity->getTranslations() as $trans) {
                $em->persist($trans);
            }
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('translations.typeOfExpenditureAdded', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('type-of-expenditure', array()));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.typeOfExpenditureCreate", array(), "DelegationsBundle"),
        );
    }

    /**
     * Creates a form to create a TypeOfExpenditure entity.
     *
     * @param TypeOfExpenditure $entity The entity
     * @param $locale
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TypeOfExpenditure $entity, $locale)
    {
        $form = $this->createForm(new TypeOfExpenditureType(), $entity, array(
            'action' => $this->generateUrl('type-of-expenditure_create'),
            'method' => 'POST',
            'locale' => $locale,
            'locale_list' => $this->container->getParameter('locale_list')
        ));
        $form->add('submit', 'submit', array('label' => 'translations.Add', 'attr' => array('class' => 'btn btn-default pull-right')));
        return $form;
    }

    /**
     * Displays a form to create a new TypeOfExpenditure entity.
     *
     * @Route("/new", name="type-of-expenditure_new")
     * @Method("GET")
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }
        $entity = new TypeOfExpenditure();
        $form = $this->createCreateForm($entity, $request->getLocale());

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.typeOfExpenditureCreate", array(), "DelegationsBundle"),
        );
    }

    /**
     * Finds and displays a TypeOfExpenditure entity.
     *
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/{id}/show", name="type-of-expenditure_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }
        $em = $this->getDoctrine()->getManager();
        //$entity = $em->getRepository('DelegationsBundle:TypeOfExpenditure')->findTranslation(TypeOfExpenditure::getTranFieldName(), $request->getLocale(), $id);
        $entity = $em->getRepository('DelegationsBundle:TypeOfExpenditure')->find($id);
        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.typeOfExpenditureNotFound', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('type-of-expenditure', array()));
        }
        $trans = $em->getRepository('DelegationsBundle:Translations')->findBy(array('hashKey' => $entity->getExpenditure()));
        return array(
            'entity' => $trans,
            'entityId' => $entity->getId(),
            'pageTitle' => $this->get("translator")->trans("translations.typeOfExpenditureView", array(), "DelegationsBundle"),
        );
    }

    /**
     * Displays a form to edit an existing TypeOfExpenditure entity.
     *
     * @Route("/{id}/edit", name="type-of-expenditure_edit")
     * @Method("GET")
     * @Template()
     * @param $id
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction($id, Request $request)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DelegationsBundle:TypeOfExpenditure')->find($id);
        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.typeOfExpenditureNotFound', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('type-of-expenditure', array()));
        }
        $editForm = $this->createEditForm($entity, $request->getLocale());

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.typeOfExpenditureEdit", array(), "DelegationsBundle"),
        );
    }

    /**
     * Creates a form to edit a TypeOfExpenditure entity.
     *
     * @param TypeOfExpenditure $entity The entity
     * @param $locale
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(TypeOfExpenditure $entity, $locale)
    {
        $form = $this->createForm(new TypeOfExpenditureType(), $entity, array(
            'action' => $this->generateUrl('type-of-expenditure_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'locale' => $locale,
            'locale_list' => $this->container->getParameter('locale_list'),
            'em' => $this->getDoctrine(),
        ));

        $form->add('submit', 'submit', array('label' => 'translations.Save', 'attr' => array('class' => 'btn btn-default pull-right')));

        return $form;
    }

    /**
     * Edits an existing TypeOfExpenditure entity.
     *
     * @Route("/{id}/update", name="type-of-expenditure_update")
     * @Method("PUT")
     * @Template("DelegationsBundle:TypeOfExpenditure:edit.html.twig")
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request, $id)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DelegationsBundle:TypeOfExpenditure')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.typeOfExpenditureNotFound', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('type-of-expenditure', array()));
        }

        $editForm = $this->createEditForm($entity, $request->getLocale());
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('translations.typeOfExpenditureEdited', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('type-of-expenditure', array()));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.typeOfExpenditureEdit", array(), "DelegationsBundle"),
        );
    }

    /**
     * Deletes a TypeOfExpenditure entity.
     *
     * @Route("/{id}/delete", name="type-of-expenditure_delete")
     */
    public function deleteAction($id)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DelegationsBundle:TypeOfExpenditure')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.typeOfExpenditureNotFound', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('type-of-expenditure', array()));
        }
        $cost = $em->getRepository('DelegationsBundle:SettlementOfOtherCosts')->findBy(array('typeOfExpenditure' => $entity->getId()));

        if (count($cost) > 0) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.typeOfExpenditurePermmisionDenied', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('type-of-expenditure', array()));
        }
        $trans = $em->getRepository('DelegationsBundle:Translations')->findBy(array('hashKey' => $entity->getExpenditure()));
        foreach ($trans as $t) {
            $em->remove($t);
        }
        $em->remove($entity);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('translations.typeOfExpenditureDeleted', array(), "DelegationsBundle")
        );
        return $this->redirect($this->generateUrl('type-of-expenditure'));
    }

}