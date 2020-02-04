<?php

declare(strict_types=1);

namespace App\Entity;

use App\Traits\EntityIdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * SpontaneousCandidate.
 *
 * @ORM\Table(name="spontaneous_candidate")
 * @ORM\Entity(repositoryClass="App\Repository\SpontaneousCandidateRepository")
 */
class SpontaneousCandidate
{
    use EntityIdTrait;

    /**
     * @var string|null
     *
     * @ORM\Column(name="label", type="string", length=255, nullable=true)
     */
    private $label;

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): Skill
    {
        $this->label = $label;

        return $this;
    }
}
