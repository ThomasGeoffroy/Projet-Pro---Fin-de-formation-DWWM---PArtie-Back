<?php

namespace App\Service;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;


class CallUserApiService
{
    /** @var  TokenStorageInterface */
    private $tokenStorage;

    /**
     * @param TokenStorageInterface  $storage
     */
    public function __construct(TokenStorageInterface $storage)
    {
        $this->tokenStorage = $storage;
    }

    public function getCurrentUser()
    {
        $token = $this->tokenStorage->getToken();
        if ($token instanceof TokenInterface) {

            /** @var User $user */
            $user = $token->getUser();
            return $user;

        } else {
            return null;
        }
    }
}