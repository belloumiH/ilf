<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Offer;
use App\Entity\Post;
use App\Entity\ScandidateSkill;
use App\Entity\Skill;
use App\Entity\SpontaneousCandidate;
use App\Helper\Mail;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

/**
 * Class FrontController.
 */
class FrontController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, string $languageUser)
    {
        $skills = $this->getDoctrine()
            ->getRepository(Skill::class)
            ->findBy(['enabled' => 1]);

        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findBy(['enabled' => 1]);

        $offers = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->findBy(['enabled' => 1]);

        $projectRoot = $this->getParameter('kernel.project_dir');
        $translations = Yaml::parseFile($projectRoot.'/translations/translation_'.$languageUser.'.yaml');

        return $this->render('Front/index.twig', [
                'posts' => $posts,
                'skills' => $skills,
                'offers' => $offers,
                'languageUser' => $languageUser,
                'translations' => $translations,
            ]
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postulate(Request $request, string $languageUser, int $offerId)
    {
        return $this->render('Front/postulate.twig',
            [
                'offerId' => $offerId,
                'languageUser' => $languageUser,
            ]
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function insertCandidateOffer(Request $request, string $languageUser)
    {
        if ($request->isMethod('post')) {
            $data = $request->request->all();
            $candidateFile = $request->files->get('candidate-file');
            $fileName = '';
            if (null !== $candidateFile) {
                $fileName = microtime(true).'.'.$candidateFile->guessExtension();
                try {
                    $candidateFile->move(
                        $this->getParameter('uploads_private_directory'),
                        $fileName);
                } catch (Exception $e) {
                    $fileName = null;
                }
            }
            $candidate = new Candidate();
            $candidate->setFirstName((string) $data['your-first-name']);
            $candidate->setLastName((string) $data['your-name']);
            $candidate->setPhone((string) $data['phone']);
            $candidate->setMail((string) $data['your-email']);
            $candidate->setComment((string) $data['message']);
            $candidate->setFile((string) $fileName);
            $offer = $this->getDoctrine()
                ->getRepository(Offer::class)
                ->find((int) $data['offer-id']);
            $candidate->setOffer($offer);
            $this->insert($candidate);
        }

        return $this->redirectToRoute('front.index', ['languageUser' => $languageUser]);
    }

    public function insertCandidateSpontanious(Request $request, string $languageUser)
    {
        if ($request->isMethod('post')) {
            $data = $request->request->all();
            $candidateFile = $request->files->get('candidate-file');
            $fileName = '';
            if (null !== $candidateFile) {
                $fileName = microtime(true).'.'.$candidateFile->guessExtension();
                try {
                    $candidateFile->move(
                        $this->getParameter('uploads_private_directory'),
                        $fileName);
                } catch (Exception $e) {
                    $fileName = null;
                }
            }
            $sCandidate = new SpontaneousCandidate();
            $sCandidate->setFirstName((string) $data['first-name']);
            $sCandidate->setLastName((string) $data['last-name']);
            $sCandidate->setPhone((string) $data['phone']);
            $sCandidate->setMail((string) $data['your-email']);
            $sCandidate->setComment((string) $data['comment']);
            $sCandidate->setFile((string) $fileName);
            if ($data['post'] > 0) {
                $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($data['post']);
                $sCandidate->setPost($post);
            }
            $arraySkills = (false === empty($data['skillSpontanious'])) ? (array) $data['skillSpontanious'] : [];
            foreach ($arraySkills as $skill) {
                $skillRepo = $this->getDoctrine()
                ->getRepository(Skill::class)
                ->find($skill);
                $spontaniousSkill = new ScandidateSkill();
                $spontaniousSkill->setLabel($skillRepo->getLabel());
                $spontaniousSkill->setSkillId((int) $skillRepo->getId());
                $sCandidate->addSkills($spontaniousSkill);
            }
            $this->insert($sCandidate);
        }

        return $this->redirectToRoute('front.index', ['languageUser' => $languageUser]);
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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contact(Request $request, string $languageUser)
    {
        return $this->render('Front/contact.twig', ['languageUser' => $languageUser]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function services(Request $request, string $languageUser)
    {
        if ($request->isMethod('post')) {
            $data = $request->request->all();
            Mail::send($data);
        }

        return $this->render('Front/services.twig', ['languageUser' => $languageUser]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function partenaires(Request $request, string $languageUser)
    {
        return $this->render('Front/partenaires.twig', ['languageUser' => $languageUser]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function quiSommeNous(Request $request, string $languageUser)
    {
        return $this->render('Front/quiSommeNous.twig', ['languageUser' => $languageUser]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function tupr(Request $request, string $languageUser)
    {
        return $this->render('Front/tupr.twig', ['languageUser' => $languageUser]);
    }
}
