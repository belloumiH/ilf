<?php

declare(strict_types=1);

namespace App\Entity;

use App\Helper\Cryptor;
use App\Traits\EntityIdTrait;
use App\Traits\EntityTimestamp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    use EntityTimestamp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=true)
     */
    private $mail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="file", type="string", length=255, nullable=true)
     */
    private $file;

    /**
     * @ORM\OneToMany(targetEntity="ScandidateSkill", cascade={"persist", "remove"}, mappedBy="spontaneous_candidate")
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
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * SpontaneousCandidate constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->setCreatedAt(new \DateTime('NOW'));
    }

    public function getFirstName(): ?string
    {
        return Cryptor::decrypt($this->firstName);
    }

    public function setFirstName(?string $firstName): SpontaneousCandidate
    {
        $this->firstName = Cryptor::encrypt($firstName);

        return $this;
    }

    public function getLastName(): ?string
    {
        return Cryptor::decrypt($this->lastName);
    }

    public function setLastName(?string $lastName): SpontaneousCandidate
    {
        $this->lastName = Cryptor::encrypt($lastName);

        return $this;
    }

    public function getPhone(): ?string
    {
        return Cryptor::decrypt($this->phone);
    }

    public function setPhone(?string $phone): SpontaneousCandidate
    {
        $this->phone = Cryptor::encrypt($phone);

        return $this;
    }

    public function getMail(): ?string
    {
        return Cryptor::decrypt($this->mail);
    }

    public function setMail(?string $mail): SpontaneousCandidate
    {
        $this->mail = Cryptor::encrypt($mail);

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): SpontaneousCandidate
    {
        $this->comment = $comment;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): SpontaneousCandidate
    {
        $this->post = $post;

        return $this;
    }

    public function getFile(): ?string
    {
        return Cryptor::decrypt($this->file);
    }

    public function setFile(?string $file): SpontaneousCandidate
    {
        $this->file = Cryptor::encrypt($file);

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkills()
    {
        return $this->skills;
    }

    public function addSkills(ScandidateSkill $skill)
    {
        $this->skills->add($skill);
        $skill->setSpontaneousCandidate($this);
    }

    public function setSkills($skills = [])
    {
        $this->skills = $skills;

        return $this;
    }
}
