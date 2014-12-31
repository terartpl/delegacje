<?php

namespace Terart\Delegations\DelegationsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

/**
 *
 */
class SecurityController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/login", name="users_login")
     * @Method({"GET", "POST"})
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
        $localeFromCookie = $request->cookies->get('_locale_delegations');
        if (!$localeFromCookie) {
            $localeFromCookie = $this->container->getParameter('locale');
        }
        $request->getSession()->set('_locale', $localeFromCookie);
        $request->setLocale($localeFromCookie);
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        $options = array(
            'username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error,
            'pageTitle' => $this->get("translator")->trans("translations.PleaseLogIn", array(), "DelegationsBundle"),
            '_target_path' => $this->generateUrl('delegations', array('_locale' => $localeFromCookie)),
        );

        return $this->render('DelegationsBundle:Login:login.html.twig', $options);
    }

    public function logoutAction()
    {
    }

    public function loginCheckAction()
    {
    }


}