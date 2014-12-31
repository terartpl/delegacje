<?php

namespace Terart\Delegations\DelegationsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Terart\Delegations\DelegationsBundle\Entity\DelegationType;
use Terart\Delegations\DelegationsBundle\Form\DelegationTypeType;
use Terart\Delegations\DelegationsBundle\Entity\Translations;

/**
 * DelegationType controller.
 *
 * @Route("/{_locale}/delegation-type")
 */
class DelegationTypeController extends Controller
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
     * Lists all DelegationType entities.
     *
     * @Route("/", name="delegationtype_list")
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
        $entities = $em->getRepository('DelegationsBundle:DelegationType')->findAllTranslations('hashKey', $request->getLocale());
        return array(
            'entities' => $entities,
            'pageTitle' => $this->get("translator")->trans("translations.DelegationTypeList", array(), "DelegationsBundle"),
        );
    }

    /**
     * Creates a new DelegationType entity.
     *
     * @Route("/", name="delegationtype_create")
     * @Method("POST")
     * @Template("DelegationsBundle:DelegationType:new.html.twig")
     * @param Request $request
     * @return array
     */
    public function createAction(Request $request)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }
        $form = $this->createCreateForm($request->getLocale());
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $validator = $this->get('validator');
            $hasKey = base_convert(uniqid(null, true), 10, 36);
            foreach ($data['trans'] as $key => $d) {
                $tmpType = new Translations();
                $tmpType->setLocale($key);
                $tmpType->setTrans($d);
                $tmpType->setHashKey($hasKey);
                $errors = $validator->validate($tmpType);
                if ($errors->count() > 0) {
                    $form->get('trans')->get($key)->addError(new FormError($errors->get(0)->getMessage()));
                    return array(
                        'form' => $form->createView(),
                    );
                }
                $em->persist($tmpType);
            }
            $delegationType = new DelegationType();
            $delegationType->setHashKey($hasKey);
            $em->persist($delegationType);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('translations.DelegatiotypeAdded', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegationtype_list', array()));
        }

        return array(
            'form' => $form->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.CreateNewDelegationType", array(), "DelegationsBundle"),
        );
    }

    /**
     * Creates a form to create a DelegationType entity.
     * @param $locale
     * @return \Symfony\Component\Form\Form
     */
    private function createCreateForm($locale)
    {
        $form = $this->createForm(new DelegationTypeType(), null, array(
            'action' => $this->generateUrl('delegationtype_create'),
            'method' => 'POST',
            'locale' => $locale,
            'locale_list' => $this->container->getParameter('locale_list')
        ));

        $form->add('submit', 'submit', array('label' => 'translations.Add', 'attr' => array('class' => 'btn btn-default pull-right')));

        return $form;
    }

    /**
     * Displays a form to create a new DelegationType entity.
     *
     * @Route("/new", name="delegationtype_new")
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
        $form = $this->createCreateForm($request->getLocale());

        return array(
            'form' => $form->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.CreateNewDelegationType", array(), "DelegationsBundle"),
        );
    }

    /**
     * Finds and displays a DelegationType entity.
     *
     * @Route("/{id}", name="delegationtype_show")
     * @Method("GET")
     * @Template()
     * @param $id
     * @return array
     */
    public function showAction($id)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DelegationsBundle:DelegationType')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.DelegationTypeNotExist', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegationtype_list', array()));
        }
        return array(
            'entity' => $em->getRepository('DelegationsBundle:DelegationType')->findTranslations($entity->getHashKey()),
            'entityId' => $entity->getId(),
            'pageTitle' => $this->get("translator")->trans("translations.DelegatiotypeView", array(), "DelegationsBundle"),
        );
    }

    /**
     * Displays a form to edit an existing DelegationType entity.
     *
     * @Route("/{id}/edit", name="delegationtype_edit")
     * @Method("GET")
     * @Template()
     * @param $id
     * @param Request $request
     * @return array
     */
    public function editAction($id, Request $request)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DelegationsBundle:DelegationType')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.DelegationTypeNotExist', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegationtype_list', array()));
        }
        $entityArray = $em->getRepository('DelegationsBundle:DelegationType')->findTranslations($entity->getHashKey());
        $editForm = $this->createEditForm($entityArray, $request->getLocale(), $id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.DelegatiotypeEdit", array(), "DelegationsBundle"),
        );
    }

    /**
     * Creates a form to edit a DelegationType entity.
     *
     * @param DelegationType $entity The entity
     * @param $locale
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm($entityArray, $locale, $id)
    {
        $form = $this->createForm(new DelegationTypeType(), $entityArray, array(
            'action' => $this->generateUrl('delegationtype_update', array('id' => $id)),
            'method' => 'PUT',
            'locale' => $locale,
            'locale_list' => $this->container->getParameter('locale_list')
        ));
        $form->add('submit', 'submit', array('label' => 'translations.Save', 'attr' => array('class' => 'btn btn-default pull-right')));
        return $form;
    }

    /**
     * Edits an existing DelegationType entity.
     *
     * @Route("/{id}/update", name="delegationtype_update")
     * @Method("PUT")
     * @Template("DelegationsBundle:DelegationType:edit.html.twig")
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
        $entity = $em->getRepository('DelegationsBundle:DelegationType')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.DelegationTypeNotExist', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegationtype_list', array()));
        }
        $entityArray = $em->getRepository('DelegationsBundle:DelegationType')->findTranslations($entity->getHashKey());
        $editForm = $this->createEditForm($entityArray, $request->getLocale(), $id);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $data = $editForm->getData();
            $validator = $this->get('validator');
            foreach ($entityArray as $entity) {
                $entity->setTrans($data['trans'][$entity->getLocale()]);
                $errors = $validator->validate($entity);
                if ($errors->count() > 0) {
                    $editForm->get('trans')->get($entity->getLocale())->addError(new FormError($errors->get(0)->getMessage()));
                    return array(
                        'edit_form' => $editForm->createView(),
                        'pageTitle' => $this->get("translator")->trans("translations.DelegatiotypeEdit", array(), "DelegationsBundle"),
                    );
                }
            }
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('translations.DelegatiotypeEdited', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegationtype_list', array()));
        }

        return array(
            'edit_form' => $editForm->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.DelegatiotypeEdit", array(), "DelegationsBundle"),
        );
    }

    /**
     * Deletes a DelegationType entity.
     *
     * @Route("/{id}/delete", name="delegationtype_delete")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DelegationsBundle:DelegationType')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.DelegationTypeNotExist', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegationtype_list', array()));
        }
        $delegationEntity = $em->getRepository('DelegationsBundle:Delegations')->findBy(array('type' => $entity->getId()));
        if (count($delegationEntity) > 0) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.DelegationTypePermmisionDenied', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegationtype_list', array()));
        }

        $hashKey = $entity->getHashKey();
        $entityArray = $em->getRepository('DelegationsBundle:DelegationType')->findTranslations($hashKey);
        foreach ($entityArray as $en) {
            $em->remove($en);
        }
        $em->remove($em->merge($entity));
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('translations.DelegatiotypeDeleted', array(), "DelegationsBundle")
        );
        return $this->redirect($this->generateUrl('delegationtype_list'));
    }
}
