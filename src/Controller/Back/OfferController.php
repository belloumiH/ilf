<?php

declare(strict_types=1);

namespace App\Controller\Back;

use App\Entity\Offer;
use App\Entity\OfferSkill;
use App\Entity\Post;
use App\Entity\Skill;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class OfferController.
 */
class OfferController extends AbstractController
{
    /**
     * @return mixed
     */
    public function show(Request $request)
    {
        $skills = $this->getDoctrine()
            ->getRepository(Skill::class)
            ->findBy(['enabled' => 1]);

        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findBy(['enabled' => 1]);

        $offers = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->findAll();

        return $this->render('Back/offer/show.twig', [
            'skills' => $skills,
            'offers' => $offers,
            'posts' => $posts,
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->request->all();
        $offer = new Offer();
        $fileImg = $request->files->get('offerImg');
        if (null !== $fileImg) {
            $fileName = microtime(true).'.'.$fileImg->guessExtension();
            try {
                $fileImg->move(
                    $this->getParameter('uploads_public_directory'),
                    $fileName);
            } catch (Exception $e) {
                $fileImg = null;
            }
            $offer->setImg($fileName);
        }
        $arraySkills = (false === empty($data['skillOffer'])) ? (array) $data['skillOffer'] : [];
        foreach ($arraySkills as $skill) {
            $skillRepo = $this->getDoctrine()
                ->getRepository(Skill::class)
                ->find($skill);
            $offerSkill = new OfferSkill();
            $offerSkill->setLabel($skillRepo->getLabel());
            $offerSkill->setSkillId((int) $skillRepo->getId());
            $offer->addSkills($offerSkill);
        }
        $offer->setTitle((string) $data['titleOffer']);
        $offer->setDescription((string) $data['descriptionOffer']);
        $offer->setAddress((string) $data['addressOffer']);
        if (true === isset($data['checkIlfOffer']) and 'on' === (string) $data['checkIlfOffer']) {
            $offer->setIlfInd(true);
        }
        $offer->disabled();
        if ($data['postOffer'] > 0) {
            $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($data['postOffer']);
            $offer->setPost($post);
        }
        $offer = $this->insert($offer);

        return $this->redirectToRoute('show.offer');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ShowUpdate(Request $request, int $idOffer)
    {
        $offer = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->find($idOffer);
        $skillOfferArray = [];
        if (null !== $offer->getSkills()) {
            foreach ($offer->getSkills() as $skillOffer) {
                $skillOfferArray[] = $skillOffer->getSkillId();
            }
        }
        $skills = $this->getDoctrine()
            ->getRepository(Skill::class)
            ->findBy(['enabled' => 1]);

        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findBy(['enabled' => 1]);

        return $this->render('Back/offer/show_update.twig', [
            'offer' => $offer,
            'skills' => $skills,
            'posts' => $posts,
            'skillOfferArray' => $skillOfferArray,
        ]);
    }

    public function updateA(Request $request)
    {
        $data = $request->request->all();
        $offer = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->find((int) $data['offerId']);
        $offer->disabled();
        if (true === isset($data['enabled']) and 'on' === (string) $data['enabled']) {
            $offer->enabled();
        }
        $fileImg = $request->files->get('offerImg');
        if (null !== $fileImg) {
            $fileName = microtime(true).'.'.$fileImg->guessExtension();
            try {
                $fileImg->move(
                    $this->getParameter('uploads_public_directory'),
                    $fileName);
            } catch (Exception $e) {
                $fileImg = null;
            }
            $offer->setImg($fileName);
        }
        if (count($offer->getSkills()) > 0) {
            foreach ($offer->getSkills() as $offerSkill) {
                $this->remove($offerSkill);
            }
        }
        $arraySkills = (false === empty($data['skillOffer'])) ? (array) $data['skillOffer'] : [];
        foreach ($arraySkills as $skill) {
            $skillRepo = $this->getDoctrine()
                ->getRepository(Skill::class)
                ->find($skill);
            $offerSkill = new OfferSkill();
            $offerSkill->setLabel($skillRepo->getLabel());
            $offerSkill->setSkillId((int) $skillRepo->getId());
            $offer->addSkills($offerSkill);
        }
        $offer->setTitle((string) $data['titleOffer']);
        $offer->setDescription((string) $data['descriptionOffer']);
        $offer->setAddress((string) $data['addressOffer']);
        $offer->setIlfInd(false);
        if (true === isset($data['checkIlfOffer']) and 'on' === (string) $data['checkIlfOffer']) {
            $offer->setIlfInd(true);
        }
        $offer->setPost(null);
        if ($data['postOffer'] > 0) {
            $post = $this->getDoctrine()
                ->getRepository(Post::class)
                ->find($data['postOffer']);
            $offer->setPost($post);
        }
        $offer = $this->update($offer);

        return $this->redirectToRoute('show.offer');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function enable(Request $request, int $idOffer)
    {
        $offer = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->find($idOffer);
        $offer->enabled();
        $offer = $this->update($offer);

        return $this->redirectToRoute('show.offer');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disable(Request $request, int $idOffer)
    {
        $offer = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->find($idOffer);
        $offer->disabled();
        $offer = $this->update($offer);

        return $this->redirectToRoute('show.offer');
    }

    /**
     * @param mixed $object
     *
     * @return mixed
     */
    public function insert($object)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($object);
        $entityManager->flush();

        return $object;
    }

    /**
     * @param mixed $object
     *
     * @return mixed
     */
    public function update($object)
    {
        return $this->insert($object);
    }

    public function remove($object)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($object);
        $entityManager->flush();
    }
}
