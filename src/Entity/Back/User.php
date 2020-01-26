<?php

namespace App\Entity\Back;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 *
 * @author  Haythem Belloumi <h.belloumi@autobiz.com>
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // Your own logic
    }

    /**
     * @var string|null
     *
     * @ORM\Column(name="ilf_description", type="string", length=10, nullable=true)
     */
    private $ilfDescription;

    public function getIlfDescription(): ?string
    {
        return $this->ilfDescription;
    }

    public function setIlfDescription(?string $ilfDescription): User
    {
        $this->ilfDescription = $ilfDescription;

        return $this;
    }
}
