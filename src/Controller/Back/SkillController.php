<?php

declare(strict_types=1);

namespace App\Controller\Back;

use App\Entity\Skill;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SkillController.
 */
class SkillController extends AbstractController
{
    /**
     * @return mixed
     */
    public function showSkill(Request $request)
    {
        $skills = $this->getDoctrine()
            ->getRepository(Skill::class)
            ->findAll();

        return $this->render('Back/show_skill.twig', [
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

        return $this->redirectToRoute('show.skill');
    }

    public function updateSkill(Request $request)
    {
        if ($request->isMethod('post')) {
            $skillLabel = (string) $request->get('skill-label');
            $idSkill = (int) $request->get('skill-id');
            $skill = $this->getDoctrine()
                ->getRepository(Skill::class)
                ->find($idSkill);
            $skill->setLabel($skillLabel);
            $skill = $this->update($skill);
        }

        return $this->redirectToRoute('show.skill');
    }

    /**
     * @return mixed
     */
    public function enableSkill(Request $request, int $idSkill)
    {
        $skill = $this->getDoctrine()
            ->getRepository(Skill::class)
            ->find($idSkill);
        $skill->enabled();
        $skill = $this->update($skill);

        return $this->redirectToRoute('show.skill');
    }

    /**
     * @return mixed
     */
    public function disableSkill(Request $request, int $idSkill)
    {
        $skill = $this->getDoctrine()
            ->getRepository(Skill::class)
            ->find($idSkill);
        $skill->disabled();
        $skill = $this->update($skill);

        return $this->redirectToRoute('show.skill');
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
