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
    public function insertSkill(Request $request)
    {
        $skill = new Skill();
        $skill->setLabel('css');
        $skill = $this->insert($skill);

        return new Response('Saved new skill with id '.$skill->getId());
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
