<?php

declare(strict_types=1);

namespace deceitya\magicales;

use RuntimeException;

class MagicPoint
{
    /** @var int */
    private $value;

    public function __construct(int $value)
    {
        if ($value < 0 || $value > 100) {
            throw new RuntimeException("Illegal Argument value={$value}");
        }
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * $amount分だけ回復する
     *
     * @param integer $amount
     * @return MagicPoint
     */
    public function plus(int $amount): MagicPoint
    {
        return new MagicPoint($this->value + $amount);
    }

    /**
     * $amount分だけ減少する
     *
     * @param integer $amount
     * @return MagicPoint
     */
    public function minus(int $amount): MagicPoint
    {
        return new MagicPoint($this->value - $amount);
    }
}
