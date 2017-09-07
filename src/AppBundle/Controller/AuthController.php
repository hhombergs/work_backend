<?php
/**
 * Handle auth request
 *
 * @author hhombergs
 * @category Work
 * @package Flats
 * @subpackage Controller
 * @since 2017-08-23
 * @copyright Heinz-Gerd Hombergs
 */
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
     * Check if the authenticate data is correct
     * 
     * @param Request $request
     * @return View
     * @throws AccessDeniedHttpException
     * @Route("/auth", name="auth")
     */
    public function authAction(Request $request) : View
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
