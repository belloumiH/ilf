<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Offer;
use App\Entity\Post;
use App\Entity\SpontaneousCandidate;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BackController.
 */
class BackController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        try {
            $posts = count($this->getDoctrine()
                ->getRepository(Post::class)
                ->findAll());
            $offers = count($this->getDoctrine()
                ->getRepository(Offer::class)
                ->findAll());
            $candidate = count($this->getDoctrine()
                ->getRepository(Candidate::class)
                ->findAll());
            $spontaneousCandidate = count($this->getDoctrine()
                ->getRepository(SpontaneousCandidate::class)
                ->findAll());
        } catch (Exception $e) {
            $posts = 0;
            $offers = 0;
            $candidate = 0;
            $spontaneousCandidate = 0;
        }

        return $this->render('Back/index.twig', [
            'posts' => $posts,
            'offers' => $offers,
            'candidate' => $candidate,
            'spontaneousCandidate' => $spontaneousCandidate,
        ]);
    }

    /**
     * @return Response
     */
    public function download(Request $request, string $fileName)
    {
        $baseDirFile = '';
        // Init new response
        $response = new Response();
        $response->headers->set('Content-Type', 'mime/type');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$fileName);
        $response->setContent('');

        // Get dir with different sources
        $baseDirFile = $this->getParameter('uploads_private_directory');

        // Test file exist to get
        if (true === file_exists($baseDirFile.'/'.$fileName)) {
            $dirFile = $baseDirFile.'/'.$fileName;
            $content = file_get_contents($dirFile);
            // Set response data
            $response->setContent($content);

            return $response;
        }

        return $response;
    }
}
