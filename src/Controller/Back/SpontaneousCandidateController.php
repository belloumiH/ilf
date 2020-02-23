<?php

declare(strict_types=1);

namespace App\Controller\Back;

use App\Entity\ScandidateSkill;
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
            $spontaneousCandidates = $this->getDoctrine()
                ->getRepository(SpontaneousCandidate::class)
                ->findAll();
            $arraySkill = [];
            foreach ($spontaneousCandidates as $key => $spontaneousCandidate) {
                $spontaneousCandidatesSkills = $this->getDoctrine()
                    ->getRepository(ScandidateSkill::class)
                    ->findBy(['spontaneousCandidate' => $spontaneousCandidate->getId()]);
                $spontaneousCandidate->setSkills($spontaneousCandidatesSkills);
            }
        } catch (Exception $e) {
            $spontaneousCandidates = [];
        }

        return $this->render('Back/show_spontaneous_candidate.twig', [
            'spontaneousCandidates' => $spontaneousCandidates,
        ]);
    }
}
