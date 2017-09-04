<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use FOS\RestBundle\View\View;

class AuthController extends Controller
{
    /**
     * @Route("/auth", name="auth")
     */
    public function authAction(Request $request)
    {
        $id = $request->get('username');
        $result = $this->getDoctrine()->getRepository('AppBundle:Flats')->find($id);
        if ($result === null || count($result) == 0) {
            throw new AccessDeniedHttpException('Access forbidden');
        }
        if ($result->getToken() !== $request->get('password')) {
            throw new AccessDeniedHttpException('Access forbidden');
        }
        return new View(['token'=>$result->getId()], Response::HTTP_OK);
    }
}
