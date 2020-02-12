<?php

declare(strict_types=1);

namespace App\Controller;

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
        return $this->render('Back/index.twig', []);
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
