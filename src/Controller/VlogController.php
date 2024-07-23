<?php

namespace App\Controller;

use App\Entity\VlogPost;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function list($page = 1, Request $request): JsonResponse
    {
        $limit = $request->get('limit', 10);
        $repository = $this->getDoctrine()->getRepository(VlogPost::class);
        $items = $repository->findALL();

        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'data' => array_map(function (VlogPost $item) {
                return $this->generateUrl('vlog_by_slug', ['slug' => $item->getSlug()]);
            }, $items)
        ]);
    }

    /**
     * @Route("/post/{id}", name="vlog_by_id", requirements={"id"="\d+"}, methods={"GET"})
     * @ParamConverter("post", class="App\Entity\VlogPost")
     */
    public function post($post): JsonResponse
    {
        return $this->json($post);
    }

    /**
     * @Route("/post/{slug}", name="vlog_by_slug", methods={"GET"})
     * @ParamConverter("post", class="App\Entity\VlogPost", options={"mapping": {"slug": "slug"}})
     */
    public function postBySlug($post): JsonResponse
    {
        return $this->json($post);
    }

    /**
     * @Route("/add", name="add_vlog", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        /** @var Serializer $serializer */
        $serializer = $this->get('serializer');

        $vlogPost = $serializer->deserialize($request->getContent(), VlogPost::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($vlogPost);
        $em->flush();

        return $this->json($vlogPost);
    }

    /**
     * @Route("/post/{id}", name="delete_vlog", methods={"DELETE"})
     */
    public function delete(VlogPost $post): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}