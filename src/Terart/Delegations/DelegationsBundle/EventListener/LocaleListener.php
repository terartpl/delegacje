<?php

namespace Terart\Delegations\DelegationsBundle\EventListener;

use Symfony\Bundle\FrameworkBundle\Routing\Router as SymfonyRouter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\EventListener\LocaleListener as SymfonyLocaleListener;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleListener implements EventSubscriberInterface
{
    private $defaultLocale;
    private $localeListener;
    private $router;
    private $localeList;

    public function __construct(SymfonyLocaleListener $localeListener, $defaultLocale, SymfonyRouter $router, array $locale_list)
    {
        $this->defaultLocale = $defaultLocale;
        $this->localeListener = $localeListener;
        $this->router = $router;
        $this->localeList = $locale_list;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }
        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }
        // try to see if the locale has been set as a cookie
        $localeFromCookie = $request->cookies->get('_locale_delegations');
        if (!in_array($request->getLocale(), $this->localeList)) {
            $url = $this->router->generate($request->get('_route'), array('_locale' => ($localeFromCookie) ? $localeFromCookie : $this->defaultLocale));
            $response = new RedirectResponse($url);
            $event->setResponse($response);
            return;
        }
        // try to see if the locale has been set as a _locale routing parameter
        if ($localeFromCookie && 'user_login' == $request->get('_route')) {
            $request->getSession()->set('_locale', $localeFromCookie);
            $request->setLocale($localeFromCookie);
        } elseif ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $locale);
        } else {
            // if no explicit locale has been set on this request, use one from the session
            $request->getSession()->get('_locale', $this->defaultLocale);
            $request->setLocale($this->defaultLocale);
        }
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }
        $request = $event->getRequest();
        if ('users_login' != $request->get('_route') && 'users_login' != $request->get('_route')) {
            if ($request->getLocale() == $request->attributes->get('_locale')) {
                $response = $event->getResponse();
                $response->headers->setCookie(new Cookie('_locale_delegations', $request->getLocale(), time() + 3600 * 24 * 365));
            }

        } elseif ('users_login' == $request->get('_route')) {
            $localeFromCookie = $request->cookies->get('_locale_delegations');
            $request->getSession()->set('_locale', $localeFromCookie);
            $request->setLocale($localeFromCookie);
        }

    }

    public static function getSubscribedEvents()
    {
        return array(
            // must be registered before the default Locale listener
            KernelEvents::REQUEST => array(array('onKernelRequest', 17)),
        );
    }
} 