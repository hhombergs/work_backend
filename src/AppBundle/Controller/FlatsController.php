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
     * The doctrine bundle name
     */
    const FLATS_BUNDLE = 'AppBundle:Flats';

    /**
     * @Rest\Get("/flats")
     */
    public function getAction()
    {
        $result = $this->getDoctrine()->getRepository(self::FLATS_BUNDLE)->findAll();
        if ($result === null || count($result) == 0) {
            return new View('There a no flats', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    /**
     * @Rest\Get("/flats/{id}")
     */
    public function idAction($id)
    {
        $result = $this->getDoctrine()->getRepository(self::FLATS_BUNDLE)->find($id);
        if ($result === null || count($result) == 0) {
            return new View('Flat not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    /**
     * @Rest\Delete("/flats/{id}/{token}")
     */
    public function deleteAction($id, $token)
    {
        $sn = $this->getDoctrine()->getManager();
        $flat = $this->getDoctrine()->getRepository(self::FLATS_BUNDLE)->find($id);
        if ($flat === null || count($flat) == 0) {
            return new View('Flat not found', Response::HTTP_NOT_FOUND);
        }
        if ($flat->getToken() !== $token) {
            return new View('Access forbidden', Response::HTTP_FORBIDDEN);
        }
        $sn->remove($flat);
        $sn->flush();
        return new View("Deleted successfully", Response::HTTP_OK);
    }
}
