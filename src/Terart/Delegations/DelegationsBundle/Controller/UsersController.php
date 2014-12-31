<?php

namespace Terart\Delegations\DelegationsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Terart\Delegations\DelegationsBundle\Entity\Users;
use Terart\Delegations\DelegationsBundle\Form\UsersPasswdType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Terart\Delegations\DelegationsBundle\Form\UsersType;
use Symfony\Component\Validator\Constraints\Image;

/**
 * Users controller.
 *
 * @Route("/{_locale}/users")
 */
class UsersController extends Controller
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
     * Lists all Users entities.
     *
     * @Route("/", name="users")
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
        $entities = $em->getRepository('DelegationsBundle:Users')->findAll();

        return array(
            'entities' => $entities,
            'pageTitle' => $this->get("translator")->trans("translations.UsersList", array(), "DelegationsBundle"),
        );
    }

    /**
     * Creates a new Users entity.
     *
     * @Route("/new", name="users_create")
     * @Method("POST")
     * @Template("DelegationsBundle:Users:new.html.twig")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }
        $entity = new Users();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setCreated(new \DateTime("now"));
            $entity->setSalt(md5(uniqid(null, true)));
            $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
            $entity->setPassword(
                $encoder->encodePassword($entity->getPassword(), $entity->getSalt())
            );
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('users_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.CreateNewUser", array(), "DelegationsBundle"),
        );
    }

    /**
     * Creates a form to create a Users entity.
     *
     * @param Users $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Users $entity)
    {
        $form = $this->createForm(new UsersType(), $entity, array(
            'action' => $this->generateUrl('users_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'translations.Add', 'attr' => array('class' => 'btn btn-default pull-right')));

        return $form;
    }

    /**
     * Displays a form to create a new Users entity.
     *
     * @Route("/new", name="users_new")
     * @Method("GET")
     * @Template()
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction()
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }
        $entity = new Users();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.CreateNewUser", array(), "DelegationsBundle"),
        );
    }

    /**
     * Finds and displays a Users entity.
     *
     * @Route("/{id}/view", name="users_show")
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

        $entity = $em->getRepository('DelegationsBundle:Users')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.userNotExist', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('users', array()));
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.UsersView", array(), "DelegationsBundle"),
        );
    }

    /**
     * Displays a form to edit an existing Users entity.
     *
     * @Route("/{id}/edit", name="users_edit")
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

        $entity = $em->getRepository('DelegationsBundle:Users')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.userNotExist', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('users', array()));
        }

        $editForm = $this->createEditForm($entity);
        //$deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            //'delete_form' => $deleteForm->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.EditAction", array(), "DelegationsBundle"),
        );
    }

    /**
     * Creates a form to edit a Users entity.
     *
     * @param Users $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Users $entity)
    {
        $form = $this->createForm(new UsersType(), $entity, array(
            'action' => $this->generateUrl('users_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'translations.Save', 'attr' => array('class' => 'btn btn-default pull-right')));

        return $form;
    }

    /**
     * Edits an existing Users entity.
     *
     * @Route("/{id}/update", name="users_update")
     * @Method("PUT")
     * @Template("DelegationsBundle:Users:edit.html.twig")
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

        $entity = $em->getRepository('DelegationsBundle:Users')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            //return $this->redirect($this->generateUrl('users_edit', array('id' => $id)));
            return $this->redirect($this->generateUrl('users'));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            //'delete_form' => $deleteForm->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.EditAction", array(), "DelegationsBundle"),
        );
    }

    /**
     * Deletes a Users entity.
     *
     * @Route("/{id}/delete", name="users_delete")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        if ($this->checkPermission()) {
            return $this->redirect($this->generateUrl('delegations', array()));
        }
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DelegationsBundle:Users')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.userNotExist', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('users', array()));
        }

        if ($entity->getId() == $this->getUser()->getId()) {
            $this->get('session')->getFlashBag()->add(
                'danger',
                $this->get('translator')->trans('translations.userHasOwn', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('users', array()));
        }

        $delegations = $em->getRepository('DelegationsBundle:Delegations')->findBy(array('user' => $id));
        if (!empty($delegations)) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.userHasDelegations', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('users', array()));
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('users'));
    }

    /**
     * Creates a form to delete a Users entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('users_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * @Route("/{id}/reset", name="users_reset")
     * @Method("GET")
     * @Template()
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function resetAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id != $this->getUser()->getId()) {
            if ($this->checkPermission()) {
                return $this->redirect($this->generateUrl('delegations', array()));
            }
        }
        $entity = $em->getRepository('DelegationsBundle:Users')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.userNotExist', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('users', array()));
        }

        $editForm = $this->createEditPasswordForm($entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            '__panel_rout' => ($this->getUser()->getIsAdmin()) ? 'users' : 'delegations',
            'pageTitle' => $this->get("translator")->trans("translations.ResetAction", array(), "DelegationsBundle"),
        );
    }

    /**
     * @Route("/{id}/update-passwd", name="users_update_passwd")
     * @Method("PUT")
     * @Template("@Delegations/Users/reset.html.twig")
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updatePasswdAction(Request $request, $id)
    {
        if ($id != $this->getUser()->getId()) {
            if ($this->checkPermission()) {
                return $this->redirect($this->generateUrl('delegations', array()));
            }
        }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DelegationsBundle:Users')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('translations.userNotExist', array(), "DelegationsBundle")
            );
            return $this->redirect($this->generateUrl('users', array()));
        }

        $editForm = $this->createEditPasswordForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
            $entity->setPassword(
                $encoder->encodePassword($entity->getPassword(), $entity->getSalt())
            );
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('translations.passwdChanged', array(), "DelegationsBundle")
            );
            $em->flush();
            if ($this->getUser()->getIsAdmin()) {
                return $this->redirect($this->generateUrl('users', array()));
            }
            return $this->redirect($this->generateUrl('delegations', array()));

        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            '__panel_rout' => ($this->getUser()->getIsAdmin()) ? 'users' : 'delegations',
            'pageTitle' => $this->get("translator")->trans("translations.ResetAction", array(), "DelegationsBundle"),
        );
    }

    /**
     * @Route("/add-logo", name="users_add_logo")
     * @Method("GET")
     * @Template("@Delegations/Users/logo.html.twig")
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addLogoAction(Request $request)
    {
//        session_unset();
//        sleep(10);
        $img = null;
        $dir = $this->get('kernel')->getRootDir() . '/../web/logo/default_logo.png';
        $form = $this->createAddLogoFrom()->getForm();

        if (file_exists($dir)) {
            $img = new \Symfony\Component\HttpFoundation\File\File($dir);
        }

        if ($img) {
            $form->add('delete', 'submit', array(
                'label' => 'Delete',
                'attr' => array(
                    'class' => 'btn btn-default btn-danger'
                )));
        }

//        var_dump($img->getOwner());
//        var_dump(get_class_methods($img));
//        var_dump($this->get('request')->getBasePath());

        return array(
            'img' => $img,
            'form' => $form->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.addLogo", array(), "DelegationsBundle"),
        );
    }

    /**
     * @Route("/add-logo", name="users_logo_upload")
     * @Method("POST")
     * @Template("@Delegations/Users/logo.html.twig")
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function uplaodAction(Request $request)
    {
        $imgValidator = new  Image();
//        $imgValidator->message = 'Invalid file format';
        $img = null;
        $dir = $dir = $this->get('kernel')->getRootDir() . '/../web/logo';
        $fileName = 'default_logo.png';
        $form = $this->createAddLogoFrom()->getForm();
        $form->add('delete', 'submit', array(
            'label' => 'Delete',
            'attr' => array(
                'class' => 'btn btn-default btn-danger'
            )));

        $form->handleRequest($request);
//        $data = $form->getData();

//        var_dump(get_class_methods($imgValidator));
//        die;

//        $errors = $this->get('validator')->validate(
//            $data['logo'],
//            $imgValidator
//        );

//        var_dump($data);
//        var_dump($errors);
//        die;

//        if(count($errors) > 0){
//            return $this->redirect($this->generateUrl('users_logo_upload', array(
//                'form' => $form
//            )));
//        }

        if(!$form->isValid()){

//            $form->getErrorsAsString();
//            var_dump($form->getErrorsAsString());
//            var_dump($form->get('logo')->getErrors()[0]);
//            die;

            return array(
                'img' => null,
                'form' => $form->createView()
            );
        }

        $btn = $form->getClickedButton()->getName();
        $img = $form['logo']->getData();

//        var_dump($img->getMimeType());
//        var_dump(get_class_methods($img));
//        die;

//        $mTypes =
        if ($img) {
            
            $sim = $this->get('delegations.simple_image_manipulator');
            $img = $img->move($dir, $fileName);
            $img = $sim->resizeLogo($img->getPath().'/'.$fileName);

        } else if (!$img && $btn == 'delete') {
            $dir = $this->get('kernel')->getRootDir() . '/../web/logo/default_logo.png';
            if (file_exists($dir)) {
                unlink($dir);
            }
            return $this->redirect($this->generateUrl('users_logo_upload', array()));
        }else{
            return $this->redirect($this->generateUrl('users_logo_upload', array()));
        }

        if (file_exists($dir)) {
            $img = new \Symfony\Component\HttpFoundation\File\File($dir . '/' . $fileName);
        }

        return array(
            'img' => $img,
            'form' => $form->createView(),
            'pageTitle' => $this->get("translator")->trans("translations.addLogo", array(), "DelegationsBundle"),
        );
    }

    /**
     * Creates a form to edit a Users passwd.
     *
     * @param Users $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditPasswordForm(Users $entity)
    {
        $form = $this->createForm(new UsersPasswdType(), $entity, array(
            'action' => $this->generateUrl('users_update_passwd', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'translations.Save', 'attr' => array('class' => 'btn btn-default pull-right')));

        return $form;
    }

    protected function createAddLogoFrom()
    {
        $form = $this->createFormBuilder()
            ->add('logo', 'file', array(
                'constraints' => new Image(array(
                    'mimeTypes' =>array(
                        'image/png',
                        'image/jpg',
                        'image/jpeg',
                        'image/gif',
                        'image/tiff',
                    )
                )),
                'required' => false,
                'label' => 'Logo',
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('save', 'submit', array(
                'label' => 'Save',
                'attr' => array(
                    'class' => 'btn btn-default'
                )
            ))
            ->setAction($this->generateUrl('users_logo_upload'))
            ->setMethod('POST');

//        var_dump(get_class_methods($form->get('logo')));
//        die;

        return $form;
    }

    public function logoPath()
    {
        $dir = $dir = $this->get('kernel')->getRootDir() . '/../web/logo';
        if (file_exists($dir)) {
            return $dir;
        } else {
            return null;
        }
    }
}
