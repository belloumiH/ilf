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
    public function show(Request $request, int $offerId = 0)
    {
        $candidates = $this->getDoctrine()
            ->getRepository(Candidate::class)
            ->findAll();

        if ((int) $offerId > 0) {
            $candidates = $this->getDoctrine()
                ->getRepository(Candidate::class)
                ->findBy(['offer' => $offerId]);
        }

        return $this->render('Back/show_candidate.twig', [
            'candidates' => $candidates,
        ]);
    }
}
