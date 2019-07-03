<?php

namespace App\Controller;

use App\Entity\Moderation\Moderation;
use App\Service\Constellations;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ConstellationController extends BaseController
{
    /**
     * @Route("/constellations", name="constellation_index")
     *
     * @param Request $request
     * @param LoggerInterface $logger
     * @param UserInterface|null $user
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Request $request, LoggerInterface $logger, UserInterface $user = null)
    {
        $limit = filter_var($request->get('limit'), FILTER_SANITIZE_NUMBER_INT);
        $limit = $limit ?: $this->getParameter('pagination.limit');
        $offset = filter_var($request->get('offset'), FILTER_SANITIZE_NUMBER_INT);
        $offset = $offset ?: $this->getParameter('pagination.offset');
        $term = filter_var($request->get('q'), FILTER_SANITIZE_STRING);
        $em = $this->getDoctrine()->getManager('moderation');
        $constService = new Constellations($em, $user);

        return $this->resultJson($constService->getConstellationListByUser($limit, $offset, $term));
    }
}