<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\OfferSkill;
use App\Entity\Skill;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        return $this->render('Back/index.html.twig', []);
    }

    /**
     * @return mixed
     */
    public function showSkill(Request $request)
    {
        $skills = $this->getDoctrine()
            ->getRepository(Skill::class)
            ->findAll();

        return $this->render('Back/show-skill.twig', [
            'skills' => $skills,
        ]);
    }

    /**
     * @return mixed
     */
    public function insertSkill(Request $request)
    {
        if ($request->isMethod('post')) {
            // Get one post data
            $skillLabel = (string) $request->get('skillLabel');
            // Get all post data
            // $data = $request->request->all();
            if (true === isset($skillLabel) && '' != $skillLabel) {
                $skill = new Skill();
                $skill->setLabel($skillLabel);
                $skill = $this->insert($skill);
            }
        }

        return $this->forward('App\Controller\BackController::showSkill', []);
    }

    /**
     * @return mixed
     */
    public function insertOffer(Request $request)
    {
        $arraySkills = [1, 2, 3];
        $offer = new Offer();

        foreach ($arraySkills as $skill) {
            $skillRepo = $this->getDoctrine()
            ->getRepository(Skill::class)
            ->find($skill);
            $offerSkill = new OfferSkill();
            $offerSkill->setLabel($skillRepo->getLabel());
            $offer->addSkills($offerSkill);
        }
        $offer->setTitle('offer1');
        $offer = $this->insert($offer);

        return new Response('Saved new offer with id '.$offer->getId());
    }

    /**
     * @return mixed
     */
    public function insert($opject)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($opject);
        $entityManager->flush();

        return $opject;
    }
}
