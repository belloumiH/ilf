<?php

declare(strict_types=1);

namespace App\Controller\Back;

use App\Entity\SpontaneousCandidate;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SpontaneousCandidateController.
 */
class SpontaneousCandidateController extends AbstractController
{
    /**
     * @return mixed
     */
    public function show(Request $request)
    {
        try {
            $SpontaneousCandidates = $this->getDoctrine()
                ->getRepository(SpontaneousCandidate::class)
                ->findAll();
        } catch (Exception $e) {
            $SpontaneousCandidates = [];
        }

        return $this->render('Back/show_spontaneous_candidate.twig', [
            'spontaneousCandidates' => $SpontaneousCandidates,
        ]);
    }
}
