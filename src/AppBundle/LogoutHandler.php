<?php

namespace AppBundle;

use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class LogoutHandler implements LogoutHandlerInterface
{
  public function logout(Request $request, Response $response, TokenInterface $token)
  {
    $session = $request->getSession();

    $timedOut = $session->get('timed out');

    $page = $session->get('page');
    $session->invalidate();

    $session->set('page', $page);

    if( $timedOut ) {
      $session->getFlashBag()->set('warning', 'Session timed out, please login again');
    }
  }
}
