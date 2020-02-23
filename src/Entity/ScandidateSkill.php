<?php

declare(strict_types=1);

namespace App\Entity;

use App\Traits\EntityIdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * ScandidateSkill.
 *
 * @ORM\Table(name="scandidate_skill")
 * @ORM\Entity(repositoryClass="App\Repository\ScandidateSkillRepository")
 */
class ScandidateSkill
{
    use EntityIdTrait;

    /**
     * @ORM\ManyToOne(targetEntity="SpontaneousCandidate", inversedBy="scandidate_skill")
     */
    private $spontaneousCandidate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="skill_id", type="bigint", nullable=true)
     */
    private $skillId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="label", type="string", length=255, nullable=true)
     */
    private $label;

    /**
     * @return mixed
     */
    public function getSpontaneousCandidate()
    {
        return $this->spontaneousCandidate;
    }

    /**
     * @param mixed $spontaneousCandidate
     */
    public function setSpontaneousCandidate($spontaneousCandidate): void
    {
        $this->spontaneousCandidate = $spontaneousCandidate;
    }

    public function getSkillId(): ?int
    {
        return $this->skillId;
    }

    public function setSkillId(?int $skillId): void
    {
        $this->skillId = $skillId;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }
}
