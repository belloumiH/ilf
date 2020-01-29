<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BackController.
 */
class BackController extends AbstractController
{
    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->render('Back/AdminLTE-3.0.2/index.html.twig', []);
    }
}
