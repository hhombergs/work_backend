<?php
/**
 * Handle the REST API calls for the flats table
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
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Flats;
use Doctrine\Common\Util\Inflector as Inflector;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class FlatsController extends FOSRestController
{

    /**
     * The doctrine bundle name
     */
    const FLATS_BUNDLE = 'AppBundle:Flats';

    /**
     * Handle the get request for the complete list
     *
     * @param Request $request
     * @return View
     * @throws NotFoundHttpException
     * @Rest\Get("/flats")
     * @Rest\Get("/flato")
     */
    public function getAction(Request $request): View
    {
        $sort = $request->get('_sort');
        $order = $request->get('_order');
        $start = $request->get('_start');
        $end = $request->get('_end');
        $filterID = $request->get('_filterid');
        if (empty($sort)) {
            $sort = 'id';
        }
        if (empty($order)) {
            $order = 'DESC';
        }
        if (empty($start)) {
            $start = 0;
        }
        if (empty($end)) {
            $end = 25;
        }
        $filter = [];
        if (!empty($filterID) && $filterID != 'null' && $filterID != 'undefined') {
            $filter = ['id' => $filterID];
        }
        $sort = Inflector::camelize($sort);
        $count = $this->getRowCounter($filter);
        if (count($count) == 0) {
            throw new NotFoundHttpException('There a no flats');
        }
        $result = $this->getDoctrine()->getRepository(self::FLATS_BUNDLE)->findBy($filter, [$sort => $order], $end, $start);
        $view = View::create();
        $view->setData($result)->setHeader('X-Total-Count', $count)
            ->setHeader('Access-Control-Expose-Headers', 'X-Total-Count')->setStatusCode(Response::HTTP_OK);
        return $view;
    }

    /**
     * Get one flat
     *
     * @param int $id
     * @return Flats
     * @throws NotFoundHttpException
     * @Rest\Get("/flats/{id}")
     * @Rest\Get("/flato/{id}")
     */
    public function idAction(int $id): Flats
    {
        $result = $this->getDoctrine()->getRepository(self::FLATS_BUNDLE)->find($id);
        if ($result === null || count($result) == 0) {
            throw new NotFoundHttpException('Flat not found');
        }
        return $result;
    }

    /**
     * Update the given flat
     *
     * @param int $id
     * @param string $token
     * @param Request $request
     * @return View
     * @throws NotFoundHttpException
     * @throws AccessDeniedHttpException
     * @Rest\Put("/flats/{id}/{token}")
     * @Rest\Put("/flato/{id}/{token}")
     */
    public function putAction(int $id, string $token, Request $request): View
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
        $sn->merge($flat);
        $sn->flush();
        return new View("Wohnung geändert", Response::HTTP_OK);
    }

    /**
     * Insert a new flat
     *
     * @param Request $request
     * @return View
     * @throws NotAcceptableHttpException
     * @Rest\Post("/flats")
     * @Rest\Post("/flato")
     */
    public function postAction(Request $request): View
    {
        $data = new Flats();
        $data = $this->buildFlatData($data, $request);
        if (empty($data->getCity()) || empty($data->getContactEmail()) || empty($data->getCountry()) || empty($data->getStreet()) || empty($data->getZip())) {
            throw new NotAcceptableHttpException('NULL VALUES ARE NOT ALLOWED');
        }
        $data->setEnterDate(new \DateTime());
        $uuid4 = Uuid::uuid4();
        $data->setToken($uuid4->toString());
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $email = [
            'id' => $data->getId(),
            'token' => $data->getToken(),
            'street' => $data->getStreet(),
            'zip' => $data->getZip(),
            'city' => $data->getCity(),
            'country' => $data->getCountry(),
        ];
        $message = \Swift_Message::newInstance()
            ->setSubject('Wohnung erstellt')
            ->setFrom('send@example.com')
            ->setTo($data->getContactEmail())
            ->setBody(
                $this->renderView(
                    'emails/create.html.twig', $email
                )
            )
            ->addPart(
            $this->renderView(
                'emails/create.twig', $email
            ), 'text/plain'
            )
        ;
        $this->get('mailer')->send($message);
        $view = View::create();
        $view->setData($data)->setStatusCode(Response::HTTP_OK);
        return $view;
    }

    /**
     * Delete the given flat
     *
     * @param int $id
     * @param string $token
     * @return View
     * @throws NotFoundHttpException
     * @throws AccessDeniedHttpException
     * @Rest\Delete("/flats/{id}/{token}")
     * @Rest\Delete("/flato/{id}/{token}")
     */
    public function deleteAction(int $id, string $token): View
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
        return new View("Wohnung gelöscht", Response::HTTP_OK);
    }

    /**
     * Build the flat data for insert and update
     *
     * @param \AppBundle\Entity\Flats $flat_orig
     * @param Request $request
     * @return \AppBundle\Entity\Flats
     */
    private function buildFlatData(\AppBundle\Entity\Flats $flat_orig, Request $request): AppBundle\Entity\Flats
    {
        $flat = $flat_orig;
        $enter_date = $request->get('enter_date');
        $street = $request->get('street');
        $zip = $request->get('zip');
        $city = $request->get('city');
        $country = $request->get('country');
        $contact_email = $request->get('contact_email');
        if (!empty($enter_date)) {
            $enter_date = new \DateTime($enter_date);
            $flat->setEnterDate($enter_date);
        }
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

    /**
     * Get the total row counter
     *
     * @param array $filter
     * @return  integer
     */
    private function getRowCounter(array $filter): int
    {
        $sn = $this->getDoctrine()->getManager();
        $qb = $sn->createQueryBuilder();
        $qb->select('count(flats.id)');
        $qb->from(self::FLATS_BUNDLE, 'flats');
        if (count($filter) > 0) {
            $key = key($filter);
            $qb->where('flats.' . $key . ' = ?1');
            $qb->setParameter(1, $filter[$key]);
        }
        return $qb->getQuery()->getSingleScalarResult();
    }
}
