<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Offer;
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
        $offers = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->findBy(['enabled' => 1]);

        $projectRoot = $this->getParameter('kernel.project_dir');
        $translations = Yaml::parseFile($projectRoot.'/translations/translation_'.$languageUser.'.yaml');

        return $this->render('Front/index.twig',
            [
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
}
