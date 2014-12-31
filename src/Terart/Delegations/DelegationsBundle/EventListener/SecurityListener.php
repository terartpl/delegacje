<?php

namespace Terart\Delegations\DelegationsBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityListener
{
    public function __construct()
    {
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        /*var_dump(get_class_methods($event)); die;
        $user = $event->getAuthenticationToken()->getUser();
        if($user && method_exists($user, 'setLastLogin'))
        {
            $user->setLastLogin(new \DateTime());
            $em = $this->em;
            $em->flush();
        }*/
    }
} 