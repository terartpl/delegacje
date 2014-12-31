<?php

namespace Terart\Delegations\DelegationsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Terart\Delegations\DelegationsBundle\Entity\Delegations;
use Terart\Delegations\DelegationsBundle\Form\DelegationsType;


/**
 * Delegations controller.
 *
 * @Route("/{_locale}/delegations")
 */
class DelegationsController extends Controller
{

    /**
     * Lists all Delegations entities.
     *
     * @Route("/", name="delegations")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('DelegationsBundle:Delegations')->findBy(array('user' => $this->getUser()), array('id' => 'DESC'));
        return array(
            'entities' => $entities,
            'pageTitle' => $this->get("translator")->trans("translations.DelegationsList", array(), "DelegationsBundle"),
            'exportToSap' => $this->container->getParameter('export_to_sap')
        );
    }

    /**
     * Creates a new Delegations entity.
     * @param Request $request
     * @return array
     * @Route("/", name="delegations_create")
     * @Method("POST")
     * @Template("DelegationsBundle:Delegations:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Delegations();
        $form = $this->createCreateForm($entity, $request->getLocale());
        $form->handleRequest($request);
        /*ini_set('xdebug.var_display_max_depth', 10);
        ini_set('xdebug.var_display_max_children', 256);
        ini_set('xdebug.var_display_max_data', 1024);
        var_dump($form->isValid(), $form->getErrorsAsString(), $request->request->all(),$form->getData()); die(__FUNCTION__);*/
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setStatus(0);
            $entity->setCreated(new \DateTime('now'));
            $entity->setUser($this->getUser());
            $em->persist($entity);
            if (!$entity->getIsPrivateCar()) {
                $entity->setAddress(null);
                $entity->setCarNumber(null);
                $entity->setEngineCapacity(null);
            } else {
                $settlementKm = $entity->getSettlementKm();
                $settlementKm->setDelegation($entity);
                $settlement = $settlementKm->getSettlementKm();
                foreach ($settlement as $set) {
                    $em->persist($set);
                    $em->flush();
                    $settlementKmCopy = clone $settlementKm;
                    $settlementKmCopy->setSettlementKm($set);
                    $em->persist($settlementKmCopy);
                    $em->flush();
                    unset($settlementKmCopy);
                }

            }

            $settlementOt = $entity->getSettlementOther();
            $settlementOt->setDelegation($entity);
            $settlement = $settlementOt->getSettlementOfOtherCost();
            foreach ($settlement as $set) {
                if ($set->getCurrency() == $this->container->getParameter('default_currency')) {
                    $set->setExchangeRate(null);
                    $set->setIsExchangeRate(0);
                }
                $em->persist($set);
                $em->flush();
                $settlementOtCopy = clone $settlementOt;
                $settlementOtCopy->setSettlementOfOtherCost($set);
                $em->persist($settlementOtCopy);
                $em->flush();
                unset($settlementOtCopy);
            }


            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('translations.DelegationAdded', array(), "DelegationsBundle")
            );
            //return $this->redirect($this->generateUrl('delegations_show', array('id' => $entity->getId())));
            return $this->redirect($this->generateUrl('delegations', array()));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.CreateNewEntry", array(), "DelegationsBundle"),
        );
    }

    /**
     * Creates a form to create a Delegations entity.
     * @param String $locale locale
     * @param Delegations $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Delegations $entity, $locale)
    {
        $form = $this->createForm(new DelegationsType(), $entity, array(
            'action' => $this->generateUrl('delegations_create'),
            'method' => 'POST',
            'user' => $this->getUser(),
            'default_currency' => $this->container->getParameter('default_currency'),
            'default_country' => $this->container->getParameter('default_country'),
            'locale' => $locale,
            'em' => $this->getDoctrine()->getManager()
        ));

        $form->add('submit', 'submit', array('label' => 'translations.Save', 'attr' => array('class' => 'btn btn-default pull-right')));

        return $form;
    }

    /**
     * Displays a form to create a new Delegations entity.
     * @param Request $request object request
     * @return array
     * @Route("/new", name="delegations_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $entity = new Delegations();
        $form = $this->createCreateForm($entity, $request->getLocale());
        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.CreateNewEntry", array(), "DelegationsBundle"),
        );
    }

    /**
     * Finds and displays a Delegations entity.
     * @param Integer $id Delegation id
     * @param Request $request
     * @return array
     * @Route("/{id}/view", name="delegations_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DelegationsBundle:Delegations')->findBy(array('id' => $id, 'user' => $this->getUser()));
        $entity = array_pop($entity);
        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.DelegationNotFounded', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegations'));
        }
        $costsTypeArray = $this->getDoctrine()->getRepository('DelegationsBundle:TypeOfExpenditure')->findAllTranslations('expenditure', $request->getLocale(), 'choicelistCost');
        $ot = $em->getRepository('DelegationsBundle:DelegationOtherCosts')->findBy(array('delegation' => $entity->getId()));
        return array(
            'entity' => $entity,
            'km' => $em->getRepository('DelegationsBundle:DelegationKmGroup')->findBy(array('delegation' => $entity->getId())),
            'ot' => $ot,
            'costsTypeArray' => $this->sumCosts($costsTypeArray, $ot),
            'pageTitle' => $this->get("translator")->trans("translations.ViewDelegation", array(), "DelegationsBundle"),
            'default_currency' => $this->container->getParameter('default_currency')
        );
    }

    private function sumCosts($costsTypeArray, $ot)
    {
        $resultCostsTypeArray = array();
        foreach ($ot as $k => $o) {
            $sett = $o->getSettlementOfOtherCost();
            if(isset($resultCostsTypeArray[$sett->getTypeOfExpenditure()->getId()])){
                $resultCostsTypeArray[$sett->getTypeOfExpenditure()->getId()]['costs'] += $sett->getConversionAmount();
                continue;
            }
            $resultCostsTypeArray[$sett->getTypeOfExpenditure()->getId()] = array(
                'name' => $costsTypeArray[$sett->getTypeOfExpenditure()->getId()],
                'costs' => $sett->getConversionAmount()
            );
        }
        foreach ($costsTypeArray as $key => $cost) {
            if (!isset($resultCostsTypeArray[$key])) {
                $resultCostsTypeArray[$key] = array(
                    'name' => $cost,
                    'costs' => 0
                );
            }
        }
        return $resultCostsTypeArray;
    }

    /**
     * Finds and displays a Delegations entity.
     * @param integer $id Delegation id
     * @param Request $request
     * @return array
     * @Route("/{id}/print", name="delegations_print")
     * @Method("GET")
     * @Template()
     */
    public function printAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DelegationsBundle:Delegations')->findBy(array('id' => $id, 'user' => $this->getUser()));
        $entity = array_pop($entity);
        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.DelegationNotFounded', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegations'));
        }
        $costsTypeArray = $this->getDoctrine()->getRepository('DelegationsBundle:TypeOfExpenditure')->findAllTranslations('expenditure', $request->getLocale(), 'choicelistCost');
        $ot = $em->getRepository('DelegationsBundle:DelegationOtherCosts')->findBy(array('delegation' => $entity->getId()));
        return array(
            'entity' => $entity,
            'km' => $em->getRepository('DelegationsBundle:DelegationKmGroup')->findBy(array('delegation' => $entity->getId())),
            'ot' => $ot,
            'costsTypeArray' => $this->sumCosts($costsTypeArray, $ot),
            'pageTitle' => $this->get("translator")->trans("translations.ViewDelegation", array(), "DelegationsBundle"),
            'default_currency' => $this->container->getParameter('default_currency')
        );
    }

    /**
     * Finds and displays a Delegations list.
     *
     * @Route("/print", name="delegations_print_list")
     * @Method("GET")
     * @Template("DelegationsBundle:Delegations:printList.html.twig")
     */
    public function printListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('DelegationsBundle:Delegations')->findBy(array('user' => $this->getUser()), array('id' => 'DESC'));
        return array(
            'entities' => $entities,
            'pageTitle' => $this->get("translator")->trans("translations.DelegationsList", array(), "DelegationsBundle")
        );
    }

    /**
     * Displays a form to edit an existing Delegations entity.
     * @param Integer $id Delegation id
     * @param Request $request object request
     * @return array
     * @Route("/{id}/edit", name="delegations_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DelegationsBundle:Delegations')->findBy(array('id' => $id, 'user' => $this->getUser()));
        $entity = array_pop($entity);
        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.DelegationNotFounded', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegations'));
        }
        if ($entity->getStatus() > 1) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.permissionDenied', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegations'));
        }

        $editForm = $this->createEditForm($entity, $request->getLocale());
        /*ini_set('xdebug.var_display_max_depth', 10);
        ini_set('xdebug.var_display_max_children', 256);
        ini_set('xdebug.var_display_max_data', 1024);
        var_dump($entity); die(__FUNCTION__);*/

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.EditDelegation", array(), "DelegationsBundle"),
        );
    }

    /**
     * Creates a form to edit a Delegations entity.
     *
     * @param Delegations $entity The entity
     * @param String $locale The locale
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Delegations $entity, $locale)
    {
        $form = $this->createForm(new DelegationsType(), $entity, array(
            'action' => $this->generateUrl('delegations_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'user' => $this->getUser(),
            'em' => $this->getDoctrine()->getManager(),
            'default_currency' => $this->container->getParameter('default_currency'),
            'default_country' => $this->container->getParameter('default_country'),
            'locale' => $locale,
        ));

        $form->add('submit', 'submit', array('label' => 'translations.Save', 'attr' => array('class' => 'btn btn-default pull-right')));

        return $form;
    }

    /**
     * Edits an existing Delegations entity.
     * @param Request $request object request
     * @param Integer $id Delegation id
     * @return array
     * @Route("/{id}/update", name="delegations_update")
     * @Method("PUT")
     * @Template("DelegationsBundle:Delegations:edit.html.twig")
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DelegationsBundle:Delegations')->findBy(array('id' => $id, 'user' => $this->getUser()));
        $entity = array_pop($entity);
        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.DelegationNotFounded', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegations'));
        }
        if ($entity->getStatus() > 1) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.permissionDenied', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegations'));
        }
        $editForm = $this->createEditForm($entity, $request->getLocale());
        $editForm->handleRequest($request);
        //var_dump($entity->getSettlementOther(), $editForm->getData()->getSettlementOther()); die(__FUNCTION__);
        if ($editForm->isValid()) {
            $groupArray = $em->getRepository("DelegationsBundle:DelegationKmGroup")->findBy(array('delegation' => $entity->getId()));
            foreach ($groupArray as $group) {
                $em->remove($group->getSettlementKm());
                $em->remove($group);
            }
            $groupArray = $em->getRepository("DelegationsBundle:DelegationOtherCosts")->findBy(array('delegation' => $entity->getId()));
            foreach ($groupArray as $group) {
                $em->remove($group->getSettlementOfOtherCost());
                $em->remove($group);
            }
            if (!$entity->getIsPrivateCar()) {
                $entity->setAddress(null);
                $entity->setCarNumber(null);
                $entity->setEngineCapacity(null);
            } else {
                $settlementKm = $entity->getSettlementKm();
                $settlementKm->setDelegation($entity);
                $settlement = $settlementKm->getSettlementKm();
                foreach ($settlement as $set) {
                    $em->persist($set);
                    $em->flush();
                    $settlementKmCopy = clone $settlementKm;
                    $settlementKmCopy->setSettlementKm($set);
                    $em->persist($settlementKmCopy);
                    $em->flush();
                    unset($settlementKmCopy);
                }

            }
            $settlementOt = $entity->getSettlementOther();
            $settlementOt->setDelegation($entity);
            $settlement = $settlementOt->getSettlementOfOtherCost();
            foreach ($settlement as $set) {
                if ($set->getCurrency() == $this->container->getParameter('default_currency')) {
                    $set->setExchangeRate(null);
                    $set->setIsExchangeRate(0);
                }
                $em->persist($set);
                $em->flush();
                $settlementOtCopy = clone $settlementOt;
                $settlementOtCopy->setSettlementOfOtherCost($set);
                $em->persist($settlementOtCopy);
                $em->flush();
                unset($settlementOtCopy);
            }
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('translations.ChangeSaved', array(), "DelegationsBundle")
            );
            //return $this->redirect($this->generateUrl('delegations_edit', array('id' => $id)));
            return $this->redirect($this->generateUrl('delegations', array()));
        }
        //var_dump($entity->getSettlementOther(), $editForm->getData()->getSettlementOther()); die(__FUNCTION__);
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.EditDelegation", array(), "DelegationsBundle"),
        );
    }

    /**
     * Deletes a Delegations entity.
     * @param Request $request
     * @param Integer $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/{id}/delete", name="delegations_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DelegationsBundle:Delegations')->findBy(array('id' => $id, 'user' => $this->getUser()));
        $entity = array_pop($entity);
        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.DelegationNotFounded', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegations'));
        }

        if ($entity->getStatus() > 1) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.permissionDenied', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegations'));
        }

        $groupKm = $em->getRepository("DelegationsBundle:DelegationKmGroup")->findBy(array('delegation' => $entity->getId()));
        $groupOt = $em->getRepository("DelegationsBundle:DelegationOtherCosts")->findBy(array('delegation' => $entity->getId()));
        foreach ($groupKm as $group) {
            $em->remove($group);
        }
        foreach ($groupOt as $group) {
            $em->remove($group);
        }
        $em->remove($entity);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('translations.DelegationDeleted', array(), "DelegationsBundle")
        );


        return $this->redirect($this->generateUrl('delegations'));
    }

    /**
     * Creates a form to delete a Delegations entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delegations_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Export a form to file an existing Delegations entity.
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/{id}/export", name="delegations_export")
     * @Method("GET")
     */
    public function exportAction($id, Request $request)
    {
        if (!$this->container->getParameter('export_to_sap')) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.permissionDenied', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegations'));
        }
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DelegationsBundle:Delegations')->find($id);
        $entitySettlementsKm = $em->getRepository('DelegationsBundle:DelegationKmGroup')->findBy(array('delegation' => $entity->getId()));
        $entitySettlementsOt = $em->getRepository('DelegationsBundle:DelegationOtherCosts')->findBy(array('delegation' => $entity->getId()));
        if (!$entity || $entity->getUser()->getId() != $this->getUser()->getId()) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.permissionDenied', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegations'));
        }
        if ($entity->getStatus() > 1) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.permissionDenied', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('delegations'));
        }
        $filepath = $this->container->getParameter('filepath');
        $filename = $entity->getId() . '_' . $this->getUser()->getId() . '.txt';
        $fs = new Filesystem();
        try {
            if ($fs->exists($filepath . '/' . $filename)) {
                $fs->remove(array($filepath . '/' . $filename));
            }
            //$fs->touch($filepath . '/' . $filename);
            //$fs->dumpFile($filepath.'/'.$filename, 'Hello World 1');
            unset($fs);
            $fp = fopen($filepath . '/' . $filename, 'w');
            //opis delegacji
            fwrite($fp, '--description_of_the_delegation--' . PHP_EOL);
            $user = $entity->getUser();
            $userData = 'OD="' . $user->getUsername() . '",' . '"' . $user->getName() . '",' . '"' . $user->getSurName() . '",' . '"' . addslashes($user->getCompany()->getName()) . '"';
            $targetCountry = '';
            if ($entity->getTargetCountryType()->getId() == 2) {
                $targetCountry = $this->get('translator')->trans('translations.' . $entity->getTargetCountry()->getName(), array(), "countries");
            }
            $delegationData = ',"' . $entity->getNrDelegation() .
                '","' . addslashes($entity->getPlaceACost()) . '","' .
                $entity->getType()->getTrans() . '","' .
                $this->get('translator')->trans($entity->getTargetCountryType()->getName(), array(), "dict") . '","' .
                $targetCountry . '","' .
                addslashes($entity->getDestination()) . '","' .
                $entity->getDateFrom()->format('Y-m-d') . '","' .
                $entity->getDateTo()->format('Y-m-d') . '","' .
                addslashes($entity->getPurposeOfTrip()) . '"';
            fwrite($fp, $userData . $delegationData . PHP_EOL);
            unset($userData, $delegationData, $user);
            fwrite($fp, '--/description_of_the_delegation--' . PHP_EOL);
            // samochod prywatny
            fwrite($fp, '--private_car--' . PHP_EOL);
            $delegationData = '';
            if ($entity->getIsPrivateCar()) {
                $delegationData .= 'SP="' . addslashes($entity->getAddress()) . '",';
                $delegationData .= '"' . $entity->getCarNumber() . '",';
                $engineCapacity = "";
                if ($entity->getEngineCapacity() == 0) {
                    $engineCapacity = $this->get('translator')->trans("translations.ltCanonical", array(), "DelegationsBundle");
                }
                if ($entity->getEngineCapacity() == 1) {
                    $engineCapacity = $this->get('translator')->trans("translations.gteCanonical", array(), "DelegationsBundle");
                }
                $delegationData .= '"' . $engineCapacity . '"' . PHP_EOL;
            }
            fwrite($fp, $delegationData);
            fwrite($fp, '--/private_car--' . PHP_EOL);
            // wydatki km
            fwrite($fp, '--expenses_km--' . PHP_EOL);
            $entityKm = '';
            $drivenCosts = 0.0;
            foreach ($entitySettlementsKm as $pos) {
                $entityKm .= 'WK="' . $pos->getSettlementKm()->getDateOfDeparture()->format('Y-m-d') . '",';
                $entityKm .= '"' . addslashes($pos->getSettlementKm()->getFrom()) . '",';
                $entityKm .= '"' . addslashes($pos->getSettlementKm()->getTo()) . '",';
                $entityKm .= '"' . $pos->getSettlementKm()->getDrivenKm() . '",';
                $entityKm .= '"' . $pos->getSettlementKm()->getRatePerKm() . '",';
                $entityKm .= '"' . $pos->getSettlementKm()->getValue() . '"' . PHP_EOL;
                $drivenCosts += $pos->getSettlementKm()->getValue();
            }
            unset($entitySettlementsKm);
            fwrite($fp, $entityKm);
            fwrite($fp, '--/expenses_km--' . PHP_EOL);
            // wydatki_inne
            fwrite($fp, '--other_expenses--' . PHP_EOL);
            $entityKm = '';
            $translationsArray = $em->getRepository('DelegationsBundle:DelegationOtherCosts')->findAllTranslations($entity->getId(), $request->getLocale());
            $expenditureArrayValue = array();
            $expenditureArrayValueAll = $em->getRepository('DelegationsBundle:TypeOfExpenditure')->findAll();
            foreach ($expenditureArrayValueAll as $val) {
                $expenditureArrayValue[$val->getId()] = array(
                    'name' => '',
                    'short' => $val->getShortcut(),
                    'value' => number_format(floatval(0), 2, ".", "")
                );
            }
            foreach ($entitySettlementsOt as $pos) {
                $isExchangeRate = $pos->getSettlementOfOtherCost()->getIsExchangeRate();
                $entityKm .= 'WI="' . $pos->getSettlementOfOtherCost()->getOriginalAmount() . '",';
                $entityKm .= '"' . $pos->getSettlementOfOtherCost()->getCurrency() . '",';
                $entityKm .= $isExchangeRate?'"1",': '"0",';
                $entityKm .= '"' . $pos->getSettlementOfOtherCost()->getExchangeRate() . '",';
                $entityKm .= '"' . $pos->getSettlementOfOtherCost()->getConversionAmount() . '",';
                $expenditureId = $pos->getSettlementOfOtherCost()->getTypeOfExpenditure()->getId();
                if (isset($expenditureId)) {
                    $entityKm .= '"' . $translationsArray[$pos->getSettlementOfOtherCost()->getTypeOfExpenditure()->getId()] . '",';
                    if (isset($expenditureArrayValue[$expenditureId])) {
                        $expenditureArrayValue[$expenditureId]['value'] += $pos->getSettlementOfOtherCost()->getConversionAmount();
                        $expenditureArrayValue[$expenditureId]['name'] = $translationsArray[$pos->getSettlementOfOtherCost()->getTypeOfExpenditure()->getId()];
                    } else {
                        $expenditureArrayValue[$expenditureId] = array(
                            'name' => $translationsArray[$pos->getSettlementOfOtherCost()->getTypeOfExpenditure()->getId()],
                            'short' => $pos->getSettlementOfOtherCost()->getTypeOfExpenditure()->getShortcut(),
                            'value' => $pos->getSettlementOfOtherCost()->getConversionAmount()
                        );
                    }

                } else {
                    $entityKm .= '"' . '",';
                }
                $entityKm .= '"' . addslashes($pos->getSettlementOfOtherCost()->getDescription()) . '"' . PHP_EOL;

            }
            unset($entitySettlementsOt);
            fwrite($fp, $entityKm);
            fwrite($fp, '--/other_expenses--' . PHP_EOL);
            // podsumowanie
            fwrite($fp, '--summation--' . PHP_EOL);
            $costs = 'SWKM="'.$drivenCosts.'"'.PHP_EOL;
            $ckw = 0;
            foreach ($expenditureArrayValue as $val) {
                $costs .= $val['short'] . '="' . $val['value'] . '"' . PHP_EOL;
                $ckw += floatval($val['value']);
            }
            $costs .= 'CKW="' . ($ckw + $drivenCosts) . '"' . PHP_EOL;
            $costs .= 'ADV="' . $entity->getAdvance() . '"';
            fwrite($fp, $costs . PHP_EOL);
            fwrite($fp, '--/summation--' . PHP_EOL);
            fclose($fp);

        } catch (IOExceptionInterface $e) {
            echo "An error occurred while creating your directory at " . $e->getPath() . ' ' . $e->getMessage();
        }
        $entity->setStatus(1);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('translations.exportedFile', array(), "DelegationsBundle")
        );
        return $this->redirect($this->generateUrl('delegations'));
    }
}