<?php

declare(strict_types=1);

namespace App\Controller\Back;

use App\Entity\Candidate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CandidateController.
 */
class CandidateController extends AbstractController
{
    /**
     * @return mixed
     */
    public function show(Request $request)
    {
        $candidates = $this->getDoctrine()
            ->getRepository(Candidate::class)
            ->findAll();

        return $this->render('Back/show_candidate.twig', [
            'candidates' => $candidates,
        ]);
    }
}
