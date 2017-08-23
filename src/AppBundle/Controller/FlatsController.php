<?php
/**
 * Handle the REST API calls for the flats table
 *
 * @author hhombergs
 * @category Work
 * @package Flats
 * @subpackage Controller
 * @since 2017-08-23
 * @copyright Henz-Gerd Hombergs
 */
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Flats;

class FlatsController extends FOSRestController
{

    /**
     * @Rest\Get("/flats")
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Flats')->findAll();
        if ($restresult === null || count($restresult) == 0) {
            return new View('There a no flats', Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }
}
