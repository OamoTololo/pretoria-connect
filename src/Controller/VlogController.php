<?php

namespace App\Controller;

use App\Entity\VlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/vlog")
 */
class VlogController extends AbstractController
{
    /**
     * @Route("/{page}", name="vlog_list", defaults={"page": 1}, requirements={"page"="\d+"})
     */
    public function list($page = 1, Request $request)
    {
        $limit = $request->get('limit', 10);
        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'data' => array_map(function ($item) {
                return $this->generateUrl('vlog_by_slug', ['slug' => $item['slug']]);
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

    /**
     * @Route("/add", name="add_vlog", methods={"GET"})
     */
    public function add(Request $request)
    {
        /** @var Serializer $serializer */
        $serializer = $this->get('serializer');

        $vlogPost = $serializer->deserialize($request->getContent(), VlogPost::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($vlogPost);
        $em->flush();

        return $this->json($vlogPost);
    }
}