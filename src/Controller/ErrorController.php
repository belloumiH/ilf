<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ErrorController.
 */
class ErrorController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request)
    {
        return $this->render('bundles/TwigBundle/Exception/error.html.twig', [
            'languageUser' => 'fr',
        ]);
    }
}
