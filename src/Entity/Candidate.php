<?php

declare(strict_types=1);

namespace App\Entity;

use App\Traits\EntityIdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Candidate.
 *
 * @ORM\Table(name="candidate")
 * @ORM\Entity(repositoryClass="App\Repository\CandidateRepository")
 */
class Candidate
{
    use EntityIdTrait;

    /**
     * @var string|null
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): Candidate
    {
        $this->firstName = $firstName;

        return $this;
    }
}
