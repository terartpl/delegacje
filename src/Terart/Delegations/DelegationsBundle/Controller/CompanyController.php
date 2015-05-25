<?php

namespace Terart\Delegations\DelegationsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Terart\Delegations\DelegationsBundle\Entity\Company;
use Terart\Delegations\DelegationsBundle\Form\CompanyType;

/**
 * Company controller.
 * @package Terart\Delegations\DelegationsBundle\Controller
 * @Route("/{_locale}/company")
 */
class CompanyController extends Controller
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
     * Lists all Company entities.
     *
     * @Route("/", name="company")
     * @Method("GET")
     * @Template()
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction()
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }


        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DelegationsBundle:Company')->findAll();

        return array(
            'entities' => $entities,
            'pageTitle' => $this->get("translator")->trans("translations.CompanyList", array(), "DelegationsBundle"),
        );
    }

    /**
     * Creates a new Company entity.
     * @Route("/", name="company_create")
     * @Method("POST")
     * @Template("DelegationsBundle:Company:new.html.twig")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }

        $entity = new Company();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('translations.CompanyHasBeenAdded', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('company', array()));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.CreateNewCompany", array(), "DelegationsBundle"),
        );
    }

    /**
     * Creates a form to create a Company entity.
     *
     * @param Company $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Company $entity)
    {
        $form = $this->createForm(new CompanyType(), $entity, array(
            'action' => $this->generateUrl('company_create'),
            'method' => 'POST',
            'default_country' => $this->container->getParameter('default_country')
        ));

        $form->add('submit', 'submit', array('label' => 'translations.Add', 'attr' => array('class' => 'btn btn-default pull-right')));

        return $form;
    }

    /**
     * Displays a form to create a new Company entity.
     *
     * @Route("/new", name="company_new")
     * @Method("GET")
     * @Template()
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction()
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }

        $entity = new Company();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.CreateNewCompany", array(), "DelegationsBundle"),
        );
    }

    /**
     * Finds and displays a Company entity.
     * @Route("/{id}", name="company_show")
     * @Method("GET")
     * @Template()
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function showAction($id)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DelegationsBundle:Company')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.CompanyNotExist', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('company', array()));
        }

        return array(
            'entity' => $entity,
            'pageTitle' => $this->get("translator")->trans("translations.Company", array(), "DelegationsBundle"),
        );
    }

    /**
     * Displays a form to edit an existing Company entity.
     * @Route("/{id}/edit", name="company_edit")
     * @Method("GET")
     * @Template()
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction($id)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DelegationsBundle:Company')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.CompanyNotExist', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('company', array()));
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.EditAction", array(), "DelegationsBundle"),
        );
    }

    /**
     * Creates a form to edit a Company entity.
     *
     * @param Company $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Company $entity)
    {
        $form = $this->createForm(new CompanyType(), $entity, array(
            'action' => $this->generateUrl('company_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'default_country' => $this->container->getParameter('default_country')
        ));

        $form->add('submit', 'submit', array('label' => 'translations.Save', 'attr' => array('class' => 'btn btn-default pull-right')));

        return $form;
    }

    /**
     * Edits an existing Company entity.
     * @param $id company id
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/{id}", name="company_update")
     * @Method("PUT")
     * @Template("DelegationsBundle:Company:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DelegationsBundle:Company')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.CompanyNotExist', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('company', array()));
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('translations.CompanyHasBeenEdited', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('company', array()));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.EditAction", array(), "DelegationsBundle"),
        );
    }

    /**
     * Deletes a Company entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/{id}/delete", name="company_delete")
     */
    public function deleteAction($id)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DelegationsBundle:Company')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.CompanyNotExist', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('company', array()));
        }

        $users = $em->getRepository('DelegationsBundle:Users')->findBy(array('company' => $id));
        if (!empty($users)) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.userHasCompany', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('company', array()));
        }

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('translations.CompanyHasBeenDeleted', array(), "DelegationsBundle")
        );

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('company'));
    }
}
