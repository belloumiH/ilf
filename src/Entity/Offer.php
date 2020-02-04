<?php

declare(strict_types=1);

namespace App\Entity;

use App\Traits\EntityEnableTrait;
use App\Traits\EntityIdTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Offer.
 *
 * @ORM\Table(name="offer")
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 */
class Offer
{
    use EntityIdTrait;
    use EntityEnableTrait;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text",nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="img", type="string", length=255, nullable=true)
     */
    private $img;

    /**
     * @ORM\OneToMany(targetEntity="OfferSkill", cascade={"persist", "remove"}, mappedBy="offer")
     */
    private $skills;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Offer
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkills()
    {
        return $this->skills;
    }

    public function addSkills(OfferSkill $skill)
    {
        $this->skills->add($skill);
        $skill->setOffer($this);
    }
}
