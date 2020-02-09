<?php

declare(strict_types=1);

namespace App\Controller\Back;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PostController.
 */
class PostController extends AbstractController
{
    /**
     * @return mixed
     */
    public function showPost(Request $request)
    {
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findAll();

        return $this->render('Back/show_post.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @return mixed
     */
    public function insertPost(Request $request)
    {
        if ($request->isMethod('post')) {
            // Get one post data
            $postLabel = (string) $request->get('postLabel');
            // Get all post data
            // $data = $request->request->all();
            if (true === isset($postLabel) && '' != $postLabel) {
                $post = new Post();
                $post->setLabel($postLabel);
                $post = $this->insert($post);
            }
        }

        return $this->redirectToRoute('show.post');
    }

    public function updatePost(Request $request, int $idPost)
    {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($idPost);
        $post->setLabel($request->get('value'));
        $post = $this->update($post);

        return new Response(
            json_encode(
                [
                    'type' => 'success',
                    'status' => '200',
                    'message' => 'post updated.',
                ]
            )
        );
    }

    /**
     * @return mixed
     */
    public function enablePost(Request $request, int $idPost)
    {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($idPost);
        $post->enabled();
        $post = $this->update($post);

        return $this->redirectToRoute('show.post');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disablePost(Request $request, int $idPost)
    {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($idPost);
        $post->disabled();
        $post = $this->update($post);

        return $this->redirectToRoute('show.post');
    }

    /**
     * @param mixed $object
     *
     * @return mixed
     */
    public function insert($object)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($object);
        $entityManager->flush();

        return $object;
    }

    /**
     * @param mixed $object
     *
     * @return mixed
     */
    public function update($object)
    {
        return $this->insert($object);
    }
}
