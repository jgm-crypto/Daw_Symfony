<?php
// src/EventListener/AuthenticationSuccessListener.php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    /**
     * This method is called when the `lexik_jwt_authentication.on_authentication_success` 
     * event is dispatched.
     *
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        // Ensure that the User object implements UserInterface
        if (!$user instanceof UserInterface) {
            return;
        }

        // Modify data to include user roles
        $data['data'] = array(
            'status' => 'OK',
            'roles' => $user->getRoles(),
        );

        // Update the event with the modified data
        $event->setData($data);
    }
}
