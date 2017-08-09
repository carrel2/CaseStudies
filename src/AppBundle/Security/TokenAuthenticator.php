<?php

namespace AppBundle\Security;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use AppBundle\Entity\User;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    private $em;

    public function __construct(EntityManager $em) {
      $this->em = $em;
    }

    public function getCredentials(Request $request)
    {
        if (!$token = $request->headers->get('php-auth-user')) {
            $token = null;
        }

        return array(
            'token' => $token,
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        dump($em);
        $username = $credentials['token'];

        if (null === $username) {
            return;
        }

        try {
          $user = $userProvider->loadUserByUsername($username);
        } catch(\Symfony\Component\Security\Core\Exception\UsernameNotFoundException $e) {
          $user = new User();
          $user->setUsername($username);

          $em->persist($user);
          $em->flush();
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = array(
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        );

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            'message' => 'Authentication Required'
        );

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
