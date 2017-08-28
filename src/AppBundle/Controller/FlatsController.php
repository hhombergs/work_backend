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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
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
            throw new NotFoundHttpException('There a no flats');
        }
        $view = View::create();
        $view->setData($result)->setHeader('X-Total-Count', count($result))
            ->setHeader('Access-Control-Expose-Headers', 'X-Total-Count')->setStatusCode(Response::HTTP_OK);
        return $view;
    }

    /**
     * @Rest\Get("/flats/{id}")
     */
    public function idAction($id)
    {
        $result = $this->getDoctrine()->getRepository(self::FLATS_BUNDLE)->find($id);
        if ($result === null || count($result) == 0) {
            throw new NotFoundHttpException('Flat not found');
        }
        return $result;
    }

    /**
     * @Rest\Put("/flats/{id}/{token}")
     */
    public function putAction($id, $token, Request $request)
    {
        $sn = $this->getDoctrine()->getManager();
        $flat = $this->getDoctrine()->getRepository(self::FLATS_BUNDLE)->find($id);
        if ($flat === null || count($flat) == 0) {
            throw new NotFoundHttpException('Flat not found');
        }
        if ($flat->getToken() !== $token) {
            throw new AccessDeniedHttpException('Access forbidden');
        }
        $flat = $this->buildFlatData($flat, $request);
        $sn->flush();
        return new View("User Updated Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/flats/")
     */
    public function postAction(Request $request) {
        $data = new Flats();
        $data = $this->buildFlatData($data, $request);
        if (empty($data->getCity()) || empty($data->getContactEmail()) || empty($data->getCountry()) || empty($data->getStreet()) || empty($data->getZip())) {
            throw new NotAcceptableHttpException('NULL VALUES ARE NOT ALLOWED');
        }
        $data->setEnterDate(new \DateTime());
        $data->setToken(uniqid('', TRUE));
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return new View("User Added Successfully", Response::HTTP_OK);
  }

    /**
     * @Rest\Delete("/flats/{id}/{token}")
     */
    public function deleteAction($id, $token)
    {
        $sn = $this->getDoctrine()->getManager();
        $flat = $this->getDoctrine()->getRepository(self::FLATS_BUNDLE)->find($id);
        if ($flat === null || count($flat) == 0) {
            throw new NotFoundHttpException('Flat not found');
        }
        if ($flat->getToken() !== $token) {
            throw new AccessDeniedHttpException('Access forbidden');
        }
        $sn->remove($flat);
        $sn->flush();
        return new View("Deleted successfully", Response::HTTP_OK);
    }

    /**
     * Build the flat data for insert and update
     *
     * @param \AppBundle\Entity\Flats $flat
     * @param Request $request
     * @return \AppBundle\Entity\Flats
     */
    private function buildFlatData(\AppBundle\Entity\Flats $flat, Request $request)
    {
        $street = $request->get('street');
        $zip = $request->get('zip');
        $city = $request->get('city');
        $country = $request->get('country');
        $contact_email = $request->get('contact_email');
        if (!empty($street)) {
            $flat->setStreet($street);
        }
        if (!empty($zip)) {
            $flat->setZip($zip);
        }
        if (!empty($city)) {
            $flat->setCity($city);
        }
        if (!empty($country)) {
            $flat->setCountry($country);
        }
        if (!empty($contact_email)) {
            $flat->setContactEmail($contact_email);
        }
        return $flat;
    }

}
