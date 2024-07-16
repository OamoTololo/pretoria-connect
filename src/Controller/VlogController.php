<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vlog")
 */
class VlogController extends AbstractController
{
    /**
     * @Route("/{page}", name="vlog_list", defaults={"page": 1})
     */
    public function list($page = 1, Request $request)
    {
        $limit = $request->get('limit', 10);
        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'data' => array_map(function ($item) {
                return $this->generateUrl('vlog_by_id', ['id' => $item['id']]);
            })
        ]);
    }

    /**
     * @Route("/{id}", name="vlog_by_id", requirements={"id"="\d+"})
     */
    public function post($id)
    {
        return $this->json([]);
    }

    /**
     * @Route("/{slug}", name="vlog_by_slug")
     */
    public function postBySlug()
    {
        return $this->json([]);
    }
}