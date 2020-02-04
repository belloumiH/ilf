<?php

declare(strict_types=1);

namespace App\Entity;

use App\Traits\EntityIdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * OfferSkill.
 *
 * @ORM\Table(name="offer_skill")
 * @ORM\Entity(repositoryClass="App\Repository\OfferSkillRepository")
 */
class OfferSkill
{
    use EntityIdTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Offer", inversedBy="offer_skill")
     */
    private $offer;

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

    public function setLabel(?string $label): OfferSkill
    {
        $this->label = $label;

        return $this;
    }

    public function getOffer()
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): OfferSkill
    {
        $this->offer = $offer;

        return $this;
    }
}
