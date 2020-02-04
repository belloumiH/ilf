<?php

declare(strict_types=1);

namespace App\Traits;

/**
 * Trait EntityEnableTrait.
 */
trait EntityEnableTrait
{
    /**
     * @var int
     *
     * @ORM\Column(name="enabled", type="boolean", options={"default" : true})
     */
    private $enabled = true;

    /**
     * Get enable status of row.
     */
    final public function isEnabled(): bool
    {
        return (bool) $this->enabled;
    }

    /**
     * Enable row.
     */
    final public function Enabled()
    {
        $this->enabled = true;
    }

    /**
     * Disable row.
     */
    final public function Disabled()
    {
        $this->enabled = false;
    }
}
