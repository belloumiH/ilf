<?php

declare(strict_types=1);

namespace App\Entity;

use App\Traits\EntityEnableTrait;
use App\Traits\EntityIdTrait;
use App\Traits\EntityTimestamp;
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
    use EntityTimestamp;

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
     * @var string|null
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="ilf_ind", type="boolean", options={"default" : false})
     */
    private $ilfInd = true;

    /**
     * @ORM\OneToMany(targetEntity="OfferSkill", cascade={"persist", "remove"}, mappedBy="offer")
     */
    private $skills;

    /**
     * @var Post|null
     * @ORM\ManyToOne(targetEntity = "Post")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=true)
     */
    private $post;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title_en", type="string", length=255, nullable=true, options={"default" : " "}))
     */
    private $titleEn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_en", type="text", nullable=true, options={"default" : " "}))
     */
    private $descriptionEn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address_en", type="string", length=255, nullable=true, options={"default" : " "}))
     */
    private $addressEn;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->setCreatedAt(new \DateTime('NOW'));
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

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     *
     * @return Offer
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return Offer
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param string|null $img
     *
     * @return Offer
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     *
     * @return Offer
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIlfInd()
    {
        return $this->ilfInd;
    }

    /**
     * @param bool|null $ilfInd
     *
     * @return Offer
     */
    public function setIlfInd($ilfInd)
    {
        $this->ilfInd = $ilfInd;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): Offer
    {
        $this->post = $post;

        return $this;
    }

    public function getTitleEn(): ?string
    {
        return $this->titleEn;
    }

    public function setTitleEn(?string $titleEn): Offer
    {
        $this->titleEn = $titleEn;

        return $this;
    }

    public function getDescriptionEn(): ?string
    {
        return $this->descriptionEn;
    }

    public function setDescriptionEn(?string $descriptionEn): Offer
    {
        $this->descriptionEn = $descriptionEn;

        return $this;
    }

    public function getAddressEn(): ?string
    {
        return $this->addressEn;
    }

    public function setAddressEn(?string $addressEn): Offer
    {
        $this->addressEn = $addressEn;

        return $this;
    }

    public function jsonSerialize()
    {
        $skillsJson = [];
        $skillsJsonFr = [];
        $skillsJsonEn = [];
        $skills = $this->getSkills();
        foreach ($skills as $skill) {
            $skillsJsonFr[] = $skill->getLabel();
            $skillsJsonEn[] = $skill->getLabelEn();
        }
        $skillsJson['fr'] = $skillsJsonFr;
        $skillsJson['en'] = $skillsJsonEn;
        $result = [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'address' => $this->address,
            'titleEn' => $this->titleEn,
            'descriptionEn' => $this->descriptionEn,
            'addressEn' => $this->addressEn,
            'skills' => $skillsJson,
        ];

        return $result;
    }
}
