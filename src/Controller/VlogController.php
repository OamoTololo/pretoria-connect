<?php

namespace App\Controller;

use App\Entity\VlogPost;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
        $repository = $this->getDoctrine()->getRepository(VlogPost::class);
        $items = $repository->findALL();

        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'data' => array_map(function ($item) {
                return $this->generateUrl('vlog_by_slug', ['slug' => $item->getSlug()]);
            }, $items)
        ]);
    }

    /**
     * @Route("/post/{id}", name="vlog_by_id", requirements={"id"="\d+"})
     * @ParamConverter("post", class="App\Entity\VlogPost")
     */
    public function post(VlogPost $post)
    {
        return $this->json($post);
    }

    /**
     * @Route("/post/{slug}", name="vlog_by_slug")
     * @ParamConverter("post", class="App\Entity\VlogPost", options={"mapping": {"slug": "slug"}})
     */
    public function postBySlug(VlogPost $post)
    {
        return $this->json($post);
    }

    /**
     * @Route("/add", name="add_vlog", methods={"POST"})
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