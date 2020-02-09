<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FrontController.
 */
class FrontController extends AbstractController
{
    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->render('Front/index.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
