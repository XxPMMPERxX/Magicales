<?php

declare(strict_types=1);

namespace deceitya\magicales\session;

use RuntimeException;

class Phase
{
    const PHASE_VOID = 0;
    const PHASE_RECRUITMENT = 1;
    const PHASE_PREPARE = 2;
    const PHASE_INGAME = 3;
    const PHASE_FINISHED = 4;

    /** @var int */
    private $value;

    public function __construct(int $value)
    {
        if ($value < 0 || $value > 4) {
            throw new RuntimeException("Illegal Argument value={$value}");
        }
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function next(): Phase
    {
        return new Phase($this->value + 1);
    }
}
