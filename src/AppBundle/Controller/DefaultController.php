<?php
/**
 * Handle index call action
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
use FOS\RestBundle\View\View;

class DefaultController extends Controller
{
    /**
     * Handle the index request
     * 
     * @param Request $request
     * @return View
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) : View
    {
        return new View('Access forbidden', Response::HTTP_FORBIDDEN);
    }
}
