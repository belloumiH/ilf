<?php

declare(strict_types=1);

namespace App\Entity;

use App\Traits\EntityEnableTrait;
use App\Traits\EntityIdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Post.
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    use EntityIdTrait;
    use EntityEnableTrait;

    /**
     * @var string|null
     *
     * @ORM\Column(name="label", type="string", length=255, nullable=true)
     */
    private $label;

    /**
     * @var string|null
     *
     * @ORM\Column(name="label_en", type="string", length=255, nullable=true , options={"default" : " "}))
     */
    private $labelEn = '';

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): Post
    {
        $this->label = $label;

        return $this;
    }

    public function getLabelEn(): ?string
    {
        return $this->labelEn;
    }

    public function setLabelEn(?string $labelEn): Post
    {
        $this->labelEn = $labelEn;

        return $this;
    }
}
